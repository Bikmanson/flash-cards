<?php

use yii\db\Migration;

/**
 * Class m181019_101553_add_to_table_flash_card_columns_created_at_updated_at
 */
class m181019_101553_add_to_table_flash_card_columns_created_at_updated_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%flash_card}}', 'created_at', $this->integer(11));
      $this->addColumn('{{%flash_card}}', 'updated_at', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('{{%flash_card}}', 'created_at');
      $this->dropColumn('{{%flash_card}}', 'updated_at');
    }
}
