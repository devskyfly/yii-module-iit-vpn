<?php
use yii\helpers\Html;
use yii\helpers\Url;
use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractUnnamedEntity;

/* @var $this \yii\web\View */
/* @var $item devskyfly\yiiModuleAdminPanel\models\AbstractItem */
?>
<?
$classes=[
    "btn",
    "btn-primary",
];

$delete_action='';
$item_id_name='';

if(Obj::isA($item, AbstractUnnamedEntity::class)){
    $delete_action='entity-delete';
    $item_id_name='entity_id';
}elseif(Obj::isA($item, AbstractSection::class)){
    $delete_action='section-delete';
    $item_id_name='section_id';
}else{
    throw new \InvalidArgumentException('Param $item is not '.AbstractUnnamedEntity::class.' or '.AbstractSection::class.' type.');
}

$action='';
if(Obj::isA($item, AbstractUnnamedEntity::class)){
    $action='section-delete';
}elseif (Obj::isA($item, AbstractSection::class)){
    $action='entity-delete';
}else{
    throw \InvalidArgumentException('Param $item is not '.AbstractUnnamedEntity::class.' type.');
}
?>
<?if($item->isNewRecord):?>
	<?=Html::submitButton("Создать",["class"=>$classes])?>
<?else:?>
    <?=Html::submitButton("Обновить",["class"=>$classes])?>
    <?=Html::a("Удалить",Url::toRoute([$delete_action,$item_id_name=>$item->id]),["class"=>$classes,'data-confirm' => 'Удалить?',])?>
<?endif?>