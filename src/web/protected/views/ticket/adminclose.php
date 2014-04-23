<?php
/* @var $this TicketController */
/* @var $model Ticket */
?>
<!--<textarea name="pp" id="pp"></textarea>-->
<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
                    <?php $tipoUsuario = CrugeAuthassignment::getRoleUser(); ?>
                    <?php if ($tipoUsuario !== "C"): ?>
                        <th id="th-plus">&nbsp;</th>
                        <th id="th-date">Type</th>
                        <th id="th-user">User</th>
                        <th id="th-carrier">Carrier</th>
                    <?php else: ?>
                        <th id="th-date">Type</th>
                    <?php endif; ?>
                    <th id="th-ticket-number">Ticket Number</th>
                    <th id="th-failure">Failure</th>
                    <th id="th-oip">Country</th>
                    <th id="th-date">Created</th>
                    <th id="th-life">LT</th>
                    <th id="th-preview">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
                <?php foreach (Ticket::ticketsClosed() as $ticket): ?>
                    <tr <?php
                            $timeTicket = Utility::getTime($ticket->date, $ticket->hour);
                            $read=DescriptionticketController::blinkTr($ticket->id);
                            $carrier=Carrier::getCarriers(true, $ticket->id);
                            switch ($ticket->idStatus->id) {
                                case '1':
                                    // Si es el dia de hoy
                                    if ($timeTicket <= 86400) {
                                        echo 'class="open today '.$read.'"'; 
                                    // Si es el dia de ayer
                                    } elseif ($timeTicket > 86400 && $timeTicket <= 172800) {
                                        echo 'class="open yesterday '.$read.'"'; 
                                    } else {
                                        echo 'class="late '.$read.'"';
                                    }
                                    break;
                                case '2':
                                    echo 'class="close '.$read.'"';
                                    break;
                                }
                                ?>>
                        <?php if ($tipoUsuario !== "C"): ?>
                            <?php if (Ticketrelation::getTicketRelation($ticket->id) != null): ?>
                                <td><img class="detalle" width="14" height="14" src="<?php echo Yii::app()->request->baseUrl.'/images/details_open.png'; ?>"</td>
                            <?php else: ?>
                                <td>&nbsp;</td>
                            <?php endif; ?>
                            <td><?php echo Utility::formatTicketNumber($ticket->ticket_number); ?></td>
                            <td>
                                <?php if ($ticket->option_open == 'etelix_to_carrier'): ?>
                                    <?php if (isset($ticket->idUser->username)) echo $ticket->idUser->username; ?>
                                <?php else: ?>
                                    <?php  echo  strlen($carrier) <= 9 ? $carrier : substr($carrier, 0, 9) .'...'; ?>
                                <?php endif; ?>
                            </td>
                            <td title="<?php echo $carrier; ?>">
                                <?php  echo  strlen($carrier) <= 9 ? $carrier : substr($carrier, 0, 9) .'...'; ?>
                            </td>
                        <?php else: ?>
                            <td><?php echo Utility::formatTicketNumber($ticket->ticket_number); ?></td>
                        <?php endif; ?>
                        <td><?php echo $ticket->ticket_number; ?></td>
                        <td><?php echo  $failure = strlen($ticket->idFailure->name) <= 15 ? $ticket->idFailure->name : substr($ticket->idFailure->name, 0, 15) .'...';  ?></td>
                        <td><?php if (TestedNumber::getNumber($ticket->id) != false) echo TestedNumber::getNumber($ticket->id)->idCountry->name; ?></td>
                        <td><?php echo $ticket->date . ' / ' . $ticket->hour; ?></td>
                        <td><?php  echo Utility::restarHoras($ticket->hour, date('H:i:s'), floor($timeTicket/ (60 * 60 * 24))); ?></td>
                        <td><a href="javascript:void(0)" class="preview" rel="<?php echo $ticket->id; ?>"><img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/view.gif'; ?>"></a></td>
                    </tr>
                <?php endforeach; ?>
	</tbody>
</table>
</div>
<div class='botones-sociales izquierda hidden-phone hidden-tablet'>
    <a class='itemsocial' href='javascript:void(0)' id='facebook-btn'>
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['white']; ?> TT's <br>(<?php echo $colors['percentageWhite']; ?>%)</span>
            <span class='texto'>TT's abiertos con 24 horas (<?php echo $colors['white']; ?> en total)</span>
        </span>
    </a>
    <a class='itemsocial' href='javascript:void(0)'id='twitter-btn'>
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['yellow']; ?> TT's <br>(<?php echo $colors['percentageYellow']; ?>%)</span>
            <span class='texto'>TT's abiertos con 48 horas (<?php echo $colors['yellow']; ?> en total)</span>
        </span>
    </a>
    <a class='itemsocial' href='javascript:void(0)' id='google-btn'>
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['red']; ?> TT's <br>(<?php echo $colors['percentageRed']; ?>%)</span>
            <span class='texto'>TT's abiertos con mas de 48 horas (<?php echo $colors['red']; ?> en total)</span>
        </span>
    </a>
    <a class='itemsocial' href='javascript:void(0)' id='pinterest-btn'>
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['green']; ?> TT's <br>(<?php echo $colors['percentageGreen']; ?>%)</span>
            <span class='texto'>TT's cerrados de la semana (<?php echo $colors['green']; ?> en total)</span>
        </span>
    </a>
</div>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/datatable.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/demo_table_jui.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/uploadfile.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/leyenda.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.dataTables.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.uploadfile.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modules/etts.ajax.js',CClientScript::POS_END); ?>
<?php if ($tipoUsuario === "C"): ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/dtable.carriers.js',CClientScript::POS_END); ?>
<?php else: ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/dtable.etelix.js',CClientScript::POS_END); ?>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>
