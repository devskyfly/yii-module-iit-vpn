## File extension
Это расширение для AbstractItem сущности для реализации возможности загрузки файлов из формы.

Чтобы использовать это расширение надо:

### Создать таблицу

Создать миграцию и унаследовать ее от devskyfly\yiiModuleAdminPanel\migrations\helpers\PageMigrationHelper

В методе up() записать команду 

```php
<?php
$fields=$this->getFieldsDefinition();
$this->createTable($this->table, $fields);
?>
```

Переменная $fields представляет из себя массив ["key"=>field description]. 
Тоесть ее можно дополнить определениями своих полей используя переменную $this, т.к она ссылается на текущую миграцию. И использовать один из методов для определея поля, так же как при создании стандартной миграции.

### Настройка экземпляра AbstractItemExtension

Создать класс унаследованный от AbstractItemExtension

```php
<?php
	protected static function itemCls()
    {
        return Entity::class;
    }
?>
```

### Настройка AbstractItem сущности к которой будет привязано расширение

1. Объявить публичное свойство для ассоциации с файлом 

```php
	/**
	* @var file
	*/
	public $file_name
```
2. Добавить связь между AbstractItem и расширением в методе extensions(). 
N.B. При чем имя связи должно соответствовать имени ранее объявленного свойства.

```php
<?php
public function extensions()
{
	 //Если расширений нет, то можно вернуть пустой массив
    return [
        'file_name'=>EntityFileExtension::class
    ];
}
?>
```
3. Дополнить правила валидации

```php
public function rules()
{
    $rules=parent::rules();

    $new_rules=[
        [['file'],'file','skipOnEmpty'=>true,'extensions'=>'png, jpg']
    ];
    
    $rules=ArrayHelper::merge($rules, $new_rules);
    return $rules;
}
```
### Виджет

```php
FileUpload::widget([
    "form"=>$form,
    "item"=>$item,
    "attribute"=>'file'
])

```
