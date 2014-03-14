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
                    <th id="th-status">Status</th>
                    <th id="th-oip">Origination Ip</th>
                    <th id="th-dip">Destination Ip</th>
                    <th id="th-date">Date</th>
                    <th id="th-life">LT</th>
                    <th id="th-preview">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
            <?php foreach (Ticket::ticketsClosed() as $ticket): ?>
            <?php 
            $timeTicket = Utility::getTime($ticket->date, $ticket->hour);
            $read=DescriptionticketController::blinkTr($ticket->id);
            ?>
            <tr class="close <?php echo $read; ?>">
                        <?php if ($tipoUsuario !== "C"): ?>
                            <?php if (Ticketrelation::getTicketRelation($ticket->id) != null): ?>
                                <td><img class="detalle" width="14" height="14" src="<?php echo Yii::app()->request->baseUrl.'/images/details_open.png'; ?>"</td>
                            <?php else: ?>
                                <td>&nbsp;</td>
                            <?php endif; ?>
                                <td><?php if (isset($ticket->idUser->username)) echo $ticket->idUser->username; ?></td>
                            <td title="<?php echo $carrier=Carrier::getCarriers(true, $ticket->id); ?>">
                                <?php  echo  strlen($carrier) <= 9 ? $carrier : substr($carrier, 0, 9) .'...'; ?>
                            </td>
                        <?php endif; ?>
                        <td><?php echo $ticket->ticket_number; ?></td>
                        <td><?php echo  $failure = strlen($ticket->idFailure->name) <= 15 ? $ticket->idFailure->name : substr($ticket->idFailure->name, 0, 15) .'...';  ?></td>
                        <td name="id" id="<?php echo $ticket->id; ?>" time="<?php echo Utility::getTime($ticket->date, $ticket->hour); ?>">
                            close
                        </td>
                        <td><?php echo $ticket->origination_ip; ?></td>
                        <td><?php echo $ticket->destination_ip; ?></td>
                        <td><?php echo $ticket->date; ?></td>
                        <td><?php  echo Utility::restarHoras($ticket->hour, date('H:i:s'), floor($timeTicket/ (60 * 60 * 24))); ?></td>
                        <td><a href="javascript:void(0)" class="preview" rel="<?php echo $ticket->id; ?>"><img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/view.gif'; ?>"></a></td>
                    </tr>
                <?php endforeach; ?>
	</tbody>
</table>
</div>

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/datatable.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/demo_table_jui.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/uploadfile.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.dataTables.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.uploadfile.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modules/etts.ajax.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/save_message_ticket.js',CClientScript::POS_END); ?>