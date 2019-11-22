<?php
/* @var $this yii\web\View */
/* @var $list [] */
/* @var $parent_section_id null|number */
/* @var $section_cls */
/* @var $entity_cls devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity */

use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
?>

<?php 
$css_namespace=Module::CSS_NAMESPACE.'-';
$widget_id=$css_namespace.'-content-panel-section-list-for-select';
$item_id_cls=$css_namespace.'-content-panel-item-selector__item-id';
$item_name_cls=$css_namespace.'-content-panel-item-selector__item-name';

$link_button_cls=$css_namespace.'-content-panel-item-selector__item-link-button';
?>

<div class="<?=$widget_id?>">
    <table class="table">
    <?//Caption?>
    <?if(Vrbl::isEmpty($parent_section_id)):?>
    	<tr>
    		<?if(Vrbl::isEmpty($entity_cls)):?>
        	<td >
        		<a>
            		<span slave_name="#" 
            		slave_id="" 
            		class="glyphicon glyphicon-link <?=$link_button_cls?>">
            		</span>
        		</a>
    		</td>
    		<?endif;?>
        	<td>-</td>
        	<td></td>
        	<td><a>#</a></td>
    	</tr>
    <?endif;?>
    
    <?//Body?>
    <?foreach ($list as $item):?>
    	<tr>
    		<?if(Vrbl::isEmpty($entity_cls)):?>
        	<td>
            	<a>
                	<span 
                	slave_name="<?=addslashes($item['name'])?>" 
                	slave_id="<?=$item['id']?>" 
                	class="glyphicon glyphicon-link <?=$link_button_cls?>">
                	</span>
            	</a>
    		</td>
    		<?endif;?>
        	<td><?=$item['order']?></td>
        	<td><span class="<?=$item['active']?"glyphicon glyphicon-ok":""?>"></span></td>
        	<td>
        		<?=Html::a($item['name'],Url::toRoute($item['sub_section_url']))?>
        	</td>
    	</tr>
    <?endforeach;?>
    </table>
</div>

<?
$request = Yii::$app->getRequest();
$params = $request instanceof Request ? $request->getQueryParams():[];

if(Vrbl::isEmpty($entity_cls)){

$script = <<<JS_SCRIPT
$(".$widget_id").find(".$link_button_cls").click(function(){
    var item=$(this);
    var slave_objects=window.opener.content_panel.slave_objects["{$params['bind_name']}"];
       
    slave_objects.setId(item.attr('slave_id'));
    slave_objects.setName(item.attr('slave_name'));
    slave_objects.closeWindow();
});
JS_SCRIPT;

$this->registerJs($script);
}
?>