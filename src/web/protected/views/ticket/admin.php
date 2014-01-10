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
                        <th>User</th>
                    <?php else: ?>
                        <th class="hidden">&nbsp;</th>
                    <?php endif; ?>
                    <th>Ticket Number</th>
                    <th>Failure</th>
                    <th>Status(s)</th>
                    <th>Origination Ip</th>
                    <th>Destination Ip</th>
                    <th>Date</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">Tickets Relations</th>
                    <th class="hidden">&nbsp;</th>
                    <th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
                <?php foreach (Ticket::ticketsByUsers(Yii::app()->user->id, false) as $ticket): ?>
                    <tr <?php if ($ticket->idStatus->id === 2) echo 'class="gradeX"'; ?> >
                        <?php if ($tipoUsuario !== "C"): ?>
                            <td><?php echo CrugeUser2::getUserTicket($ticket->ids); ?></td>
                        <?php else: ?>
                            <td class="hidden">&nbsp;</td>
                        <?php endif; ?>
                        <td><?php echo $ticket->ticket_number; ?></td>
                        <td><?php echo $ticket->idFailure->name; ?></td>
                        <td id="<?php echo $ticket->ids; ?>">
                            <span class="span-status">
                                <span><?php echo $ticket->idStatus->name; ?></span>
                                <a href="javascript:void(0)" class="edit-status" rel="<?php echo $ticket->ids; ?>"><img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/edit.png'; ?>"></a>
                            </span>
                        </td>
                        <td><?php echo $ticket->origination_ip; ?></td>
                        <td><?php echo $ticket->destination_ip; ?></td>
                        <td><?php echo $ticket->date; ?></td>
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
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>