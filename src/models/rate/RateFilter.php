<?php
namespace devskyfly\yiiModuleIitVpn\models\rate;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterTrait;

class RateFilter extends Rate implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [
            [['active','create_date_time','change_date_time','name'],'string']
        ];
    }
}