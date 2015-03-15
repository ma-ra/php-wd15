<?php
/* @var $this ManufacturerController */
/* @var $model Manufacturer */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_id'); ?>
		<?php echo $form->textField($model,'manufacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_number'); ?>
		<?php echo $form->textField($model,'manufacturer_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_name'); ?>
		<?php echo $form->textField($model,'manufacturer_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->