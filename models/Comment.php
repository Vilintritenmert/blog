<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $text
 * @property string $name
 * @property string $email
 * @property string $created_at
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'integer'],
            [['text', 'name', 'email'], 'required'],
            [['text', 'name', 'email'], 'string', 'max' => 255],
        ];
    }


    /**
     * Relationship with Post
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }


    /**
     * Getter for date
     */
    public function getCreated()
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'text' => 'Text',
            'name' => 'Name',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];
    }


    /**
     * @param bool $insert
     */
    public function beforeSave($insert)
    {
        //$this->created_at =  microtime() ;

        return parent::beforeSave($insert);
    }


}
