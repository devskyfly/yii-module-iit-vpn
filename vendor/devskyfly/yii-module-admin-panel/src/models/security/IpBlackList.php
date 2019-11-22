<?php
namespace devskyfly\yiiModuleAdminPanel\models\security;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractUnnamedEntity;

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
class IpBlackList extends AbstractUnnamedEntity
{
    protected static function sectionCls()
    {
        return null;
    }

    public function extensions()
    {
        return [];
    }

    public function getIp()
    {
        return $this->ip;
    }
    
    public function setIp($val)
    {
        $this->name=$val;
        return $this;
    }
    
    /**
     *
     * @param string $ip
     * @return \yii\db\ActiveRecord|array|NULL
     */
    public static function findByIp($ip)
    {
        return static::find()->where(['ip'=>$ip])->one();
    }
    
    /**********************************************************************/
    /** Redeclaration **/
    /**********************************************************************/
    public function rules()
    {
        $rules=parent::rules();
        $rules[]=['ip','ip'];
        return $rules;
    }
}

