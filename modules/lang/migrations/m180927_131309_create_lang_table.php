<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lang`.
 */
class m180927_131309_create_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema('{{%lang}}', true))
            $this->dropTable('{{%lang}}');

        $this->createTable('{{%lang}}', [
            'id' => $this->integer()->notNull()->unique(),
            'name' => $this->string(64)->notNull(),
            'label' => $this->string(64),
            'ietf_tag' => $this->string(64)->notNull(),
            'is_default' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('pk-lang-id', '{{%lang}}', 'id');
        $this->batchInsert('{{%lang}}', ['id', 'name', 'label', 'ietf_tag', 'is_default', 'created_at', 'updated_at'], [
            [1, 'Русский', 'язык', 'ru', 0, time(), time()],
            [2, 'Украинский', 'мова', 'uk', 0, time(), time()],
            [3, 'English', 'language', 'en', 1, time(), time()],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lang}}');
    }
}
