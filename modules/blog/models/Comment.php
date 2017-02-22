<?php

namespace app\modules\blog\models;

use Yii;

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
            [['created_at'], 'safe'],
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
}
