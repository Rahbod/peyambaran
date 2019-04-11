<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $department_id;
    public $tel;
    public $degree;
    public $country;
    public $city;
    public $address;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'body', 'tel'], 'required'],
            [['department_id'], 'required', 'on' => 'default'],
            [['subject'], 'required', 'on' => 'sgn-scenario'],
            [['department_id'], 'default', 'value' => Department::find()->one()->id, 'except' => 'default'],
            // email has to be a valid email address
            ['email', 'email'],
            [['degree'], 'integer', 'max' => 10],
            [['country', 'city'], 'string', 'max' => 50],
            [['address'], 'string'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('words', 'Name and Family'),
            'email' => Yii::t('words', 'Email'),
            'subject' => Yii::t('words', 'Subject'),
            'body' => Yii::t('words', 'Body'),
            'department_id' => Yii::t('words', 'Department ID'),
            'tel' => Yii::t('words', 'Tel'),
            'verifyCode' => Yii::t('words', 'Verify Code'),
            'degree' => Yii::t('words', 'Degree'),
            'country' => Yii::t('words', 'Country'),
            'city' => Yii::t('words', 'City'),
            'address' => Yii::t('words', 'Address'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
