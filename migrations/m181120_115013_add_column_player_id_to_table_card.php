<?php

use yii\db\Migration;

/**
 * Class m181120_115013_add_column_player_id_to_table_card
 */
class m181120_115013_add_column_player_id_to_table_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%flash_card}}', 'player_id', $this->integer(11));

      $this->addForeignKey('fk_flash_card_player', '{{%flash_card}}', 'player_id', '{{%player}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('fk_flash_card_player', '{{%flash_card}}');

      $this->dropColumn('{{%flash_card}}', 'player_id');
    }
}
