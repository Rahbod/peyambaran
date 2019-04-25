<?php

namespace app\models;

use app\components\MultiLangActiveRecord;
use devgroup\dropzone\UploadedFiles;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_request".
 *
 * @property int $id
 * @property int $userID
 * @property string $type all user request types
 * @property string $name
 * @property resource $dyna All fields
 * @property string $extra JSON array keeps all other options
 * @property string $created
 * @property int $status Request Status
 * @property [] $files
 * @property Attachment[] $attachments
 *
 * @property User $user
 */
class UserRequest extends MultiLangActiveRecord
{
    public $files = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_request';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['userID', 'type', 'name', 'created', 'status'], 'required'],
            [['userID', 'status'], 'integer'],
            [['type'], 'number'],
            [['dyna', 'extra'], 'string'],
            [['files'], 'safe'],
            [['created'], 'safe'],
            [['name'], 'string', 'max' => 511],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('words', 'ID'),
            'userID' => Yii::t('words', 'User I D'),
            'type' => Yii::t('words', 'all user request types'),
            'name' => Yii::t('words', 'Name'),
            'dyna' => Yii::t('words', 'All fields'),
            'extra' => Yii::t('words', 'JSON array keeps all other options'),
            'created' => Yii::t('words', 'Created'),
            'status' => Yii::t('words', 'Request Status'),
            'files' => Yii::t('words', 'Attachments'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // save attachments
        if ($this->files) {
            $lastFiles = $this->attachments ? ArrayHelper::map($this->attachments, 'id', 'file') : [];
            if (!is_array($this->files)) $this->files = [$this->files];
            foreach ($this->files as $key => $attachment) {
                if (!in_array($attachment, $lastFiles) && is_file(Yii::getAlias('@webroot/uploads/temp') . DIRECTORY_SEPARATOR . $attachment)) {
                    $model = new Attachment();
                    $model->userID = Yii::$app->user->id;
                    $model->status = Attachment::STATUS_ACTIVE;
                    $model->created = time();
                    $model->file = $attachment;
                    $model->type = pathinfo($attachment, PATHINFO_EXTENSION);
                    $model->receptionID = $this->id;
                    $model->size = @filesize(Yii::getAlias('@webroot/uploads/temp') . DIRECTORY_SEPARATOR . $attachment);
                    $model->path = Attachment::getAttachmentRelativePath();
                    if (!@$model->save())
                        $this->addErrors($model->errors);
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
        $this->files = $this->attachments ? $this->attachments : [];
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
        return $query->andWhere(['receptionID' => $this->id])->all();
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

        if (!$count)
            return $query->andWhere(['receptionID' => $this->id])->one();
        else
            return $query->andWhere(['receptionID' => $this->id])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentRel()
    {
        return $this->hasOne(Attachment::className(), [Attachment::columnGetString('receptionID', 'attachment') => 'id']);
    }
}