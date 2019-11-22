<?php 
/* $view yii\web\View */
/* $model devskyfly\yiiModuleAdminPanel\models\auth\LoginForm */

use devskyfly\yiiModuleAdminPanel\widgets\auth\LoginForm;
use yii\base\Widget;
?>

<?=LoginForm::widget(['model'=>$model])?>