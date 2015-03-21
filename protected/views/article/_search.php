<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'article_id'); ?>
		<?php echo $form->textField($model,'article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_number'); ?>
		<?php echo $form->textField($model,'article_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model_name'); ?>
		<?php echo $form->textField($model,'model_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model_type'); ?>
		<?php echo $form->textField($model,'model_type',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_colli'); ?>
		<?php echo $form->textField($model,'article_colli'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_all_textile_amount'); ?>
		<?php echo $form->textField($model,'article_all_textile_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_first_textile_amount'); ?>
		<?php echo $form->textField($model,'article_first_textile_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_second_textile_amount'); ?>
		<?php echo $form->textField($model,'article_second_textile_amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->