<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_number'); ?>
		<?php echo $form->textField($model,'order_number',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_date'); ?>
		<?php echo $form->textField($model,'order_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_order_number'); ?>
		<?php echo $form->textField($model,'buyer_order_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_comments'); ?>
		<?php echo $form->textField($model,'buyer_comments',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_reference'); ?>
		<?php echo $form->textField($model,'order_reference',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_term'); ?>
		<?php echo $form->textField($model,'order_term',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_amount'); ?>
		<?php echo $form->textField($model,'article_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_buyer_id'); ?>
		<?php echo $form->textField($model,'buyer_buyer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'broker_broker_id'); ?>
		<?php echo $form->textField($model,'broker_broker_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_manufacturer_id'); ?>
		<?php echo $form->textField($model,'manufacturer_manufacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leg_leg_id'); ?>
		<?php echo $form->textField($model,'leg_leg_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_article_id'); ?>
		<?php echo $form->textField($model,'article_article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textile_order'); ?>
		<?php echo $form->textField($model,'textile_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'printed_minilabel'); ?>
		<?php echo $form->textField($model,'printed_minilabel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'printed_shipping_label'); ?>
		<?php echo $form->textField($model,'printed_shipping_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_manufactured'); ?>
		<?php echo $form->textField($model,'article_manufactured'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_exported'); ?>
		<?php echo $form->textField($model,'article_exported'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->