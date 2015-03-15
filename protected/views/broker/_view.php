<?php
/* @var $this BrokerController */
/* @var $data Broker */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('broker_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->broker_id), array('view', 'id'=>$data->broker_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broker_name')); ?>:</b>
	<?php echo CHtml::encode($data->broker_name); ?>
	<br />


</div>