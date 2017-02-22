<?php

namespace app\modules\blog\models;

use Yii;
use yii\db\Expression;
use yii\web\UploadedFile;

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
            [['created_at', 'publicated'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 1024],
            [['resource'], 'file'],
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
            'resource' => 'Resource',
            'short_description' => 'Short Description',
            'description' => 'Description',
            'created_at' => 'Created At',
            'publicated' => 'Publicated',
        ];
    }


    /**
     * Relation Ship with comment
     */
    public function Comments(){
        $this->hasMany(Commment::className(), ['post_id' => 'id']);
    }


    /**
     * 
     * 
     * @return $this
     */
    public function publicated()
    {
        $this->andWhere(['>=', 'publicated' , new Expression('NOW()')]);

        return $this;
    }


    /**
     * @param bool $insert
     */
    public function beforeSave($insert)
    {

        if($this->isNewRecord)
        {
            $this->created_at = new Expression('NOW()');

            $this->string = substr(uniqid('img'), 0, 12);
            $this->image = UploadedFile::getInstance($this, 'resource');
            $this->fileName = 'img/blog/' . $this->string . '.' .$this->image->extension;
            $this->image->saveAs($this->fileName);

            $this->resource = '/' . $this->fileName;
        } else {


        }

        return parent::beforeSave($insert);
    }
}
