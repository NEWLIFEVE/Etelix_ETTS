<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>

<fieldset>
        <legend>Use this form to submit a ticket.</legend>
<?php echo $form->errorSummary($model); ?>

<div class="input-control select block">
        <strong>Response to </strong><small class="text-muted "><em>(select the participents mails)</em></small>  <a href="javascript:void(0)" class="a-agregar_correo"><i class="icon-plus-2"></i></a>
        <div class="div-agregar_correo">
            <input type="text" placeholder="example@example.com" /> <button class="primary btn-g_correo" type="button">OK</button>
        </div>
        <?php echo $form->ListBox(
                $model,'mail[]', 
                CHtml::listData(Mail::getMails(Yii::app()->getSession()->get('usuario_id')), 'id', 'mail'),  
                array('multiple' => 'multiple', 'onchange'=> 'marcar(this)')) ?>
        <?php echo $form->error($model,'mail[]'); ?>
</div>

<div class="input-control select block">
        <?php echo $form->dropDownList($model,'fallas_id', CHtml::listData(Fallas::model()->findAll(), 'id', 'falla'),  array('empty' => 'Failure (required)')); ?>
        <?php echo $form->error($model,'fallas_id'); ?>
</div>

<div class="input-control text block" data-role="input-control">
    <label>
        <?php echo $form->textField($model,'origen_ip',array('placeholder' => 'Origination IP (Customer IP)(requiered)')); ?>
        <?php echo $form->error($model,'origen_ip'); ?>
    </label>
</div>

<div class="input-control text block" data-role="input-control">
    <label>
        <?php echo $form->textField($model,'destino_ip',array('placeholder' => 'DestinationIP IP (Etelix IP)(requiered)')); ?>
        <?php echo $form->error($model,'destino_ip'); ?>
    </label>
</div>

<div class="input-control text block" data-role="input-control">
    <label>
        <?php echo $form->textField($model,'prefijo',array('placeholder' => 'Prefix (required)')); ?>
        <?php echo $form->error($model,'prefijo'); ?>
    </label>
</div>

        

<div class="grid">
    <div classclass="row">
        <div class="input-control text span3">
            <small class="text-muted "><em>without prefix</em></small>
            <?php echo $form->textField($model,'tested_numbers[]',array('placeholder' => 'Tested numbers (required)')); ?>
            <?php echo $form->error($model,'tested_numbers[]'); ?>
        </div>

        <div class="input-control select span2 country " style="margin-left: 5px;">
            <br>
            <?php echo $form->dropDownList($model,'destination[]', CHtml::listData(Destinos::model()->findAll(), 'id', 'destino'),  array('empty'=>'Country')); ?>
            <?php echo $form->error($model,'destination[]'); ?>
        </div>

        <div class="input-control text span2" style="margin-left: 5px;">
            <br>
            <?php echo $form->textField($model,'fecha[]',array('placeholder' => 'Date', 'class' => 'fecha')); ?>
            <?php echo $form->error($model,'fecha[]'); ?>
        </div>

        <div class="input-control text span1" style="margin-left: 15px; padding-top: 5px">
            <br>
            <a href="javascript:void(0)" class="_agregar"><i class="icon-plus-2"></i></a>
        </div>
    </div>
</div>
        
<div style="clear: left;"></div>

<div class="grid">
    <div classclass="row">
        <div class="container_agregar"></div>
    </div>
</div>

<div class="input-control textarea" data-role="input-control">
    <label>
        <?php echo $form->textArea($model,'descripcion',array('placeholder' => 'Description (required)')); ?>
        <?php echo $form->error($model,'descripcion'); ?>
    </label>
</div>

<div></div>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Preview Ticket' : 'Save', array('class' => 'primary large')); ?>

</fieldset>

