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
		<?php echo $form->textField($model,'order_number',array('size'=>50,'maxlength'=>50)); ?>
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
		<?php echo $form->label($model,'textil_pair'); ?>
		<?php echo $form->textField($model,'textil_pair'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textilpair_price_group'); ?>
		<?php echo $form->textField($model,'textilpair_price_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textile1_textile_id'); ?>
		<?php echo $form->textField($model,'textile1_textile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textile2_textile_id'); ?>
		<?php echo $form->textField($model,'textile2_textile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_price'); ?>
		<?php echo $form->textField($model,'order_price',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_total_price'); ?>
		<?php echo $form->textField($model,'order_total_price',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping1_shopping_id'); ?>
		<?php echo $form->textField($model,'shopping1_shopping_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping2_shopping_id'); ?>
		<?php echo $form->textField($model,'shopping2_shopping_id'); ?>
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
		<?php echo $form->label($model,'textile_prepared'); ?>
		<?php echo $form->textField($model,'textile_prepared'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_planed'); ?>
		<?php echo $form->textField($model,'article_planed',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_manufactured'); ?>
		<?php echo $form->textField($model,'article_manufactured'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_prepared_to_export'); ?>
		<?php echo $form->textField($model,'article_prepared_to_export'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_exported'); ?>
		<?php echo $form->textField($model,'article_exported',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_canceled'); ?>
		<?php echo $form->textField($model,'article_canceled'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_error'); ?>
		<?php echo $form->textField($model,'order_error',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_notes'); ?>
		<?php echo $form->textField($model,'order_notes',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_add_date'); ?>
		<?php echo $form->textField($model,'order_add_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_storno_date'); ?>
		<?php echo $form->textField($model,'order_storno_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'checked'); ?>
		<?php echo $form->textField($model,'checked'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->