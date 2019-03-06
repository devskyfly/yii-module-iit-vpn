<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;

/**
 * Class m190306_065105_init_vpn_service
 */
class m190306_065105_init_vpn_service extends EntityMigrationHelper
{
    public $table="iit_vpn_service";
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fields=$this->getFieldsDefinition();
        $fields['price']='DECIMAL(8,2)';
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
        echo "m190306_065105_init_vpn_service cannot be reverted.\n";

        return false;
    }
    */
}
