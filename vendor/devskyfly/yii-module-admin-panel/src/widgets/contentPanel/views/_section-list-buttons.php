<?php
/* @var $parent_section_id integer */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?
$classes=[
    "btn",   
    "btn-primary",   
];
?>
<div>
	<?=Html::a("Создать раздел",Url::toRoute(['section-create','parent_section_id'=>$parent_section_id]),['class'=>$classes])?>
</div>