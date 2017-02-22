<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m170222_103332_create_posts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('posts', [
            'id'               =>$this->primaryKey(),
            'author_id'        =>$this->integer()
                                      ->notNull(),
            'title'            =>$this->string(255)
                                      ->notNull(),
            'description'      =>$this->string(1024)
                                      ->notNull(),
            'short_description'=>$this->string(255)
                                      ->notNull(),
            'image'            =>$this->string(255)
                                      ->null(),
            'video'            =>$this->string(255)
                                      ->null(),
            'created_at'       =>'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'publicated'       =>$this->boolean()
                                      ->defaultValue(false),
        ]);

        $this->createIndex(
            'idx-post-author_id',
            'posts',
            'author_id'
        );

        $this->createIndex(
            'idx-post-publicated',
            'posts',
            'publicated'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-posts-author_id',
            'posts'
        );

        $this->dropTable('post');

    }
}
