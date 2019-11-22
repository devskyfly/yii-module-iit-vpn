<?php
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\SectionEditor;

/* @var $item devskyfly\yiiModuleAdminPanel\models\AbstractSection */
/* @var $views callable */
?>
<?
$label=Yii::$app->controller->itemLabel();
$title_prefix="";

if($item->isNewRecord){
    $title_prefix="Создать раздел: ";
}else{
    $title_prefix="Обновить раздел: ";
}

$this->title=$title_prefix.Yii::$app->controller->itemLabel();
?>

<?=SectionEditor::widget(compact("item","views","label"));?>