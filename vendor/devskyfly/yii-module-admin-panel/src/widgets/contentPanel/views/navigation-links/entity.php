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

<div>
	<h4><strong><?=$label?></strong></h4>
</div>
<div>
    <ol class="breadcrumb">
        <?foreach ($list as $item):?>
        	<?$i++;?>
        	<li class="<?=$cnt==$i?"active":""?>">
            		<?=Html::a($item['label'],$item['url'])?>
        	</li>
        <?endforeach;?>
    </ol>
</div>