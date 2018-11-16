<?php

use yii\db\Migration;

/**
 * Class m181019_102816_table_flash_card_columns_question_and_answer_change_type
 */
class m181019_102816_table_flash_card_columns_question_and_answer_change_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->alterColumn('{{%flash_card}}', 'question', $this->string(255));
      $this->alterColumn('{{%flash_card}}', 'answer', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->alterColumn('{{%flash_card}}', 'question', $this->text());
      $this->alterColumn('{{%flash_card}}', 'answer', $this->text());
    }
}
