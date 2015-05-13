<?php
/* @var $this ShoppingController */
/* @var $model Shopping */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'shopping_id'); ?>
		<?php echo $form->textField($model,'shopping_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_number'); ?>
		<?php echo $form->textField($model,'shopping_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_type'); ?>
		<?php echo $form->textField($model,'shopping_type',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textile_textile_id'); ?>
		<?php echo $form->textField($model,'textile_textile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_amount'); ?>
		<?php echo $form->textField($model,'article_amount',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_calculated_amount'); ?>
		<?php echo $form->textField($model,'article_calculated_amount',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_term'); ?>
		<?php echo $form->textField($model,'shopping_term'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_status'); ?>
		<?php echo $form->textField($model,'shopping_status',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_printed'); ?>
		<?php echo $form->textField($model,'shopping_printed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creation_time'); ?>
		<?php echo $form->textField($model,'creation_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->