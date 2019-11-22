<?php
namespace devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel;

use yii\db\Migration;

class FileMigrationHelper extends AbstractMigrationHelper
{
    public function getFieldsDefinition()
    {
        return [
            'id'=>$this->primaryKey(11),
            'guid'=>$this->char(36)->unique(),
            'path'=>$this->text(),
            'item_table'=>$this->string(256)->notNull(),
            '__id'=>$this->integer(11)
        ];
    }
}