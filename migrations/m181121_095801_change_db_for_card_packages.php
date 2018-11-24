<?php

use yii\db\Migration;

/**
 * Class m181121_095801_change_db_for_card_packages
 */
class m181121_095801_change_db_for_card_packages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('{{%package_allowance}}', [
        'id' => $this->primaryKey(),
        'player_id' => $this->integer(11),
        'allowance_id' => $this->integer(11),
        'created_at' => $this->integer(),
        'updated_at' => $this->integer()
      ]);
      $this->createTable('{{%package}}', [
        'id' => $this->primaryKey(),
        'name' => $this->string(50),
        'creator_id' => $this->integer(11),
        'allowance_id' => $this->integer(11),
        'created_at' => $this->integer(11),
        'updated_at' => $this->integer(11)
      ]);
      $this->addForeignKey('fk-package-player', '{{%package}}', 'creator_id', '{{%player}}', 'id', 'NO ACTION');

      $this->addColumn('{{%flash_card}}', 'package_id', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('fk-package-player', '{{%package}}');
      $this->dropColumn('{{%flash_card}}', 'package_id');
      $this->dropTable('{{%package}}');
      $this->dropTable('{{%package_allowance}}');
    }
}
