<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */
/* @var $form CActiveForm */
?>

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

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'warehouse_type'); ?>
		<?php echo $form->textField($model,'warehouse_type',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'warehouse_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_number'); ?>
		<?php echo $form->textField($model,'article_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'article_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_name'); ?>
		<?php echo $form->textField($model,'article_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'article_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_count'); ?>
		<?php echo $form->textField($model,'article_count',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_price'); ?>
		<?php echo $form->textField($model,'article_price',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_name'); ?>
		<?php echo $form->textField($model,'document_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'document_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'warehouse_error'); ?>
		<?php echo $form->textField($model,'warehouse_error',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'warehouse_error'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_shopping_id'); ?>
		<?php echo $form->textField($model,'shopping_shopping_id'); ?>
		<?php echo $form->error($model,'shopping_shopping_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'warehouse_delivery_date'); ?>
		<?php echo $form->textField($model,'warehouse_delivery_date'); ?>
		<?php echo $form->error($model,'warehouse_delivery_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creation_date'); ?>
		<?php echo $form->textField($model,'creation_date'); ?>
		<?php echo $form->error($model,'creation_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->