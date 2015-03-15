<?php
/* @var $this BrokerController */
/* @var $model Broker */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'broker_id'); ?>
		<?php echo $form->textField($model,'broker_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'broker_name'); ?>
		<?php echo $form->textField($model,'broker_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->