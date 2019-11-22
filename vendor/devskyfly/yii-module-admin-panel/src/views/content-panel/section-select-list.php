<?php
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\EntitySelectList;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\SectionSelectList;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\NavigationLinks;
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

<?if(!Vrbl::isEmpty($section_cls)):?>
<div class="row">
	<?=NavigationLinks::widget(['section_cls'=>$section_cls,'parent_section_id'=>$parent_section_id,'label'=>$label,'route'=>'section-select-list'])?>
</div>
<?endif;?>

<div class="row">
	<div class="col-xs-12">
		<?=SectionSelectList::widget(compact("section_cls","parent_section_id"))?>
	</div>
</div>