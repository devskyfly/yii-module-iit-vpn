<?php

use yii\helpers\FileHelper;
use devskyfly\yiiModuleAdminPanel\Module;

/* @var $view \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $item \devskyfly\yiiModuleAdminPanel\models\AbstractItem */
/* @var $file \devskyfly\yiiModuleAdminPanel\models\AbstractFile */
/* @var $attribute string */
?>

<style>
.devskyfly-yii-admin-panel__image-preview{
    width:200px;
    height: 200px;
}
</style>

<?php 
$images_extensions=['png','jpg','jpeg','gif'];

$file_path=Yii::getAlias($file->path);
$file_exists=false;

if(file_exists($file_path)){
    $file_exists=true;
}
?>

<?php 
if((!$file->isNewRecord)
    &&($file_exists)){
    $extension=FileHelper::getExtensionsByMimeType(FileHelper::getMimeType($file_path));
}
?>
<div class="<?=Module::CSS_NAMESPACE?>-content-panel-file-upload-widget">
	<label><?=ucfirst($attribute)?></label>
	<?if((!$file->isNewRecord)
	    &&($file_exists)):?>
    	<div>
    		<?if(in_array($extension[0], $images_extensions)):?>
    			<img 
    			class="devskyfly-yii-admin-panel__image-preview"
    			src="<?=$file->path?>"/>
    		<?else:?>
    			<span class="glyphicon glyphicon-file"></span>
    		<?endif;?>
    		<span>
    			File path: <?=$file_path?>
    		</span>
    	</div>
	<?endif;?>
	<?=$form->field($item, $attribute)->fileInput()->label('')?>
</div>
