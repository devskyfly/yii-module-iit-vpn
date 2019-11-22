<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\auth;

use yii\base\Widget;
use devskyfly\yiiModuleAdminPanel\models\auth\LoginForm as LoginFormModel;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Obj;

class LoginForm extends Widget
{
    /**
     * 
     * @var LoginForm
     */
    public $model=null;
    
    public function init()
    {
        parent::init();
        if(!Obj::isA($this->model, LoginFormModel::class)){
            throw new \InvalidArgumentException('Property $model is not '.LoginFormModel::class.' type.'); 
        }
    }
    
    public function run()
    {
        $model=$this->model;
        return $this->render('login-form',compact("model"));
    }
}

