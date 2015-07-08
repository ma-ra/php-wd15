<?php
/* @var $this TextileController */
/* @var $model Textile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'textile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'textile_number'); ?>
		<?php echo $form->textField($model,'textile_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'textile_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textile_name'); ?>
		<?php echo $form->textField($model,'textile_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'textile_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textile_price_group'); ?>
		<?php echo $form->textField($model,'textile_price_group'); ?>
		<?php echo $form->error($model,'textile_price_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_supplier_id'); ?>
		<?php echo $form->error($model,'supplier_supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pattern'); ?>
		<?php echo $form->textField($model,'pattern'); ?>
		<?php echo $form->error($model,'pattern'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->