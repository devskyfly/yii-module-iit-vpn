<?php
namespace devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel;

use yii\db\Migration;

class PageMigrationHelper extends AbstractMigrationHelper
{
    public function getFieldsDefinition()
    {
        return [
            'id'=>$this->primaryKey(11),
            'preview_text'=>$this->text(60000),
            'detail_text'=>$this->text(),
            'preview_img'=>$this->text(),
            'detail_img'=>$this->text(),
            'title'=>$this->text(),
            'keywords'=>$this->text(),
            'description'=>$this->text(),
            'item_table'=>$this->string(256)->notNull(),
            '__id'=>$this->integer(11)
        ];
    }
}