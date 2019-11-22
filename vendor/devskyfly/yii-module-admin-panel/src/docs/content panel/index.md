## Content panel

Эта часть модуля предоставляет возможность управления сущностями хранящимися в базе данных.

Реализована возможность управления как линенйным списком элементов, так элементами подчиненными иерархическому списку. 

Чтобы использовать эту часть модуля надо:

1. Создать контроллер наследующий devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController (настроить)
2. Создать модель элемента наследующую devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity (настроить)
3. (Опционально) Создать модель секции наследующую devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection (настроить)
4. (Опционально) Создать модель расширения наследующую devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItemExtension (настроить)
5. Создать таблицы в базе данных для созданных моделей (описание ниже)

Пара слов о расширении модели. После создания рашрения модели наследуясь от AbstractItemExtension. У вас появляется возможность вынести общие свойства моделей в это расширение. 
На примере расшерения PageExtension, этой модели передаются все поля которые характерны для страницы:

* Title
* Keywords
* Description
* Detail text
* Preview Text
* Detail picture
* Preview picture

N.B. При удалении сущности к которой привязано расширение удаляеся и запись в б.ю. этого расширения.

### Настройка экземпляра AbstractContentPanelController

```php
<?php
	/**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionItem()
     */
    public static function sectionCls()
    {
    	 //Если иерархичность не требуется, то вместо названия класса можно передать null
        return Section::class;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityItem()
     */
    public static function entityCls()
    {
        return Entity::class;
    }
    
    /**
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem | null
     */
    public static function entityFilterCls()
    {
        return null;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityEditorViews()
     */
    public function entityEditorViews()
    {
        return function($form,$item)
        {
            return [
                [
                    "label"=>"main",
                    "content"=>
                    $form->field($item,'name')
                    .ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>$item::sectionCls(),
                        "property"=>"_section__id"
                    ])
                    .$form->field($item,'create_date_time')
                    .$form->field($item,'change_date_time')
                    .$form->field($item,'active')->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                ],
                [
                    "label"=>"seo",
                    "content"=>$form->field($item->extensions['page'],'title')
                    .$form->field($item->extensions['page'],'keywords')
                    .$form->field($item->extensions['page'],'description')
                    .$form->field($item->extensions['page'],'preview_text')
                    .$form->field($item->extensions['page'],'detail_text')
                ]
            ];
        };
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionEditorItems()
     */
    public function sectionEditorViews()
    {
        return function($form,$item)
        {
            
             return [
                [
                    "label"=>"main",
                    "content"=>
                    $form->field($item,'name')
                    .ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>Obj::getClassName($item),
                        "property"=>"__id"
                    ])
                    .$form->field($item,'create_date_time')
                    .$form->field($item,'change_date_time')
                    .$form->field($item,'active')->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                    
                ],
                [
                    "label"=>"seo",
                    "content"=>$form->field($item->extensions['page'],'title')
                    .$form->field($item->extensions['page'],'keywords')
                    .$form->field($item->extensions['page'],'description')
                    .$form->field($item->extensions['page'],'preview_text')
                    .$form->field($item->extensions['page'],'detail_text')
                ]
            ];
        };
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::itemLabel()
     */
    public function itemLabel()
    {
        return "Сущность с секцией";
    }
?>
```

### Настройка экземпляра AbstractEntity

```php
<?php
	/**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    protected static function sectionCls()
    {
    	 //Если иерархичность не требуется, то вместо названия класса можно передать null
        return Section::class;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractItem::extensions()
     */
    public function extensions()
    {
    	 //Если расширений нет, то можно вернуть пустой массив
        return [
            'page'=>EntityPageExtension::class
        ];
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "contentPanel/entity-with-section/section-select-list";
    }

    /**
     * Для подключения к другим базам данных необходимо переопределить данный метод
     * @return yii\db\Connection
     */
    public static function getDb()
    {
        return \Yii::$app->db2;
    }
?>
```



### Имплементация FilterInterface

Реализация поиска по столбцам.

Фильтрации будут подвержены только те столбцы, которые перечислены в rules.

N.B. поля id и active ищутся по точному соответствию, остальные же по совпадению

```php
<?php
	class EntityFilter extends Entity implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [[["data","active"],"string"]];
    }
}
?>
```

### Настройка экземпляра AbstractSection

```php
<?php
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::entity()
     */
    public static function entityCls()
    {
        return Entity::class;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractItem::extensions()
     */
    public function extensions()
    {
    	//Если расширений нет, то можно вернуть пустой массив
        return [
            'page'=>SectionPageExtension::class
        ];
    }
   

    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "contentPanel/entity-with-section/section-select-list";
    }

    /**
     * Для подключения к другим базам данных необходимо переопределить данный метод
     * @return yii\db\Connection
     */
    public static function getDb()
    {
        return \Yii::$app->db2;
    }
?>
```

### Настройка экземпляра AbstractItemExtension
```php
<?php
	protected static function itemCls()
    {
        return Entity::class;
    }
?>
```

### Создание таблиц для созданных моделей

Создать через консоль миграцию и наследовать ее от:

* devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper
* devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\SectionMigrationHelper
* devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\PageMigrationHelper
* devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\FileMigrationHelper

В методе up() записать команду 

```php
<?php
$fields=$this->getFieldsDefinition();
$this->createTable($this->table, $fields);
?>
```

Переменная $fields представляет из себя массив ["key"=>field description]. 
Тоесть ее можно дополнить определениями своих полей используя переменную $this, т.к она ссылается на текущую миграцию. И использовать один из методов для определея поля, так же как при создании стандартной миграции.
