<?php
/* @var $this ShoppingController */
/* @var $model Shopping */
/* @var $form CActiveForm */
?>

<style>
	table {
   		border-collapse: collapse;
	}
	
	table, th, td {
	    border: 1px solid black;
    	vertical-align: text-top;
	}
</style>

<div class="form">

<?php  $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shopping-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($models); ?>
	
	<table>
		<tr>
			<td>
					<?php echo $form->labelEx($models[key($models)],'shopping_number'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'textile_textile_id'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'article_amount'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'article_calculated_amount'); ?>
			</td>
			<td>							
					<?php echo $form->labelEx($models[key($models)],'shopping_term'); ?>
			</td>		
		</tr>
		
		<?php
		#http://www.yiiframework.com/wiki/362/how-to-use-multiple-instances-of-the-same-model-in-the-same-form/
		foreach ($models as $key => $model) {
			echo "<tr>\n";
				echo "<td>\n";				
					echo $form->textField($model,"[$key]" . 'shopping_number');
					echo $form->error($model,"[$key]" . 'shopping_number');
				echo "</td>\n";
				echo "<td>\n";		
					echo $form->textField($model,"[$key]" . 'textile_textile_id');
					echo $form->error($model,"[$key]" . 'textile_textile_id');
				echo "</td>\n";
				echo "<td>\n";		
					echo $form->textField($model,"[$key]" . 'article_amount',array('size'=>9,'maxlength'=>9));
					echo $form->error($model,"[$key]" . 'article_amount');
				echo "</td>\n";
				echo "<td>\n";		
					echo $form->textField($model,"[$key]" . 'article_calculated_amount',array('size'=>9,'maxlength'=>9));
					echo $form->error($model,"[$key]" . 'article_calculated_amount');
				echo "</td>\n";
				echo "<td>\n";		
					echo $form->textField($model,"[$key]" . 'shopping_term');
					echo $form->error($model,"[$key]" . 'shopping_term');
				echo "</td>\n";
			echo "</tr>\n";
		echo "\n" . $form->hiddenField($model,"[$key]" . 'order_ids');
		}
		?>
	</table>
	

	<div class="row buttons">
		<?php  echo CHtml::submitButton('Zapisz'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->