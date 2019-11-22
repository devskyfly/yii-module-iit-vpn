<?php
use yii\helpers\Html;        
?>
<?if(Yii::$app->user->isGuest):?>
	<?=Html::a('Login','/admin-panel/auth/access-control/login')?>
<?else:?>
	<?=Html::beginForm(['/admin-panel/auth/access-control/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
            )
        . Html::endForm()
	?>
<?endif;?>