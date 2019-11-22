<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Vrbl;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Request;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use Yii;

class SectionSelectList extends SectionList
{
    public $entity_cls=null;
    
    public function init()
    {
        parent::init();
        if(!Vrbl::isEmpty($this->entity_cls)){
            if(!Cls::isSubClassOf($this->entity_cls, AbstractEntity::class)){
                throw new \InvalidArgumentException('Property $entity_cls is not '.AbstractEntity::class.' type.');
            }
        }
    }
    /**
     * Init $list property
     */
    protected function formList()
    {
        $section_cls=$this->section_cls;
        $entity_cls=$this->entity_cls;
        
        $query=$section_cls::find()->andWhere(['__id'=>$this->parent_section_id]);
        $query=$query->orderBy($this->sort);
        
        $result=$query->all();
        $i=0;
        
        $route="";
        
        if(Vrbl::isEmpty($entity_cls)){
            $route=$section_cls::selectListRoute();
        }else{
            $route=$entity_cls::selectListRoute();
        }
        
        $request = Yii::$app->getRequest();
        $params = $request instanceof Request ? $request->getQueryParams():[];
        
        
        foreach ($result as $item){
            $full_route=ArrayHelper::merge($params,[$route,'parent_section_id'=>$item->id]);
            $i++;
            $this->list[]=[
                "order"=>$i,
                "active"=>$item->active=="Y"?true:false,
                "id"=>$item->id,
                "name"=>$item->name,
                "sub_section_url"=>Url::toRoute($full_route),
            ];
        }
    }
    
    public function run()
    {
        $this->variables['entity_cls']=$this->entity_cls;
        return $this->render('section-select-list',$this->variables);
    }
}