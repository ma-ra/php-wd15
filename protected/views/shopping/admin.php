<?php

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/wd15.css');

/* @var $this ShoppingController */
/* @var $model Shopping */

$this->setPageTitle('Lista zakupów');
$this->breadcrumbs=array(
	'Lista zakupów'=>array('admin'),
);

$this->menu=array(
	array('label'=>'# - w nowej karcie'),
	array('label'=>'* - w tle'),
	array('label'=>'brak - normalne przejście do nowej strony'),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Dodaj ręcznie', 'url'=>array('create')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Wyświetl zamówienie #', 'url'=>'#', 'itemOptions'=>array('id' => 'html-menu')),
	array('label'=>'Drukuj zamówienie #', 'url'=>'#', 'itemOptions'=>array('id' => 'print-menu')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Dostarczono *', 'url'=>'#', 'itemOptions'=>array('id' => 'delivered')),
	array('label'=>'Częściowo *', 'url'=>'#', 'itemOptions'=>array('id' => 'partial')),
	array('label'=>'Anulowano *', 'url'=>'#', 'itemOptions'=>array('id' => 'canceled')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Filtr [nowe] *', 'url'=>'#', 'itemOptions'=>array('id' => 'new')),
	array('label'=>'Filtr [w trakcie] *', 'url'=>'#', 'itemOptions'=>array('id' => 'during')),
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
						'value' => 'CHtml::encode(isset($data->fabricCollectionFabric->supplierSupplier->supplier_name) ? $data->fabricCollectionFabric->supplierSupplier->supplier_name : "-" )'
				),
				//'textile_textile_id',
				array(
						'name' => 'fabricCollectionFabric.fabric_number',
						'filter'=>CHtml::activeTextField($model,'textile_textile_number'),
						'type' => 'raw',
						'value' => 'CHtml::encode($data->fabricCollectionFabric->fabric_number)'
				),
				array(
						'name' => 'fabricCollectionFabric.fabric_name',
						'filter'=>CHtml::activeTextField($model,'textile_textile_name'),
						'type' => 'raw',
						'value' => 'CHtml::encode($data->fabricCollectionFabric->fabric_name)'
				),
				'article_calculated_amount',
				'article_amount',
            	'article_delivered_amount',
            	'article_price',
            	'document_name',
            	'invoice_name',
				'shopping_notes',
				'shopping_term',
				'shopping_printed',
				'shopping_scheduled_delivery',
            	'shopping_date_of_shipment',
            	'shopping_delivery_date',
				array(
						'name' => 'shopping_status',
						'filter'=>array('w trakcie'=>'w trakcie','nowy'=>'nowy', 'wydrukowane'=>'wydrukowane', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo'),
						'type' => 'raw',
						'value' => 'CHtml::encode($data->shopping_status)'
				),
            	'paid',
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
)); 

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'mydialog',
		// additional javascript options for the dialog plugin
		'options'=>array(
				'title'=>'WD15',
				'autoOpen'=>false,
				'buttons' => array(
                    'OK'=>'js:function(){$(this).dialog("close")}',
				),
				'model' => true,
		),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<div class="modal"><!-- Place at bottom of page --></div>

<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('shopping-grid');
}

$(document).ready(function() {
	//obsługa ikonki ładowania
	$body = $("body");
	$(document).on({
	    ajaxStart: function() { 
		    $body.addClass("loading");
		    console.log("start loading");   
		},
	    ajaxStop: function() { 
		    $body.removeClass("loading");
		    console.log("stop loading");
		}    
	});     
	
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

	$("li#delivered a").click(function(event) {
		//wysyłka ajaxem
		$.ajax({
			type: 'POST',
			url : "<?php echo Yii::app()->createUrl("Shopping/delivered")?>",
			data: $("form#shopping-form").serialize(),
			success : function(data) {
				console.log(data);
				$('#shopping-grid').yiiGridView('update');
			},
			error : function(data) {
				console.log(data);
			}
		});
		event.preventDefault();
	});

	$("li#partial a").click(function(event) {
		//wysyłka ajaxem
		$.ajax({
			type: 'POST',
			url : "<?php echo Yii::app()->createUrl("Shopping/partial")?>",
			data: $("form#shopping-form").serialize(),
			success : function(data) {
				console.log(data);
				$('#shopping-grid').yiiGridView('update');
				$("#mydialog").dialog( "option", "title", "Częściowo" );
				$("#mydialog").html("Oznaczono jako dostarczone częściowo.\n<br> <b>Należy uzupełnić dostarczoną ilość.</b>");
				$("#mydialog").dialog( "open" );
			},
			error : function(data) {
				console.log(data);
			}
		});
		event.preventDefault();
	});

	$("li#canceled a").click(function(event) {
		//wysyłka ajaxem
		$.ajax({
			type: 'POST',
			url : "<?php echo Yii::app()->createUrl("Shopping/canceled")?>",
			data: $("form#shopping-form").serialize(),
			success : function(data) {
				console.log(data);
				$('#shopping-grid').yiiGridView('update');
			},
			error : function(data) {
				console.log(data);
			}
		});
		event.preventDefault();
	});

	$("li#new a").click(function(event) {
		$('#shopping-grid').yiiGridView('update', {data: 'Shopping[shopping_status]=nowy&sort=shopping_number.desc'});
		event.preventDefault();
	});

	$("li#during a").click(function(event) {
		$('#shopping-grid').yiiGridView('update', {data: 'Shopping[shopping_status]=w trakcie&sort=shopping_number.desc'});
		event.preventDefault();
	});

	

	//Rozszeżanie kontenera
	width1=$('.span-7').width();
	width2=$('.span-24').width();
	width3=$('#shopping-grid table').width();
	if (width3 > width2) {
		allWidth=width3+width1+40;
	} else {
		allWidth=width2+width1+40;
	}
	$('div#page').css("width",allWidth);
	
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
