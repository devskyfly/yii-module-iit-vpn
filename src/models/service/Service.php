<?php
namespace devskyfly\yiiModuleIitVpn\models\service;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;

/**
 *
 * @author devskyfly
 * @property $price
 */
class Service extends AbstractEntity
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
        return 'iit_vpn_service';
    }
    
    protected static function sectionCls()
    {
        return null;
    }
}