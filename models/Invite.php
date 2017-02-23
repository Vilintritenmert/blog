<?php

namespace app\models;

use Yii;
use Swift_Plugins_Loggers_ArrayLogger;

/**
 * This is the model class for table "invits".
 *
 * @property integer $id
 * @property string $email
 * @property string $created_at
 */
class Invite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max'=>255],
            ['email', 'email'],
            ['email', 'notUser'],
        ];
    }

    /**
     * Check user not
     *
     * @param $attribute
     * @param $params
     */
    public function notUser($attribute, $params)
    {
        $user=User::find()
        ->where(['email'=>$this[ $attribute ]])
        ->one();

        if ($user) {
            $this->addError($attribute, 'User alredy registred.');
        }
    }

    /**
     * Relationship with User
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['email'=>'email']);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        =>'ID',
            'email'     =>'Email',
            'created_at'=>'Created At',
        ];
    }


    /**
     * Send invite
     */
    public function sendNotification()
    {
        $hostName  =Yii::$app->request->getHostName();
        $adminEmail=Yii::$app->params[ 'adminEmail' ]?: 'admin@' . $hostName;
        $mailer    =Yii::$app->mailer;

        $result=$mailer->compose('invite')
                       ->setFrom($adminEmail)
                       ->setTo($this->email)
                       ->setSubject('Invite to blog')
                       ->send();

        return $result;
    }

    /**
     * Send invite before sending data
     *
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->sendNotification();

        return parent::beforeSave($insert);
    }

}
