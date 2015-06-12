<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Pola zawierające znak <span class="required">*</span> są wymagane.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order_number'); ?>
		<?php echo $form->textField($model,'order_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'order_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_date'); ?>
		<?php echo $form->textField($model,'order_date'); ?>
		<?php echo $form->error($model,'order_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_order_number'); ?>
		<?php echo $form->textField($model,'buyer_order_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'buyer_order_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_comments'); ?>
		<?php echo $form->textField($model,'buyer_comments',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'buyer_comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_reference'); ?>
		<?php echo $form->textField($model,'order_reference',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'order_reference'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_term'); ?>
		<?php echo $form->textField($model,'order_term',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'order_term'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_amount'); ?>
		<?php echo $form->textField($model,'article_amount'); ?>
		<?php echo $form->error($model,'article_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_buyer_id'); ?>
		<?php echo $form->textField($model,'buyer_buyer_id'); ?>
		<?php echo $form->error($model,'buyer_buyer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'broker_broker_id'); ?>
		<?php echo $form->textField($model,'broker_broker_id'); ?>
		<?php echo $form->error($model,'broker_broker_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_manufacturer_id'); ?>
		<?php echo $form->textField($model,'manufacturer_manufacturer_id'); ?>
		<?php echo $form->error($model,'manufacturer_manufacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leg_leg_id'); ?>
		<?php echo $form->textField($model,'leg_leg_id'); ?>
		<?php echo $form->error($model,'leg_leg_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_article_id'); ?>
		<?php echo $form->textField($model,'article_article_id'); ?>
		<?php echo $form->error($model,'article_article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textil_pair'); ?>
		<?php echo $form->textField($model,'textil_pair'); ?>
		<?php echo $form->error($model,'textil_pair'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textilpair_price_group'); ?>
		<?php echo $form->textField($model,'textilpair_price_group'); ?>
		<?php echo $form->error($model,'textilpair_price_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textile1_textile_id'); ?>
		<?php echo $form->textField($model,'textile1_textile_id'); ?>
		<?php echo $form->error($model,'textile1_textile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textile2_textile_id'); ?>
		<?php echo $form->textField($model,'textile2_textile_id'); ?>
		<?php echo $form->error($model,'textile2_textile_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'shopping1_shopping_id'); ?>
		<?php echo $form->textField($model,'shopping1_shopping_id'); ?>
		<?php echo $form->error($model,'shopping1_shopping_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'shopping2_shopping_id'); ?>
		<?php echo $form->textField($model,'shopping2_shopping_id'); ?>
		<?php echo $form->error($model,'shopping2_shopping_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'printed_minilabel'); ?>
		<?php echo $form->textField($model,'printed_minilabel'); ?>
		<?php echo $form->error($model,'printed_minilabel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'printed_shipping_label'); ?>
		<?php echo $form->textField($model,'printed_shipping_label'); ?>
		<?php echo $form->error($model,'printed_shipping_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textile_prepared'); ?>
		<?php echo $form->textField($model,'textile_prepared'); ?>
		<?php echo $form->error($model,'textile_prepared'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_planed'); ?>
		<?php echo $form->textField($model,'article_planed'); ?>
		<?php echo $form->error($model,'article_planed'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'article_manufactured'); ?>
		<?php echo $form->textField($model,'article_manufactured'); ?>
		<?php echo $form->error($model,'article_manufactured'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'article_prepared_to_export'); ?>
		<?php echo $form->textField($model,'article_prepared_to_export'); ?>
		<?php echo $form->error($model,'article_prepared_to_export'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_exported'); ?>
		<?php echo $form->textField($model,'article_exported',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'article_exported'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_canceled'); ?>
		<?php echo $form->textField($model,'article_canceled'); ?>
		<?php echo $form->error($model,'article_canceled'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_error'); ?>
		<?php echo $form->textField($model,'order_error', array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'order_error'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_add_date'); ?>
		<?php echo $form->textField($model,'order_add_date'); ?>
		<?php echo $form->error($model,'order_add_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checked'); ?>
		<?php echo $form->textField($model,'checked'); ?>
		<?php echo $form->error($model,'checked'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Dodaj' : 'Zapisz'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->