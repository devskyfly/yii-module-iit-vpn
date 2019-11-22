<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;


class EntitySelectList extends EntityList
{
    

    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        return $this->render('entity-select-list',$this->variables);
    }
}