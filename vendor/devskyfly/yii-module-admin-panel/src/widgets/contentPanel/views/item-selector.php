<?php
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\assets\VueAsset;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\ItemSelector;
use yii\helpers\Inflector;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $master_item \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem */
/* @var $slave_item \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem */
/* @var $slave_item_cls \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem */
/* @var $property string */
?>

<?
$widget_cls=ItemSelector::class;
$short_cls=(new ReflectionClass($widget_cls))->getShortName();

$widget_name="content-panel-item-selector";
$widget_id=$widget_name.'-'.Inflector::camel2id(str_replace("\\", "-", $widget_cls)).'-'
.str_replace('_', '-', $slave_item_cls::tableName());

$name="";
$id=0;

if(!Vrbl::isEmpty($slave_item)){
    $name=$slave_item->name;
    $id=$slave_item->id;
}else{
    $name="Связь не установлена";
    $id="";
}

$url=$slave_item_cls::selectListRoute();
?>
<div 
class="well well-sm" 
id="<?=$widget_id?>">
    <div 
    style="padding-bottom:30px" 
    class="content-panel-item-selector" >
        <?=$form->field($master_item,$property)->hiddenInput(['v-model'=>'slave_obj.id'])?>
        <div>
            <strong
            class="content-panel-item-selector__item-name">
                {{slave_obj.name}}
            </strong>
            <a>
                <span class="glyphicon glyphicon-link content-panel-item-selector_link-button" 
                v-on:click='bind'>
        		</span>
            </a>
            <a>
                <span class="glyphicon glyphicon-trash content-panel-item-selector_link-button" 
                v-on:click='reset'>
        		</span>
        	</a>
        </div>
    </div>
</div>
<?

$url=Url::toRoute([$slave_item_cls::selectListRoute(),'bind_name'=>$widget_id]);

$fn_name="content_panel_item_selector_{$master_item::tableName()}_$property";
$script = <<<JS_SCRIPT
(function (){
    var vue=new Vue({
        el:'#{$widget_id}',
        data:{
            slave_obj:{
                name:'{$name}',
                id:'{$id}',
                setId:function(id){
                    this.id=id},
                setName:function(name){
                    this.name=name}
            }
        },
        methods:{
            bind:function(){               
                var slave_window=window.open("$url");
                
                if(!('content_panel' in window)){
                    window.content_panel={};
                    if(!('slave_objects' in window.content_panel)){
                        window.content_panel={slave_objects:{}}
                    }
                }         

                this.slave_obj.closeWindow=function(){slave_window.close();};

                window.content_panel.slave_objects={"$widget_id":this.slave_obj};
            },
            reset: function()
            {
                this.slave_obj.setId('');
                this.slave_obj.setName('Связь не установлена');
            }
        }
    });
})();

JS_SCRIPT;
?>
<?VueAsset::register($this);?>
<?$this->registerJs($script);?>