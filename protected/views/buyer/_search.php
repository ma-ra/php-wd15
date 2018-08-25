<?php
/* @var $this BuyerController */
/* @var $model Buyer */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'buyer_id'); ?>
		<?php echo $form->textField($model,'buyer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_name_1'); ?>
		<?php echo $form->textField($model,'buyer_name_1',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_name_2'); ?>
		<?php echo $form->textField($model,'buyer_name_2',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_street'); ?>
		<?php echo $form->textField($model,'buyer_street',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_zip_code'); ?>
		<?php echo $form->textField($model,'buyer_zip_code',array('size'=>60,'maxlength'=>150)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'buyer_city'); ?>
		<?php echo $form->textField($model,'buyer_city',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_contact'); ?>
		<?php echo $form->textField($model,'buyer_contact',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->