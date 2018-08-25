<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'article_id'); ?>
		<?php echo $form->textField($model,'article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_number'); ?>
		<?php echo $form->textField($model,'article_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model_name'); ?>
		<?php echo $form->textField($model,'model_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model_type'); ?>
		<?php echo $form->textField($model,'model_type',array('size'=>60,'maxlength'=>100)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'model_description'); ?>
		<?php echo $form->textField($model,'model_description',array('size'=>60,'maxlength'=>450)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_colli'); ?>
		<?php echo $form->textField($model,'article_colli'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_all_textile_amount'); ?>
		<?php echo $form->textField($model,'article_all_textile_amount', array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_first_textile_amount'); ?>
		<?php echo $form->textField($model,'article_first_textile_amount', array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_second_textile_amount'); ?>
		<?php echo $form->textField($model,'article_second_textile_amount', array('size'=>9,'maxlength'=>9)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'price_in_pg1'); ?>
		<?php echo $form->textField($model,'price_in_pg1',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_in_pg2'); ?>
		<?php echo $form->textField($model,'price_in_pg2',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_in_pg3'); ?>
		<?php echo $form->textField($model,'price_in_pg3',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_in_pg4'); ?>
		<?php echo $form->textField($model,'price_in_pg4',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_in_pg5'); ?>
		<?php echo $form->textField($model,'price_in_pg5',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_in_pg6'); ?>
		<?php echo $form->textField($model,'price_in_pg6',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_in_pg7'); ?>
		<?php echo $form->textField($model,'price_in_pg7',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->