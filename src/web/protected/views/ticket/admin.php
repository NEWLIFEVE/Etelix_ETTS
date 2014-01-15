<?php
/* @var $this TicketController */
/* @var $model Ticket */
?>

<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
                    <?php $tipoUsuario = CrugeAuthassignment::getRoleUser(); ?>
                    <?php if ($tipoUsuario !== "C"): ?>
                        <th id="th-plus">&nbsp;</th>
                        <th id="th-user">User</th>
                        <th id="th-carrier">Carrier</th>
                    <?php else: ?>
                        <th id="th-user" class="hidden">&nbsp;</th>
                    <?php endif; ?>
                    <th id="th-ticket-number">Ticket Number</th>
                    <th id="th-failure">Failure</th>
                    <th id="th-status">Statu(s)</th>
                    <th id="th-oip">Origination Ip</th>
                    <th id="th-dip">Destination Ip</th>
                    <th id="th-date">Date</th>
                    
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">&nbsp;</th>
                    <th id="th-preview">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
                <?php foreach (Ticket::ticketsByUsers(Yii::app()->user->id, false) as $ticket): ?>
                    <tr <?php switch ($ticket->idStatus->id) {
                                case '1':
                                    $date = explode('-', $ticket->date);
                                    $hour = explode(':', $ticket->hour);
                                    $timestamp = mktime($hour[0],$hour[1],$hour[2], $date[1],$date[2],$date[0]);
                                    if( (time() - $timestamp) > 72000 )
                                        echo 'class="late"';
                                    else
                                        echo 'class="open"'; 
                                    break;
                                case '2':
                                    echo 'class="close"';
                                    break;
                                }?>>
                        <?php if ($tipoUsuario !== "C"): ?>
                            <?php if (Ticketrelation::getTicketRelation($ticket->ids) != null): ?>
                                <td><img class="detalle" width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/details_open.png'; ?>"</td>
                            <?php else: ?>
                                <td>&nbsp;</td>
                            <?php endif; ?>
                            <td><?php echo CrugeUser2::getUserTicket($ticket->ids); ?></td>
                            <td><?php  echo Carrier::getCarriers(true, $ticket->ids) != null ?  Carrier::getCarriers(true, $ticket->ids): ''; ?></td>
                        <?php else: ?>
                            <td class="hidden">&nbsp;</td>
                        <?php endif; ?>
                        <td><?php echo $ticket->ticket_number; ?></td>
                        <td><?php echo  $failure = strlen($ticket->idFailure->name) <= 15 ? $ticket->idFailure->name : substr($ticket->idFailure->name, 0, 15) .'...';  ?></td>
                        <td id="<?php echo $ticket->ids; ?>">
                            <span class="span-status">
                                <span><?php echo $ticket->idStatus->name; ?></span>
                                <?php if ($tipoUsuario !== "C"): ?>
                                    <a href="javascript:void(0)" class="edit-status" rel="<?php echo $ticket->ids; ?>">
                                        <img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/edit.png'; ?>">
                                    </a>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td><?php echo $ticket->origination_ip; ?></td>
                        <td><?php echo $ticket->destination_ip; ?></td>
                        <td><?php echo $ticket->date; ?></td>
                        
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo CrugeUser2::getUserTicket($value->id) . '|'; ?></td>
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo Carrier::getCarriers(true, $value->id) . '|'; ?></td>

                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo $value->ticket_number . '|'; ?></td>
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo $value->idFailure->name . '|'; ?></td>
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo $value->idStatus->name . '|'; ?></td>
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo $value->origination_ip . '|'; ?></td>
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo $value->destination_ip . '|'; ?></td>
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo $value->date . '|'; ?></td>
                        <td class="hidden"><?php foreach (Ticket::ticketsRelations($ticket->ids) as $value) echo '<a href="javascript:void(0)" class="preview" rel="'.$value->id.'"><img width="12" height="12" src="'.Yii::app()->request->baseUrl.'/images/view.gif" /></a>' . '|'; ?></td>
                        <td><a href="javascript:void(0)" class="preview" rel="<?php echo $ticket->ids; ?>"><img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/view.gif'; ?>"></a></td>
                    </tr>
                <?php endforeach; ?>
	</tbody>
</table>
</div>

<!--<div class="input-control select block select-status" >-->
    <select id="status" class="hidden">
        <option value="">Select</option>
        <?php foreach (Status::getStatus() as $value): ?>
            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
        <?php endforeach; ?>
    </select>
<!--</div>-->
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/datatable.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/demo_table_jui.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.dataTables.min.js',CClientScript::POS_END); ?>
<?php if ($tipoUsuario === "C"): ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin_cliente.js',CClientScript::POS_END); ?>
<?php else: ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>
<?php endif; ?>

