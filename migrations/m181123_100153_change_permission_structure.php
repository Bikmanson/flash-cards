<?php

use yii\db\Migration;

/**
 * Class m181123_100153_change_permission_structure
 */
class m181123_100153_change_permission_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//       package and package_permission
      $this->renameTable('{{%package_allowance}}', '{{%package_permission}}');
      $this->dropColumn('{{%package}}', 'allowance_id');
      $this->renameColumn('{{%package_permission}}', 'allowance_id', 'package_id');
      $this->addForeignKey('fk-package_permission-package', '{{%package_permission}}', 'package_id', '{{%package}}', 'id', 'CASCADE');

//       flash_card
      $this->alterColumn('{{%flash_card}}', 'package_id', $this->integer(11)->notNull());
      $this->addForeignKey('fk-flash_card-package', '{{%flash_card}}', 'package_id', '{{%package}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      // flash_card
      $this->dropForeignKey('fk-flash_card-package', '{{%flash_card}}');
      $this->alterColumn('{{%flash_card}}', 'package_id', $this->integer(11));

      // package and package_permission
      $this->dropForeignKey('fk-package_permission-package', '{{%package_permission}}');
      $this->renameColumn('{{%package_permission}}', 'package_id', 'allowance_id');
      $this->addColumn('{{%package}}', 'allowance_id', $this->integer(11));
      $this->renameTable('{{%package_permission}}', '{{%package_allowance}}');
    }
}
