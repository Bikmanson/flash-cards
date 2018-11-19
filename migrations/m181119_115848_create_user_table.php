<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m181119_115848_create_user_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('{{%player}}', [
      'id' => $this->primaryKey(),
      'username' => $this->string('20')->unique()->notNull(),
      'password_hash' => $this->string()->unique()->notNull(),
      'authKey' => $this->string()->unique()->notNull()
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable('{{%player}}');
  }
}
