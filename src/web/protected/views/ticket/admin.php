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
                    <?php endif; ?>
                    <th id="th-ticket-number">Ticket Number</th>
                    <th id="th-failure">Failure</th>
                    <th id="th-status">Statu(s)</th>
                    <th id="th-oip">Origination Ip</th>
                    <th id="th-dip">Destination Ip</th>
                    <th id="th-date">Date</th>
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
                            <?php if (Ticketrelation::getTicketRelation($ticket->id) != null): ?>
                                <td><img class="detalle" width="14" height="14" src="<?php echo Yii::app()->request->baseUrl.'/images/details_open.png'; ?>"</td>
                            <?php else: ?>
                                <td>&nbsp;</td>
                            <?php endif; ?>
                            <td><?php echo CrugeUser2::getUserTicket($ticket->id); ?></td>
                            <td><?php  echo Carrier::getCarriers(true, $ticket->id) != null ?  Carrier::getCarriers(true, $ticket->id): ''; ?></td>
                        <?php endif; ?>
                        <td><?php echo $ticket->ticket_number; ?></td>
                        <td><?php echo  $failure = strlen($ticket->idFailure->name) <= 15 ? $ticket->idFailure->name : substr($ticket->idFailure->name, 0, 15) .'...';  ?></td>
                        <td name="id" id="<?php echo $ticket->id; ?>">
                            <span class="span-status">
                                <span><?php echo $ticket->idStatus->name; ?></span>
                                <?php if ($tipoUsuario !== "C"): ?>
                                    <a href="javascript:void(0)" class="edit-status" rel="<?php echo $ticket->id; ?>">
                                        <img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/edit.png'; ?>">
                                    </a>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td><?php echo $ticket->origination_ip; ?></td>
                        <td><?php echo $ticket->destination_ip; ?></td>
                        <td><?php echo $ticket->date; ?></td>
                        <td><a href="javascript:void(0)" class="preview" rel="<?php echo $ticket->id; ?>"><img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/view.gif'; ?>"></a></td>
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

