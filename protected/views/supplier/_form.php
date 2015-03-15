<?php
/* @var $this SupplierController */
/* @var $model Supplier */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'supplier-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_name'); ?>
		<?php echo $form->textField($model,'supplier_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'supplier_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_tel'); ?>
		<?php echo $form->textField($model,'supplier_tel',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'supplier_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_email'); ?>
		<?php echo $form->textField($model,'supplier_email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'supplier_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textile_textile_id'); ?>
		<?php echo $form->textField($model,'textile_textile_id'); ?>
		<?php echo $form->error($model,'textile_textile_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->