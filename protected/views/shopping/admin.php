<?php
/* @var $this ShoppingController */
/* @var $model Shopping */

$this->setPageTitle('Lista zakupów');
$this->breadcrumbs=array(
	'Lista zakupów'=>array('admin'),
);

$this->menu=array(
	//array('label'=>'Dodaj', 'url'=>array('create')),
	array('label'=>'Dodaj ręcznie', 'url'=>array('create')),
	array('label'=>'Wyświetl zamówienie', 'url'=>'#', 'itemOptions'=>array('id' => 'html-menu')),
	array('label'=>'Drukuj zamówienie', 'url'=>'#', 'itemOptions'=>array('id' => 'print-menu')),
);
?>

<h1>Lista zakupów</h1>

<p>
Wprowadzone filtry należy zatwierdzić klawiszem "Enter". Można dodatkowo używać operatorów (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
lub <b>=</b>) na początku każdej wyszukiwanej wartości aby sprecyzować sposób działania porównania. W niektórych polach można użyć cyfry 0, aby wyszukać puste wartości.
</p>

<?php 
$dialog = $this->widget('ext.ecolumns.EColumnsDialog', array(
       'options'=>array(
            'title' => 'Konfiguracja tabeli',
            'autoOpen' => false,
            'show' =>  'fade',
            'hide' =>  'fade',
        ),
       'htmlOptions' => array('style' => 'display: none'), //disable flush of dialog content
       'ecolumns' => array(
            'gridId' => 'shopping-grid', //id of related grid
            'storage' => 'cookie',  //where to store settings: 'db', 'session', 'cookie'
            'fixedLeft' => array(), //fix checkbox to the left side 
            'model' => $model->search()->model, //model is used to get attribute labels
            'columns' => array(
				array(
					'id'=>'check',
					'class' => 'CCheckBoxColumn',
				),
				'shopping_id',
				'shopping_number',
				array(
						'header' => 'dostawca',
						'name' => 'supplierSupplier.supplier_name',
						'filter'=>CHtml::activeTextField($model,'textile_supplier_supplier_name'),
						'type' => 'raw',
						'value' => 'CHtml::encode(isset($data->textileTextile->supplierSupplier->supplier_name) ? $data->textileTextile->supplierSupplier->supplier_name : "-" )'
				),
				//'textile_textile_id',
				array(
						'name' => 'textileTextile.textile_number',
						'filter'=>CHtml::activeTextField($model,'textile_textile_number'),
						'type' => 'raw',
						'value' => 'CHtml::encode($data->textileTextile->textile_number)'
				),
				array(
						'name' => 'textileTextile.textile_name',
						'filter'=>CHtml::activeTextField($model,'textile_textile_name'),
						'type' => 'raw',
						'value' => 'CHtml::encode($data->textileTextile->textile_name)'
				),
				'article_amount',
				'article_calculated_amount',
				'shopping_term',
            	'shopping_date_of_shipment',
				'shopping_scheduled_delivery',
				'shopping_notes',
				array(
						'name' => 'shopping_status',
						'filter'=>array('w trakcie'=>'w trakcie','nowy'=>'nowy', 'wydrukowane'=>'wydrukowane', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo'),
						'type' => 'raw',
						'value' => 'CHtml::encode($data->shopping_status)'
				),
				'shopping_printed',
				'creation_time',
				array(
					'class'=>'CButtonColumn',
					'template'=>'{update}',
				),
			),
       )
    ));
?>

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
	'columns'=>$dialog->columns(),
	'template' => $dialog->link()."{summary}\n{items}\n{pager}",
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

	$("li#html-menu a").click(function() {
		//zmieniamy cel wysłania danych i ustawiamy aby było w nowej karcie
		$("form#shopping-form").attr("action","<?php echo Yii::app()->createUrl("Shopping/html", array('act'=>'print_order'))?>");
		$("form#shopping-form").attr("target","_blank");
		//zatwierdzenie formularza i przywrócenie otwierania w bieżącej karcie
		$("form#shopping-form").submit();
		$("form#shopping-form").attr("target","_self");
	});
	
});
</script>
<?php $this->endWidget(); ?>

<?php 
Yii::app()->clientScript->registerScript('gridFilter',"   
    $(function(){
        $(document).off('change.yiiGridView');
    });
", CClientScript::POS_READY);
?> 
