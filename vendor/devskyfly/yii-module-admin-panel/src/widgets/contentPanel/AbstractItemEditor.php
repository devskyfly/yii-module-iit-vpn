<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use yii\base\Widget;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem;

abstract class AbstractItemEditor extends Widget
{
    /**
     * 
     * @var string
     */
    public $label;

    /**
     * Instance of item
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    public $item=null;
    
    /**
     * 
     * @var array
     */
    public $views=[];
    
    /**
     * 
     * @var string
     */
    public $view=null;
    
    public function init()
    {
        parent::init();
        
        if(!Obj::isA($this->item, AbstractItem::class)){
            throw new \InvalidArgumentException('Property $item_container is not '.AbstractItem::class.' type.');
        }
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        $views=$this->views;
        $item=$this->item;
        $label=$this->label;
        return $this->render($this->view,compact("item","views","label"));
    }
    
}