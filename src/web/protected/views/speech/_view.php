<?php
/* @var $this SpeechController */
/* @var $data Speech */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('speech')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->speech), array('view', 'id'=>$data->speech)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />


</div>