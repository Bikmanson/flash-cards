<?php

use yii\db\Migration;

/**
 * Class m181026_214838_alter_columns_created_at_updated_at_table_flash_card
 */
class m181026_214838_alter_columns_created_at_updated_at_table_flash_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->alterColumn('{{%flash_card}}', 'created_at', $this->integer());
      $this->alterColumn('{{%flash_card}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->alterColumn('{{%flash_card}}', 'created_at', $this->integer(11));
      $this->alterColumn('{{%flash_card}}', 'updated_at', $this->integer(11));
    }
}
