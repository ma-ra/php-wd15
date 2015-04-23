<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'log_id'); ?>
		<?php echo $form->textField($model,'log_id'); ?>
		<?php echo $form->error($model,'log_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creation_time'); ?>
		<?php echo $form->textField($model,'creation_time'); ?>
		<?php echo $form->error($model,'creation_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'route'); ?>
		<?php echo $form->textField($model,'route',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'route'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'actionaction'); ?>
		<?php echo $form->textField($model,'actionaction',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'actionaction'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'params'); ?>
		<?php echo $form->textField($model,'params',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'params'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'info'); ?>
		<?php echo $form->textField($model,'info',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'info'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->