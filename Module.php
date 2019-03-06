<?php
namespace devskyfly\yiiModuleIitVpn;

use Yii;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
     const CSS_NAMESPACE='devskyfly-yii-iit-vpn';
     
     public function init()
     {
         parent::init();
         //$this->checkProperties();
         if(Yii::$app instanceof \yii\console\Application){
             $this->controllerNamespace='devskyfly\yiiModuleIitVpn\console';
         }
     }
     
     public function behaviors()
     {
         if(!(Yii::$app instanceof \yii\console\Application)){
             return [
                 'access' => [
                     'class' => AccessControl::className(),
                     'except'=>[
                         'rest/*/*',
                     ],
                     'rules' => [
                          [
                             'allow' => true,
                             'roles' => ['@'],
                         ], 
                     ],
                 ]
             ];
         }else{
             return [];
         }
     }
}