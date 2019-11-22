<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use yii\base\Widget;
use devskyfly\php56\core\Cls;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractBinder;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use yii\widgets\ActiveForm;

/**
 * Widget
 * 
 * Code sample:
 * Binder::widget([
 * "label"=>$label,
 * "form"=>$form,
 * "master_item"=>$master_item,
 * "binder_cls"=>$binder_cls
 * ]);
 * 
 * @author devskyfly
 *
 */
class Binder extends Widget
{
    /**
     * 
     */
    public $label="";
    
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
     * Binder class
     * 
     * @var devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractBinder
     */
    public $binder_cls;
    
    /**
     *
     * @var [['binder'=>,'slave_item']]
     */
    protected $list=[];
    
    public function init()
    {
        parent::init();
        
        if(!Obj::isA($this->form, ActiveForm::class)){
            throw new \InvalidArgumentException('Property $item is not '.ActiveForm::class.' type.');
        }
        
        if(!Str::isString($this->label)){
            throw new \InvalidArgumentException('Property $label is not string type.');
        }
        
        if(!Obj::isA($this->master_item, AbstractItem::class)){
            throw new \InvalidArgumentException('Property $master_item is not '.AbstractItem::class.' type.');
        }
        
        if(!Cls::isSubClassOf($this->binder_cls, AbstractBinder::class)){
            throw new \InvalidArgumentException('Property $binder_cls is not sub class of '.AbstractBinder::class.'.');
        }

        $binder_cls=$this->binder_cls;
        $slave_cls=$binder_cls::getSlaveCls();
        
        $binder_list=[];
        
        if(!$this->master_item->isNewRecord){
            $binder_list=$binder_cls::getRowsByMasterItem($this->master_item);
        }
        $list=[]; 
        
        foreach ($binder_list as $binder){
            $slave_id=$binder->slave_id;
            $slave_item=$slave_cls::find()->where(['id'=>$slave_id])->one();
            $this->list[]=['binder'=>$binder,'slave_item'=>$slave_item];
        }
    }
    
    public function run()
    {
        $label=$this->label;
        $binder_cls=$this->binder_cls;
        $form=$this->form;
        $master_item=$this->master_item;
        $slave_item_cls=$binder_cls::getSlaveCls();
        $list=$this->list;
        
        return $this->render('binder',compact("form","list","master_item","binder_cls","slave_item_cls","label"));
    }
}