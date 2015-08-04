<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */
/* @var $form CActiveForm */

/* echo "<pre>";
var_dump($models);
echo "</pre>";
die(); */
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

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'warehouse-form',
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
					<?php echo $form->labelEx($models[key($models)],'article_number'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'article_name'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'article_count'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'article_price'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'document_name'); ?>
			</td>
			<td>
					<?php echo $form->labelEx($models[key($models)],'warehouse_delivery_date'); ?>
			</td>
			<td>							
					<?php echo $form->labelEx($models[key($models)],'shopping_shopping_id'); ?>
			</td>				
		</tr>
		
		<?php
		#http://www.yiiframework.com/wiki/362/how-to-use-multiple-instances-of-the-same-model-in-the-same-form/
		foreach ($models as $key => $model) {
			echo "<tr>\n";
				echo "<td>\n";
					echo $form->textField($model,"[$key]" . 'article_number',array('size'=>10,'maxlength'=>50));
					echo $form->error($model,"[$key]" . 'article_number');
				echo "</td>\n";
				echo "<td>\n";
					echo $form->textField($model,"[$key]" . 'article_name',array('size'=>25,'maxlength'=>50));
					echo $form->error($model,"[$key]" . 'article_name');
				echo "</td>\n";
				echo "<td>\n";
					echo $form->textField($model,"[$key]" . 'article_count',array('size'=>9,'maxlength'=>9));
					echo $form->error($model,"[$key]" . 'article_count');
				echo "</td>\n";
				echo "<td>\n";
					echo $form->textField($model,"[$key]" . 'article_price',array('size'=>9,'maxlength'=>9));
					echo $form->error($model,"[$key]" . 'article_price');
				echo "</td>\n";
				echo "<td>\n";
					echo $form->textField($model,"[$key]" . 'document_name',array('size'=>20,'maxlength'=>50));
					echo $form->error($model,"[$key]" . 'document_name');
				echo "</td>\n";
				echo "<td>\n";							
					echo $form->dateField($model,"[$key]" . 'warehouse_delivery_date');
					echo $form->error($model,"[$key]" . 'warehouse_delivery_date');
				echo "</td>\n";
				echo "<td>\n";							
					echo $form->textField($model,"[$key]" . 'shopping_shopping_id');
					echo $form->error($model,"[$key]" . 'shopping_shopping_id');
				echo "</td>\n";
			echo "</tr>\n";
		}
		?>
	</table>
<div class="row buttons">
	<?php echo CHtml::submitButton('Zapisz'); ?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->