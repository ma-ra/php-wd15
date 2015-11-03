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
		<?php echo $form->labelEx($model,'shopping_notes'); ?>
		<?php echo $form->textField($model,'shopping_notes',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shopping_notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->