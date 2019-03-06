<?php
namespace devskyfly\yiiModuleIitVpn\models\service;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterTrait;

class ServiceFilter extends Service implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [
            [['active','create_date_time','change_date_time','name'],'string']
        ];
    }
}