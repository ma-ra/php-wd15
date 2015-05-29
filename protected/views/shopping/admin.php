<?php
/* @var $this ShoppingController */
/* @var $model Shopping */

$this->breadcrumbs=array(
	'Shoppings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Dodaj', 'url'=>array('create')),
	array('label'=>'Drukuj zamówienie', 'url'=>'#', 'itemOptions'=>array('id' => 'print-menu')),
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


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shopping-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>

<?php $this->widget('ext.selgridview.SelGridView', array(
	'id'=>'shopping-grid',
	'dataProvider'=>$model->search(),
	'selectableRows' => 2,
	'filter'=>$model,
	'columns'=>array(
		array(
			'id'=>'check',
			'class' => 'CCheckBoxColumn',
		),
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
		array(
				'name' => 'shopping_status',
				'filter'=>array('0'=>'w trakcie','nowy'=>'nowy', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->shopping_status)'
		),
		'shopping_printed',
		'creation_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('shopping-grid');
}

$(document).ready(function() {
	$("li#print-menu a").click(function() {
		//zmieniamy cel wysłania danych i ustawiamy aby było w nowej karcie
		$("form#shopping-form").attr("action","<?php echo Yii::app()->createUrl("Shopping/print", array('act'=>'print_order'))?>");
		$("form#shopping-form").attr("target","_blank");
		//zatwierdzenie formularza i przywrócenie otwierania w bieżącej karcie
		$("form#shopping-form").submit();
		$("form#shopping-form").attr("target","_self");
	});
	
});
</script>
<?php $this->endWidget(); ?>
