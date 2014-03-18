<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>
<div id="content_attached_file"></div>
<input type="hidden" id="open-ticket" value="carrier_to_etelix">
<fieldset>
    <legend>Use this form to submit a ticket.</legend>
<?php echo $form->errorSummary($model); ?>


<div class="input-control select block">
        Class<small class="text-muted "><em> (required)</em></small>
        <select id="class" class="validate[required]">
            <option value=""></option>
            <option value="customer">Customer</option>            
            <option value="supplier">Supplier</option>
        </select>
</div>
    
<div class="input-control select block">
        User<small class="text-muted "><em> (required)</em></small>
        <select id="user" class="validate[required]"></select>
</div>
    
<div id="recipients-emails">
    <div class="input-control select block">
        Select the recipients emails that will received the ticket confirmation
        <select id="mails" multiple></select>
    </div>
</div>

<div class="input-control select block">
    <span class="toggle">To</span>&nbsp;<small class="text-muted "><em>(required)</em></small>&nbsp;
    <a href="javascript:void(0)" class="a-agregar-correo"><i class="icon-plus-2"></i></a>
    <a href="javascript:void(0)" class="a-bajar-correo"><i class="icon-arrow-down"></i></a>&nbsp;
    <a href="javascript:void(0)" class="a-borrar-correo" ><i class="icon-cancel-2 fg-red "></i></a>&nbsp;&nbsp;
    <span class="toggle cc" title="Click to add a copy">CC</span>&nbsp;&nbsp;&nbsp;<span class="toggle bbc" title="Click to add a Bcc">BBC</span>&nbsp;
    <div class="div-agregar-correo">
        <div class="input-control text span3"  data-role="input-control">
            <input type="text" id="new_mail" class="validate[custom[email]]" name="new_mail" placeholder="example@example.com" />
        </div>
        
        <div class="input-control text span2">
            <button class="btn-agregar-correo-interno-proveedor primary" type="button"><i class="icon-floppy on-left"></i>Save</button>
        </div>
    </div>
    <?php echo $form->ListBox(
                $model,'mail[]', 
                array(),  
                array('multiple' => 'multiple', 'class'=>'validate[required]')) ?>
    <?php echo $form->error($model,'mail[]'); ?>
</div>

<div id="div-cc"> 
    <div class="input-control select block" >
        CC&nbsp;
        <a href="javascript:void(0)" class="a-bajar-correo"><i class="icon-arrow-down"></i></a>&nbsp;
        <a href="javascript:void(0)" class="a-borrar-correo" ><i class="icon-cancel-2 fg-red "></i></a>
        <select id="cc" multiple></select>
    </div>
</div>

<div id="div-bbc"> 
    <div  class="input-control select block" >
        BBC&nbsp;
        <a href="javascript:void(0)" class="a-bajar-correo"><i class="icon-arrow-down"></i></a>&nbsp;
        <a href="javascript:void(0)" class="a-borrar-correo" ><i class="icon-cancel-2 fg-red "></i></a>
        <select id="bbc" multiple></select>
    </div>
</div>

<div class="input-control select block">
        Failure<small class="text-muted "><em> (required)</em></small>
        <?php echo $form->dropDownList($model,'id_failure', CHtml::listData(Failure::model()->findAll(), 'id', 'name'),  array('empty' => '' ,'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'id_failure'); ?>
</div>
 
<!--<div class="input-control select block">
        Asociate to TT
        <select id="tt_asociado"></select>
</div>-->

<div class="_label">Origination IP<input type="text" id="originationIp" class="validate[custom[ipv4]]"><small class="text-muted "><em>(Customer IP)</em></small><span class="margen_31px"></span>Destination IP<input type="text" id="destinationIp" class="validate[,custom[ipv4]]"><small class="text-muted "><em>(Etelix IP)</em></small></div>
<div class="input-control text block" data-role="input-control">

    <input type="text" class="_ip validate[custom[integer]]" id="oip1" name="oip1" maxlength="3"> 
    <input type="text" class="_ip validate[custom[integer]]" id="oip2" maxlength="3"> 
    <input type="text" class="_ip validate[custom[integer]]" id="oip3" maxlength="3"> 
    <input type="text" class="_ip validate[custom[integer]]" id="oip4" maxlength="3">
    
    <span class="margen_22px"></span>
    
    <input type="text" class="_ip validate[custom[integer]]" id="dip1" maxlength="3"> 
    <input type="text" class="_ip validate[custom[integer]]" id="dip2" maxlength="3"> 
    <input type="text" class="_ip validate[custom[integer]]" id="dip3" maxlength="3"> 
    <input type="text" class="_ip validate[custom[integer]]" id="dip4" maxlength="3">
</div>


<div class="input-control text block" data-role="input-control">
        Prefix
        <?php echo $form->textField($model,'prefix', array('class' => 'validate[custom[integer]]')); ?>
        <?php echo $form->error($model,'prefix'); ?>
</div>

<!--        
<div class="input-control select">
        Status<small class="text-muted "><em> (required)</em></small>
        <select id="statu" class="validate[required]">
            <option value=""></option>
            <?php // foreach (Status::getStatus() as $value): ?>
                <option value="<?php // echo $value->id; ?>"><?php // echo $value->name; ?></option>
            <?php // endforeach; ?>
        </select>
</div>
        
<div class="input-control select block">
        Account Manager<small class="text-muted "><em> (required)</em></small>
        <?php // echo $form->dropDownList($model,'id_manager', Managers::getListManagers(),  array('empty' => '' ,'class' => 'validate[required]')); ?>
        <?php // echo $form->error($model,'id_manager'); ?>
</div>-->
        
<div class="input-control select block">
        SPEECHS
        <select id="speech">
            <option value=""></option>
            <?php foreach (Speech::getSpeech() as $value): ?>
                <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
            <?php endforeach; ?>
        </select>
</div>


<div class="input-control textarea" data-role="input-control">
    <label>
        <?php echo $form->textArea($model,'description',array('placeholder' => 'Description (required)', 'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'description'); ?>
    </label>
</div>

<div></div>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Preview Ticket' : 'Save', array('class' => 'primary large', 'name'=>'preview')); ?>

</fieldset>

