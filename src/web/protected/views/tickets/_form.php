<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tickets-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	
        <fieldset>
                <legend>Utilice este formulario para enviar un ticket.</legend>
	<?php echo $form->errorSummary($model); ?>
                
        <div class="input-control select">
                <?php // echo $form->labelEx($model,'fallas_id'); ?>
                <?php echo $form->dropDownList($model,'mail', CHtml::listData(Mail::getMails(Yii::app()->getSession()->get('usuario_id')), 'id', 'mail'),  array('empty' => 'Response to')); ?>
                <?php echo $form->error($model,'fallas_id'); ?>
	</div>

        <div class="input-control text span3">
            <input type="text" name="tested_number[]" placeholder="Tested numbers" >
        </div>
                
        <div class="input-control select span2" style="margin-left: 5px;">
            <?php echo $form->dropDownList($model,'mail', CHtml::listData(Destinos::model()->findAll(), 'id', 'destino'),  array('empty' => 'Destination')); ?>
            <?php echo $form->error($model,'fallas_id'); ?>
        </div>
        <div class="input-control text span2" style="margin-left: 5px;">
            <input type="text" name="fecha[]" placeholder="Fecha" >
        </div>
        <div class="input-control text span1" style="margin-left: 15px; padding-top: 5px"><a type="button"><i class="icon-plus-2"></i></a></div>
                
      
        <div class="input-control select">
                <?php // echo $form->labelEx($model,'fallas_id'); ?>
                <?php echo $form->dropDownList($model,'fallas_id', CHtml::listData(Fallas::model()->findAll(), 'id', 'falla'),  array('empty' => 'Seleccione la falla')); ?>
                <?php echo $form->error($model,'fallas_id'); ?>
	</div>

	<div class="input-control select">
		<?php // echo $form->labelEx($model,'prioridad_id'); ?>
		<?php echo $form->dropDownList($model,'prioridad_id', CHtml::listData(Prioridad::model()->findAll(), 'id', 'prioridad'),  array('empty' => 'Seleccione la prioridad')); ?>
		<?php echo $form->error($model,'prioridad_id'); ?>
	</div>


	<div class="input-control text" data-role="input-control">
            <label>
		<?php // echo $form->labelEx($model,'origen_ip'); ?>
		<?php echo $form->textField($model,'origen_ip',array('placeholder' => 'Origination ip')); ?>
		<?php echo $form->error($model,'origen_ip'); ?>
            </label>
	</div>

	<div class="input-control text" data-role="input-control">
            <label>
		<?php // echo $form->labelEx($model,'destino_ip'); ?>
		<?php echo $form->textField($model,'destino_ip',array('placeholder' => 'Destination ip')); ?>
		<?php echo $form->error($model,'destino_ip'); ?>
            </label>
	</div>

	<div class="input-control text" data-role="input-control">
            <label>
		<?php // echo $form->labelEx($model,'prefijo'); ?>
		<?php echo $form->textField($model,'prefijo',array('placeholder' => 'Prefix')); ?>
		<?php echo $form->error($model,'prefijo'); ?>
            </label>
	</div>

        <div class="input-control textarea" data-role="input-control">
            <label>
		<?php // echo $form->labelEx($model,'prefijo'); ?>
		<?php echo $form->textArea($model,'descripcion',array('placeholder' => 'Descripción')); ?>
		<?php echo $form->error($model,'descripcion'); ?>
            </label>
	</div>

        <div></div>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Send Ticket' : 'Save', array('class' => 'primary large')); ?>
	
        </fieldset>
<?php $this->endWidget(); ?>



<!--<div class="grid">
<div class="row">
    <div class="span2">
        <div class="input-control text span2">
            <input type="text" name="tested_number[]" placeholder="Tested numbers" >
        </div>
    </div>
    <div class="span2">
        <div class="input-control text span2">
            <input type="text" name="tested_number[]" placeholder="Tested numbers" >
        </div>
    </div>
    <div class="span2">
        <div class="input-control text span2">
            <input type="text" name="tested_number[]" placeholder="Tested numbers" >
        </div>
    </div>
</div>
</div>-->