## Ip black list

Состоит из :

* IpBlackListController (контроллер)
* IpBlackList (Модель)
* IpBlackListFilter (Фильтр)

Чтобы обратиться к контроллеру для управления блокировкой Ip используется маршрут:

```php
Url::toRoute(['admin-panel/security/ip-black-list');
```

N.B. Чтобы не терять информацию о ранее заблокированных ip достаточно снять активность с элемента.
Только активные записи будут блокироваться фильтром.

### Фильтр

Фильтр возможно использовать следующим образом:

```php
public function behaviors()
    {
        return [
            [
                'class'=>IpBlackListFilter::class,
                'only'=>['ip-black-list']
            ]
        ];    
    }
```
### Миграция

./yii migrate --migrationPath="./vendor/devskyfly/yiiModuleAdminPanel/migration/security"