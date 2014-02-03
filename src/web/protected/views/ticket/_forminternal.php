<?php
/* @var $this TicketsController */
/* @var $model Tickets */
/* @var $form CActiveForm */
?>
<div id="content_attached_file"></div>
<fieldset>
    <legend>Use this form to submit a ticket.</legend>
<?php echo $form->errorSummary($model); ?>
    
    
<div class="input-control text block" >
    To
    <input type="text" id="to">
</div>
    
<div class="input-control text block" >
    CC
    <input type="text" id="cc">
</div>
    
<div class="input-control text block" >
    BBC
    <input type="text" id="bbc">
</div>
    


<div class="input-control select block">
        Failure<small class="text-muted "><em> (required)</em></small>
        <?php echo $form->dropDownList($model,'id_failure', CHtml::listData(Failure::model()->findAll(), 'id', 'name'),  array('empty' => '' ,'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'id_failure'); ?>
</div>
    
<div class="input-control select block">
        Class<small class="text-muted "><em> (required)</em></small>
        <select id="class"></select>
</div>
    
<div class="input-control select block">
        Asociate to TT
        <select id="tt_asociado"></select>
</div>

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

        
<div class="input-control select block">
        Status<small class="text-muted "><em> (required)</em></small>
        <select id="status"></select>
</div>
        
<div class="input-control select block">
        Account Manager<small class="text-muted "><em> (required)</em></small>
        <?php echo $form->dropDownList($model,'id_manager', Managers::getListManagers(),  array('empty' => '' ,'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'id_manager'); ?>
</div>
        
<div class="input-control select block">
        SPEECHS
        <select id="speechs"></select>
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

