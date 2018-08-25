<?php
/* @var $this DeliveryAddressController */
/* @var $model DeliveryAddress */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'delivery_address_id'); ?>
		<?php echo $form->textField($model,'delivery_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivery_address_name_1'); ?>
		<?php echo $form->textField($model,'delivery_address_name_1',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivery_address_name_2'); ?>
		<?php echo $form->textField($model,'delivery_address_name_2',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivery_address_street'); ?>
		<?php echo $form->textField($model,'delivery_address_street',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivery_addressr_zip_code'); ?>
		<?php echo $form->textField($model,'delivery_addressr_zip_code',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivery_addressr_city'); ?>
		<?php echo $form->textField($model,'delivery_addressr_city',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivery_addressr_contact'); ?>
		<?php echo $form->textField($model,'delivery_addressr_contact',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->