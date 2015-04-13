<?php
/* @var $model Order */

$this->breadcrumbs=array(
	'Zamówienia'=>array('index'),
);

$this->menu=array(
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Zaznacz wszystkie widoczne', 'url'=>'#', 'itemOptions'=>array('id' => 'check')),
	array('label'=>'Zapisz/Usuń zaznaczenie', 'url'=>'#', 'itemOptions'=>array('id' => 'save_check')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Dodaj zamówienie', 'url'=>array('create')),
	array('label'=>'Wgraj zamówienia', 'url'=>array('upload')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Drukuj etykiety na wykroje', 'url'=>'#', 'itemOptions'=>array('id' => 'print_minilabel')),
	array('label'=>'Drukuj etykiety transportowe', 'url'=>'#', 'itemOptions'=>array('id' => 'print_label')),
	array('label'=>'Drukuj ladeliste', 'url'=>'#', 'itemOptions'=>array('id' => 'print_transport_list')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Wykrojono (Zaznacz/Odznacz)', 'url'=>'#', 'itemOptions'=>array('id' => 'prepared')),
	array('label'=>'Wyprodukowano (Zaznacz/Odznacz)', 'url'=>'#', 'itemOptions'=>array('id' => 'manufactured')),
	array('label'=>'Storno (Zaznacz/Odznacz)', 'url'=>'#', 'itemOptions'=>array('id' => 'canceled')),
	array('label'=>'--------------------------------------------------'),
	array('label'=>'Podsumowanie', 'url'=>'#', 'itemOptions'=>array('id' => 'summary')),
	array('label'=>'--------------------------------------------------'),
);
?>

<h1>Zamówienia</h1>

<p>
Można dodatkowo używać operatorów (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
lub <b>=</b>) na początku każdej wyszukiwanej wartości aby sprecyzować sposób działania porównania.
</p>
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
		'printed_minilabel',
		'printed_shipping_label',
		'textile_prepared',
		array(
				'name' => 'article_manufactured',
				'type' => 'raw',
				'value' => 'CHtml::encode(isset($data->article_manufactured)? $data->article_manufactured . "/" . ($data->article_amount*$data->articleArticle->article_colli) . " Coli (" . (100*$data->article_manufactured)/($data->article_amount*$data->articleArticle->article_colli) . "%)" : "0%")'
		),
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
		})
		$("li#print_transport_list a").click(function() {
			$("form#check_form").attr("target","_blank");
			$('input[value="Drukuj listę załadunkową"]').click();
			$("form#check_form").attr("target","_self");
		})
		$("li#print_minilabel a").click(function() {
			$("form#check_form").attr("target","_blank");
			$('input[value="Drukuj etykiety na wykroje"]').click();
			$("form#check_form").attr("target","_self");
		})
		$("li#save_check a").click(function() {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "checked")
	            .val("checked");
			$("form#check_form").append($(input));
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/checked")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").submit();
		})
		$("li#prepared a").click(function() {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "prepared")
	            .val("prepared");
			$("form#check_form").append($(input));
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/prepared")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").submit();
		})
		$("li#manufactured a").click(function() {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "manufactured")
	            .val("manufactured");
			$("form#check_form").append($(input));
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/manufactured")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").submit();
		})
		$("li#canceled a").click(function() {
			//dodajemy informację do POST po przez ukryte pole
			var input = $("<input>")
	            .attr("type", "hidden")
	            .attr("name", "canceled")
	            .val("canceled");
			$("form#check_form").append($(input));
			//zmieniamy cel wysłania danych
			$("form#check_form").attr("action","<?php echo Yii::app()->createUrl("Order/canceled")?>");
			console.log($("form#check_form").attr("action"));
			//zatwierdzenie formularza
			$("form#check_form").submit();
		})
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
		})
		
		
		//obsługa zaznaczania i odznaczania
		$('li#check a').click(function(e) {
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
			e.preventDefault();
		})
		
		//Rozszeżanie kontenera
		$('div#page').css("width","2800px");
		
	});
/*]]>*/
</script>
