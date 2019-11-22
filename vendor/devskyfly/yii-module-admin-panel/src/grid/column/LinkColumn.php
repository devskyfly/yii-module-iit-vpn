<?php
namespace devskyfly\yiiModuleAdminPanel\grid\column;

use devskyfly\yiiModuleAdminPanel\Module;
use yii\grid\Column;

class LinkColumn extends Column
{
    public function init()
    {
        parent::init();
            
            $this->content=function($model,$keym,$index,$column){
                $item_link_button_cls=Module::CSS_NAMESPACE.'-content-panel-entity-select-list__item-link-button';            
$td= <<<TD_CONTENT
<a>
<span 
    slave_name="{$model->name}" 
    slave_id="{$model->id}" 
    class="glyphicon glyphicon-link {$item_link_button_cls}">
</span>
</a>
TD_CONTENT;
                return $td;
            };
    }
}