<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m170222_103554_create_comments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comments', [
            'id'        =>$this->primaryKey(),
            'post_id'   =>$this->integer()
                               ->notNull(),
            'name'      =>$this->string(255)
                               ->notNull(),
            'email'     =>$this->string(255)
                               ->notNull(),
            'text'      =>$this->string(255)
                               ->notNull(),
            'created_at'=> 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);


        $this->createIndex(
            'idx-comment-post_id',
            'comments',
            'post_id'
        );

        $this->createIndex(
            'idx-comment-created_at',
            'comments',
            'created_at'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropIndex(
            'idx-comment-post_id',
            'comments'
        );

        $this->dropIndex(
            'idx-comment-created_at',
            'comments'
        );

        $this->dropTable('comments');

    }
}
