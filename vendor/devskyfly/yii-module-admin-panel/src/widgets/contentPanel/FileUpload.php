<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

use yii\base\Widget;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem;
use yii\widgets\ActiveForm;

class FileUpload extends Widget
{
    /**
     * 
     * @var \yii\widgets\ActiveForm
     */
    public $form;
    
    /**
     * 
     * @var AbstractItem
     */
    public $item;
    
    /**
     * 
     * @var string
     */
    public $attribute;
    
    public function init()
    {
        parent::init();
        
        if(!Obj::isA($this->form,ActiveForm::class)){
            throw new \InvalidArgumentException('Property $form is not '.ActiveForm::class.' type.');
        }
        
        if(!Obj::isA($this->item,AbstractItem::class)){
            throw new \InvalidArgumentException('Property $item is not '.AbstractItem::class.' type.');
        }
        
        if(!Str::isString($this->attribute)){
            throw new \InvalidArgumentException('Property $attribute is not string type.');
        }
    }
    
    public function run()
    {
        $form=$this->form;
        $item=$this->item;
        $attribute=$this->attribute;
        $file=$item->extensions[$attribute];
        
        return $this->render('file-upload', compact("form","item","attribute","file"));
    }
}