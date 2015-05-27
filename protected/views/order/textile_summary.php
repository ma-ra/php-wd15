<style>
	table {
   		border-collapse: collapse;
	}
	
	table, th, td {
	    border: 1px solid black;
    	vertical-align: text-top;
    	text-align: center;
	}
</style>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shopping-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'action'=>array('Shopping/create'),
)); ?>

<table>
	<tr>
		<td>Dostawca:</td>
		<td>Nr. Mat.:</td>
		<td>Nazwa Mat.:</td>
		<td>Materiały - zaznaczone:</td>
		<td>Materiał - jeszcze potrzeba</td>
		<td>Zamawiana ilość</td>
		<td>Termin</td>
		<td>Materiały - na magazynie</td>
		<td>Materiał - zamówione</td>
		<td>Materiał - pozostało</td>
	</tr>
	<?php 
		foreach ($rapTextile as $key => $Order) {
			#wyświetlenie podsumowania materiałów, które zarazem jest formularzem zamówienia
			echo "<tr>";
				echo "<td>$Order->supplier_name</td>";
				echo "<td>$Order->textile_number</td>";
				echo "<td>$Order->textile_name</td>";
				echo "<td>$Order->textiles_selected</td>";
				echo "<td>$Order->textile_yet_need</td>";
				#pozycje które trzeba uzupełnić (formularz)
				echo "<td>\n";
					echo $form->textField($shopping[$key],"[$key]" . 'article_amount',array('size'=>9,'maxlength'=>9));
				echo "</td>\n";
				echo "<td>\n";
					//echo $form->textField($models[$key],"[$key]" . 'shopping_term');
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model' => $shopping[$key],
							'attribute' => "[$key]" . 'shopping_term',
							'language' => 'pl',
							'options' => array(
									'showOn' => 'button',
									'dateFormat' => 'yy-mm-dd',
									'showButtonPanel' => true,
							),
							'htmlOptions' => array(
									'size' => '10',         // textField size
									'maxlength' => '10',    // textField maxlength
							),
					));
				echo "</td>\n";
				echo "<td>$Order->textile1_warehouse</td>";
				echo "<td>$Order->textiles_ordered</td>";
				echo "<td>$Order->order1_id</td>";
			echo "</tr>";
			
			#ukryte pola
			echo "\n" . $form->hiddenField($shopping[$key],"[$key]" . 'shopping_number');
			echo "\n" . $form->hiddenField($shopping[$key],"[$key]" . 'textile_textile_id');
			echo "\n" . $form->hiddenField($shopping[$key],"[$key]" . 'article_calculated_amount');
			echo "\n" . $form->hiddenField($shopping[$key],"[$key]" . 'order2_id');
		}
	?>
</table>

<div class="row buttons">
	<?php  echo CHtml::submitButton('Twórz zamówienie'); ?>
</div>

<?php $this->endWidget(); ?>