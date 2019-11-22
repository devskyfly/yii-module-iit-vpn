<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\search;

use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\models\search\ElasticSearchActiveRecord;
use yii\base\Widget;
use yii\data\Pagination;
use yii\elasticsearch\ActiveDataProvider;
use yii\helpers\Html;
use yii\elasticsearch\ActiveRecord;


class SearchWidget extends Widget
{
    /**
     * 
     * @var string
     */
    public $query;
    
    /**
     * 
     * @var integer
     */
    public $result_limit=400;
    
    /**
     * 
     * @var integer
     */
    public $page_size=20;
    
    /**
     * 
     * @var []
     */
    protected $list=[];
    
    protected $pagination=null;
    
    public function init()
    {
        if(!Str::isString($this->query)){
            throw new \InvalidArgumentException('Param query is not string type.');
        }
        $this->query=Html::encode($this->query);
        
        if(!Nmbr::isInteger($this->result_limit)){
            throw new \InvalidArgumentException('Param query is not integer type.');
        }
        
        $this->pagination=new Pagination();
        $this->pagination->pageSize=$this->page_size;
        
        if(!Vrbl::isEmpty($this->query)){
            $query_obj=$this->formQuery($this->query);
            
            $data_provider=$this->formDataProvider($query_obj,$this->pagination);
            $this->list=$this->formList($data_provider);
            
            $count_query_obj=$this->formCountQuery($this->query);
            
            $this->pagination->totalCount = $count_query_obj->count();
        }
    }
    
    /**
     * 
     * @param string $query
     * @return \yii\elasticsearch\Query
     */
    protected function formQuery($query)
    {
        if(Vrbl::isEmpty($query)){
            return null;
        }
            
        $params=[
            "bool"=>
            [
                "should"=>
                [
                    ["match" => ["content" => $query]],
                    ["match" => ["name" => $query]]
                ]
            ],
            
        ];
        
        $db_query=ElasticSearchActiveRecord::find()
        ->query($params)
        ->limit($this->result_limit)
        ->highlight([
            "pre_tags" => ["<strong>"],
            "post_tags" => ["</strong>"],
            "fields" => [
                "content" =>new \stdClass()
            ],
            'require_field_match'=>false
        ]);
        return $db_query;
    }
    
    /**
     *
     * @param string $query
     * @return \yii\elasticsearch\Query
     */
    protected function formCountQuery($query)
    {
        if(Vrbl::isEmpty($query)){
            return null;
        }
        
        $params=[
            "bool"=>
            [
                "should"=>
                [
                    ["match" => ["content" => $query]],
                    ["match" => ["name" => $query]]
                ]
            ],
            
        ];
        
        $db_query=ElasticSearchActiveRecord::find()
        ->query($params)
        ->limit(null);
        
        return $db_query;
    }
    
    /**
     * 
     * @param \yii\data\ActiveDataProvider $query_obj
     */
    protected function formDataProvider($query_obj,$pagination)
    {
        $provider = new ActiveDataProvider([
            'query' => $query_obj,
            'pagination' => [
                'pageSize' => $this->page_size,
            ],
            /* 'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC,
                ]
            ], */
        ]);
        return $provider;
    }
    
    /**
     * 
     * @param \yii\data\ActiveDataProvider $data_provider
     * @return []|ActiveRecord[]
     */
    protected function formList(ActiveDataProvider $data_provider)
    {
        $list=[];
        $result=$data_provider->getModels();
        foreach ($result as $model){
            $highlight=$model->getHighlight();
            $list[]=[
                'name'=>$model->name,
                'content'=>Vrbl::isEmpty($highlight['content'])?[]:$highlight['content'],
                'route'=>$model->route
            ];
        }
        return $list;
    }
    
    public function run()
    {
        $query=$this->query;
        $list=$this->list;
        $pagination=$this->pagination;
        
        return $this->render('search-widget',compact("query","list","pagination"));
    }
}