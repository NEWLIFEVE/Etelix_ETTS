<?php
/* @var $this TicketsController */
/* @var $data Tickets */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tickets_id')); ?>:</b>
	<?php echo CHtml::encode($data->tickets_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fallas_id')); ?>:</b>
	<?php echo CHtml::encode($data->fallas_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prioridad_id')); ?>:</b>
	<?php echo CHtml::encode($data->prioridad_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statu_id')); ?>:</b>
	<?php echo CHtml::encode($data->statu_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_id')); ?>:</b>
	<?php echo CHtml::encode($data->mail_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('origen_ip')); ?>:</b>
	<?php echo CHtml::encode($data->origen_ip); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('destino_ip')); ?>:</b>
	<?php echo CHtml::encode($data->destino_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prefijo')); ?>:</b>
	<?php echo CHtml::encode($data->prefijo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_ticket')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_ticket); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_maquina')); ?>:</b>
	<?php echo CHtml::encode($data->ip_maquina); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	*/ ?>

</div>