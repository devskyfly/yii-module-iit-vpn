<?php
/* $this \yii\web\view */
/* $query string */
/* $list [['name'=>,'route'=>,'content'=>[]],...] */
/* $pagination \yii\data\Pagination */

use devskyfly\php56\types\Vrbl;
use yii\widgets\LinkPager;

?>

<div class="devskyfly-yii-module-admin-panel-search_search-widget">
	<div class="devskyfly-yii-module-admin-panel-search-search-widget_query-wrapper">
		<form method="get">
    		<input 
    		class="devskyfly-yii-module-admin-panel-search-search-widget_query-input" 
    		type="text"
    		name="query"
    		value="<?=$query?>"/>
    		<input type="submit" value="search" class="btn"/>
		</form>
	</div>
	<div class="devskyfly-yii-module-admin-panel-search-search-widget_result-wrapper">
		<table class="table">
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Content</th>
				<th>Route</th>
			</tr>
			<?php $i=0;?>
			<?foreach ($list as $list_item):?>
			<tr>
				<td><?=$i++?></td> 
				<td><?=$list_item['name']?></td>
				
				<td>
				<?php foreach ($list_item['content'] as $content_item):?>
					... <?=$content_item?> 
				<?php endforeach;?>
				...
				</td>
				<td><?=$list_item['route']?></td>
			</tr>
			<?endforeach;?>
		</table>
	</div>
	<?if(!Vrbl::isEmpty($list)):?>
	<div class="devskyfly-yii-module-admin-panel-search-search-widget_pagination-wrapper">
		<?= LinkPager::widget(['pagination' => $pagination,]);?>
	</div>
	<?endif;?>
</div>