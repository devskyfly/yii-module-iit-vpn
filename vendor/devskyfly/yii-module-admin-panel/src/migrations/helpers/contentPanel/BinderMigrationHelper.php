<?php
namespace devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel;


class BinderMigrationHelper extends AbstractMigrationHelper
{
    public function getFieldsDefinition()
    {
        return [
            'id' => $this->primaryKey(),
            'name'=>$this->string(255),
            'master_id'=>$this->integer(11),
            'slave_id'=>$this->integer(11)
        ];
    }
}