<?php
/* @var $this TicketController */
/* @var $data Ticket */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_ticket')); ?>:</b>
	<?php echo CHtml::encode($data->id_ticket); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_failure')); ?>:</b>
	<?php echo CHtml::encode($data->id_failure); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_status')); ?>:</b>
	<?php echo CHtml::encode($data->id_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('origination_ip')); ?>:</b>
	<?php echo CHtml::encode($data->origination_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination_ip')); ?>:</b>
	<?php echo CHtml::encode($data->destination_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('machine_ip')); ?>:</b>
	<?php echo CHtml::encode($data->machine_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hour')); ?>:</b>
	<?php echo CHtml::encode($data->hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prefix')); ?>:</b>
	<?php echo CHtml::encode($data->prefix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_gmt')); ?>:</b>
	<?php echo CHtml::encode($data->id_gmt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_number')); ?>:</b>
	<?php echo CHtml::encode($data->ticket_number); ?>
	<br />

	*/ ?>

</div>