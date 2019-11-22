## Search

Эта часть модуля реализует индексацию данных:

* из базы данных
* статичных страниц
* файлов (pdf, doc)

Для реализации индексации и поиска используется **ElasticSearch**.

Дополнительное ПО:

* [ElasticSearch](https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-5.6.13.zip)
* [Morphological Analysis Plugin for ElasticSearch 5.6.13](http://dl.bintray.com/content/imotov/elasticsearch-plugins/org/elasticsearch/elasticsearch-analysis-morphology/5.6.13/elasticsearch-analysis-morphology-5.6.13.zip)
	
### Настройка компонентов приложения

```php
'elasticsearch' => [
    'class' => 'yii\elasticsearch\Connection',
    'nodes' => [
        ['http_address' => '127.0.0.1:9200'],
        //настройте несколько хостов, если у вас есть кластер
    ],
],
```

### Настройка экземпляра AbstractIndexerController

В своем приложении надо объявить контроллер наследуемый от AbstractIndexerController, как указано ниже.
В нем надо реализовать метод dataProviderFnc() который будет возвращать объекты наследники AbstractDataProvider.

Т.к. таких объектов может быть очень много, то становится нецелесообразно сначала формировать их список, а затем передавть их дальше.

N.B. По этому вместо **return** в этой фунции должен использоваться **yield**.

```php
use devskyfly\yiiModuleAdminPanel\console\search\AbstractIndexerController;

class IndexerController extends AbstractIndexerController
{
     protected function dataProviderHandler()
    {
        return function(){
            $query=EntityWithoutSection::find()->where(['active'=>'Y']);
            foreach ($query->each(10) as $item){
                BaseConsole::stdout($item->id.' - '.$item->name.PHP_EOL);
                yield new EntityWithoutSectionDataProvider(['item'=>$item]);
            }
        };
    }
}
```

### Настройка экземпляра AbstractDataProvider

Наследуя класс от AbstractDataProvider, определяется правило преобразования данных для их хранения в индексе.

```php 
use devskyfly\yiiModuleAdminPanel\models\search\AbstractDataProvider;

class EntityDataProvider extends AbstractDataProvider
{
    public $item;
    
    protected function params()
    {
       $item=$this->item;
       return [
           'id'=>$item::tableName().'_'.$this->item->id,
           'name'=>$this->item->name,
           'content'=>$this->item->extensions['page']->detail_text,
           'route'=>serialize(["moduleAdminPanel/contentPanel/entity-without-section/entity-edit","entity_id"=>$this->item->id])
        ];
    }
}
```
### Виджет

В качестве примера получения результата поиска приведен widgets\search\SearchWidget
