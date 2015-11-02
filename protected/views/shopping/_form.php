<?php
/* @var $this ShoppingController */
/* @var $model Shopping */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shopping-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_number'); ?>
		<?php echo $form->textField($model,'shopping_number'); ?>
		<?php echo $form->error($model,'shopping_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_type'); ?>
		<?php echo $form->textField($model,'shopping_type',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fabric_collection_fabric_id'); ?>
		<?php echo $form->textField($model,'fabric_collection_fabric_id'); ?>
		<?php echo $form->error($model,'fabric_collection_fabric_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_amount'); ?>
		<?php echo $form->textField($model,'article_amount',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_calculated_amount'); ?>
		<?php echo $form->textField($model,'article_calculated_amount',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_calculated_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_term'); ?>
		<?php echo $form->textField($model,'shopping_term',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_term'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_date_of_shipment'); ?>
		<?php echo $form->textField($model,'shopping_date_of_shipment',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_date_of_shipment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_delivery_date'); ?>
		<?php echo $form->textField($model,'shopping_delivery_date'); ?>
		<?php echo $form->error($model,'shopping_delivery_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_scheduled_delivery'); ?>
		<?php echo $form->textField($model,'shopping_scheduled_delivery',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_scheduled_delivery'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_delivered_amount'); ?>
		<?php echo $form->textField($model,'article_delivered_amount',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_delivered_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_price'); ?>
		<?php echo $form->textField($model,'article_price',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_name'); ?>
		<?php echo $form->textField($model,'document_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'document_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_name'); ?>
		<?php echo $form->textField($model,'invoice_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'invoice_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_notes'); ?>
		<?php echo $form->textField($model,'shopping_notes',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_notes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_status'); ?>
		<?php echo $form->textField($model,'shopping_status',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid'); ?>
		<?php echo $form->textField($model,'paid'); ?>
		<?php echo $form->error($model,'paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_printed'); ?>
		<?php echo $form->textField($model,'shopping_printed'); ?>
		<?php echo $form->error($model,'shopping_printed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creation_time'); ?>
		<?php echo $form->textField($model,'creation_time'); ?>
		<?php echo $form->error($model,'creation_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->