<?php
/* @var $this FabricCollectionController */
/* @var $model FabricCollection */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fabric-collection-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fabric_number'); ?>
		<?php echo $form->textField($model,'fabric_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'fabric_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fabric_name'); ?>
		<?php echo $form->textField($model,'fabric_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'fabric_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fabric_price_group'); ?>
		<?php echo $form->textField($model,'fabric_price_group'); ?>
		<?php echo $form->error($model,'fabric_price_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_supplier_id'); ?>
		<?php echo $form->error($model,'supplier_supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fabric_price'); ?>
		<?php echo $form->textField($model,'fabric_price',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'fabric_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->