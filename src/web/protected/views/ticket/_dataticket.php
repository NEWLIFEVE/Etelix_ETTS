<div class="input-control select block">
Response to
<select multiple="multiple" disabled="disabled" id="preview_response_to">
    <?php foreach (MailUser::getMailsByTicket($datos->id) as $value): ?>
        <option><?php echo $value->idMail->mail; ?></option>
    <?php endforeach; ?>
</select>
</div>

<div class="input-control text block">
Failure
<input type="text" value="<?php echo $datos->idFailure->name; ?>" disabled>
</div>


<?php $originationIp = explode('.', $datos->origination_ip); ?>
<?php $destinationIp = explode('.', $datos->destination_ip); ?>
<div class="_label">Origination IP <small class="text-muted "><em>(Customer IP)</em></small><span class="margen_17px"></span>&nbsp;&nbsp;&nbsp;&nbsp;DestinationIP  <small class="text-muted "><em>(Etelix IP)</em></small></div>
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

<div class="input-control text block" >
    Prefix
    <input type="text" value="<?php echo $datos->prefix; ?>" disabled>
</div>

<div class="input-control text block">
    GMT
    <input type="text" value="<?php echo $datos->idGmt->name; ?>" disabled>
</div>

<div id="tabla_tested_number" class="grid">
    <?php $tabla = '<div><table id="tabla_preview"><thead><tr><th>Tested Numbers</th><th>Country</th><th>Date</th><th>Hour</th></thead><tbody>';
    foreach (TestedNumber::getNumbers($datos->id) as $value){
        $tabla .= '<tr><td>' . $value->numero . '</td><td>' . $value->idCountry->name . '</td><td>' . $value->date . '</td><td>' . $value->hour . '</td></tr>';
    } 
    echo $tabla . '</tbody></table></div>';
    ?>
    
</div>


Description<hr>
<ul>
    <?php 
    foreach ($datos->descriptionTickets as $value) {
        echo '<li>' . $value->description . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong>User: </strong>' . $value->idUser->username .  '<hr></li>';
    }
    ?>
</ul>
<div class="input-control select block">
    <select>
        <option></option>
    </select>
</div>

<div class="input-control textarea" data-role="input-control">
    <label>
        <textarea></textarea>
    </label>
</div>
<div></div>
<button type="submit" id="send-msg" class="primary large">Send</button>
