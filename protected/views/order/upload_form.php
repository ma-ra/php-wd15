<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
$user="";
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transfer-protocol-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
		<?php echo $form->fileField($model,'file'); ?>
		<?php echo $form->error($model,'file'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Wczytaj'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->