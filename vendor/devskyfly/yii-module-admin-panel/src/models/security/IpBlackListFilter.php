<?php
namespace devskyfly\yiiModuleAdminPanel\models\security;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterTrait;

/**
 * 
 * @author devskyfly
 * @property integer $id
 * @property string $ip
 * @property string $code
 * @property string $active
 * @property integer $sort
 * @property string $create_date_time
 * @property string $change_date_time
 * @property string $_section__id
 */
class IpBlackListFilter extends IpBlackList implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [
            [["ip","active","create_date_time","change_date_time"],"string"]
        ];
    }
    

}

