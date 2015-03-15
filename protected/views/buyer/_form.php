<?php
/* @var $this BuyerController */
/* @var $model Buyer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buyer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_name_1'); ?>
		<?php echo $form->textField($model,'buyer_name_1',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'buyer_name_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_name_2'); ?>
		<?php echo $form->textField($model,'buyer_name_2',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'buyer_name_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_street'); ?>
		<?php echo $form->textField($model,'buyer_street',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'buyer_street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_zip_code'); ?>
		<?php echo $form->textField($model,'buyer_zip_code',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'buyer_zip_code'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->