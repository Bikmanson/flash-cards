<?php

use yii\db\Migration;

/**
 * Class m181211_135618_create_table_flash
 */
class m181211_135618_create_table_flash extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('{{%flash}}', [
        'id' => $this->primaryKey(),
      ]);

      $this->createTable('{{%flash_lang}}', [
        'id' => $this->primaryKey(),
        'entity_id' => $this->integer(11),
        'lang_id' => $this->integer(11),
        'question' => $this->text(),
        'answer' => $this->text()
      ]);

      $this->addForeignKey('fk-flash_lang-flash', '{{%flash_lang}}', 'entity_id', '{{%flash}}', 'id', 'CASCADE');

      $this->addForeignKey('fk-flash_lang-lang', '{{%flash_lang}}', 'lang_id', '{{%lang}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('fk-flash_lang-lang', '{{%flash_lang}}');

      $this->dropForeignKey('fk-flash_lang-flash', '{{%flash_lang}}');

      $this->dropTable('{{%flash_lang}}');

      $this->dropTable('{{%flash}}');
    }
}
