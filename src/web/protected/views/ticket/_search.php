<?php
/* @var $this TicketController */
/* @var $model Ticket */
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
		<?php echo $form->label($model,'id_ticket'); ?>
		<?php echo $form->textField($model,'id_ticket'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_failure'); ?>
		<?php echo $form->textField($model,'id_failure'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_status'); ?>
		<?php echo $form->textField($model,'id_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'origination_ip'); ?>
		<?php echo $form->textField($model,'origination_ip',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destination_ip'); ?>
		<?php echo $form->textField($model,'destination_ip',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'machine_ip'); ?>
		<?php echo $form->textField($model,'machine_ip',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hour'); ?>
		<?php echo $form->textField($model,'hour'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prefix'); ?>
		<?php echo $form->textField($model,'prefix',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_gmt'); ?>
		<?php echo $form->textField($model,'id_gmt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ticket_number'); ?>
		<?php echo $form->textField($model,'ticket_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->