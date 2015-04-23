<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'article_number'); ?>
		<?php echo $form->textField($model,'article_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'article_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model_name'); ?>
		<?php echo $form->textField($model,'model_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'model_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model_type'); ?>
		<?php echo $form->textField($model,'model_type',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'model_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_colli'); ?>
		<?php echo $form->textField($model,'article_colli'); ?>
		<?php echo $form->error($model,'article_colli'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_all_textile_amount'); ?>
		<?php echo $form->textField($model,'article_all_textile_amount', array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_all_textile_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_first_textile_amount'); ?>
		<?php echo $form->textField($model,'article_first_textile_amount', array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_first_textile_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_second_textile_amount'); ?>
		<?php echo $form->textField($model,'article_second_textile_amount', array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'article_second_textile_amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->