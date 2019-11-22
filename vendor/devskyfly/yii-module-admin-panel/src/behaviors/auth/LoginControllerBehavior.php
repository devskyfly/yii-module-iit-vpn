<?php
namespace devskyfly\yiiModuleAdminPanel\behaviors\auth;

use devskyfly\yiiModuleAdminPanel\models\auth\LoginForm;
use Yii;
use yii\base\Behavior;

class LoginControllerBehavior extends Behavior
{
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
}

