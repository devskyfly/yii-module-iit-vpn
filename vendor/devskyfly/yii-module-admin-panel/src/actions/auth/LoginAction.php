<?php
namespace devskyfly\yiiModuleAdminPanel\actions\auth;


use devskyfly\php56\types\Str;
use yii\base\Action;
use devskyfly\yiiModuleAdminPanel\models\auth\LoginForm;
use Yii;

class LoginAction extends Action
{
    public $view='login';
        
    public function init()
    {
        parent::init();
        if(!Str::isstring($this->view)){
            throw new \InvalidArgumentException();
        }
    }
    
    public function run()
    {
        $view=$this->view;

        //$this->layout='login';
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->controller->goBack();
        } else {
            return $this->controller->render($this->view,compact("model"));
        }
        
        
    }
}