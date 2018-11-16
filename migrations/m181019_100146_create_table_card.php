<?php

use yii\db\Migration;

/**
 * Class m181019_100146_create_table_card
 */
class m181019_100146_create_table_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('{{%flash_card}}', [
        'id' => $this->primaryKey(),
        'question' => $this->text(),
        'answer' => $this->text(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%flash_card}}');
    }
}
