<?php
/* @var $this yii\web\View */
/* @var $data_provider yii\data\ActiveDataProvider */
/* @var $parent_section_id null|number */
/* @var $columns [] */
use devskyfly\yiiModuleAdminPanel\Module;
use yii\grid\GridView;
use yii\web\Request;
?>

<?
$widget_id=Module::CSS_NAMESPACE.'-content-panel-entity-select-list';
$item_link_button_cls=Module::CSS_NAMESPACE.'-content-panel-entity-select-list__item-link-button';
?>

<div class="<?=$widget_id?>">
	<?=GridView::widget(
	    [
	        'columns'=>$columns,
	        'dataProvider'=>$data_provider        
	    ]
    )?>
</div>



<?
$request = Yii::$app->getRequest();
$params = $request instanceof Request ? $request->getQueryParams():[];

$js = <<<JS_SCRIPT
$(".$widget_id").find(".$item_link_button_cls").click(function(){
    
    var item=$(this);
    
    var slave_objects=window.opener.content_panel.slave_objects["{$params['bind_name']}"];
    slave_objects.setId(item.attr('slave_id'));
    slave_objects.setName(item.attr('slave_name'));
    
    slave_objects.closeWindow();
});
JS_SCRIPT;
?>

<?$this->registerJs($js);?>