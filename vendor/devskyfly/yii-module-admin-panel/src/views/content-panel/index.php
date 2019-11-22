<?php
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\EntityList;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\SectionList;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\NavigationLinks;
use devskyfly\php56\types\Vrbl;

/* @var $entity_filter_cls \devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface*/
/* @var $entity_cls \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstructEntity*/
/* @var $entity_columns mixed */
/* @var $section_cls \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstructSection */
/* @var $parent_section_id null|number */
/* @var $page null|integer */
?>

<?
$label=Yii::$app->controller->itemLabel();
$this->title=Yii::$app->controller->itemLabel();
?>

<?
$show_section_list=false;

if(!Vrbl::isNull($section_cls)){
    $show_section_list=true;
}
?>


<?if(!Vrbl::isEmpty($section_cls)):?>
<div class="row">
	<?=NavigationLinks::widget(['section_cls'=>$section_cls,'parent_section_id'=>$parent_section_id,'label'=>$label])?>
</div>
<?else:?>
<div class="row">
	<?=NavigationLinks::widget(['label'=>$label])?>
</div>
<?endif;?>

<div class="row">
	<?if($show_section_list):?>
	<div class="col-xs-3">
		<?=SectionList::widget(compact("section_cls","parent_section_id"))?>
	</div>
	<?endif;?>
	<?if($entity_cls):?>
	<div <?=$show_section_list?'class="col-xs-9"':'class="col-xs-12"'?>>
		<?=EntityList::widget(compact("entity_filter_cls","entity_cls","parent_section_id","page","entity_columns"))?>
	</div>
	<?endif;?>
</div>