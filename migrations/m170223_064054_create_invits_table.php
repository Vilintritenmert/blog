<?php

use yii\db\Migration;

/**
 * Handles the creation of table `invits`.
 */
class m170223_064054_create_invits_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('invits', [
            'id'        =>$this->primaryKey(),
            'email'     =>$this->string(255)
                               ->notNull(),
            'created_at'=>'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex(
            'idx-invits-email',
            'invits',
            'email'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-invits-email',
            'invits'
        );

        $this->dropTable('invits');
    }
}
