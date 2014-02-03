<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<!--<textarea name="pp" id="pp"></textarea>-->
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
                    <th id="th-status">Statu</th>
                    <th id="th-oip">Origination Ip</th>
                    <th id="th-dip">Destination Ip</th>
                    <th id="th-date">Date</th>
                    <th id="th-life">TL</th>
                    <th id="th-preview">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
                <?php foreach (Ticket::ticketsByUsers(Yii::app()->user->id, false) as $ticket): ?>
                    <tr <?php
                            $timeTicket = Utility::getTime($ticket->date, $ticket->hour);
                            switch ($ticket->idStatus->id) {
                                case '1':
                                    if($timeTicket > 86400 )
                                        echo 'class="late"';
                                    else
                                        echo 'class="open"'; 
                                    break;
                                case '2':
                                    echo 'class="close"';
                                    break;
                                }
                                ?>>
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
                        <td title="Open about <?php echo Utility::restarHoras($ticket->hour, date('H:i:s'), floor($timeTicket/ (60 * 60 * 24))); ?>" name="id" id="<?php echo $ticket->id; ?>" time="<?php echo Utility::getTime($ticket->date, $ticket->hour); ?>">
                            <span class="span-status">
                                <span class="text-span"><?php echo $ticket->idStatus->name; ?></span>
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
                        <td><?php echo Utility::restarHoras($ticket->hour, date('H:i:s'), floor($timeTicket/ (60 * 60 * 24))); ?></td>
                        <td><a href="javascript:void(0)" class="preview" rel="<?php echo $ticket->id; ?>"><img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/view.gif'; ?>"></a></td>
                    </tr>
                <?php endforeach; ?>
	</tbody>
</table>
</div>
<select id="status" class="hidden">
    <option value="">Select</option>
    <?php foreach (Status::getStatus() as $value): ?>
        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
    <?php endforeach; ?>
</select>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/datatable.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/demo_table_jui.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/uploadfile.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.dataTables.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.uploadfile.js',CClientScript::POS_END); ?>
<?php if ($tipoUsuario === "C"): ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin_cliente.js',CClientScript::POS_END); ?>
<?php else: ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/save_message_ticket.js',CClientScript::POS_END); ?>
<?php // Yii::app()->clientScript->registerScriptFile('http://js.nicedit.com/nicEdit-latest.js',CClientScript::POS_HEAD); ?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/textarea_enriquecido.js',CClientScript::POS_HEAD); ?>
