<?php
namespace devskyfly\yiiModuleAdminPanel\models\search;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;

class Indexer extends BaseObject
{
    
    protected $elastic_provider=null;
    
    public function init()
    {
        parent::init();
        $module=Yii::$app->getModule('admin-panel');
        
        if(Vrbl::isNull($module)){
            throw \InvalidArgumentException('Variable $module is null.');
        }
        $search_settings=$module->search_settings;
        
        $this->elastic_provider=new ElasticSearchProvider();
        
        if(isset($search_settings['index_settings'])
            &&Arr::isArray($search_settings['index_settings'])){
        $this->elastic_provider->index_settings=$search_settings['index_settings'];
        }
        
        if(isset($search_settings['type_mappings'])
            &&Arr::isArray($search_settings['type_mappings'])){
        $this->elastic_provider->type_mappings=$search_settings['type_mappings'];
        }
    }
    
    public function index($callback)
    {
        if(!Vrbl::isCallable($callback)){
            throw new \InvalidArgumentException('Param $callable is not callable type.');
        }
        
        foreach ($callback() as $item)
        {
            if(!Obj::isSubClassOf($item, AbstractDataProvider::class))
            {               
                throw new \InvalidArgumentException('Variable $item is not '.AbstractDataProvider::class.' type.');
            }
            $this->elastic_provider->saveDocumentItem($item);
        }
    }  
}