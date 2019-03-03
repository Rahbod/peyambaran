<?php

namespace app\models;

use devgroup\dropzone\UploadedFiles;
use Yii;
use \app\components\MultiLangActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int $userID Book creator
 * @property int $modelID
 * @property string $type
 * @property string $name
 * @property resource $dyna All fields
 * @property string $extra JSON array keeps all other options
 * @property string $created
 * @property int $status
 *
 * @property Catitem[] $catitems
 * @property Attachment[] $attachments
 * @property User $user
 * @property Model $model
 */
abstract class Item extends MultiLangActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static $modelName = null;
    public static $typeName = null;

    public $gallery = null;

    public function init()
    {
        $this->status = 1;
        parent::init();
//        $this->dynaDefaults = array_merge($this->dynaDefaults, [
//        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name'], 'required'],
            [['userID', 'modelID', 'status'], 'integer'],
            [['type'], 'number'],
            [['dyna', 'extra'], 'string'],
            [['gallery'], 'safe'],
            [['name'], 'string', 'max' => 511],
            [['created'], 'string', 'max' => 20],
            ['created', 'default', 'value' => time()],
            ['userID', 'default', 'value' => Yii::$app->user->getId()],
            ['status', 'default', 'value' => self::STATUS_PUBLISHED],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
            [['modelID'], 'exist', 'skipOnError' => true, 'targetClass' => Model::className(), 'targetAttribute' => ['modelID' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('words', 'ID'),
            'userID' => Yii::t('words', 'Creator'),
            'modelID' => Yii::t('words', 'Model'),
            'type' => Yii::t('words', 'Type'),
            'name' => Yii::t('words', 'Name'),
            'dyna' => Yii::t('words', 'All fields'),
            'extra' => Yii::t('words', 'Extra'),
            'created' => Yii::t('words', 'Created'),
            'status' => Yii::t('words', 'Status'),
            'gallery' => Yii::t('words', 'Gallery'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'modelID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatitems()
    {
        return $this->hasMany(Catitem::className(), ['itemID' => 'id']);
    }

    public static function getStatusLabels($status = null)
    {
        $statusLabels = [
            self::STATUS_DELETED => 'حذف شده',
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        if (is_null($status))
            return $statusLabels;
        return $statusLabels[$status];
    }

    public static function getStatusFilter()
    {
        $statusLabels = [
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        return $statusLabels;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        if ($this->gallery) {
            $lastGallery = $this->attachments ? ArrayHelper::map($this->attachments, 'id', 'file') : [];
            if (!is_array($this->gallery)) $this->gallery = [$this->gallery];
            foreach ($this->gallery as $key => $attachment) {
                if (!in_array($attachment, $lastGallery) && is_file(Attachment::getAttachmentPath() . DIRECTORY_SEPARATOR . $attachment)) {
                    $model = new Attachment();
                    $model->userID = Yii::$app->user->id;
                    $model->status = Attachment::STATUS_ACTIVE;
                    $model->created = time();
                    $model->file = $attachment;
                    $model->type = pathinfo($attachment, PATHINFO_EXTENSION);
                    $model->itemID = $this->id;
                    $model->size = @filesize(Attachment::getAttachmentPath() . DIRECTORY_SEPARATOR . $attachment);
                    $model->path = Attachment::getAttachmentRelativePath();
                    if (!@$model->save())
                        $this->addErrors($model->errors);
                    else
                        unset($this->gallery[$key]);
                }
            }
        }
    }

    public function afterDelete()
    {
        if($this->attachments){
            foreach ($this->attachments as $attachment) {
                try {
                    $file = new UploadedFiles(Attachment::$attachmentPath, $attachment);
                    $file->removeAll(true);
                    $attachment->delete();
                }catch (\Exception $exception){}
            }
        }
        parent::afterDelete();
    }

    /**
     * @param null $fieldID
     * @param null $type
     * @return Attachment[]
     * @throws \yii\base\InvalidConfigException
     */
    public function getAttachments($fieldID = null, $type = null)
    {
        $query = Attachment::find();
        if ($type)
            $query = Attachment::find()->andWhere([Attachment::columnGetString('type') => $type]);
        if ($fieldID)
            return $query->andWhere(['itemID' => $this->id, 'fieldID' => $fieldID])->all();
        return $query->andWhere(['itemID' => $this->id])->andWhere([Attachment::columnExistsString('fieldID') => 0])->all();
    }

    /**
     * @param null $fieldID
     * @param null $type
     * @param bool $count
     * @return array|null|Attachment|int
     * @throws \yii\base\InvalidConfigException
     */
    public function getAttachment($fieldID = null, $type = null, $count = false)
    {
        $query = Attachment::find();
        if ($type == 'pdf')
            $query = Attachment::find()->andWhere([Attachment::columnGetString('type') => $type]);
        elseif ($type == 'doc')
            $query = Attachment::find()->andWhere(['or', [Attachment::columnGetString('type') => $type], [Attachment::columnGetString('type') => 'docx']]);

        if (!$count) {
            if ($fieldID)
                return $query->andWhere(['itemID' => $this->id, 'fieldID' => $fieldID])->one();
            return $query->andWhere(['itemID' => $this->id])->andWhere([Attachment::columnExistsString('fieldID') => 0])->one();
        } else {
            if ($fieldID)
                return $query->andWhere(['itemID' => $this->id, 'fieldID' => $fieldID])->count();
            return $query->andWhere(['itemID' => $this->id])->andWhere([Attachment::columnExistsString('fieldID') => 0])->count();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentRel()
    {
        return $this->hasOne(Attachment::className(), [Attachment::columnGetString('itemID', 'attachment') => 'id']);
    }
}
