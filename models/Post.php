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
 * @property string $resource
 * @property string $short_description
 * @property string $description
 * @property string $created_at
 * @property string $publicated
 */
class Post extends \yii\db\ActiveRecord
{

    /**
     * Variables for fila save
     *
     * @var
     */
    protected $string;
    protected $image;
    protected $fileName;

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
            [['short_description'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 5024],
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
     * @param bool $insert
     */
    public function beforeSave($insert)
    {

        if($this->isNewRecord)
        {
            $this->created_at = new Expression('NOW()');

//            $this->string = substr(uniqid('img'), 0, 12);
//
//            $this->image = UploadedFile::getInstance($this, 'resource');
//            $this->fileName = 'img/blog/' . $this->string . '.' .$this->image->extension;
//            $this->image->saveAs($this->fileName);
//
//            $this->resource = '/' . $this->fileName;
        } else {


        }

        return parent::beforeSave($insert);
    }
}
