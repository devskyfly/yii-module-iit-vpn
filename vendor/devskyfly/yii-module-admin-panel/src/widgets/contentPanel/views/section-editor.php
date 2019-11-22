<?php
/* @var $this \yii\web\View */
/* @var $item \devskyfly\yiiModuleAdminPanel\models\AbstractItem */
/* @var $views callable */

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\NavigationLinks;
?>
<?
$label_prefix="";
if($item->isNewRecord){
    $label_prefix="Создать раздел: ";
}else{
    $label_prefix="Обновить раздел: ";
}
$section_cls=Obj::getClassName($item);

if(!Vrbl::isEmpty($item->__id))
{
    $parent_section_id=Nmbr::toIntegerStrict($item->__id);
}else{
    $parent_section_id=$item->__id;
}
?>
<div>
	<h4>
		<strong><?=$label_prefix.$label?></strong>
	</h4>
</div>
<div class="row">
	<?=NavigationLinks::widget(
	    [
	        "current_item_is_active"=>true,
	        'section_cls'=>$section_cls,
	        'parent_section_id'=>Vrbl::isEmpty($parent_section_id)?null:$parent_section_id
	    ])
    ?>
</div>
<?$form=ActiveForm::begin(['method'=>'POST','options'=>['name'=>'section-editor-form']]);?>

<?
$errors=$item->getAllErrors();
?>

<?if(!Vrbl::isEmpty($errors)):?>
	<div>
	<div><h4>Errors</h4></div>
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