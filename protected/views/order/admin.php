<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
		array('label'=>'Upload', 'url'=>array('upload')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Orders</h1>

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

<?php 
echo CHtml::beginForm(array('Order/print'),'post', array('enctype'=>'multipart/form-data'));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'select'=>array(
				'header' => 'zaznacz',
				'type'=>'raw',
				'value'=>'"<input id=\"select_".$data->order_id."\" type=\"checkbox\" value=\"1\" name=\"select[".$data->order_id."]\"/>"'
		),
		'order_id',
		'order_number',
		'order_date',
		'buyer_order_number',
		'buyer_comments',
		'order_reference',
		'order_term',
		array(
				'name' => 'manufacturerManufacturer.manufacturer_name',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->manufacturerManufacturer->manufacturer_name)'
		),
		array(
				'name' => 'brokerBroker.broker_name',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->brokerBroker->broker_name)'
		),
		array(
				'name' => 'buyerBuyer.buyer_name',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->buyerBuyer->buyer_name_1)'
		),
		array(
				'name' => 'articleArticle.article_number',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->article_number)'
		),
		array(
				'name' => 'articleArticle.model_name',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->model_name)'
		),
		array(
				'name' => 'articleArticle.model_type',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->model_type)'
		),
		array(
				'name' => 'articleArticle.article_colli',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->article_colli)'
		),
		'article_amount',
		'textile_order',
		array(
				'name' => 'legLeg.leg_type',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->legLeg->leg_type)'
		),
		array(
				'name' => 'textiles.textile_number',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textiles[0]->textile_number)'
		),
		array(
				'name' => 'textiles.textile_name',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textiles[0]->textile_name)'
		),
		array(
				'name' => 'textiles.textile_price_group',
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textiles[0]->textile_price_group)'
		),
		array(
				'name' => 'textiles.textile_number',
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textiles[1]->textile_number)? $data->textiles[1]->textile_number : "")'
		),
		array(
				'name' => 'textiles.textile_name',
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textiles[1]->textile_name)? $data->textiles[1]->textile_name : "")'
		),
		array(
				'name' => 'textiles.textile_price_group',
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textiles[1]->textile_price_group)? $data->textiles[1]->textile_price_group : "")'
		),
		'printed_minilabel',
		'printed_shipping_label',
		'article_manufactured',
		'article_exported',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
echo CHtml::button('Zaznacz wszystkie powyższe') . "<br>";
echo CHtml::submitButton('Drukuj etykiety') . "<br>";
echo CHtml::submitButton('Drukuj listę załadunkową');
echo CHtml::endForm();
?>

<script type="text/javascript">
	$(document).ready(function() {
		console.log('KLIK1');
		$('input[name=yt1]).click(function() {
			console.log('KLIK!');
		});
	});
</script>
