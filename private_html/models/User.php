<?php

namespace app\models;

use app\components\DynamicActiveRecord;
use app\components\MultiLangActiveRecord;
use Yii;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $roleID
 * @property resource $dyna
 * @property string $created
 * @property integer $status
 * @property integer $verification_code
 * @property integer $nationalCode
 * @property integer $email
 * @property integer $phone
 * @property integer $text
 * @property integer $image
 * @property integer $memCode
 * @property integer $gender
 * @property integer $address
 * @property integer $birthDate
 * @property integer $reception_type
 *
 */
class User extends DynamicActiveRecord implements IdentityInterface
{
    /**
     * This variables determine that the log is executed or not.
     * Each one is empty or not declared, that event will not be logged.
     */
    protected $insertLogCode = Log::EVENT_USER;
    protected $updateLogCode = null; // set null to prevent execution CustomActiveRecord update create log
    protected $deleteLogCode = Log::EVENT_USER_REMOVE_PERMANENTLY;
    private $_old; // to keep old attribute values

    const STATUS_DELETED = -1;
    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    public $oldPassword;
    public $repeatPassword;
    public $newPassword;
    public $authKey;
    public $accessToken;
    public $verifyCode;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'email' => ['CHAR', ''],
            'phone' => ['CHAR', ''],
            'text' => ['CHAR', ''],
            'image' => ['CHAR', ''],
            'nationalCode' => ['INTEGER', ''],
            'memCode' => ['INTEGER', ''],
            'gender' => ['INTEGER', ''],
            'address' => ['CHAR', ''],
            'birthDate' => ['DATETIME', ''],
            'verification_code' => ['CHAR', ''],

