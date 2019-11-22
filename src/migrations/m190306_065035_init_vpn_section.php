<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\SectionMigrationHelper;

/**
 * Class m190306_065035_init_vpn_section
 */
class m190306_065035_init_vpn_section extends SectionMigrationHelper
{
    public $table="iit_vpn_section";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fields=$this->getFieldsDefinition();
        $this->createTable($this->table, $fields);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190306_065035_init_vpn_section cannot be reverted.\n";

        return false;
    }
    */
}
