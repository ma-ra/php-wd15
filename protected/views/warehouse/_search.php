<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'warehouse_id'); ?>
		<?php echo $form->textField($model,'warehouse_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'warehouse_type'); ?>
		<?php echo $form->textField($model,'warehouse_type',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_name'); ?>
		<?php echo $form->textField($model,'article_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_count'); ?>
		<?php echo $form->textField($model,'article_count',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_price'); ?>
		<?php echo $form->textField($model,'article_price',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_name'); ?>
		<?php echo $form->textField($model,'document_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'warehouse_error'); ?>
		<?php echo $form->textField($model,'warehouse_error',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shopping_shopping_id'); ?>
		<?php echo $form->textField($model,'shopping_shopping_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creation_date'); ?>
		<?php echo $form->textField($model,'creation_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->