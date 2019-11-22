<?php

use devskyfly\php56\types\Vrbl;
use yii\helpers\Json;
use yii\helpers\Url;
use devskyfly\yiiModuleAdminPanel\assets\VueAsset;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $label string */
/* @var $master_item \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem */
/* @var $list [] */
/* @var $slave_item_cls \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem */
/* @var $binder_cls \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem */
/* @var $property string */
?>

<?VueAsset::register($this);?>

<?
$binder=new $binder_cls();
$short_cls=(new ReflectionClass($binder))->getShortName();

$widget_name="content-panel-binder";
$widget_id=$widget_name.'-'.Inflector::camel2id(str_replace("\\", "-", $binder_cls));

$tbl_row = <<<TBL_ROW_TMP
    <td style="padding:5px">{{index+1}}</td>
    <td ><input type="hidden" name="{$short_cls}[slave_id][]" v-model="item.slave_id"></td>
    <td style="padding-top:5px">
        <input type="text" class="{$widget_name}__item-name" v-model="item.slave_name" size="80" disabled/>
    </td>
    <td style="padding-top:5px;padding-left:5px">
        <a>
    		<span class="glyphicon glyphicon-link content-panel-binder__link-button"
            v-on:click="link(item)"></span>
    		<span class="glyphicon glyphicon-trash content-panel-binder__delete-button" 
            v-on:click="remove(index)"></span>
    	</a>
    </td>

TBL_ROW_TMP;
?>


<div style="padding-bottom:30px" class="<?=$widget_name?> row" id="<?=$widget_id?>" style="max-height:500px">
	<input type="hidden" name="<?=$short_cls?>[slave_id][]" v-if="list.length==0">
    <div class="col-xs-12 ">
        <div class="well well-sm">
            <div>
            	<strong><?=$label?></strong>
            </div>
            <div>
                <table>
                    <tr v-for="(item,index) in list" >
                    	<?=$tbl_row?>
                	</tr>
                </table>
            </div>
            <div style="padding-top:5px">
            	<span class="btn btn-primary" v-on:click="add">Добавить</span>
            </div>
        </div>
    </div>
</div>

<?
$js_list=[];
foreach ($list as $item){
    
    $js_list[]=[
        'slave_id'=>$item['binder']->slave_id,
        'slave_name'=>Vrbl::isEmpty($item['slave_item'])?"":$item['slave_item']->name
    ];
}

$js_list=Json::encode($js_list,JSON_UNESCAPED_UNICODE);

$url=Url::toRoute([$slave_item_cls::selectListRoute(),'bind_name'=>$widget_id]);

$fnc=str_replace('-', '_', $widget_id);
$script = <<<JS_SCRIPT
(function (){
var list=$js_list;

var vue=new Vue({
    el:'#$widget_id',
    data:{
        list:list
    },
    methods:{
        link:function(item){
            var slave_window=window.open("$url");
            if(!('content_panel' in window)){
                window.content_panel={};
                if(!('slave_objects' in window.content_panel)){
                    window.content_panel={slave_objects:{}}
                }
            }

            var slave_obj={
                setId:function(id){item.slave_id=id},
                setName:function(name){item.slave_name=name},
                closeWindow:function(){slave_window.close();}
            };            

            window.content_panel.slave_objects={"$widget_id":slave_obj};
        },
        remove:function(index){
            this.list.splice(index,1);
        },
        add:function(){
            var item={master_id:"",slave_id:"",slave_item_name:""}
            this.list.push(item);
        }
    }
});
})();
JS_SCRIPT;
?>

<?VueAsset::register($this);?>
<?$this->registerJs($script);?>