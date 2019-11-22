<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use yii\db\ActiveRecord;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Nmbr;
use Yii;
use yii\helpers\ArrayHelper;
use phpDocumentor\Reflection\Types\Static_;

/**
 * Give opportunity to bind entity to other entities using relation one to many.
 * 
 * @author devskyfly
 * @param $name
 * @param $master_id
 * @param $slave_id
 */
abstract class AbstractBinder extends ActiveRecord
{
    /**********************************************************************/
    /** Abstract **/
    /**********************************************************************/
    
    /**
     * @return string - Class name
     */
    abstract protected static function masterCls();
    
    /**
     * @return string - Class name
     */
    abstract protected static function slaveCls();
    
    /**
     * Return master class name
     */
    public static function getMasterCls()
    {
        $cls=static::masterCls();
        
        if(!Cls::isSubClassOf($cls, AbstractItem::class)){
            throw new \BadMethodCallException("Method masterCls() return not subclass of ".AbstractItem::class.".");
        };
        
        return $cls;
    }
    
    /**
     * Return slave class name
     */
    public static function getSlaveCls()
    {
        $cls=static::slaveCls();
        
        if(!Cls::isSubClassOf($cls, AbstractItem::class)){
            throw new \BadMethodCallException("Method slaveCls() return not subclass of ".AbstractItem::class.".");
        };
        
        return $cls;
    }
    
    /**
     *
     * @param AbstractItem $item
     * @throws \InvalidArgumentException
     * @return AbstractBinder[]
     */
    public static function getRowsByMasterItem($item)
    {
        $result=static::getRowsByMasterId($item->id);
        return $result;
    }
    
    /**
     * 
     * @param int $id
     * @throws \InvalidArgumentException
     * @return AbstractBinder[]
     */
    public static function getRowsByMasterId($id)
    {
        $id=Nmbr::toIntegerStrict($id);
        $result=static::find()
        ->andWhere(['master_id'=>$id])->all();
        return $result;
    }
    
    //Slave
    
    /**
     *
     * @param AbstractItem
     * @throws \InvalidArgumentException
     * @return int[]
     */
    public static function getSlaveIdsByItem($item)
    {
        $master_id=Nmbr::toIntegerStrict($item->id);
        return static::getSlaveIds($master_id);
    }
    
    /**
     *
     * @param int $master_id
     * @throws \InvalidArgumentException
     * @return int[]
     */
    public static function getSlaveIds($master_id)
    {
        $master_id=Nmbr::toIntegerStrict($master_id);
        $result=static::find()
        ->andWhere(['master_id'=>$master_id])
        ->asArray()
        ->all();
        return array_column($result, 'slave_id');
    }

    /**
     *
     * @throws \InvalidArgumentException
     * @return int[]
     */
    public static function getAllSlaveIds()
    {
        $result=static::find()
        ->asArray()
        ->all();
        return array_column($result, 'slave_id');
    }
    
    /**
     *
     * @param int $master_id
     * @throws \InvalidArgumentException
     * @return AbstractItem[]
     */
    public static function getSlaveItems($master_id)
    {
        $slave_cls=static::getSlaveCls();
        $ids=static::getSlaveIds($master_id);
        $result=$slave_cls::find()
        ->andWhere(['id'=>$ids])
        ->all();     
        return $result;
    }
    
    public static function getSlaveItemsByItem($item)
    {
        $master_id=Nmbr::toIntegerStrict($item->id);
        return static::getSlaveItems($master_id);
    }
    
    //Master
    /**
     *
     * @param int $slave_id
     * @throws \InvalidArgumentException
     * @return int[]
     */
    public static function getMasterIds($slave_id)
    {
        $master_id=Nmbr::toIntegerStrict($slave_id);
        $result=static::find()
        ->andWhere(['slave_id'=>$slave_id])
        ->asArray()
        ->all();
        return array_column($result, 'master_id');
    }

    /**
     *
     * @throws \InvalidArgumentException
     * @return int[]
     */
    public static function getAllMasterIds()
    {
        $result=static::find()
        ->asArray()
        ->all();
        return array_column($result, 'master_id');
    }
    
    /**
     *
     * @param int $master_id
     * @throws \InvalidArgumentException
     * @return AbstractItem[]
     */
    public static function getMasterItems($master_id)
    {
        $master_cls=static::getMasterCls();

        $ids=static::getMasterIds($master_id);
        $result=$master_cls::find()
        ->andWhere(['id'=>$ids])
        ->all();
        return $result;
    }
    /**
     * Remove all item from bind table by master_id
     *
     * @param int $master_id
     * @return int
     */
    public static function clear($master_id)
    {
        return static::deleteAll(['name'=>static::bindName(),'master_id'=>$master_id]);
    }
    
    /**
     * Return bind name for property name converted from short class name.
     * @return string
     */
    protected static function bindName()
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }
    
    /**********************************************************************/
    /** Redeclaration **/
    /**********************************************************************/
    public function init()
    {
        parent::init();
        $name=static::bindName();
        $this->name=$name;
    }
    
    public function rules()
    {
        $rules=parent::rules();
        
        $new_rules=[
            [['name','master_id','slave_id'],'required'],
            [['master_id','slave_id'],'number']
        ];
        
        $rules=ArrayHelper::merge($new_rules, $rules);
        return $rules;
    }
    
    public static function tableName()
    {
        return 'binder';
    }
    
    public static function find()
    {
        return parent::find()->where(['name'=>static::bindName()]);
    }
}