            'updated' => ['DATETIME', ''],
            'lastLogin' => ['DATETIME', ''],
            'reception_type' => ['CHAR', ''],
        ]);
    }

    public function formAttributes()
    {
        return [
            'name' => ['type' => self::FORM_FIELD_TYPE_TEXT],
            'email' => ['type' => self::FORM_FIELD_TYPE_TEXT],
            'hr' => ['type' => static::FORM_SEPARATOR],
            'reception_type' => [
                'type' => self::FORM_FIELD_TYPE_SELECT,
                'items' => Reception::getReceptionTypeLabels(),
                'options' => ['prompt' => 'دسترسی پذیرش را در صورت نیاز انتخاب نمایید'],
                'containerCssClass' => 'col-sm-12'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
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
            [['name', 'username', 'status', 'roleID'], 'required', 'except' => ['change-password', 'manual_insert', 'register']],
            [['name', 'username', 'status', 'roleID'], 'required', 'on' => 'manual_insert'],
            [['password'], 'required', 'on' => 'insert'],
            [['newPassword', 'repeatPassword'], 'required', 'on' => 'change-password'],
            [['oldPassword'], 'required', 'on' => 'change-password'],
            [['oldPassword'], 'checkPassword', 'on' => 'change-password'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'insert'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'change-password'],
            ['created', 'default', 'value' => date(Yii::$app->params['dbDateTimeFormat']), 'on' => ['insert', 'manual_insert', 'register']],
            [['dyna', 'address'], 'string'],
            [['created', 'phone', 'text', 'image', 'nationalCode', 'memCode', 'gender', 'address', 'birthDate'], 'safe'],
            [['status', 'nationalCode', 'memCode', 'gender'], 'integer'],
            [['name', 'username', 'password'], 'string', 'max' => 255],
            [['nationalCode'], 'string', 'max' => 10],
            [['reception_type'], 'string'],
            [['phone'], 'string', 'min' => 11, 'max' => 11],
            [['username'], 'unique'],
            [['email'], 'email'],
            [['roleID'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['roleID' => 'name']],

            [['name', 'nationalCode', 'phone'], 'required', 'on' => 'register'],
            [['nationalCode'], 'string', 'min' => 10, 'on' => 'register'],
            [['phone'], 'string', 'min' => 11, 'on' => 'register'],
            [['roleID'], 'default', 'value' => 'user', 'on' => 'register'],
            [['status'], 'default', 'value' => 0, 'on' => 'register'],
            ['verifyCode', 'captcha', 'skipOnEmpty' => false, 'captchaAction' => '/user/captcha', 'on' => 'register'],

            [['verification_code'], 'integer', 'on' => 'authorize'],
        ];
    }

    public function checkPassword($attribute)
    {
        if (!$this->validatePassword($this->oldPassword, $this->password))
            $this->addError($attribute, Yii::t('words', 'user.wrongOldPassword'));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('words', 'base.id'),
            'name' => Yii::t('words', 'user.name'),
            'username' => Yii::t('words', 'user.username'),
            'password' => Yii::t('words', 'user.password'),
            'repeatPassword' => Yii::t('words', 'user.repeatPassword'),
            'oldPassword' => Yii::t('words', 'user.oldPassword'),
            'newPassword' => Yii::t('words', 'user.newPassword'),
            'dyna' => 'Dyna',
            'created' => Yii::t('words', 'base.created'),
            'status' => Yii::t('words', 'base.status'),
            'roleID' => Yii::t('words', 'user.roleID'),
            'email' => Yii::t('words', 'user.email'),
            'phone' => Yii::t('words', 'user.phone'),
            'text' => Yii::t('words', 'base.text'),
            'image' => Yii::t('words', 'user.image'),
            'groups' => Yii::t('words', 'user.groups'),
            'group' => Yii::t('words', 'user.group'),
            'nationalCode' => Yii::t('words', 'user.nationalCode'),
            'memCode' => Yii::t('words', 'user.memCode'),
            'gender' => Yii::t('words', 'user.gender'),
            'address' => Yii::t('words', 'user.address'),
            'birthDate' => Yii::t('words', 'user.birthDate'),
            'verifyCode' => Yii::t('words', 'verifyCode'),
            'verification_code' => Yii::t('words', 'Verification code'),
            'reception_type' => Yii::t('words', 'Reception type permission'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = self::findOne($id);
        return $user ?: null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::find()->where(['username' => $username])->one();

        if ($user)
            return $user;

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->updated = date(Yii::$app->params['dbDateTimeFormat']);
        if ($this->scenario != 'delete-user' && $this->scenario != 'change-password')
            $this->birthDate = date(Yii::$app->params['dbDateTimeFormat'], $this->birthDate);

        if ($this->scenario == 'change-password')
            $this->password = $this->newPassword;

        if ($this->isNewRecord || $this->scenario == 'change-password')
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

        $this->_old = $this->oldAttributes; // for create log
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$insert && $this->logging) {
            if ($this->scenario == 'edit-profile')
                $code = Log::EVENT_USER_EDIT_PROFILE;
            else if ($this->scenario == 'delete-user')
                $code = Log::EVENT_USER_REMOVE;
            else
                $code = Log::EVENT_USER_EDIT;

            Log::createUpdateLogWithCode($code, $this->id, self::tableName(),
                Json::encode(['old' => $changedAttributes, 'new' => $this->getNewValues($changedAttributes, $this->attributes)]));
        }

        if ($this->scenario == 'edit-profile')
            return;

        if (Yii::$app->request->post('User') and $insert and isset(Yii::$app->request->post('User')['password']))
            $this->password = Yii::$app->request->post('User')['password'];

        if ($this->groups) {
            if (!$insert) {
                $lastRels = UserUGroup::find()->where(['userID' => $this->id])->all();
                foreach ($lastRels as $rel)
                    $rel->delete();
            }

            foreach ($this->groups as $group) {
                $userUGroup = new UserUGroup();
                $userUGroup->userID = $this->id;
                $userUGroup->ugroupID = $group;
                @$userUGroup->save();
            }
        }
    }

    public function getAvatar()
    {
        $path = Yii::getAlias('@web/themes/frontend/svg/default-user.svg');
        if (!Yii::$app->user->isGuest && $this->image && is_file(Yii::getAlias('uploads/users/avatars/') . $this->image)) {
            $path = Yii::getAlias('@web/uploads/users/avatars/');
            $path .= $this->image;
        }
        return $path;
    }

    /**
     * @param bool $withSuper
     * @return Query
     */
    public static function validQuery($withSuper = false)
    {
        $query = self::find()
            ->orderBy(['id' => SORT_DESC])
            ->where('username != "guest"');

        if ($withSuper)
            return $query;

        return $query->andWhere(['<>', 'roleID', 'superAdmin']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['userID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRule()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'ruleID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserugroups()
    {
        return $this->hasMany(UserUGroup::className(), ['userID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUgroups()
    {
        return $this->hasMany(UGroup::className(), ['id' => 'ugroupID'])->viaTable('userugroup', ['userID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['name' => 'roleID']);
    }

    /**
     * @return boolean
     */
    public static function isSuperAdmin()
    {
        /* @var $role \yii\rbac\Role */
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        foreach ($roles as $role)
            if ($role->name == 'superAdmin')
                return true;

        return false;
    }

    public static function getGenderLabels($gender = null)
    {
        $labels = [
            0 => Yii::t('words', 'Male'),
            1 => Yii::t('words', 'Female')
        ];
        if (is_null($gender))
            return $labels;
        return $labels[$gender];
    }

    public static function getStatusLabels($status = null)
    {
        $labels = [
            self::STATUS_DELETED => Yii::t('words', 'base.deleted'),
            self::STATUS_DISABLE => Yii::t('words', 'base.disable'),
            self::STATUS_ENABLE => Yii::t('words', 'base.enable')
        ];
        if (is_null($status))
            return $labels;
        return $labels[$status];
    }
}