<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * CommentForm is the model behind the Comment form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CommentForm extends Model
{
    public $name;
    public $email;
    public $post_id;
    public $text;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min'=>2, 'max'=>255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max'=>255],

            ['post_id', 'required'],
            ['post_id', 'integer'],
            ['post_id', 'requiredPost'],

            ['text', 'trim'],
            ['text', 'required'],
            ['text', 'string', 'min'=>2, 'max'=>255],
        ];
    }

    /**
     * Check post exists and published
     *
     * @param $attribute
     * @param $params
     */
    public function requiredPost($attribute, $params)
    {
        $post = Post::find()
            ->where(['id'=>$this[$attribute]])
            ->where(['publicated' => 1])
            ->one();

        if (!$post) {
            $this->addError($attribute, 'The fields don`t match.');
        }

        return ;
    }


    /**
     * Save Comments
     */
    public function save()
    {
        if($this->validate($this->attributes))
        {
            $comment         =new Comment();
            $comment->name   =$this->name;
            $comment->email  =$this->email;
            $comment->text   =$this->text;
            $comment->post_id=$this->post_id;
            $comment->save();

            return $comment;
        }
    }

}
