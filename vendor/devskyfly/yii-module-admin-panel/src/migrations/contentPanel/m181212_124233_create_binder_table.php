<?php

use yii\db\Migration;
use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\BinderMigrationHelper;

/**
 * Handles the creation of table `binder`.
 */
class m181212_124233_create_binder_table extends BinderMigrationHelper
{
    public $table='binder';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
