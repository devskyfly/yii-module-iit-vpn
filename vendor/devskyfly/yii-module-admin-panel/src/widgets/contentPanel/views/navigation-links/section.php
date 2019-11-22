<?php
/* @var $this yii\web\View */
/* @var $list [] */
/* @var $current_item_is_active boolean */

use devskyfly\php56\types\Arr;
use yii\helpers\Html;
?>

<?
$i=0;
$cnt=Arr::getSize($list);
?>
<?if(isset($label)):?>
<div>
	<h4><strong><?=$label?></strong></h4>
</div>
<?endif;?>
<div>
    <ol class="breadcrumb">
        <?foreach ($list as $item):?>
        	<?$i++;?>
        	<li class="<?=$cnt==$i?"active":""?>">
            	<?if($cnt!==$i||$current_item_is_active==true):?>
            		<?=Html::a($item['label'],$item['url'])?>
            	<?else:?>
            		<?=$item['label']?>
            	<?endif;?>
        	</li>
        <?endforeach;?>
    </ol>
</div>