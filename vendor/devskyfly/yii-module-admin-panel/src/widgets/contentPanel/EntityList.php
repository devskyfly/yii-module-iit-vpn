<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use yii\base\Widget;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractUnnamedEntity;
use Yii;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;

class EntityList extends Widget
{
    /**
     *
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface
     */
    public $entity_filter_cls;
    /**
     *
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity
     */
    public $entity_cls;
    
    /**
     * @var integer|null
     */
    public $page=null;
    
    /**
     * @var integer|null
     */
    public $parent_section_id=null;
    
    /**
     * @var array
     */
    public $entity_columns=[];
    
    protected $variables=[];
    
    public function init()
    {
        parent::init();
        
        if(!Vrbl::isNull($this->parent_section_id))
        {
            $this->parent_section_id=Nmbr::toIntegerStrict($this->parent_section_id);
            if(!Nmbr::isInteger($this->parent_section_id)){
                throw new \InvalidArgumentException('Property $parent_section_id is not integer type.');
            }
        }
        if(!Vrbl::isNull($this->page))
        {
            if(!Nmbr::isInteger($this->page)){
                throw new \InvalidArgumentException('Property $page is not integer type.');
            }
        }
        
        if(!Cls::isSubClassOf($this->entity_cls,AbstractUnnamedEntity::class)){
            throw new \InvalidArgumentException('Property $entity_cls is not '.AbstractUnnamedEntity::class.' class.');
        }
        
        if(!Vrbl::isNull($this->entity_filter_cls)){
            if(!Cls::isSubClassOf($this->entity_filter_cls,FilterInterface::class)){
                throw new \InvalidArgumentException('Property $entity_cls is not '.FilterInterface::class.' class.');
            }
        }
        
        if(!Arr::isArray($this->entity_columns)){
            throw new \InvalidArgumentException('Property $page is not array type.');
        }
        
        $parent_section_id=$this->parent_section_id;
        $entity_filter_cls=$this->entity_filter_cls;
        $entity_cls=$this->entity_cls;       
        $columns=$this->entity_columns;
        
        $filter_model=null;
        
        if(!Vrbl::isNull($entity_filter_cls)){
            $filter_model=new $entity_filter_cls();
            $data_provider=$filter_model->search(Yii::$app->request->get(),$this->parent_section_id);
        }else{
            $data_provider=new ActiveDataProvider([
                'query'=>$entity_cls::find()->where(['_section__id'=>$this->parent_section_id]),
                'pagination'=>[
                    'pageSize'=>30,
                    'page'=>$this->page-1
                ]
            ]);
        }
        
        $this->variables=compact("data_provider","filter_model","columns","parent_section_id");
    }
    
    
    public function run()
    {
        return $this->render('entity-list',$this->variables);
    }
}