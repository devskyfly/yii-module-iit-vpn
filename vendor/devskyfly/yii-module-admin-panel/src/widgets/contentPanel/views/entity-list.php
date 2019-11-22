<?php
/* @var $this yii\web\View */
/* @var $data_provider yii\data\ActiveDataProvider */
/* @var $filter_model yii\data\ActiveDataProvider */
/* @var $parent_section_id null|number */
/* @var $columns [] */
use devskyfly\php56\types\Vrbl;
use yii\grid\GridView;

?>
<div style="padding-bottom:20px">
	<?=$this->render('_entity-list-buttons',["parent_section_id"=>$parent_section_id])?>
</div>
<div>
	<?if(!Vrbl::isEmpty($filter_model)):?>
    	<?=GridView::widget(
    	    [
    	        'dataProvider'=>$data_provider,
    	        'filterModel'=>$filter_model,
    	        'columns'=>$columns,
    	 ])?>
	 <?else:?>
	 	<?=GridView::widget(
    	    [
    	        'dataProvider'=>$data_provider,
    	        'columns'=>$columns,
    	 ])?>
	 <?endif;?>
</div>
 