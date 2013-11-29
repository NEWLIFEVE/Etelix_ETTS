<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>
<fieldset>
        <legend>Use this form to submit a ticket.</legend>
<?php echo $form->errorSummary($model); ?>

<div class="input-control select block">
        Select the recipients emails that will received the ticket confirmation
        <small class="text-muted "><em> (maximum 5 emails)</em></small>
        <select id="cargar_mails" multiple>
            <?php foreach (MailUser::getMails(Yii::app()->user->id) as $mails): ?>
                <option value="<?php echo $mails['id']; ?>"><?php echo $mails['mail']; ?></option>
            <?php endforeach; ?>
        </select>
</div>

        
<div class="input-control select block">
    Response to <small class="text-muted "><em>(required)</em></small>&nbsp;&nbsp;
    <a href="javascript:void(0)" class="a-agregar_correo"><i class="icon-plus-2"></i></a>
    &nbsp;
    <a href="javascript:void(0)" class="a-bajar_correo"><i class="icon-arrow-down"></i></a>
    &nbsp;
    <a href="javascript:void(0)" class="a-borrar_correo" ><i class="icon-cancel-2 fg-red "></i></a>
    &nbsp;
    <a href="javascript:void(0)" id="add_all_email" >Add all emails</a>
    <div class="div-agregar_correo">
        <div class="input-control text span3"  data-role="input-control">
            <input type="text" id="new_mail" placeholder="example@example.com" />
        </div>
        
        <div class="input-control text span2">
            <button class="btn-agregar-correo primary" type="button"><i class="icon-floppy on-left"></i>Save</button>
        </div>
    </div>
    <?php echo $form->ListBox(
                $model,'mail[]', 
                array(),  
                array('multiple' => 'multiple')) ?>
    <?php echo $form->error($model,'mail[]'); ?>
</div>


<div class="input-control select block">
        Failure<small class="text-muted "><em> (required)</em></small>
        <?php echo $form->dropDownList($model,'id_failure', CHtml::listData(Failure::model()->findAll(), 'id', 'name'),  array('empty' => '')); ?>
        <?php echo $form->error($model,'id_failure'); ?>
</div>

<div class="_label">Origination IP <small class="text-muted "><em>(Customer IP)(required)</em></small><span class="margen_17px"></span>DestinationIP  <small class="text-muted "><em>(Etelix IP)(required)</em></small></div>
<div class="input-control text block" data-role="input-control">

    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3">
    
    <span class="margen_22px"></span>
    
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3"> 
    <input type="text" class="_ip" maxlength="3">
</div>


<div class="input-control text block" data-role="input-control">
        Prefix <small class="text-muted "><em>(required)</em></small>
        <?php echo $form->textField($model,'prefix'); ?>
        <?php echo $form->error($model,'prefix'); ?>
</div>

<div class="grid" >
    <div class="row" id="separador-prefijo"></div>
</div>



<div class="input-control select block">
        GMT <small class="text-muted "><em>(required)</em></small>
        <?php echo $form->dropDownList($model,'idGmt',array()); ?>
        <?php echo $form->error($model,'idGmt'); ?>
</div>

<div class="grid" >
        <div class="input-control text span3" >
            Tested numbers<small class="text-muted "><em> (required)</em></small>
            <?php echo $form->textField($model,'tested_numbers[]',array('placeholder' => 'Without prefix')); ?>
            <?php echo $form->error($model,'tested_numbers[]'); ?>
        </div>

        <div id="content_country">
            <div class="input-control select span2 margen-number">
                <br>
                <?php echo $form->dropDownList($model,'country[]', Country::getNames(),  array('empty'=>'Country')); ?>
                <?php echo $form->error($model,'country[]'); ?>
            </div>
        </div>

        <div class="input-control text span2 margen-number fecha_div">
            <br>
            <?php echo $form->textField($model,'date_number[]',array('placeholder' => 'Date', 'class' => 'fecha')); ?>
            <?php echo $form->error($model,'date_number[]'); ?>
        </div>

        <div class="input-control text span1 margen-number hour_div">
            <br>
            <?php echo $form->textField($model,'hour_number[]',array('placeholder' => 'Hour', 'class' => 'hour')); ?>
            <?php echo $form->error($model,'hour_number[]'); ?>
        </div>


        <div class="input-control text span1" style="margin-left: 5px; padding-top: 5px; width: 10px !important;">
            <br>
            <a href="javascript:void(0)" class="_agregar"><i class="icon-plus-2"></i></a>
        </div>
</div>
        
<div style="clear: left;"></div>

<div class="container_agregar"></div>


<div class="input-control textarea" data-role="input-control">
    <label>
        <?php echo $form->textArea($model,'description',array('placeholder' => 'Description (required)')); ?>
        <?php echo $form->error($model,'description'); ?>
    </label>
</div>

<div></div>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Preview Ticket' : 'Save', array('class' => 'primary large')); ?>

</fieldset>