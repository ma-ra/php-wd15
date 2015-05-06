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
		<?php echo $form->labelEx($model,'shopping_type'); ?>
		<?php echo $form->textField($model,'shopping_type',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textile_textile_id'); ?>
		<?php echo $form->textField($model,'textile_textile_id'); ?>
		<?php echo $form->error($model,'textile_textile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_amount'); ?>
		<?php echo $form->textField($model,'article_amount',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_calculated_amount'); ?>
		<?php echo $form->textField($model,'article_calculated_amount',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'article_calculated_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_term'); ?>
		<?php echo $form->textField($model,'shopping_term'); ?>
		<?php echo $form->error($model,'shopping_term'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shopping_status'); ?>
		<?php echo $form->textField($model,'shopping_status',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_status'); ?>
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