<?php

use yii\db\Migration;

/**
 * Class m181121_095744_add_columns_created_at_and_updated_at_to_table_player
 */
class m181121_095744_add_columns_created_at_and_updated_at_to_table_player extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%player}}', 'created_at', $this->integer());
      $this->addColumn('{{%player}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('{{%player}}', 'created_at');
      $this->dropColumn('{{%player}}', 'updated_at');
    }
}
