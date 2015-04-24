<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */

$this->breadcrumbs=array(
	'Warehouses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Warehouse', 'url'=>array('index')),
	array('label'=>'Create Warehouse', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#warehouse-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Warehouses</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'warehouse-grid2',
	'dataProvider'=>$model->summary(),
	'enableSorting' => false,
	'filter'=>$model,
	'columns'=>array(
		'article_number',
		'article_name',
		'article_count',
		'article_price',
	),
)); ?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'warehouse-grid1',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'warehouse_id',
		'warehouse_type',
		'article_number',
		'article_name',
		'article_count',
		'article_price',
		'document_name',
		'warehouse_error',
		'shopping_shopping_id',
		'creation_date',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>