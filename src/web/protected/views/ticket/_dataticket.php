<?php $mailByTicket=MailUser::getMails(CrugeUser2::getUserTicket($datos->id, true)->iduser); ?>
<input type="hidden" id="id_ticket" value="<?php echo $datos->id; ?>">
<?php if ($datos->id_status != '2'): ?>
<!--<div class="div-agregar-correo">
    <div class="input-control select block">
        <select id="mails" multiple>
            <?php // foreach ($mailByTicket as $mails): ?>
                <option value="<?php // echo $mails['id']; ?>"><?php // echo $mails['mail']; ?></option>
            <?php // endforeach; ?>
        </select>
    </div>
</div>-->
<?php endif; ?>
<div class="input-control select block">
    Response to&nbsp;
    <?php if ($datos->id_status != '2'): ?>
    <!--<a href="javascript:void(0)" class="a-agregar-correo" onclick="toggleMails()"><i class="icon-plus-2"></i></a>-->
    <!--<a href="javascript:void(0)" class="a-bajar-correo down-mail" onclick="bajarCorreo()"><i class="icon-arrow-down"></i></a>-->
    <!--<a href="javascript:void(0)" class="a-borrar-correo" ><i class="icon-cancel-2 fg-red "></i></a>-->
    <?php endif; ?>
    <select multiple="multiple" readonly="readonly" id="preview_response_to">
        <?php foreach (MailUser::getMailsByTicket($datos->id) as $value): ?>
            <option><?php echo $value->idMail->mail; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="input-control text block">
Failure
<input type="text" value="<?php echo $datos->idFailure->name; ?>" disabled>
</div>


<?php
$originationIp = explode('.', $datos->origination_ip);
$destinationIp = explode('.', $datos->destination_ip);
$etelixIp='Etelix IP';
$customerIp='Customer IP';
$espacios='';
if ($datos->option_open=='etelix_to_carrier')
{
    $etelixIp='Customer IP';
    $customerIp='Etelix IP';
    $espacios='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';    
}
?>
<?php if ($datos->origination_ip !== null): ?>

<div class="_label">Origination IP <small class="text-muted "><em>(<?php echo $customerIp; ?>)</em></small><span class="margen_17px"></span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $espacios; ?>DestinationIP  <small class="text-muted "><em>(<?php echo $etelixIp; ?>)</em></small></div>
<div class="input-control text block" data-role="input-control">
    
    <input type="text" value="<?php echo $originationIp[0]; ?>" disabled class="_ip" disabled id="oip1" maxlength="3" >
    <input type="text" value="<?php echo $originationIp[1]; ?>" disabled class="_ip" disabled id="oip2" maxlength="3" >
    <input type="text" value="<?php echo $originationIp[2]; ?>" disabled class="_ip" disabled id="oip3" maxlength="3" >
    <input type="text" value="<?php echo $originationIp[3]; ?>" disabled class="_ip" disabled id="oip4" maxlength="3" >

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" value="<?php echo $destinationIp[0]; ?>" disabled class="_ip" disabled id="dip1" maxlength="3" >
    <input type="text" value="<?php echo $destinationIp[1]; ?>" disabled class="_ip" disabled id="dip2" maxlength="3" >
    <input type="text" value="<?php echo $destinationIp[2]; ?>" disabled class="_ip" disabled id="dip3" maxlength="3" >
    <input type="text" value="<?php echo $destinationIp[3]; ?>" disabled class="_ip" disabled id="dip4" maxlength="3" >

    
</div>
<?php endif; ?>

<?php if ($datos->prefix !== null): ?>
<div class="input-control text block" >
    Prefix
    <input type="text" value="<?php echo $datos->prefix; ?>" disabled>
</div>
<?php endif; ?>

<?php if (isset($datos->idGmt->name)): ?>
<div class="input-control text block">
    GMT
    <input type="text" value="<?php  echo $datos->idGmt->name; ?>" disabled>
</div>
<?php endif; ?>

<?php
$testedNumber=TestedNumber::getNumbers($datos->id);
?>
<?php if ($testedNumber != null): ?>
<div id="tabla_tested_number" class="grid">
    <?php $tabla = '<div><table id="tabla_preview"><thead><tr><th>Tested Numbers</th><th>Country</th><th>Date</th><th>Hour</th></thead><tbody>';
    foreach ($testedNumber as $value){
        $tabla .= '<tr><td>' . $value->numero . '</td><td>' . $value->idCountry->name . '</td><td>' . $value->date . '</td><td>' . $value->hour . '</td></tr>';
    } 
    echo $tabla . '</tbody></table></div>';
    ?>
</div>
<?php endif; ?>

Description
<div class="answer-ticket">
    <?php $this->renderPartial('_answer', array('datos'=>$datos)); ?>
</div>
<?php if ($datos->id_status != '2'): ?>
<div id="only-open">
<?php
$tipoUsuario = CrugeAuthassignment::getRoleUser();
if ($tipoUsuario !== 'C'):
?>
<div class="input-control select medium">
    <select id="speech">
        <option value="">Speech</option>
        <optgroup label="English">
        <?php foreach (Speech::getSpeech($datos->ticket_number) as $value): ?>
            <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
        <?php endforeach; ?>
        </optgroup>
        <optgroup label="Spanish">
        <?php foreach (Speech::getSpeechSpanish($datos->ticket_number) as $value): ?>
            <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
        <?php endforeach; ?>
        </optgroup>
    </select>
</div>

<?php endif; ?>

<div class="input-control textarea" data-role="input-control">
    <textarea name="answer" id="answer"></textarea>
</div>
<div class="panel-down-textarea">
    <div class="option-panel right">
        <input type="button" value="Send message" class="primary" id="sendmsg" onclick="saveMessage()">
    </div>
    <div class="option-panel right">
        <div id="mulitplefileuploader">Add file</div>
    </div>
    <div class="option-panel left confirmation">
        <div class="input-control checkbox" data-role="input-control">
            <?php if (CrugeAuthassignment::getRoleUser() != 'C'): ?>
            <label>
                <input type="checkbox" id="internalAsCarrier" value="1">
                <span class="check"></span>  <small class="text-muted ">Respond as Carrier</small>
            </label>
            <?php endif; ?>
            <label>
                <input type="checkbox" id="close-ticket" value="2">
                <span class="check"></span> <small class="text-muted ">Close TT</small>
            </label>
	</div>
    </div>
</div>
<div id="area-add-file"></div>
<div id="status"></div>
<div id="filename"></div>
</div>
<?php endif; ?>
