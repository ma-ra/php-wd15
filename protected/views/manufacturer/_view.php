<?php
/* @var $this ManufacturerController */
/* @var $data Manufacturer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->manufacturer_id), array('view', 'id'=>$data->manufacturer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_number')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_name')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_name); ?>
	<br />


</div>