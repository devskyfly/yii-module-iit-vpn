## Консольные команды
	
### admin-panel/auth/user

	index (login, email, password) - выводит список пользователей
	add - добавляет пользователя 
	delete - удаляет пользователя
	deleteAll - удаляет всех пользователей
	
### Customize

Если есть необходимость в реализации своей собственной модели User, то надо ее наследовать от extends ActiveRecord implements IdentityInterface.

Надо создать консольный контроллер унаследованный от devskyfly\yiiModuleAdminPanel\console\auth\UserController и переопределить метод.

```php
protected static function getUserClass()
{
    return User::class;
}
```