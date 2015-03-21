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
	array('label'=>'Drukuj etykiety transportowe', 'url'=>'#', 'itemOptions'=>array('id' => 'print_label')),
	array('label'=>'Drukuj ladeliste', 'url'=>'#', 'itemOptions'=>array('id' => 'print_transport_list')),
	array('label'=>'Zaznacz wszystkie widoczne', 'url'=>'#', 'itemOptions'=>array('id' => 'check')),
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

<br>
<br>
<br>
<br>
<?php 
echo CHtml::beginForm(array('Order/print'),'post', array('enctype'=>'multipart/form-data', 'id'=>'check_form'));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'select'=>array(
				'header' => 'Zaznacz',
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
				'filter'=>CHtml::activeTextField($model,'manufacturerManufacturer_manufacturer_name'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->manufacturerManufacturer->manufacturer_name)'
		),
		array(
				'name' => 'brokerBroker.broker_name',
				'filter'=>CHtml::activeTextField($model,'brokerBroker_broker_name'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->brokerBroker->broker_name)'
		),
		array(
				'name' => 'buyerBuyer.buyer_name_1',
				'filter'=>CHtml::activeTextField($model,'buyerBuyer_buyer_name_1'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->buyerBuyer->buyer_name_1)'
		),
		array(
				'name' => 'articleArticle.article_number',
				'filter'=>CHtml::activeTextField($model,'articleArticle_article_number'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->article_number)'
		),
		array(
				'name' => 'articleArticle.model_name',
				'filter'=>CHtml::activeTextField($model,'articleArticle_model_name'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->model_name)'
		),
		array(
				'name' => 'articleArticle.model_type',
				'filter'=>CHtml::activeTextField($model,'articleArticle_model_type'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->model_type)'
		),
		array(
				'name' => 'articleArticle.article_colli',
				'filter'=>CHtml::activeTextField($model,'articleArticle_article_colli'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->articleArticle->article_colli)'
		),
		'article_amount',
		array(
				'name' => 'legLeg.leg_type',
				'filter'=>CHtml::activeTextField($model,'legLeg_leg_type'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->legLeg->leg_type)'
		),
		'textil_pair',
		'textilpair_price_group',
		array(
				'name' => 'textile1Textile.textile_number',
				'filter'=>CHtml::activeTextField($model,'textiles1_textile_number'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textile1Textile->textile_number)'
		),
		array(
				'name' => 'textile1Textile.textile_name',
				'filter'=>CHtml::activeTextField($model,'textiles1_textile_name'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textile1Textile->textile_name)'
		),
		array(
				'name' => 'textile1Textile.textile_price_group',
				'filter'=>CHtml::activeTextField($model,'textiles1_textile_price_groupe'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textile1Textile->textile_price_group)'
		),
		array(
				'name' => 'textile2Textile.textile_number',
				'filter'=>CHtml::activeTextField($model,'textiles2_textile_number'),
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textile2Textile->textile_number)? $data->textile2Textile->textile_number : "")'
		),
		array(
				'name' => 'textile2Textile.textile_name',
				'filter'=>CHtml::activeTextField($model,'textiles2_textile_name'),
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textile2Textile->textile_name)? $data->textile2Textile->textile_name : "")'
		),
		array(
				'name' => 'textile2Textile.textile_price_group',
				'filter'=>CHtml::activeTextField($model,'textiles2_textile_price_groupe'),
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textile2Textile->textile_price_group)? $data->textile2Textile->textile_price_group : "")'
		),
		'printed_minilabel',
		'printed_shipping_label',
		'textile_prepared',
		'article_manufactured',
		'article_exported',
		'article_canceled',
		'order_error',
		'order_add_date',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
echo CHtml::submitButton('Drukuj etykiety') . "<br>";
echo CHtml::submitButton('Drukuj listę załadunkową');
echo CHtml::endForm();
?>

<script type="text/javascript">
/*<![CDATA[*/
	 $(document).ready(function() {
		//najpierw ukrywamy orginalne przyciski
		$('input[value="Drukuj etykiety"]').hide();
		$('input[value="Drukuj listę załadunkową"]').hide();
		
		//realizujemy kliknięcie za pomocą linku
		$("li#print_label a").click(function() {
			$('input[value="Drukuj etykiety"]').click();
		})
		$("li#print_transport_list a").click(function() {
			$('input[value="Drukuj listę załadunkową"]').click();
		})
		
		//obsługa zaznaczania i odznaczania
		$('li#check a').click(function() {
			console.log("klik");
			//zaznaczanie i odznaczanie
			if($(this).text() == "Zaznacz wszystkie widoczne") {
				$('input[id^=select_]').attr("checked",true);
				$(this).text("Odznacz wszystkie widoczne");
			} 
			else {
				$('input[id^=select_]').attr("checked",false);
				$(this).text("Zaznacz wszystkie widoczne");
			}
		})
		
		//Rozszeżanie kontenera
		$('div#page').css("width","2100px");
		
	});
/*]]>*/
</script>
