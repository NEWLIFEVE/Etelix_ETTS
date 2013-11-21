<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>

<fieldset>
        <legend>Use this form to submit a ticket.</legend>
<?php echo $form->errorSummary($model); ?>

<div class="input-control select block">
        <small class="text-muted "><em>select the participents mails</em></small>  
        <select id="cargar_mails" multiple>
            <?php foreach (Mail::getMails(Yii::app()->getSession()->get('usuario_id')) as $mails): ?>
                <option value="<?php echo $mails['id']; ?>"><?php echo $mails['mail']; ?></option>
            <?php endforeach; ?>
        </select>
</div>

        
<div class="input-control select block">
    <strong>Response to </strong><small class="text-muted "><em>(required)</em></small>&nbsp;&nbsp;
    <a href="javascript:void(0)" class="a-agregar_correo"><i class="icon-plus-2"></i></a>
    &nbsp;
    <a href="javascript:void(0)" class="a-bajar_correo"><i class="icon-arrow-down"></i></a>
    &nbsp;
    <a href="javascript:void(0)" ><i class="icon-cancel-2 fg-red "></i></a>
    <div class="div-agregar_correo">
            <input type="text" placeholder="example@example.com" /> <button class="primary btn-g_correo" type="button">OK</button>
    </div>
    <?php echo $form->ListBox(
                $model,'mail[]', 
                array(),  
                array('multiple' => 'multiple')) ?>
    <?php echo $form->error($model,'mail[]'); ?>
</div>


<div class="input-control select block">
        <strong>Failure</strong><small class="text-muted "><em> (required)</em></small>
        <?php echo $form->dropDownList($model,'fallas_id', CHtml::listData(Fallas::model()->findAll(), 'id', 'falla'),  array('empty' => '')); ?>
        <?php echo $form->error($model,'fallas_id'); ?>
</div>

<div class="_label"><strong>Origination IP </strong><small class="text-muted "><em>(Customer IP)(required)</em></small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>DestinationIP IP</strong> <small class="text-muted "><em>(Etelix IP)(required)</em></small></div>
<div class="input-control text block" data-role="input-control">

    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3">
    
    <span class="margen_17px"></span>
    
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3">
</div>


<div class="input-control text block" data-role="input-control">
        <strong>Prefix </strong><small class="text-muted "><em>(required)</em></small>
        <?php echo $form->textField($model,'prefijo'); ?>
        <?php echo $form->error($model,'prefijo'); ?>

</div>

<div class="grid" >
    <div class="row" id="separador-prefijo"></div>
</div>

<div class="grid" >
        <div class="input-control text span3" >
            <strong>Tested numbers</strong><small class="text-muted "><em> (required)</em></small>
            <?php echo $form->textField($model,'tested_numbers[]',array('placeholder' => 'Without prefix')); ?>
            <?php echo $form->error($model,'tested_numbers[]'); ?>
        </div>

        <div class="input-control select span2 margen-number" style="margin-left: 5px;">
            <br>
            <?php echo $form->dropDownList($model,'destination[]', CHtml::listData(Destinos::model()->findAll(), 'id', 'destino'),  array('empty'=>'Country')); ?>
            <?php echo $form->error($model,'destination[]'); ?>
        </div>

        <div class="input-control text span2 margen-number" style="margin-left: 5px; ">
            <br>
            <?php echo $form->textField($model,'fecha[]',array('placeholder' => 'Date', 'class' => 'fecha')); ?>
            <?php echo $form->error($model,'fecha[]'); ?>
        </div>

        <div class="input-control text span1" style="margin-left: 15px; padding-top: 5px; ">
            <br>
            <a href="javascript:void(0)" class="_agregar"><i class="icon-plus-2"></i></a>
        </div>
</div>
        
<div style="clear: left;"></div>

<div class="container_agregar"></div>


<div class="input-control textarea" data-role="input-control">
    <label>
        <?php echo $form->textArea($model,'descripcion',array('placeholder' => 'Description (required)')); ?>
        <?php echo $form->error($model,'descripcion'); ?>
    </label>
</div>

<div></div>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Preview Ticket' : 'Save', array('class' => 'primary large')); ?>

</fieldset>

