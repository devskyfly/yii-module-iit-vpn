<?php
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\EntitySelectList;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\NavigationLinks;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\SectionSelectList;
use devskyfly\php56\types\Vrbl;

/* @var $entity_cls \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstructEntity */
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
	<?=NavigationLinks::widget(['section_cls'=>$section_cls,'parent_section_id'=>$parent_section_id,'label'=>$label,'route'=>'entity-select-list'])?>
</div>
<?else:?>
<div class="row">
	<?=NavigationLinks::widget(['label'=>$label])?>
</div>
<?endif;?>

<div class="row">
	<?if($show_section_list):?>
	<div class="col-xs-3">
		<?=SectionSelectList::widget(compact("section_cls","parent_section_id","entity_cls"))?>
	</div>
	<?endif;?>
	<div <?=$show_section_list?'class="col-xs-9"':'class="col-xs-12"'?>>
		<?=EntitySelectList::widget(compact("entity_cls","parent_section_id","page","entity_columns"))?>
	</div>
</div>
