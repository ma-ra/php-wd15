<?php
/* @var $this DeliveryAddressController */
/* @var $model DeliveryAddress */

$this->breadcrumbs=array(
	'Delivery Addresses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DeliveryAddress', 'url'=>array('index')),
	array('label'=>'Create DeliveryAddress', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#delivery-address-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Delivery Addresses</h1>

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
	'id'=>'delivery-address-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'delivery_address_id',
		'delivery_address_name_1',
		'delivery_address_name_2',
		'delivery_address_street',
		'delivery_addressr_zip_code',
		'delivery_addressr_city',
		/*
		'delivery_addressr_contact',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
