<?php
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\EntityEditor;

/* @var $item devskyfly\yiiModuleAdminPanel\models\AbstractEntity */
/* @var $views callable */
?>
<?
$label=Yii::$app->controller->itemLabel();
$title_prefix="";

if($item->isNewRecord){
    $title_prefix="Создать элемент: ";
}else{
    $title_prefix="Обновить элемент: ";
}

$this->title=$title_prefix.Yii::$app->controller->itemLabel();
?>

<?=EntityEditor::widget(compact("item","views","label"));?>