## Config

- настроить компонент приложения user.

```php
'user' => [
            'identityClass' => 'devskyfly\yiiModuleAdminPanel\models\auth\User',
            'enableAutoLogin' => true,
        ],
```

- добавить отдельные действия для

```php
public function actions()
{
    return [
        'login'=>[
            'class'=>LoginAction::class
        ],
        'logout'=>[
            'class'=>LogoutAction::class
        ],
        'error' => [
            'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
            'class' => 'yii\captcha\CaptchaAction',
            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
    ];
} 
```

- добавить поведения

```php
public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['login', 'error'],
                    'allow' => true,
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ],
    ];
}
```

- добавить представление site/view

```php

use devskyfly\yiiModuleAdminPanel\widgets\auth\LoginForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */

<?=LoginForm::widget(compact("model"));?>
```