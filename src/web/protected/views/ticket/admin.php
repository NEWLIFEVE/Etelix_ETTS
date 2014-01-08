<?php
/* @var $this TicketController */
/* @var $model Ticket */
?>

<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
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
<!--                    <th class="hidden">Date</th>
                    <th class="hidden">Prefix</th>
                    <th class="hidden">GMT</th>
                    <th class="hidden">Number</th>
                    <th class="hidden">Date</th>
                    <th class="hidden">Hour</th>
                    <th class="hidden">Country</th>
                    <th class="hidden">Mail</th>-->
                    <th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
                <?php foreach (Ticket::ticketsByUsers(Yii::app()->user->id, false) as $ticket): ?>
                    <tr <?php if ($ticket->idStatus->id === 2) echo 'class="gradeX"'; ?> >
                        <td><?php echo $ticket->ticket_number; ?></td>
                        <td><?php echo $ticket->idFailure->name; ?></td>
                        <td>
                            <div class="input-control select block select-status" >
                                <select id="status">
                                    <?php foreach (Status::getStatus() as $value): ?>
                                        <option value="<?php  echo $value->id; ?>" <?php if ($ticket->idStatus->id === $value->id) echo 'selected';?>><?php echo $value->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" id="<?php echo $ticket->ids; ?>" value="<?php echo $ticket->ids; ?>">
                            <div>
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
<!--                        <td class="hidden"><?php // echo $ticket->descriptionTickets->description; ?></td>
                        <td class="hidden"><?php // echo $ticket->prefix; ?></td>
                        <td class="hidden"><?php // echo $ticket->idGmt->name; ?></td>
                        <td class="hidden"><?php // foreach (TestedNumber::getNumbers($ticket->ids) as $value) echo $value->numero . ','; ?></td>
                        <td class="hidden"><?php // foreach (TestedNumber::getNumbers($ticket->ids) as $value) echo $value->date . ','; ?></td>
                        <td class="hidden"><?php // foreach (TestedNumber::getNumbers($ticket->ids) as $value) echo $value->hour . ','; ?></td>
                        <td class="hidden"><?php // foreach (TestedNumber::getNumbers($ticket->ids) as $value) echo $value->idCountry->name . '|'; ?></td>
                        <td class="hidden"><?php // echo implode(',', Mail::getNameMails($ticket->ids)); ?></td>-->
                        <td><a href="javascript:void(0)"><img src="<?php echo Yii::app(); ?>"></a></td>
                    </tr>
                <?php endforeach; ?>
	</tbody>
</table>
</div>

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/demo_table_jui.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/datatable.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.dataTables.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>