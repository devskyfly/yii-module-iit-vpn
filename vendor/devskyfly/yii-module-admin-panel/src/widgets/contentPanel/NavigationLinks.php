<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Request;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection;

use LogicException;
use Yii;
use devskyfly\php56\types\Lgc;

class NavigationLinks extends Widget
{
    /**
     * 
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection
     */
    public $section_cls;
    
    /**
     * 
     * @var string
     */
    public $label="";
    
    /**
     * 
     * @var null|integer
     */
    public $parent_section_id;
    
    /**
     * 
     * @var true
     */
    public $current_item_is_active=false;
    
    /**
     * Name of route
     * @var string
     */
    public $route='index';
    
    public function init()
    {
        parent::init();
        
        if((!Cls::isSubClassOf($this->section_cls,AbstractSection::class))&&(!Vrbl::isEmpty($this->section_cls))){
            throw new \InvalidArgumentException('Property $section_cls is not '.AbstractSection::class.' class.');
        }
        
        if(!Vrbl::isNull($this->parent_section_id)){
            $this->parent_section_id=Nmbr::toIntegerStrict($this->parent_section_id);
            if((!Nmbr::isInteger($this->parent_section_id))
                &&(!Vrbl::isNull($this->parent_section_id))){
                    throw new \InvalidArgumentException('Property $parent_section_id is not integer or null type.');
            }
        }
        
        if((!Str::isString($this->label))
            &&(!Vrbl::isNull($this->label))){
                throw new \InvalidArgumentException('Property $label is not string type.');
        }
        
        if(!Str::isString($this->route)){
                throw new \InvalidArgumentException('Property $label is not string type.');
        }
        
        if((!Lgc::isBoolean($this->current_item_is_active))
            &&(!Vrbl::isNull($val))){
                throw new \InvalidArgumentException('Property $current_item_is_active is not boolean type.');
        }
    }
    
    
    
    /**
     * 
     * @param integer $section_id
     */
    protected function getSection($section_id)
    {
        $section_cls=$this->section_cls;
        
        
        
        $section=$section_cls::getById($section_id);
        
        if(Vrbl::isNull($section)){
            throw new LogicException('There is no such '.$section_cls.' class item with '.$section_id.' id.');
        }
        return $section;
    }
    
    public function run()
    {
        $label=$this->label;
        $list=[];
        $current_item_is_active=$this->current_item_is_active;
        
        $request = Yii::$app->getRequest();
        $params = $request instanceof Request ? $request->getQueryParams():[];
        
        if(array_key_exists('parent_section_id', $params)){
            unset($params['parent_section_id']);
        }
        if(array_key_exists('entity_id', $params)){
            unset($params['entity_id']);
        }
        
        if(!Vrbl::isEmpty($this->section_cls)){
            if(!Vrbl::isEmpty($this->parent_section_id)){
                
                $parent_section_id=$this->parent_section_id;
                do{
                    $section=$this->getSection($parent_section_id);
                    $full_route=ArrayHelper::merge([$this->route,'parent_section_id'=>$section->id],$params);
                    $list[]=['label'=>$section->name,'url'=>Url::toRoute($full_route)];
                    
                    $parent_section=$section->getParentSection();
                    if(!Vrbl::isNull($parent_section)){
                        $parent_section_id=$parent_section->id;
                    }
                }while(!Vrbl::isNull($parent_section));   
            }
            
            $full_route=ArrayHelper::merge([$this->route],$params);
            $list[]=['label'=>"#",'url'=>Url::toRoute($full_route)];
            $list=Arr::reverse($list);
            return $this->render('navigation-links/section',compact("list","label","current_item_is_active"));
        }else{
            $full_route=ArrayHelper::merge([$this->route],$params);
            $list[]=['label'=>"#",'url'=>Url::toRoute($full_route)];
            return $this->render('navigation-links/entity',compact("list","label"));
        }
        
    }
}