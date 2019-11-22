<?php
namespace devskyfly\yiiModuleAdminPanel\actions\auth;


use devskyfly\php56\types\Str;
use yii\base\Action;
use devskyfly\yiiModuleAdminPanel\models\auth\LoginForm;
use Yii;

class LogoutAction extends Action
{
    public function run()
    {
        Yii::$app->user->logout();
        return $this->controller->goHome();
    }
}