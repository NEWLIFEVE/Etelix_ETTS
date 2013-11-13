<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tickets_id'); ?>
		<?php echo $form->textField($model,'tickets_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fallas_id'); ?>
		<?php echo $form->textField($model,'fallas_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prioridad_id'); ?>
		<?php echo $form->textField($model,'prioridad_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'statu_id'); ?>
		<?php echo $form->textField($model,'statu_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuarios_id'); ?>
		<?php echo $form->textField($model,'usuarios_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'origen_ip'); ?>
		<?php echo $form->textField($model,'origen_ip',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destino_ip'); ?>
		<?php echo $form->textField($model,'destino_ip',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prefijo'); ?>
		<?php echo $form->textField($model,'prefijo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_ticket'); ?>
		<?php echo $form->textField($model,'fecha_ticket'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip_maquina'); ?>
		<?php echo $form->textField($model,'ip_maquina',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->