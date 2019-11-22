<?php
namespace devskyfly\yiiModuleAdminPanel\models\search;

use devskyfly\php56\types\Str;
use yii\base\BaseObject;

/**
 * Extend it to provide data to indexer.
 * @author devskyfly
 *
 */
abstract class AbstractDataProvider extends BaseObject
{
    protected $param_fields=[
        'id',
        'name',
        'content',
        'route'
    ];
    
    /**
     * Params for adding in elasticsearch document
     * @var array
     */
    protected $params=[];
    
    public function init()
    {
        parent::init();
        $this->formParams();
        $this->checkParams();
    }
    
   
    protected function formParams()
    {
        $this->params=$this->params();   
        return $this;
    }
    
    
    /**
     * This methode realize logic of params forming.
     *
     * Return array of params ['id'=>,'name'=>,'content'=>,'route'=>]
     * @return []
     */
    abstract protected function params();

    /**
     * 
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleAdminPanel\models\search\AbstractDataProvider
     */
    protected function checkParams()
    {
        foreach ($this->param_fields as $param_fields_item){
            if(!isset($this->params[$param_fields_item])){
                throw new \OutOfRangeException('Property $param does not have key \''.$param_fields_item.'\'.');
            }
            if(!Str::isString($this->params[$param_fields_item])){
                throw new \InvalidArgumentException('Property $params['.$param_fields_item.'] is not string type');
            }
        }
        return $this;
    }
    
    public function getParams()
    {
       return $this->params;
    }
}