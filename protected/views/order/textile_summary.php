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
	'action'=>array('Shopping/createMany'),
	//'htmlOptions'=>array('target'=>'_blank')
)); ?>

<table>
	<tr>
		<td>Dostawca:</td>
		<td>Nr. Mat.:</td>
		<td>Nazwa Mat.:</td>
		<td>Wyliczona ilość:</td>
		<td>Zamawiana ilość</td>
		<td>Notki</td>
		<td>Materiał - zamówione</td>
	</tr>
	<?php 
		foreach ($rapTextile as $key => $Order) {
			#wyświetlenie podsumowania materiałów, które zarazem jest formularzem zamówienia
			echo "\n<tr>\n";
				echo "<td>$Order->supplier_name</td>\n";
				echo "<td>$Order->textile_number</td>\n";
				echo "<td>$Order->fabric_name</td>\n";
				
				#trik matematyczny pozwalający wyliczyć ile modeli nie ma zadeklarowanych metrów
				#trik polega na założeniu, że jak model nie ma podanych metrów, to jego zużycie wynisi 1mln
				
				$omitted=round(floor($Order->textiles_selected/1000000),2);
				$result=round($Order->textiles_selected-($omitted*1000000),2);
				if ($Order->textiles_selected < 1000000) {
					echo "<td>$Order->textiles_selected</td>\n";
				} else {
					echo "<td>$result<br>\n(Pominięto $omitted modeli.)</td>\n";
					$shoppings[$key]->article_calculated_amount=$result;
				}
				#pozycje które trzeba uzupełnić (formularz)
				echo "<td>";
					# np. <input size="9" maxlength="9" name="Shopping[0][article_amount]" id="Shopping_0_article_amount" type="text" />
					echo $form->textField($shoppings[$key],"[$key]" . 'article_amount',array('size'=>9,'maxlength'=>9));
				echo "</td>\n";
				echo "<td>";
					echo $form->textField($shoppings[$key],"[$key]" . 'shopping_notes',array('size'=>9,'maxlength'=>50));
				echo "</td>\n";
				echo "<td>$Order->textiles_ordered</td>\n";
			echo "</tr>";
			
			#ukryte pola służące do przeniesienia informacji z OrderControler do ShoppingContlorer
			echo "\n" . $form->hiddenField($shoppings[$key],"[$key]" . 'fabric_collection_fabric_id');
			echo "\n" . $form->hiddenField($shoppings[$key],"[$key]" . 'article_calculated_amount');
			echo "\n" . $form->hiddenField($shoppings[$key],"[$key]" . 'order1_ids');
			echo "\n" . $form->hiddenField($shoppings[$key],"[$key]" . 'order2_ids') . "\n";
		}
	?>
</table>

<div class="row buttons">
	<?php  echo CHtml::submitButton('Twórz zamówienie'); ?>
</div>

<?php $this->endWidget(); ?>