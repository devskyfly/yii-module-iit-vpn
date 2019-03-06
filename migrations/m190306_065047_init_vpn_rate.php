<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;

/**
 * Class m190306_065047_init_vpn_rate
 */
class m190306_065047_init_vpn_rate extends EntityMigrationHelper
{
    public $table="iit_vpn_rate";
    
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
        echo "m190306_065047_init_vpn_rate cannot be reverted.\n";

        return false;
    }
    */
}
