<?php
namespace devskyfly\yiiModuleIitVpn\controllers;

use yii\web\Controller;
use devskyfly\yiiModuleIitVpn\Module;
use devskyfly\yiiModuleIitVpn\models\common\ModuleNavigation;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $title=Module::TITLE;
        $module_navigation=new ModuleNavigation();
        $list=[$module_navigation->getData()];
        return $this->render('index',compact("list","title"));
    }
}