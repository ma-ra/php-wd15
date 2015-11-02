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
		<?php echo $form->label($model,'fabric_collection_fabric_id'); ?>
		<?php echo $form->textField($model,'fabric_collection_fabric_id'); ?>
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
		<?php echo $form->textField($model,'shopping_term',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_date_of_shipment'); ?>
		<?php echo $form->textField($model,'shopping_date_of_shipment',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_delivery_date'); ?>
		<?php echo $form->textField($model,'shopping_delivery_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_scheduled_delivery'); ?>
		<?php echo $form->textField($model,'shopping_scheduled_delivery',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_delivered_amount'); ?>
		<?php echo $form->textField($model,'article_delivered_amount',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_price'); ?>
		<?php echo $form->textField($model,'article_price',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_name'); ?>
		<?php echo $form->textField($model,'document_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_name'); ?>
		<?php echo $form->textField($model,'invoice_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_notes'); ?>
		<?php echo $form->textField($model,'shopping_notes',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_status'); ?>
		<?php echo $form->textField($model,'shopping_status',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paid'); ?>
		<?php echo $form->textField($model,'paid'); ?>
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