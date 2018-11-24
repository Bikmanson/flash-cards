<?php

use yii\db\Migration;

/**
 * Class m181124_130358_rename_column_player_id_to_creator_id_in_table_flash_card
 */
class m181124_130358_rename_column_player_id_to_creator_id_in_table_flash_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->renameColumn('{{%flash_card}}', 'player_id', 'creator_id');
      $this->dropForeignKey('fk_flash_card_player', '{{%flash_card}}');
      $this->addForeignKey('fk_flash_card-player', '{{%flash_card}}', 'creator_id', '{{%player}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('fk_flash_card-player', '{{%flash_card}}');
      $this->renameColumn('{{%flash_card}}', 'creator_id', 'player_id');
      $this->addForeignKey('fk_flash_card_player', '{{%flash_card}}', 'player_id', '{{%player}}', 'id', 'CASCADE');
    }
}
