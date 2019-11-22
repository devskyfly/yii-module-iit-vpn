<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use devskyfly\php56\types\Vrbl;
use devskyfly\php56\core\Cls;
use yii\helpers\ArrayHelper;
use yii\base\Event;

/**
 * This class represent entity
 * 
 * @author devskyfly
 * @property string $_section__id
 */
abstract class AbstractUnnamedEntity extends AbstractItem 
{
    /**
     * Bind to section class, to have access to section class methods
     *
     * @var devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection;
     */
    public $section_cls;
    
    /**
     * Need to return class name
     * 
     * @return string
     */
    abstract protected static function sectionCls();
    
    /**
     * Return entity class name
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function getSectionCls()
    {
        $cls=static::sectionCls();
        if((!Cls::isSubClassOf($cls, AbstractSection::class))&&(!Vrbl::isEmpty($cls))){
            throw new \InvalidArgumentException('$cls is not '.AbstractSection::class.' class.');
        }
        return $cls;
    }
    
    /**********************************************************************/
    /** INIT **/
    /**********************************************************************/
    
    
    public function init()
    {
        parent::init();
        $this->section_cls=$this->getSectionCls();
        $this->initCreateAndChangeDateTime();
    }
    
    /**********************************************************************/
    /** CRUD **/
    /**********************************************************************/
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    public function deleteLikeItem()
    {
        $this->trigger(static::EVENT_BEFORE_DELETE_LIKE_ITEM);
        Event::trigger(static::className(), static::EVENT_AFTER_DELETE_LIKE_ITEM, new ItemEventMessage(['obj'=>$this]));

        $transaction=static::getDb()->beginTransaction();
        try{
            if($this->isNewRecord){
                throw new \LogicException("Try to delete not existed section");
            }
            
            foreach ($this->extensions as $extension){
                if($extension->delete()===false){
                    throw new \yii\db\Exception('Can\'t delete extension');
                }
            }
            if($this->delete()===false){
                throw new \yii\db\Exception('Can\'t delete section');
            }
            $transaction->commit();
        }catch(\yii\db\Exception $e){
            $transaction->rollBack();
            return false;
        }catch (\Exception $e){
            $transaction->rollBack();
            throw $e;
        }
        catch (\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }
        $this->trigger(static::EVENT_AFTER_DELETE_LIKE_ITEM);
        Event::trigger(static::className(), static::EVENT_AFTER_DELETE_LIKE_ITEM, new ItemEventMessage(['obj'=>$this]));

        return true;
    }
    
    /**********************************************************************/
    /** SEARCH **/
    /**********************************************************************/
    
    /**
    * Return parent section
    *
    * @return NULL | devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection
    * @todo test
    */
    public function getParentSection()
    {
        if($this->isNewRecord){
            return null;
        }else{
            $section=$this->section_cls;
            
            if(Vrbl::isNull($section)){
                return null;
            }
            
            return $section::find()
            ->where(['id'=>$this->_section__id])
            ->one();
        }
    }
  
    /**
     *
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        $rules=parent::rules();
        $new_rules=[
            [["_section__id"],"number"]
        ];
        $rules=ArrayHelper::merge($rules, $new_rules);
        return $rules;
    }

}