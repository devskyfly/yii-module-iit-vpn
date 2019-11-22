<?php
namespace devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel;

use yii\db\Migration;

class SectionMigrationHelper extends AbstractMigrationHelper
{
    public function getFieldsDefinition()
    {
        return [
            'id'=>$this->primaryKey(11),
            'name'=>$this->string(255)->notNull(),
            'code'=>$this->string(255)->unique(),
            'active'=>"ENUM('Y','N') NOT NULL",
            'sort'=>$this->integer(11),
            'create_date_time'=>$this->dateTime(),
            'change_date_time'=>$this->dateTime(),
            'entity_table'=>$this->string(256)->notNull(),
            '__id'=>$this->integer(11)
        ];
    }
}