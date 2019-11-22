<?php
namespace devskyfly\yiiModuleAdminPanel\assets;

use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/vue/';

    public function init()
    {
        parent::init();
        if(YII_ENV_PROD){
            $this->js = [
                'js/vue.min.js'
            ];
        }else{
            $this->js = [
                'js/vue.js'
            ];
        }
    }
}