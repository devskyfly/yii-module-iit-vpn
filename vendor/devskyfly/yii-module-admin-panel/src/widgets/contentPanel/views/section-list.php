<?php
/* @var $this yii\web\View */
/* @var $list [] */
/* @var $parent_section_id null|number */
use yii\helpers\Html;

?>
<div style="padding-bottom:20px">
	<?=$this->render('_section-list-buttons',["parent_section_id"=>$parent_section_id])?>
</div>
<div>
    <table class="table">
    <?foreach ($list as $item):?>
    	<tr>
        	<td><?=$item['order']?></td>
        	<td><span class="<?=$item['active']?"glyphicon glyphicon-ok":""?>"></span></td>
        	<td><?=Html::a($item['name'],$item['sub_section_url'])?></td>
        	<td><?=Html::a('',$item['edit_url'],['class'=>['glyphicon', 'glyphicon-pencil']])?></td>
        	<td><?=Html::a('',$item['delete_url'],['class'=>['glyphicon', 'glyphicon-trash'],'data-confirm' => 'Удалить?',])?></td>
    	</tr>
    <?endforeach;?>
    </table>
</div>