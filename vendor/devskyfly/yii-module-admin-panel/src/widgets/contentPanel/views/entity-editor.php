<?php
/* @var $this \yii\web\View */
/* @var $item \devskyfly\yiiModuleAdminPanel\models\AbstractItem */
/* @var $views callable */

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\NavigationLinks;
?>
<?
$label_prefix="";
if($item->isNewRecord){
    $label_prefix="Создать элемент: ";
}else{
    $label_prefix="Обновить элемент: ";
}
if(!Vrbl::isEmpty($item->_section__id))
{
    $parent_section_id=Nmbr::toIntegerStrict($item->_section__id);
}else{
    $parent_section_id=$item->_section__id;
}
?>

<div>
	<h4>
		<strong><?=$label_prefix.$label?></strong>
	</h4>
</div>

<?if(!Vrbl::isEmpty($item->section_cls)):?>
<div class="row">
	<?=NavigationLinks::widget(
	    [
	        "current_item_is_active"=>true,
	        'section_cls'=>$item->section_cls,
	        'parent_section_id'=>Vrbl::isEmpty($parent_section_id)?null:$parent_section_id
	    ])
    ?>
</div>
<?else:?>
<div class="row">
	<?=NavigationLinks::widget()
    ?>
</div>
<?endIf;?>

<?
$form=ActiveForm::begin(['method'=>'POST','options'=>['name'=>'entity-editor-form']]);
$errors=$item->getAllErrors();
?>

<?if(!Vrbl::isEmpty($errors)):?>
	<div>
    	<div>
    		<h4>Errors</h4>
    	</div>
    	<div>
            <ul class="list-group">
            <?foreach($errors as $error):?>
            	<li class="list-group-item list-group-item-danger"><?=$error?></li>
            <?endforeach;?>
            </ul>
        </div>
    </div>
<?endif;?>

<?=Tabs::widget(['items'=>$views($form,$item)]);?>

<?=$this->render('_item-buttons',compact("item"))?>
<?$form->end();?>