<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use yii\base\Widget;
use yii\helpers\Url;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Arr;


/**
 */
class SectionList extends Widget
{
    /**
     * 
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection
     */
    public $section_cls;
    
    /**
     * 
     * @var null|number
     */
    public $parent_section_id=null;
    
    /**
     * Array of columns and order conditions
     * @var null|array
     */
    public $sort=null;
    
    protected $list=[];
    
    protected $variables=[];
    
    public function init()
    {
        parent::init();
        
        if(!Cls::isSubClassOf($this->section_cls, AbstractSection::class)){
            throw new \InvalidArgumentException('Property $section_cls is not '.AbstractSection::class.' class.');
        }
        
        if(!Vrbl::isNull($this->parent_section_id)){
            $this->parent_section_id=Nmbr::toIntegerStrict($this->parent_section_id);
            if(!Nmbr::isInteger($this->parent_section_id)){
                throw new \InvalidArgumentException('Property $parent_section_id is not number type.');
            }
        }

        if(!Vrbl::isNull($this->sort)){
            if(!Arr::isArray($this->sort)){
                throw new \InvalidArgumentException('Property $sort is not array type.');
            }
        }else{
            $this->sort=['name'=>SORT_ASC];
        }
        $this->formList();
        
        $parent_section_id=$this->parent_section_id;
        $list=$this->list;
        $section_cls=$this->section_cls;
        $this->variables=compact("parent_section_id","list","section_cls");
    }
    
    /**
     * Init $list property
     */
    protected function formList()
    {
        $section=$this->section_cls;
        $query=$section::find()->andWhere(['__id'=>$this->parent_section_id]);
        $query=$query->orderBy($this->sort);

        $result=$query->all();
        $i=0;
        foreach ($result as $item){
            $i++;
            $this->list[]=[
                "order"=>$i,
                "active"=>$item->active=="Y"?true:false,
                "name"=>$item->name,
                "sub_section_url"=>Url::toRoute(['index','parent_section_id'=>$item->id]),
                "edit_url"=>Url::toRoute(['section-edit','section_id'=>$item->id]),
                "delete_url"=>Url::toRoute(['section-delete','section_id'=>$item->id]),
            ];
        }
    }
    
    public function run()
    {
        return $this->render('section-list',$this->variables);
    }
}