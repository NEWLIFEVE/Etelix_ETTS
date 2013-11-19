<?php
/* @var $this StatuController */
/* @var $data Statu */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statu')); ?>:</b>
	<?php echo CHtml::encode($data->statu); ?>
	<br />


</div>