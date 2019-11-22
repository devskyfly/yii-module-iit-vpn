<?php
namespace devskyfly\yiiModuleIitVpn\models\rate;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;

/**
 * 
 * @author devskyfly
 * @property $price
 */
class Rate extends AbstractEntity
{
    public function rules()
    {
        $rules=parent::rules();
        $new_rules=[
            [['price'],'string']
        ];
        
        $rules=ArrayHelper::merge($rules, $new_rules);
        return $rules;
    }
    
    public static function tableName()
    {
        return 'iit_vpn_rate';
    }

    
    protected static function sectionCls()
    {
        return Section::class;
    }
}