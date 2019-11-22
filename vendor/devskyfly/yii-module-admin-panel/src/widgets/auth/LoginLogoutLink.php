<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\auth;

use yii\base\Widget;
use devskyfly\yiiModuleAdminPanel\models\auth\LoginForm as LoginFormModel;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Lgc;

class LoginLogoutLink extends Widget
{   
    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        return $this->render('login-logout-link',compact("model"));
    }
}

