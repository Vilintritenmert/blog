<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\web\UploadedFile;
use app\models\Comment;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property integer $author_id
 * @property string $short_description
 * @property string $description
 * @property string $created_at
 * @property string $publicated
 */
class Post extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_description', 'description'], 'required'],
            [['author_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 255],
            [['video'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 5024],
            [['publicated'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'author_id' => 'Author ID',
            'short_description' => 'Short Description',
            'description' => 'Description',
            'created_at' => 'Created At',
            'publicated' => 'Publicated',
        ];
    }

    /**
     * Relation Ship with comment
     */
    public function getComments(){
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])
            ->orderBy('created_at');
    }

    /**
     * Relation Ship with Author
     */
    public function getAuthor(){

        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Getter for created
     *
     * @return false|string
     */
    public function getCreated()
    {
        return date('Y-m-d', $this->created_at);
    }


    /**
     * Need add id;
     *
     * @param bool $insert
     */
    public function beforeSave($insert)
    {

        if($this->isNewRecord)
        {
            $this->author_id =Yii::$app->user->getId();
        }

        return parent::beforeSave($insert);
    }
}
