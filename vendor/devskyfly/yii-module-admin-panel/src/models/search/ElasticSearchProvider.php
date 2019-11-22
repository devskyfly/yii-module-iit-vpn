<?php
namespace devskyfly\yiiModuleAdminPanel\models\search;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;
use Elasticsearch\ClientBuilder;
use devskyfly\yiiModuleAdminPanel\Module;

class ElasticSearchProvider extends BaseObject
{
    protected $module=null;
    
    public $type_mappings=[
        'properties'=> [
            'name'=>[
                'type'=>'text',
                'analyzer'=>"russian_morphology" ,
                'search_analyzer'=>"russian_morphology"
            ],
            'content'=>[
                'type'=>'text',
                'analyzer'=>"russian_morphology" ,
                'search_analyzer'=>"russian_morphology",
            ],
            'route'=>['type'=>'text']
        ]
    ];
    
    public $index_settings=[];
    /**
     *
     * @var Elasticsearch\Client;
     */
    private $_client=null;
    private $_elastic_hosts=[];
    private $_index="";
    private $_type="";
    private $_client_settings=[];
    
    public function init()
    {
        parent::init();
        
        $module=Module::getInstance();
        
        if(Vrbl::isNull($module)){
            throw new \InvalidArgumentException('Property module is null.');
        }
        
        if(!Arr::isArray($module->search_settings['elastic_hosts'])){
            $ar=[];
            $ar[]=$module->search_settings['elastic_hosts'];
            $this->_elastic_hosts=$ar;
        }else{
            $this->_elastic_hosts=$module->search_settings['elastic_hosts'];
        }
        
        $this->_index=$module->search_settings['index'];
        $this->_type=$module->search_settings['type'];
        
        if(isset($module->search_settings['client_settings'])){
            $this->_client_settings=$module->search_settings['client_settings'];
        }
        
        $this->initClient();
    }
    
    protected function initClient()
    {
        $this->_client=ClientBuilder::create()
        ->setHosts($this->_elastic_hosts)
        ->setConnectionParams($this->_client_settings)
        ->build();
    }
    
    /**********************************************************************/
    /** Actions **/
    /**********************************************************************/
    
    /**
     * 
     * @return []
     */
    
    public function createIndex()
    {
        $params=[
            'index'=>$this->_index
        ];
        
        $response=$this->_client->indices()->create($params);
        return $response;
    }
    
    /**
     *
     * @return []
     */
    public function dropIndex()
    {
        $params=[
            'index'=>$this->_index
        ];
        $response=$this->_client
        ->indices()
        ->delete($params);
        return $response;
    }
    
    public function openIndex()
    {
        $params=[
            'index'=>$this->_index
        ];
        $response=$this->_client
        ->indices()
        ->open($params);
        return $response;
    }
    
    public function closeIndex()
    {
        $params=[
            'index'=>$this->_index
        ];
        $response=$this->_client
        ->indices()
        ->close($params);
        return $response;
    }
    
    
    /**********************************************************************/
    /** Crud **/
    /**********************************************************************/
    
    /**
     *
     * @param AbstractDataProvider $item
     * @return []
     */
    public function saveDocumentItem(AbstractDataProvider $item)
    {
        $item_params=$item->getParams();
        $id=$item_params['id'];
        unset($item_params['id']);
        
        $params=[
            "index"=>$this->_index,
            "type"=>$this->_type,
            "id"=>$id,
            "body"=>$item_params
        ];
        $response=$this->client->index($params);
        return $response;
    }
    
    /**********************************************************************/
    /** Mappings, settings **/
    /**********************************************************************/
    
   /*  public function open()
    {
        $params=[
            'index'=>$this->_index
            ];
        $response = $this->_client->indices()->open($params);
        return $response;
    }
    
    public function close()
    {
        $params=[
            'index'=>$this->_index
        ];
        $response = $this->_client->indices()->close($params);
        return $response;
    } */
    
    public function putTypeMappings()
    {
        $params=[
            'index'=>$this->_index,
            'type'=>$this->_type,
            'body'=>[
                $this->_type=>$this->type_mappings
            ]
        ];
        
        $response = $this->_client->indices()->putMapping($params);
        return $response;
    }

    public function putIndexSettings()
    {
        $params = [
            'index' => $this->_index,
            'body' => [
                'settings' => $this->index_settings   
            ]
        ];
        
        $response=$this->_client->indices()->putSettings($params);
        return $response;
    }
    
    
    
    public function getIndexMapping()
    {
        $params=[
            'index'=>$this->_index
        ];
        $response=$this->_client->indices($params)->getMapping();
        return $response;
    }
    
    
    
    
    /**********************************************************************/
    /** Search **/
    /**********************************************************************/

    /**
     *
     * @param string $str
     * @return []
     */
    public function search($str)
    {
        $params=[
            'index'=>$this->_index,
            'body'=>[
                'query'=> [
                     'bool'=>[
                        'should'=>[
                            ['match'=> ['name'=>$str,]],
                            ['match'=> ['content'=>$str,]],
                        ]
                    ]
                ]
            ]
        ];
        $response=$this->_client->search($params);
        return $response;
    }
    
    /**********************************************************************/
    /** Getters **/
    /**********************************************************************/
    
    /**
     *
     * @return string[]
     */
    public function getElasticHosts()
    {
        return $this->_elastic_hosts;
    }
    
    /**
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->_index;
    }
    
    /**
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->_type;
    }
    
    /**
     *
     * @return \devskyfly\yiiModuleAdminPanel\models\search\Elasticsearch\Client;
     */
    public function getClient()
    {
        return $this->_client;
    }
}

