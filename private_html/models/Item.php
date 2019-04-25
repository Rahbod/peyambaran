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
 * @property int $en_status
 * @property int $ar_status
 *
 * @property Catitem[] $catitems
 * @property Attachment[] $attachments
 * @property Category[] $categories
 * @property Category[] $tags
 * @property User $user
 * @property Model $model
 */
class Item extends MultiLangActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static $modelName = null;
    public static $typeName = null;

    public $gallery = null;
    public $formCategories = [];
    public $formTags = [];

    public function init()
    {
        parent::init();
        preg_match('/(app\\\\models\\\\)(\w*)(Search)/', $this::className(), $matches);
        if (!$matches)
        {
            $this->status = 1;
            $this->en_status = 1;
            $this->ar_status = 1;
        }
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
            [['formCategories', 'formTags'], 'safe'],
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
            'gallery' => Yii::t('words', 'Picture Gallery'),
            'formCategories' => Yii::t('words', 'Category'),
            'formTags' => Yii::t('words', 'Tags'),
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

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'catID'])
            ->viaTable('catitem', ['itemID' => 'id'])->andWhere(['type' => Catitem::TYPE_CATEGORY]);
    }

    public function getTags()
    {
        return $this->hasMany(Category::className(), ['id' => 'catID'])
            ->viaTable('catitem', ['itemID' => 'id'])->andWhere(['type' => Catitem::TYPE_TAXONOMY]);
    }

    public static function getStatusLabels($status = null, $html = false)
    {
        $statusLabels = [
            self::STATUS_DELETED => 'حذف شده',
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        if (is_null($status))
            return $statusLabels;

        if($html)
        {
            switch ($status){
                case self::STATUS_PUBLISHED:
                    $class = 'success';
                    $icon = '<i class="fa fa-check-circle"></i>';
                    break;
                case self::STATUS_DISABLED:
                    $class = 'warning';
                    $icon = '<i class="fa fa-times-circle"></i>';
                    break;
                case self::STATUS_DELETED:
                    $class = 'danger';
                    $icon = '<i class="fa fa-times-circle"></i>';
                    break;
            }
            return "<span class='text-{$class}'>$icon</span>";
        }
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

        if ($this->scenario == 'increase_seen')
            return true;

        // save attachments
        if ($this->gallery) {
            $lastGallery = $this->attachments ? ArrayHelper::map($this->attachments, 'id', 'file') : [];
            if (!is_array($this->gallery)) $this->gallery = [$this->gallery];
            foreach ($this->gallery as $key => $attachment) {
                if (!in_array($attachment, $lastGallery) && is_file(Yii::getAlias('@webroot/uploads/temp') . DIRECTORY_SEPARATOR . $attachment)) {
                    $model = new Attachment();
                    $model->userID = Yii::$app->user->id;
                    $model->status = Attachment::STATUS_ACTIVE;
                    $model->created = time();
                    $model->file = $attachment;
                    $model->type = pathinfo($attachment, PATHINFO_EXTENSION);
                    $model->itemID = $this->id;
                    $model->size = @filesize(Yii::getAlias('@webroot/uploads/temp') . DIRECTORY_SEPARATOR . $attachment);
                    $model->path = Attachment::getAttachmentRelativePath();
                    if (!@$model->save())
                        $this->addErrors($model->errors);
                }
            }
        }

        // save categories
        if ($this->formCategories) {
            // multiple categories
//            $lastTags = $this->categories ? ArrayHelper::map($this->categories, 'id', 'name') : [];
            if (!is_array($this->formCategories)) $this->formCategories = [$this->formCategories];
            if(!$this->isNewRecord)
                Catitem::deleteAll(['itemID' => $this->id]);
            foreach ($this->formCategories as $id) {
                $model = new Catitem();
                $model->type = Catitem::TYPE_CATEGORY;
                $model->catID = $id;
                $model->itemID = $this->id;
                if (!@$model->save())
                    $this->addErrors($model->errors);
                else
                    unset($this->formCategories[$id]);
            }
        }

        // save tags
        if ($this->formTags) {
            $lastTags = $this->tags ? ArrayHelper::map($this->tags, 'id', 'name') : [];
            if (!is_array($this->formTags)) $this->formTags = [$this->formTags];
            foreach ($this->formTags as $id) {
                if (!array_key_exists($id, $lastTags)) {
                    $model = new Catitem();
                    $model->type = Catitem::TYPE_TAXONOMY;
                    $model->catID = $id;
                    $model->itemID = $this->id;
                    if (!@$model->save())
                        $this->addErrors($model->errors);
                    else
                        unset($this->formTags[$id]);
                }
            }
        }
    }

    public function afterDelete()
    {
        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                try {
                    $file = new UploadedFiles(Attachment::$attachmentPath, $attachment);
                    $file->removeAll(true);
                    $attachment->delete();
                } catch (\Exception $exception) {
                }
            }
        }
        parent::afterDelete();
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->formCategories = ArrayHelper::getColumn($this->catitems, 'catID');
        $this->gallery = $this->attachments ? $this->attachments : [];
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

    public function getName()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa')
                return $this->name;
            else
                return $this->{Yii::$app->language . '_name'}?:$this->name;
        }
        return $this->name;
    }
}
