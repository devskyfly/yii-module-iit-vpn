<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

interface FilterInterface
{
    public function search($params,$parent_section_id);
    
}