<?php
/* $this yii/web/view */
/* $list []*/
/* $title string */
use devskyfly\yiiModuleAdminPanel\widgets\common\NavigationMenu;
use devskyfly\yiiModuleIitUc\widgets\RatesTree;
?>
<?
$this->title=$title;
?>
<div class="row">
    <div class="col-xs-3">
    <?=NavigationMenu::widget(['list'=>$list])?>
    
    </div>
</div>