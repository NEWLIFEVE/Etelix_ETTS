<?php
/* @var $this TicketController */
?>
<!--<textarea name="pp" id="pp"></textarea>-->
<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
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
                    <th id="th-color" class="hidden">color</th>
                    <th id="th-preview">&nbsp;</th>
		</tr> 
	</thead>
        <thead>
            <tr class="test-select">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <?php if ($tipoUsuario !== "C"): ?>
                <th></th>
                <th></th>
                <th></th>
                <?php endif;  ?>
            </tr>
        </thead>
	<tbody>
                <?php foreach (Ticket::ticketsByUsers(Yii::app()->user->id, false) as $ticket): ?>
                    <tr <?php
                            $timeTicket = Utility::getTime($ticket->date, $ticket->hour);
                            $read=DescriptionticketController::blinkTr($ticket->id);
                            $carrier=Carrier::getCarriers(true, $ticket->id);
                            switch ($ticket->idStatus->id) {
                                case '1':
                                    // Tickes a partir de las 6:00am
                                    if ($timeTicket <= 64800) {
                                        $color = 'only-white';
                                        echo 'class="open today '.$read.'"'; 
                                    // Tickets de antes de las 6:00am hasta 6:00am del dia anterior
                                    } elseif ($timeTicket > 64800 && $timeTicket <= 151200) {
                                        $color = 'only-yellow';
                                        echo 'class="open yesterday '.$read.'"'; 
                                    } else {
                                        $color = 'only-red';
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
                            <td <?php echo strlen($carrier) <= 9 ? '' : 'title="'.$carrier.'"'; ?> >
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
                        <td class="hidden"><?php echo $color; ?></td>
                        <td><a href="javascript:void(0)" class="preview" rel="<?php echo $ticket->id; ?>"><img width="12" height="12" src="<?php echo Yii::app()->request->baseUrl.'/images/view.gif'; ?>"></a></td>
                    </tr>
                <?php endforeach; ?>
	</tbody>
</table>
</div>
<div class='botones-sociales izquierda hidden-phone hidden-tablet'>
    <a class='itemsocial' href='javascript:void(0)' id='youtube-btn' rel="">
        <span class='social'>
            <span class="total-tickets">Default</span>
            <span class="texto">view all TT's</span>
        </span>
    </a>
    <a class='itemsocial' href='javascript:void(0)' id='facebook-btn' rel="only-white">
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['white']; ?> TT's <br>(<?php echo $colors['percentageWhite']; ?>%)</span>
            <span class='texto'>TT's within 24 hours (<?php echo $colors['white']; ?> total)</span>
        </span>
    </a>
    <a class='itemsocial' href='javascript:void(0)'id='twitter-btn' rel="only-yellow">
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['yellow']; ?> TT's <br>(<?php echo $colors['percentageYellow']; ?>%)</span>
            <span class='texto'>TT's within 48 hours (<?php echo $colors['yellow']; ?> total)</span>
        </span>
    </a>
    <a class='itemsocial' href='javascript:void(0)' id='google-btn' rel="only-red">
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['red']; ?> TT's <br>(<?php echo $colors['percentageRed']; ?>%)</span>
            <span class='texto'>TT's with more than 48 hours (<?php echo $colors['red']; ?> total)</span>
        </span>
    </a>
    <a class='itemsocial' href='javascript:void(0)' id='pinterest-btn' rel="only-green">
        <span class='social'>
            <span class="total-tickets"><?php echo $colors['green']; ?> TT's <br>(<?php echo $colors['percentageGreen']; ?>%)</span>
            <span class='texto'>TT's closed last 14 days (<?php echo $colors['green']; ?> total)</span>
        </span>
    </a>
</div>
<div class="reportes-laterales derecha">
    <a class='itemreporte' href='javascript:void(0)' id='print-btn' rel="/site/print">
        <span class='reporte'>
            <span class="text-visible">Print</span>
        </span>
    </a>
    
    <a class='itemreporte' href='javascript:void(0)' id='excel-btn' rel="/site/excel">
        <span class='reporte'>
            <span class="text-visible">Excel</span>
        </span>
    </a>
    
    <a class='itemreporte' href='javascript:void(0)' id='mail-btn' rel="/site/mail">
        <span class='reporte'>
            <span class="text-visible">Mail</span>
        </span>
    </a>
</div>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/datatable.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/demo_table_jui.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/uploadfile.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/leyenda.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/TableTools.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.dataTables.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/ZeroClipboard.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/TableTools.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.uploadfile.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modules/etts.ajax.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modules/etts.reports.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>
<?php if ($tipoUsuario === "C"): ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/dtable.carriers.js',CClientScript::POS_END); ?>
<?php else: ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/dtable.etelix.js',CClientScript::POS_END); ?>
<?php endif; ?>
