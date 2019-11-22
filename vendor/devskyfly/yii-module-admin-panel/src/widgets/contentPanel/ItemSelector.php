<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use yii\base\Widget;
use devskyfly\php56\core\Cls;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use yii\widgets\ActiveForm;

class ItemSelector extends Widget
{
    /**
     * 
     * @var \yii\widgets\ActiveForm
     */
    public $form=null;
    
    /**
     * Master item instance
     * 
     * @var devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    public $master_item=null;
    
    /**
     * Property name where master item hold slave item id
     * 
     * @var string
     */
    public $property;
    
    
    /**
     * Class name of linked item
     *
     * @var devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    public $slave_item_cls="";
    
    /**
     *
     * @var devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    protected $slave_item=null;
    
    public function init()
    {
        if(!Obj::isA($this->form, ActiveForm::class)){
            throw new \InvalidArgumentException('Property $item is not '.ActiveForm::class.' type.');
        }
        
        if(!Obj::isA($this->master_item, AbstractItem::class)){
            throw new \InvalidArgumentException('Property $master_item is not '.AbstractItem::class.' type.');
        }
        
        if(!Cls::isSubClassOf($this->slave_item_cls, AbstractItem::class)){
            throw new \InvalidArgumentException('Property $slave_item_cls is not sub class of '.AbstractItem::class.'.');  
        }
        
        $slave_item_id=$this->master_item[$this->property];
        
        if(!Vrbl::isEmpty($slave_item_id)){
            $slave_item_id=Nmbr::toIntegerStrict($slave_item_id);
            $slave_item_cls=$this->slave_item_cls;
            $this->slave_item=$slave_item_cls::getById($slave_item_id);
        }
        
    }
    
    public function run()
    {
        $form=$this->form;
        $master_item=$this->master_item;
        $slave_item=$this->slave_item;
        $slave_item_cls=$this->slave_item_cls;
        $property=$this->property;
        return $this->render('item-selector',compact("master_item","slave_item","slave_item_cls","form","property"));
    }
}