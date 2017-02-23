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
            'short_description'=>$this->string(255)
                                      ->notNull(),
            'description'      =>$this->string(5024)
                                      ->notNull(),
            'created_at'       =>'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'publicated'       =>$this->boolean()
                                      ->defaultValue(false),
        ]);

        $this->createIndex(
            'idx-posts-author_id',
            'posts',
            'author_id'
        );

        $this->createIndex(
            'idx-posts-created_at',
            'posts',
            'created_at'
        );

        $this->createIndex(
            'idx-posts-publicated',
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

        $this->dropIndex(
            'idx-posts-created_at',
            'posts'
        );

        $this->dropIndex(
            'idx-posts-publicated',
            'posts'
        );

        $this->dropTable('post');

    }
}
