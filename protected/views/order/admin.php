<?php

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/wd15.css');

/* @var $model Order */
$this->setPageTitle('Lista zamówień, tydz. ' . date('W'));
$this->breadcrumbs=array(
	'Lista zamówień'=>array('admin'),
);

$this->menu=array(
	array('label'=>'# - w nowej karcie'),
	array('label'=>'* - w tle'),
	array('label'=>'brak - normalne przejście do nowej strony'),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Filtr [materiały] *', 'url'=>'#', 'itemOptions'=>array('id' => 'textile')),
	array('label'=>'Filtr [plan] *', 'url'=>'#', 'itemOptions'=>array('id' => 'plan')),
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
	array('label'=>'Drukuj etykiety transportowe (Zebra) #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_zebra_label')),
	array('label'=>'Drukuj plombę gwarnacyjną #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_guarantee_seal')),
	array('label'=>'Drukuj ladeliste #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_transport_list')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Twórz plan *', 'url'=>'#', 'itemOptions'=>array('id' => 'create_plan')),
	array('label'=>'Drukuj plan #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_plan')),
	array('label'=>'Drukuj zamówienia #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_orders')),
	array('label'=>'Drukuj zamówienia (krój) #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_orders_for_cutting_department')),
	array('label'=>'Drukuj zamówienia (z cenami) #', 'url'=>'#', 'itemOptions'=>array('id' => 'print_orders_with_price')),
	array('label'=>'Dopasuj materiały #', 'url'=>'#', 'itemOptions'=>array('id' => 'search_textiles')),
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
<B>Obecny tydzień: <?php echo date('W')?></B>
<?php
# definicja kolumn
$columns=array(
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
	'buyer_order_number',
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
    	'name' => 'articleArticle.model_description',
    	'filter'=>CHtml::activeTextField($model,'articleArticle_model_description'),
    	'type' => 'raw',
    	'value' => 'CHtml::encode($data->articleArticle->model_description)'
	    ),
	array(
		'name' => 'articleArticle.article_colli',
		'filter'=>CHtml::activeTextField($model,'articleArticle_article_colli'),
		'type' => 'raw',
		'value' => 'CHtml::encode($data->articleArticle->article_colli)'
	),
	'textil_pair',
	array(
		'header' => 'deseń 1',
		'name' => 'textile1Textile.textile_number',
		'filter'=>CHtml::activeTextField($model,'textiles1_textile_number'),
		'type' => 'raw',
		'value' => 'CHtml::encode($data->textile1Textile->textile_number)'
	),
	array(
    	'header' => 'deseń 2',
		'name' => 'textile2Textile.textile_number',
    	'filter'=>CHtml::activeTextField($model,'textiles2_textile_number'),
    	'type' => 'raw',
    	'value' => 'CHtml::encode(isset($data->textile2Textile->textile_number)? $data->textile2Textile->textile_number : "")'
	),
	array(
    	'header' => 'deseń 3',
    	'name' => 'textile3Textile.textile_number',
    	'filter'=>CHtml::activeTextField($model,'textiles2_textile_number'),
    	'type' => 'raw',
    	'value' => 'CHtml::encode(isset($data->textile3Textile->textile_number)? $data->textile3Textile->textile_number : "")'
	),
    array(
        'header' => 'deseń 4',
        'name' => 'textile4Textile.textile_number',
        'filter'=>CHtml::activeTextField($model,'textiles2_textile_number'),
        'type' => 'raw',
        'value' => 'CHtml::encode(isset($data->textile4Textile->textile_number)? $data->textile4Textile->textile_number : "")'
    ),
    array(
        'header' => 'deseń 5',
        'name' => 'textile5Textile.textile_number',
        'filter'=>CHtml::activeTextField($model,'textiles2_textile_number'),
        'type' => 'raw',
        'value' => 'CHtml::encode(isset($data->textile5Textile->textile_number)? $data->textile5Textile->textile_number : "")'
    ),
	array(
		'name' => 'textile1Textile.textile_name',
		'filter'=>CHtml::activeTextField($model,'textiles1_textile_name'),
		'type' => 'raw',
		'value' => 'CHtml::encode($data->textile1Textile->textile_name)'
	),
	array(
		'name' => 'textile2Textile.textile_name',
		'filter'=>CHtml::activeTextField($model,'textiles2_textile_name'),
		'type' => 'raw',
		'value' => 'CHtml::encode(isset($data->textile2Textile->textile_name)? $data->textile2Textile->textile_name : "")'
	),
	array(
	    'header' => 'opis materiału',
    	'name' => 'textile1Textile.textile_description',
    	'filter'=>CHtml::activeTextField($model,'textiles1_textile_name'),
    	'type' => 'raw',
    	'value' => 'CHtml::encode(isset($data->textile1Textile->textile_description)? $data->textile1Textile->textile_description : "")'
    ),
    array(
        'header' => 'opis materiału',  
        'name' => 'textile2Textile.textile_description',
        'filter'=>CHtml::activeTextField($model,'textiles2_textile_name'),
        'type' => 'raw',
        'value' => 'CHtml::encode(isset($data->textile2Textile->textile_description)? $data->textile2Textile->textile_description : "")'
    ),
	array(
    	'header' => 'deseń 1 - status zakupów',
    	'name' => 'shopping1Shopping.shopping_status',
    	'filter'=>CHtml::activeDropDownList($model,'shopping1Shopping_shopping_status', array(''=>'', 'w trakcie'=>'w trakcie','nowy'=>'nowy', 'wydrukowane'=>'wydrukowane', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo', '0'=>'null')),
    	'type' => 'raw',
    	'value' => 'CHtml::encode(isset($data->shopping1Shopping->shopping_status)? $data->shopping1Shopping->shopping_status . " (" . $data->shopping1Shopping->shopping_number . "/" . $data->shopping1_shopping_id . ")" : "")'
    ),
	array(
		'header' => 'deseń 2 - status zakupów',
		'name' => 'shopping2Shopping.shopping_status',
		'filter'=>CHtml::activeDropDownList($model,'shopping2Shopping_shopping_status', array(''=>'', 'w trakcie'=>'w trakcie','nowy'=>'nowy', 'wydrukowane'=>'wydrukowane', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo', '0'=>'null')),
		'type' => 'raw',
		'value' => 'CHtml::encode(isset($data->shopping2Shopping->shopping_status)? $data->shopping2Shopping->shopping_status . " (" . $data->shopping2Shopping->shopping_number . "/" . $data->shopping2_shopping_id . ")" : "")'
	),
	array(
    	'header' => 'deseń 3 - status zakupów',
    	'name' => 'shopping3Shopping.shopping_status',
    	'filter'=>CHtml::activeDropDownList($model,'shopping2Shopping_shopping_status', array(''=>'', 'w trakcie'=>'w trakcie','nowy'=>'nowy', 'wydrukowane'=>'wydrukowane', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo', '0'=>'null')),
    	'type' => 'raw',
    	'value' => 'CHtml::encode(isset($data->shopping2Shopping->shopping_status)? $data->shopping2Shopping->shopping_status . " (" . $data->shopping2Shopping->shopping_number . "/" . $data->shopping2_shopping_id . ")" : "")'
    ),
    array(
        'header' => 'deseń 4 - status zakupów',
        'name' => 'shopping4Shopping.shopping_status',
        'filter'=>CHtml::activeDropDownList($model,'shopping2Shopping_shopping_status', array(''=>'', 'w trakcie'=>'w trakcie','nowy'=>'nowy', 'wydrukowane'=>'wydrukowane', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo', '0'=>'null')),
        'type' => 'raw',
        'value' => 'CHtml::encode(isset($data->shopping2Shopping->shopping_status)? $data->shopping2Shopping->shopping_status . " (" . $data->shopping2Shopping->shopping_number . "/" . $data->shopping2_shopping_id . ")" : "")'
    ),
    array(
        'header' => 'deseń 5 - status zakupów',
        'name' => 'shopping5Shopping.shopping_status',
        'filter'=>CHtml::activeDropDownList($model,'shopping2Shopping_shopping_status', array(''=>'', 'w trakcie'=>'w trakcie','nowy'=>'nowy', 'wydrukowane'=>'wydrukowane', 'dostarczono'=>'dostarczono', 'częściowo'=>'częściowo', '0'=>'null')),
        'type' => 'raw',
        'value' => 'CHtml::encode(isset($data->shopping2Shopping->shopping_status)? $data->shopping2Shopping->shopping_status . " (" . $data->shopping2Shopping->shopping_number . "/" . $data->shopping2_shopping_id . ")" : "")'
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
	'order_notes',
	array(
		'class'=>'CButtonColumn',
		'template'=>'{update}',
	),
	'order_add_date',
	'order_storno_date',
	'order_date',
	'buyer_comments',
	'order_reference',
	'order_EAN_number',
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
		'name' => 'buyerBuyer.buyer_name_2',
		'filter'=>CHtml::activeTextField($model,'buyerBuyer_buyer_name_2'),
		'type' => 'raw',
		'value' => 'CHtml::encode($data->buyerBuyer->buyer_name_2)'
	),
	array(
    	'name' => 'deliveryAddressDeliveryAddress.delivery_address_name_1',
    	'filter'=>CHtml::activeTextField($model,'deliveryAddressDeliveryAddress_delivery_address_name_1'),
    	'type' => 'raw',
        'value' => 'CHtml::encode(isset($data->deliveryAddressDeliveryAddress->delivery_address_name_1)? $data->deliveryAddressDeliveryAddress->delivery_address_name_1 : "")'
    ),
    array(
    'name' => 'deliveryAddressDeliveryAddress.delivery_address_name_2',
    'filter'=>CHtml::activeTextField($model,'deliveryAddressDeliveryAddress_delivery_address_name_2'),
    'type' => 'raw',
    'value' => 'CHtml::encode(isset($data->deliveryAddressDeliveryAddress->delivery_address_name_2)? $data->deliveryAddressDeliveryAddress->delivery_address_name_2 : "")'
		    ),
	array(
		'name' => 'legLeg.leg_type',
		'filter'=>CHtml::activeTextField($model,'legLeg_leg_type'),
		'type' => 'raw',
		'value' => 'CHtml::encode($data->legLeg->leg_type)'
	),
	'textilpair_price_group',
	#'order_price',
	#'order_total_price',
);

# wybranym osobą włączamy dodatkowe kolumny
if (in_array(Yii::app()->user->name, array('asia', 'gosia', 'mara', 'mariola', 'michalina'))) {
	array_push($columns, 'order_price', 'order_total_price');
}

$dialog = $this->widget('ext.ecolumns.EColumnsDialog', array(
	'options'=>array(
	     'title' => 'Konfiguracja tabeli',
	     'autoOpen' => false,
	     'show' =>  'fade',
	     'hide' =>  'fade',
	 ),
	'htmlOptions' => array('style' => 'display: none'), //disable flush of dialog content
	'ecolumns' => array(
	     'gridId' => 'order-grid', //id of related grid
	     'storage' => 'cookie',  //where to store settings: 'db', 'session', 'cookie'
	     'fixedLeft' => array(), //fix checkbox to the left side 
	     'model' => $model->search()->model, //model is used to get attribute labels
	     'columns' => $columns,
	)
));

echo CHtml::beginForm(array('Order/print'),'post', array('enctype'=>'multipart/form-data', 'id'=>'check_form'));
$this->widget('ext.selgridview.SelGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'selectableRows' => 2,
	'filter'=>$model,
	'columns'=>$dialog->columns(),
    'template' => $dialog->link()."{summary}\n{items}\n{pager}",
)); 
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

<div class="modal"><!-- Place at bottom of page --></div>

<script type="text/javascript">
/*<![CDATA[*/
	 $(document).ready(function() {
		//obsługa ikonki ładowania
		$body = $("body");
		$(document).on({
		    ajaxStart: function() { $body.addClass("loading");    },
		    ajaxStop: function() { $body.removeClass("loading"); }    
		});     

		//
		// Wysyłka za pomocą linku i dodatkowej informacji w formularzu
		//
		$("li#print_label a").click(function(event) {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "shipping_label")
	            .val("shipping_label");
			$("form#check_form").append($(input));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank");
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self");
			input.remove();
			event.preventDefault();
		});
		$("li#print_zebra_label a").click(function(event) {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "shipping_zebra_label")
	            .val("shipping_zebra_label");
			$("form#check_form").append($(input));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank");
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self");
			input.remove();
			event.preventDefault();
		});
		$("li#print_transport_list a").click(function(event) {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "ladeliste")
	            .val("ladeliste");
			$("form#check_form").append($(input));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank");
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self");
			input.remove();
			event.preventDefault();
		});
		$("li#print_minilabel a").click(function(event) {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "minilabel")
	            .val("minilabel");
			$("form#check_form").append($(input));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank");
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self");
			input.remove();
			event.preventDefault();
		});

		//
		// Wysyłka za pomocą linku ze zmianą celu i dodatkowej informacji w POST
		//
		$("li#summary a").click(function(event) {
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
			input.remove();
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});
		$("li#textile_summary a").click(function(event) {
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
			input.remove();
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});

		//
		// Wysyłka za pomocą linku i dodatkowej informacji w GET pobranej ze specjalnego formularza
		//
		$("li#create_plan a").click(function(event) {
			//dialog - tytuł + treść html (zwykły input)
			$("#mydialog").dialog( "option", "title", "Podaj numer planu" );
			$("#mydialog").html('Numer tygodnia: <input type="text" id="week_number" value="/2015" >');
			//zmiana przycisków na dialogu
			$("#mydialog").dialog( "option", "buttons", {
				 "Zamknij": function() { $(this).dialog("close"); },
				 //pod ten przycisk podpinamy główną funkcjonalność
				 "Zapisz": function() {
					//pobieramy numer planu
					var weekNumber=$("input#week_number").val();

					//zamykamy dialog
					$(this).dialog("close");
					
					//wysyłka ajaxem
					$.ajax({
						type: 'POST',
						url : "<?php echo Yii::app()->createUrl("Order/printPlan", array('act'=>'create_plan','week_number'=>'week_number_placeholder'))?>".replace("week_number_placeholder", weekNumber),
						data: $("form#check_form").serialize(),
						success : function(data) {
							//zmiana opisu w dialogu i wyświetlenie
							$("#mydialog").dialog("open");
							$("#mydialog").html('Zapisano. Kliknięcie na OK spowoduje odświerzenie listy zamówień');
							$("#mydialog").dialog( "option", "buttons", {
								 "OK": function() { 
									 $('#order-grid').yiiGridView('update');
									 $(this).dialog("close"); 
								  },
							});
						},
						error : function(data) {
							console.log(data);
						}
					});
				 } 
			});
			$("#mydialog").dialog( "open" );
			event.preventDefault();
		});

		//
		// Wysyłka za pomocą linku i dodatkowej informacji w GET
		//
		$("li#print_plan a").click(function(event) {
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/printPlan", array('act'=>'print_plan'))?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});
		$("li#print_orders a").click(function(event) {
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/printPlan", array('act'=>'print_orders'))?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});
		$("li#print_orders_for_cutting_department a").click(function(event) {
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/printPlan", array('act'=>'print_orders_for_cutting_department'))?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});
		$("li#print_orders_with_price a").click(function(event) {
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/printOrdersWithPrice")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});
		$("li#search_textiles a").click(function(event) {
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/searchTextiles")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});
		$("li#print_guarantee_seal a").click(function(event) {
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/PrintGuaranteeSeal")?>");
			//zatwierdzenie formularza
			$("form#check_form").attr("target","_blank")
			$("form#check_form").submit();
			$("form#check_form").attr("target","_self")
			//przywracamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/print")?>");
			event.preventDefault();
		});

		//
		// Wysyłka ajaxem
		//
		$("li#set_check a").click(function(event) {
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
			event.preventDefault();
		});
		$("li#unset_check a").click(function(event) {
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
			event.preventDefault();
		});
		$("li#reset_check a").click(function(event) {
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
			event.preventDefault();
		});
		$("li#read_check a").click(function(event) {
			//pobieramy dane ajaxem
			$.ajax({
				type: 'POST',
				url : "<?php echo Yii::app()->createUrl("Order/checked", array('act'=>'read'))?>",
				data: $("form#check_form").serialize(),
				success : function(data) {
					console.log("SUCCESS");
					console.log(data);
					console.log($.map(data.split(","), Number));
					$("#order-grid").selGridView("addSelection", $.map(data.split(","), Number));
				},
				error : function(data) {
					console.log("ERROR");
					console.log(data);
				}
			});
			event.preventDefault();
		});
		$("li#prepared a").click(function(event) {
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
			event.preventDefault();
		});
		$("li#manufactured a").click(function(event) {
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
			event.preventDefault();
		});
		$("li#canceled a").click(function(event) {
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
			event.preventDefault();
		});

		$("li#textile a").click(function(event) {
			$('#order-grid').yiiGridView('update', {data: 'Order[textile_prepared]=0'});
			event.preventDefault();
		});

		$("li#plan a").click(function(event) {
			$('#order-grid').yiiGridView('update', {data: 'Order[article_planed]=%3E0'});
			event.preventDefault();
		});
		
		//Rozszeżanie kontenera
		width1=$('.span-7').width();
		width2=$('.span-24').width();
		width3=$('#order-grid table').width();
		if (width3 > width2) {
			allWidth=width3+width1+40;
		} else {
			allWidth=width2+width1+40;
		}
		$('div#page').css("width",allWidth);
		
	});
/*]]>*/
</script>
