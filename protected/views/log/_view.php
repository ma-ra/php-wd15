<?php
/* @var $this LogController */
/* @var $data Log */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->log_id), array('view', 'id'=>$data->log_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_time')); ?>:</b>
	<?php echo CHtml::encode($data->creation_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('route')); ?>:</b>
	<?php echo CHtml::encode($data->route); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actionaction')); ?>:</b>
	<?php echo CHtml::encode($data->actionaction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('info')); ?>:</b>
	<?php echo CHtml::encode($data->info); ?>
	<br />

	*/ ?>

</div>