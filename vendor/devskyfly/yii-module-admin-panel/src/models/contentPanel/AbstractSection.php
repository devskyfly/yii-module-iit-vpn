<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use devskyfly\php56\core\Cls;
use yii\helpers\ArrayHelper;
use yii\base\Event;

/**
 * This class represent section
 *
 * It dives opportunity to create, edit and delete items.
 * Deleting item also delete all sub sections and sub entities.
 * 
 * @author devskyfly
 * @property strin $name
 * @property string $__id
 */
abstract class AbstractSection extends AbstractItem
{
    
    /**
     * Bind to entity class, to have access to entity class methods
     * 
     * @var devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
     */
    public $entity_cls;
    
    /**
     * Need to return class name
     * 
     * @return string
     */
    abstract protected static function entityCls();
    
    /**
     * Return entity class name
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function getEntityCls()
    {
        $cls=static::entityCls();
        if(!(Cls::isSubClassOf($cls, AbstractEntity::class))){
            throw new \InvalidArgumentException('$cls is not '.AbstractEntity::class.' class.');
        }
        return $cls;
    }
    
    /**********************************************************************/
    /** INIT **/
    /**********************************************************************/
    
    public function init()
    {
        parent::init();
        
        $this->entity_cls=static::getEntityCls();
        
        $entity=$this->entity_cls;
        $this->entity_table=$entity::tableName();
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
        Event::trigger(static::className(), static::EVENT_BEFORE_DELETE_LIKE_ITEM, new ItemEventMessage(['obj'=>$this]));

        $transaction=static::getDb()->beginTransaction();
        try{
            if($this->isNewRecord){
                throw new \LogicException("Try to delete not existed section");
            }
            
            //delete current section extensions
            foreach ($this->extensions as $name=>$extension){
                $extension=$extension::findByItem($this,$name);
                if($extension->delete()===false){
                    throw new \yii\db\Exception('Can\'t delete extension');
                }
            }
            
            //delete current section entities
            $entities=$this->getEntities();
            foreach ($entities as $entity){
                $entity->deleteLikeItem();
            }
            
            //delete subsections and there entities
            $sections=$this->getSubSections();
            foreach ($sections as $section)
            {
                $entities=$section->getEntities();
                
                foreach ($entities as $entity){
                    $entity->deleteLikeItem();
                }
                
                if($section->deleteLikeItem()===false){
                    throw new \yii\db\Exception('Can\'t delete section');
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
    
    /**
     * Return array of sub sections
     * 
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection[]
     * @todo test
     */
    
    /**********************************************************************/
    /** IERARHI **/
    /**********************************************************************/
    
    public function getSubSections()
    {
        $guid=null;
        if(!$this->isNewRecord){
            $guid=$this->id;
        }
        return $this::find()->andWhere(['__id'=>$guid])->all();
    }
    
    /**
     * Return array of sub all sections
     * 
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection[]
     * @todo test
     */
    public function getSubSectionsRecursively()
    {
        $sections_result=[];
        $sub_sections=$this->getSubSections();
        
        foreach ($sub_sections as $section){
            $sections_result[]=$section;
            $arr=$section->getSubSectionsRecursively();
            $sections_result=array_merge($sections_result,$arr);
        }
        return $sections_result;
    }
    
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
            return $this::find()->where(['id'=>$this->__id])->one();
        }
    }
    
    /**
     * Return entities
     * 
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity[]
     * @todo test
     */
    public function getEntities()
    {
        if(!$this->isNewRecord){
            $id=$this->id;
        }
        
        $entity=static::getEntityCls();
        $entities=$entity::find()->where(['_section__id'=>$id])->all();
        return $entities;
    }
    
    /**
     * Return all entities recursively
     * 
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity[]
     * @todo test
     */
    public function getEntitiesRecursively()
    {
        $entities_result=[];
        $sections=$this->getSubSectionsRecursively();
        foreach ($sections as $section){
            $entities=$section->getEntities();
            foreach ($entities as $entity){
                $entities_result[]=$entity;
            }
        }
        return $entities_result;
    }
    
    
    /**********************************************************************/
    /** SEARCH **/
    /**********************************************************************/
    
    /**
     * Init entity_table condition to avoid mistakes in queries
     * 
     * Now you need to use andWhere() method to add more conditions.
     * 
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::find()
     */
    public static function find()
    {
        $cls=static::getEntityCls();
        return parent::find()->where(['entity_table'=>$cls::tableName()]);
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
            [["name"],"required"],
            [["name"],"string"],
            [["code"],"string"],
            [["__id"],"number"]
        ];
        $rules=ArrayHelper::merge($rules, $new_rules);
        return $rules;
    }
    
    public static function tableName()
    {
        return 'section';
    }
}