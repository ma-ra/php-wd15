<?php
/* @var $model Order */

$this->breadcrumbs=array(
	'Lista zamówień'=>array('admin'),
);

$this->menu=array(
	array('label'=>'# - w nowej karcie'),
	array('label'=>'* - w tle'),
	array('label'=>'brak - normalne przejście do nowej strony'),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Zapisz zaznaczenie *', 'url'=>'#', 'itemOptions'=>array('id' => 'set_check')),
	array('label'=>'Usuń zaznaczenie *', 'url'=>'#', 'itemOptions'=>array('id' => 'unset_check')),
	array('label'=>'Reset zaznaczenia *', 'url'=>'#', 'itemOptions'=>array('id' => 'reset_check')),			
	array('label'=>'Odczyt zaznaczenia *', 'url'=>'#', 'itemOptions'=>array('id' => 'read_check')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Dodaj zamówienie', 'url'=>array('create')),
	array('label'=>'Wczytaj zamówienia', 'url'=>array('upload')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Drukuj etykiety na wykroje #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_minilabel')),
	array('label'=>'Drukuj etykiety transportowe #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_label')),
	array('label'=>'Drukuj ladeliste #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_transport_list')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Wykrojono (Zaznacz/Odznacz) *', 'url'=>'#', 'itemOptions'=>array('id' => 'prepared')),
	array('label'=>'Wyprodukowano (Zaznacz/Odznacz) *', 'url'=>'#', 'itemOptions'=>array('id' => 'manufactured')),
	array('label'=>'Storno (Zaznacz/Odznacz) *', 'url'=>'#', 'itemOptions'=>array('id' => 'canceled')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Podsumowanie #', 'url'=>'#', 'itemOptions'=>array('id' => 'summary')),
	array('label'=>'Wyliczenie materiałów #', 'url'=>'#', 'itemOptions'=>array('id' => 'textile_summary')),
	array('label'=>'--------------------------------------------------'),
);
?>

<h1>Lista zamówień</h1>

<p>
Wprowadzone filtry należy zatwierdzić klawiszem "Enter". Można dodatkowo używać operatorów (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
lub <b>=</b>) na początku każdej wyszukiwanej wartości aby sprecyzować sposób działania porównania. W niektórych polach można użyć cyfry 0, aby wyszukać puste wartości.
</p>
<?php 
echo CHtml::beginForm(array('Order/print'),'post', array('enctype'=>'multipart/form-data', 'id'=>'check_form'));

$this->widget('ext.selgridview.SelGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'selectableRows' => 2,
	'filter'=>$model,
	'columns'=>array(
		array(
				'id'=>'select',
				'class' => 'CCheckBoxColumn',
		),
		'checked',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
		),
		'order_id',
		'article_amount',
		'order_number',
		'order_term',
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
		'textil_pair',
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
				'name' => 'shoppingShopping.shopping_status',
				'filter'=>CHtml::activeTextField($model,'shoppingShopping_shopping_status'),
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->shoppingShopping->shopping_status)? $data->shoppingShopping->shopping_status . " (" . $data->shopping_shopping_id . ")" : "")'
		),
		'printed_minilabel',
		'printed_shipping_label',
		'textile_prepared',
		'article_planed',
		array(
				'name' => 'article_manufactured',
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->article_manufactured)? $data->article_manufactured . "/" . ($data->article_amount*$data->articleArticle->article_colli) . " Coli (" . (100*$data->article_manufactured)/($data->article_amount*$data->articleArticle->article_colli) . "%)" : "0%")'
		),
		'article_prepared_to_export',
		'article_exported',
		'article_canceled',
		'order_error',
		array(
				'class'=>'CButtonColumn',
				'template'=>'{update}',
		),
		'order_add_date',
		'order_date',
		'buyer_order_number',
		'buyer_comments',
		'order_reference',
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
				'name' => 'legLeg.leg_type',
				'filter'=>CHtml::activeTextField($model,'legLeg_leg_type'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->legLeg->leg_type)'
		),
		'textilpair_price_group',
		array(
				'name' => 'textile1Textile.textile_price_group',
				'filter'=>CHtml::activeTextField($model,'textiles1_textile_price_groupe'),
				'type' => 'raw',
				'value' => 'CHtml::encode($data->textile1Textile->textile_price_group)'
		),
		array(
				'name' => 'textile2Textile.textile_price_group',
				'filter'=>CHtml::activeTextField($model,'textiles2_textile_price_groupe'),
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->textile2Textile->textile_price_group)? $data->textile2Textile->textile_price_group : "")'
		),
	),
)); 
echo CHtml::submitButton('Drukuj etykiety') . "<br>";
echo CHtml::submitButton('Drukuj listę załadunkową') . "<br>";
echo CHtml::submitButton('Drukuj etykiety na wykroje') . "<br>";
echo CHtml::endForm();

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

