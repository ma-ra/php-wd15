<?php
/* @var $this ShoppingController */
/* @var $model Shopping */

$this->breadcrumbs=array(
	'Shoppings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Shopping', 'url'=>array('index')),
	array('label'=>'Create Shopping', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shopping-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Shoppings</h1>

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
	'id'=>'shopping-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'shopping_id',
		'shopping_number',
		array(
				'header' => 'dostawca',
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textileTextile->supplierSupplier->supplier_name) ? $data->textileTextile->supplierSupplier->supplier_name : "-" )'
		),
		'textile_textile_id',
		array(
				'name' => 'textileTextile.textile_number',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textileTextile->textile_number)'
		),
		array(
				'name' => 'textileTextile.textile_name',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textileTextile->textile_name)'
		),
		'article_amount',
		'article_calculated_amount',
		'shopping_term',
		'shopping_status',
		'shopping_printed',
		'creation_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
