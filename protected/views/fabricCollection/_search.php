<?php
/* @var $this FabricCollectionController */
/* @var $model FabricCollection */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'fabric_id'); ?>
		<?php echo $form->textField($model,'fabric_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fabric_number'); ?>
		<?php echo $form->textField($model,'fabric_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fabric_name'); ?>
		<?php echo $form->textField($model,'fabric_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fabric_price_group'); ?>
		<?php echo $form->textField($model,'fabric_price_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fabric_price'); ?>
		<?php echo $form->textField($model,'fabric_price',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->