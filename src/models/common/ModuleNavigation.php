<?php
namespace devskyfly\yiiModuleIitVpn\models\common;

use devskyfly\yiiModuleAdminPanel\models\common\AbstractModuleNavigation;

class ModuleNavigation extends AbstractModuleNavigation
{
    protected function moduleRoute()
    {
        return "/iit-vpn/";
    }

    protected function moduleList()
    {
        return
        [
            ['name'=>'Услуги','route'=>'/iit-vpn/services'],
            ['name'=>'Тарифы','route'=>'/iit-vpn/rates'],
        ];
    }

    protected function moduleName()
    {
        return 'iit-vpn';
    }

}