<?php 
Yii::app()->clientScript->registerScript('gridFilter',"   
    $(function(){
        $(document).off('change.yiiGridView');
    });
", CClientScript::POS_READY);
?> 

<script type="text/javascript">
/*<![CDATA[*/
	 $(document).ready(function() {
		//najpierw ukrywamy orginalne przyciski
		$('input[value="Drukuj etykiety na wykroje"]').hide();
		$('input[value="Drukuj etykiety"]').hide();
		$('input[value="Drukuj listę załadunkową"]').hide();
		
		//realizujemy kliknięcie za pomocą linku
		$("li#print_label a").click(function() {
			$("form#check_form").attr("target","_blank");
			$('input[value="Drukuj etykiety"]').click();
			$("form#check_form").attr("target","_self");
		});
		$("li#print_transport_list a").click(function() {
			$("form#check_form").attr("target","_blank");
			$('input[value="Drukuj listę załadunkową"]').click();
			$("form#check_form").attr("target","_self");
		});
		$("li#print_minilabel a").click(function() {
			$("form#check_form").attr("target","_blank");
			$('input[value="Drukuj etykiety na wykroje"]').click();
			$("form#check_form").attr("target","_self");
		});
		
		//wysyłka za pomocą linku i dodatkowej informacji w POST
		$("li#summary a").click(function() {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "summary")
	            .val("summary");
			$("form#check_form").append($(input));
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/summary")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
		});
		$("li#textile_summary a").click(function() {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "textile_summary")
	            .val("textile_summary");
			$("form#check_form").append($(input));
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/textileSummary")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
		});

		//wysyłka za pomocą linku i dodatkowej informacji w GET
		$("li#set_check a").click(function() {
			//wysyłka ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/checked", array('act'=>'set'))?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log(data);
					$('#order-grid').yiiGridView('update');
					$("#mydialog").dialog( "option", "title", "Zaznaczenie" );
					$("#mydialog").html("Zapisano zaznaczenie");
					$("#mydialog").dialog( "open" );
				},
				error : function(data) {
					console.log(data);
				}
			});
		});
		$("li#unset_check a").click(function() {
			//wysyłka ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/checked", array('act'=>'unset'))?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log(data);
					$('#order-grid').yiiGridView('update');
					$("#mydialog").dialog( "option", "title", "Zaznaczenie" );
					$("#mydialog").html("Usunieto zaznaczenie");
					$("#mydialog").dialog( "open" );
				},
				error : function(data) {
					console.log(data);
				}
			});
		});
		$("li#reset_check a").click(function() {
			//wysyłka ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/checked", array('act'=>'reset'))?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log(data);
					$('#order-grid').yiiGridView('update');
					$("#mydialog").dialog( "option", "title", "Zaznaczenie" );
					$("#mydialog").html(data);
					$("#mydialog").dialog( "open" );
				},
				error : function(data) {
					console.log(data);
				}
			});
		});
		$("li#read_check a").click(function() {
			//pobieramy dane ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/checked", array('act'=>'read'))?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log("SUCCESS");
					console.log(data);
					console.log(data.split(","));
					$("#order-grid").selGridView("addSelection", data.split(","));
				},
				error : function(data) {
					console.log("ERROR");
					console.log(data);
				}
			});
		});
		$("li#prepared a").click(function() {
			//wysyłka ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/prepared")?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log(data);
					$('#order-grid').yiiGridView('update');
					$("#mydialog").dialog( "option", "title", "Wykrojono" );
					$("#mydialog").html("Zapisano zmiany");
					$("#mydialog").dialog( "open" );
				},
				error : function(data) {
					console.log(data);
				}
			});
		});
		$("li#manufactured a").click(function() {
			//wysyłka ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/manufactured")?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log(data);
					$('#order-grid').yiiGridView('update');
					$("#mydialog").dialog( "option", "title", "Wyprodukowano" );
					$("#mydialog").html("Zapisano zmiany");
					$("#mydialog").dialog( "open" );
				},
				error : function(data) {
					console.log(data);
				}
			});
		});
		$("li#canceled a").click(function() {
			//wysyłka ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/canceled")?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log(data);
					$('#order-grid').yiiGridView('update');
					$("#mydialog").dialog( "option", "title", "Storno" );
					$("#mydialog").html("Zapisano zmiany");
					$("#mydialog").dialog( "open" );
				},
				error : function(data) {
					console.log(data);
				}
			});
		});
		
		//Rozszeżanie kontenera
		$('div#page').css("width","2800px");
		
	});
/*]]>*/
</script>
