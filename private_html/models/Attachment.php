<?php

namespace app\models;

use app\components\DynamicActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "attachment".
 *
 * @property integer $id
 * @property integer $userID
 * @property resource $dyna
 * @property string $created
 * @property integer $status
 */
class Attachment extends DynamicActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    public static $attachmentPath = 'uploads/items/attachments';

    public function init()
    {
        parent::init();
        if ($this->scenario != 'search')
            $this->status = 1;
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'itemID' => ['INTEGER', ''], //Item that is attached to
            'receptionID' => ['INTEGER', ''], //Field the file is attached to
            'file' => ['CHAR', ''], //Filename
            'path' => ['CHAR', ''], //Directory
            'type' => ['CHAR', ''], //Extention in lowercase
            'size' => ['INTEGER', ''], //Filesize in bytes
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * @inheritdoc
     */
    public static function dynamicColumn()
    {
        return 'dyna';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'created', 'status'], 'required'],
            [['userID', 'status'], 'integer'],
            [['dyna'], 'string'],
            [['created','itemID', 'receptionID'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User uploaded the file.
NULL is system files.',
            'created' => 'Created',
            'status' => '',
        ];
    }

    /**
     * Return valid query
     * @return \yii\db\ActiveQuery
     */
    public static function validQuery()
    {
        return self::find();
    }

    /**
     * Returns attachment sub folder, create it if not exists
     *
     * @param null $timestamp
     * @return string
     */
    public static function getAttachmentPath($timestamp = null)
    {
        $timestamp = $timestamp ?: time();
        $subFolder = date('Y', $timestamp) . "/" . date('m', $timestamp);
        if (!is_dir(self::$attachmentPath . "/" . $subFolder))
            mkdir(self::$attachmentPath . "/" . $subFolder, 0777, true);
        return self::$attachmentPath . "/" . $subFolder;
    }

    /**
     * Returns attachment sub folder, create it if not exists
     *
     * @param null $timestamp
     * @return string
     */
    public static function getAttachmentRelativePath($timestamp = null)
    {
        $timestamp = $timestamp ?: time();
        $subFolder = date('Y', $timestamp) . "/" . date('m', $timestamp);
        if (!is_dir(self::$attachmentPath . "/" . $subFolder))
            mkdir(self::$attachmentPath . "/" . $subFolder, 0777, true);
        return $subFolder;
    }

    public function getAbsoluteUrl()
    {
        return \Yii::getAlias('@web/'.Attachment::getAttachmentPath($this->created).'/').$this->file;
    }

    public function getDownloadUrl()
    {
        return Url::to(['/item/download', 'id' => $this->id]);
    }

    public function __toString()
    {
        return (string)$this->file;
    }
}
