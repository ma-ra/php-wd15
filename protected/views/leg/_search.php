<?php
/* @var $this LegController */
/* @var $model Leg */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'leg_id'); ?>
		<?php echo $form->textField($model,'leg_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leg_type'); ?>
		<?php echo $form->textField($model,'leg_type',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->