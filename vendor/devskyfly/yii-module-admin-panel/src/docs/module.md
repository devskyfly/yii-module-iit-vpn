## Module

### Настройки модуля

```php
'admin-panel'=>[
        'class'=>'devskyfly\yiiModuleAdminPanel\Module',
        
        //common
        'upload_dir'=>'@app/upload',
        
        //search
        'search_settings'=>[
            'elastic_hosts'=>'http://127.0.0.1:9200',
            'index'=>'common_search',
            'index_settings'=>[],
            'type'=>'common_search_document',
            'type_mappings'=>[
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
		     ],
		     'type_mappings'=>[
                    'properties'=> [
                        'name'=>[
                            'type'=>'text',
                            'analyzer'=>"my_analyzer" ,
                            'search_analyzer'=>"my_analyzer"
                        ],
                        'content'=>[
                            'type'=>'text',
                            'analyzer'=>"my_analyzer" ,
                            'search_analyzer'=>"my_analyzer",
                        ],
                        'route'=>['type'=>'text']
                    ]
                ],
                'index_settings'=>[
                    "analysis"=> [
                         "analyzer"=> [
                            "my_analyzer"=> [
                                "type"=> "custom",
                                "tokenizer"=> "standard",
                                "filter"=> ["lowercase", "russian_morphology", "english_morphology", "my_stopwords"]
                            ]
                        ],
                        "filter"=> [
                            "my_stopwords"=> [
                            "type"=> "stop",
                            "stopwords"=> "а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я,a,an,and,are,as,at,be,but,by,for,if,in,into,is,it,no,not,of,on,or,such,that,the,their,then,there,these,they,this,to,was,will,with"
                            ]
                        ]
                    ]
                ],
            'client_settings'=>[
                'client'=>[
                     'curl'=>[
                         CURLOPT_PROXY=>'',
                         CURLOPT_HTTPPROXYTUNNEL=>false
                     ]
                 ] 
            ]
        ]
        
    ]
```