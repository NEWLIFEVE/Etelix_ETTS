<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>
<div id="content_attached_file"></div>
<fieldset>
    <legend>Use this form to submit a ticket.</legend>
<?php echo $form->errorSummary($model); ?>



<div class="input-control select block">
        Class<small class="text-muted "><em> (required)</em></small>
        <select id="class">
            <option value=""></option>
            <option value="customer">Customer</option>            
            <option value="supplier">supplier</option>
            <option value="internal">Internal</option>
        </select>
</div>
    
<div class="input-control select block">
        User<small class="text-muted "><em> (required)</em></small>
        <select id="user"></select>
</div>
    
<div id="recipients-emails">
    <div class="input-control select block">
        Select the recipients emails that will received the ticket confirmation

        <small class="text-muted "><em> (maximum 5 emails)</em></small>
        <select id="mails" multiple></select>
    </div>
</div>

<div class="input-control select block">
    <span class="toggle">To</span>&nbsp;
    <a href="javascript:void(0)" class="a-bajar-correo"><i class="icon-arrow-down"></i></a>&nbsp;&nbsp;
    <span class="toggle cc" title="Add CC">CC</span>&nbsp;&nbsp;&nbsp;<span class="toggle bbc" title="Add BBC">BBC</span>&nbsp;
    <?php echo $form->ListBox(
                $model,'mail[]', 
                array(),  
                array('multiple' => 'multiple', 'class' => 'validate[required]')) ?>
    <?php echo $form->error($model,'mail[]'); ?>
</div>

<div id="div-cc"> 
    <div class="input-control select block" >
        CC&nbsp;
        <a href="javascript:void(0)" class="a-bajar-correo"><i class="icon-arrow-down"></i></a>
        <select id="cc" multiple></select>
    </div>
</div>

<div id="div-bbc"> 
    <div  class="input-control select block" >
        BBC&nbsp;
        <a href="javascript:void(0)" class="a-bajar-correo"><i class="icon-arrow-down"></i></a>
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

        <div class="_label">Origination IP<input type="text" id="originationIp" class="validate[required,custom[ipv4]]"><small class="text-muted "><em>(Customer IP)(required)</em></small><span class="margen_17px"></span>Destination IP<input type="text" id="destinationIp" class="validate[required,custom[ipv4]]"><small class="text-muted "><em>(Etelix IP)(required)</em></small></div>
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
        Prefix <small class="text-muted "><em>(required)</em></small>
        <?php echo $form->textField($model,'prefix', array('class' => 'validate[required,custom[integer]]')); ?>
        <?php echo $form->error($model,'prefix'); ?>
</div>

        
<div class="input-control select">
        Status<small class="text-muted "><em> (required)</em></small>
        <select id="statu" class="validate[required]">
            <option value=""></option>
            <?php foreach (Status::getStatus() as $value): ?>
                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
            <?php endforeach; ?>
        </select>
</div>
        
<div class="input-control select block">
        Account Manager<small class="text-muted "><em> (required)</em></small>
        <?php echo $form->dropDownList($model,'id_manager', Managers::getListManagers(),  array('empty' => '' ,'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'id_manager'); ?>
</div>
        
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

