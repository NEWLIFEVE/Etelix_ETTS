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
        User<small class="text-muted "><em> (required)</em></small>
        <select id="user" class="validate[required]">
            <option value=""></option>
            <?php foreach(CrugeUser2::getUsuerByIdCarrier() as $value): ?>
            <option value="<?php echo $value->iduser; ?>"><?php echo $value->username; ?></option>
            <?php endforeach; ?>
        </select>
</div>
        
<div class="input-control select block">
        Select the recipients emails that will received the ticket confirmation

        <small class="text-muted "><em> (maximum 5 emails)</em></small>
        <select id="mails" multiple>
            
        </select>
</div>
      
<div class="input-control select block">
    Response to <small class="text-muted "><em>(required)</em></small>&nbsp;&nbsp;
    <a href="javascript:void(0)" class="a-agregar-correo"><i class="icon-plus-2"></i></a>
    &nbsp;
    <a href="javascript:void(0)" class="a-bajar-correo"><i class="icon-arrow-down"></i></a>
    &nbsp;
    <a href="javascript:void(0)" class="a-borrar-correo" ><i class="icon-cancel-2 fg-red "></i></a>
    &nbsp;
    <a href="javascript:void(0)" class="add-all-email" >Add all emails</a>
    <div class="div-agregar-correo">
        <div class="input-control text span3"  data-role="input-control">
            <input type="text" id="new_mail" class="validate[custom[email]]" name="new_mail" placeholder="example@example.com" />
        </div>
        
        <div class="input-control text span2">
            <button class="btn-agregar-correo-interno-cliente primary" type="button"><i class="icon-floppy on-left"></i>Save</button>
        </div>
    </div>
    <?php echo $form->ListBox(
                $model,'mail[]', 
                array(),  
                array('multiple' => 'multiple', 'class' => 'validate[required]')) ?>
    <?php echo $form->error($model,'mail[]'); ?>
</div>


<div class="input-control select block">
        Failure<small class="text-muted "><em> (required)</em></small>
        <?php echo $form->dropDownList($model,'id_failure', CHtml::listData(Failure::model()->findAll(), 'id', 'name'),  array('empty' => '' ,'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'id_failure'); ?>
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
        GMT <small class="text-muted "><em>(required)</em></small>
        <?php echo $form->dropDownList($model,'idGmt', CHtml::listData(Gmt::model()->findAll(array('order'=>'id')), 'id', 'name'),  array('empty' => '', 'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'idGmt'); ?>
</div>

<!--Preview tested number-->
<div id="preview_tested_number"> 
<div id="elemento" class="grid" >
        <div class="input-control text span3" >
            <span>Tested numbers<small class="text-muted "><em> (required)</em></small></span>
            <?php echo $form->textField($model,'tested_numbers[]',array('placeholder' => 'Without prefix', 'class' => 'validate[required,custom[integer]]')); ?>
            <?php echo $form->error($model,'tested_numbers[]'); ?>
        </div>

        <div id="content_country">
            <div class="input-control select span2 margen-number">
                <br>
                <?php echo $form->dropDownList($model,'country[]', Country::getNames(),  array('empty'=>'Country', 'class' => 'validate[required]')); ?>
                <?php echo $form->error($model,'country[]'); ?>
            </div>
        </div>

        <div class="input-control text span2 margen-number fecha_div">
            <br>
            <?php echo $form->textField($model,'date_number[]',array('placeholder' => 'Date', 'class' => 'fecha validate[required]', 'readonly' => 'readonly')); ?>
            <?php echo $form->error($model,'date_number[]'); ?>
        </div>

        <div class="input-control text span1 margen-number hour_div">
            <br>
            <?php echo $form->textField($model,'hour_number[]',array('placeholder' => 'Hour', 'class' => 'hour validate[required]')); ?>
            <?php echo $form->error($model,'hour_number[]'); ?>
        </div>


        <div class="input-control text span1" style="margin-left: 5px; padding-top: 5px; width: 10px !important;">
            <br>
            <a href="javascript:void(0)" class="agregar-tested-number"><i class="icon-plus-2"></i></a>
        </div>
</div>
        
<div style="clear: left;"></div>

<div class="container_agregar"></div>
</div> <!--/.preview_tested_number-->


<div class="input-control textarea" data-role="input-control">
    <label>
        <?php echo $form->textArea($model,'description',array('placeholder' => 'Description (required)', 'class' => 'validate[required]')); ?>
        <?php echo $form->error($model,'description'); ?>
    </label>
</div>

<div></div>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Preview Ticket' : 'Save', array('class' => 'primary large', 'name'=>'preview')); ?>

</fieldset>

