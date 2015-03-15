<?php
/* @var $this LegController */
/* @var $data Leg */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('leg_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->leg_id), array('view', 'id'=>$data->leg_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leg_type')); ?>:</b>
	<?php echo CHtml::encode($data->leg_type); ?>
	<br />


</div>