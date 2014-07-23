<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Export extends TicketDesign
{
    /**
     * El css de los th
     * @var string
     */
    private $_cssTh;
    
    /**
     * El css de la tabla
     * @var string
     */
    private $_cssTable;
    
    public function __construct() 
    {
        $this->_cssTh = 'style="color:#FFF; font-size: 0.8em; background: #2E62B4; border-bottom: 1px solid #d3d3d3 !important; padding: 3px !important; margin: 0 !important; text-align: center; font-weight: normal; ';
        $this->_cssTable = 'border="0" cellspacing="0" align="center width="100%"';
    }
    
    /**
     * Tabla de los tickets
     * @param arrray $ids El id's de los tickets
     * @param string $date La fecha para establecer la búsqueda de los tickets
     * @param int $idUser Id del usuario
     * @return string
     */
    public function table($ids, $date = false, $idUser = false)
    {
        if (!is_array($ids)) {
            $ids = explode (",", $ids);
        }
        $data = $this->_getData($ids, $date);
        $table = null;
        if (count($data)) {
            $table = '<table ' . $this->_cssTable . '>' . 
                    $this->_thead($idUser) .
                    $this->_contentTable($data, $idUser) .
                    '</table>';
        }
        return $table;
    }
    
    /**
     * Tabla del resumen de los tickets
     * @param string $carrier Si es supplier, customer o ambos
     * @param string $date La fecha para buscar los tickets
     * @return string
     */
    public function tableSummary($carrier = 'both', $date = false)
    {
        Yii::import('webroot.protected.components.reports.Report');
        $report = new Report;
        if ($date === false) {
            $date = date('Y-m-d H:i:s');
        } else {
            $date = $date;
        }
        
        // $k es el conteo de carriers
        $k = $report->countCarriers($date, $carrier);
        $intervals = $report->setIntervalDays(array('date' => $date, 'carrier' => $carrier));
       
        $th = 'style="padding:3px 7px; background: #e6e6e6;color:#555;border: 1px solid #d3d3d3; font-weight: normal;"';
        $white = 'style="background: #FFF; padding:3px 7px;"';
        $white2 = 'style="background: #FFF; padding:3px 7px; border-top: 1px solid silver; border-left: 1px solid silver; border-right: 1px solid silver;"';
        $yellow = 'style="background: #FFDC51; padding:3px 7px;"';
        $red = 'style="background: #EEB8B8; padding:3px 7px;"';
        $without = 'style="background: #d3d3d3; padding:3px 7px; border-bottom: 10px solid #16499a;"';
        
        $caption = "<table width='50%' border='0' align='left' cellspacing='0'>
                        <caption>Caption</caption>
                        <tr>
                            <td $white2 >TT's within 24 hours</td>
                        </tr>
                        <tr>
                            <td $yellow >TT's within 48 hours</td>
                        </tr>
                        <tr>
                            <td $red >TT's with more than 48 hours</td>
                        </tr>
                    </table><div style='clear:left;'></div><br><br>";
        
        $table = '<table width="100%" border="0" cellspacing="0">';
            $table .= '<caption>Ticket Summary '.$date.'</caption>';
            $table .= '<thead>'
                        . '<tr>'
                            . '<th '.$th.'>Category</th>'
                            . '<th '.$th.'>Supplier</th>'
                            . '<th '.$th.'>Customer</th>'
                            . '<th '.$th.'>Total</th>'
                            . '<th '.$th.'></th>'
                            . '<th '.$th.'>Previous Day</th>'
                            . '<th '.$th.'></th>'
                            . '<th '.$th.'>A Week Ago</th>'
                        . '</tr>'
                    . '</thead>';
            $table .= '<tbody>'
                        . '<tr>'
                            . '<td '.$white.'>Open white within 24 hours</td>'
                            . '<td '.$white.'>' . $k[0][0] . '</td>'
                            . '<td '.$white.'>' . $k[0][1] . '</td>'
                            . '<td '.$white.'>' . $temp1 = count($report->openOrClose($date, 'white', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$white.'>' . $report->arrow($temp1, $intervals['wo1Day']) . '</td>'
                            . '<td '.$white.'>' . $intervals['wo1Day'] . '</td>'
                            . '<td '.$white.'>' . $report->arrow($temp1, $intervals['wo1Week']) . '</td>'
                            . '<td '.$white.'>' . $intervals['wo1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>Open yellow within 48 hours</td>'
                            . '<td '.$yellow.'>' . $k[1][0] . '</td>'
                            . '<td '.$yellow.'>' . $k[1][1] . '</td>'
                            . '<td '.$yellow.'>' . $temp1 = count($report->openOrClose($date, 'yellow', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['yo1Day']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['yo1Day'] . '</td>'
                            . '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['yo1Week']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['yo1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>Open red with more than 48 hours</td>'
                            . '<td '.$red.'>' . $k[2][0] . '</td>'
                            . '<td '.$red.'>' . $k[2][1] . '</td>'
                            . '<td '.$red.'>' . $temp1 = count($report->openOrClose($date, 'red', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$red.'>' . $report->arrow($temp1, $intervals['ro1Day']) . '</td>'
                            . '<td '.$red.'>' . $intervals['ro1Day'] . '</td>'
                            . '<td '.$red.'>' . $report->arrow($temp1, $intervals['ro1Week']) . '</td>'
                            . '<td '.$red.'>' . $intervals['ro1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total open today</td>'
                            . '<td '.$without.'>' . ($k[0][0]+$k[1][0]+$k[2][0]) . '</td>'
                            . '<td '.$without.'>' . ($k[0][1]+$k[1][1]+$k[2][1]) . '</td>'
                            . '<td '.$without.'>' . $temp1 = count($report->totalTicketsPending($date, $carrier)) . '</td>';
                            $table .= '<td '.$without.'>' . $report->arrow($temp1, $intervals['to1Day']) . '</td>'
                            . '<td '.$without.'>' . $intervals['to1Day'] . '</td>'
                            . '<td '.$without.'>' . $report->arrow($temp1, $intervals['to1Week']) . '</td>'
                            . '<td '.$without.'>' . $intervals['to1Week'] . '</td>'
                        . '</tr>'
                    
                        . '<tr>'
                            . '<td '.$white.'>Closed white today</td>'
                            . '<td '.$white.'>' . $k[3][0] . '</td>'
                            . '<td '.$white.'>' . $k[3][1] . '</td>'
                            . '<td '.$white.'>' . $temp1 = count($report->openOrClose($date, 'white', 'close', $carrier)) . '</td>';
                            $table .= '<td '.$white.'>' . $report->arrow($temp1, $intervals['wc1Day']) . '</td>'
                            . '<td '.$white.'>' . $intervals['wc1Day'] . '</td>'
                            . '<td '.$white.'>' . $report->arrow($temp1, $intervals['wc1Week']) . '</td>'
                            . '<td '.$white.'>' . $intervals['wc1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>Closed yellow today</td>'
                            . '<td '.$yellow.'>' . $k[4][0] . '</td>'
                            . '<td '.$yellow.'>' . $k[4][1] . '</td>'
                            . '<td '.$yellow.'>' . $temp1 = count($report->openOrClose($date, 'yellow', 'close', $carrier)) . '</td>';
                            $table .= '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['yc1Day']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['yc1Day'] . '</td>'
                            . '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['yc1Week']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['yc1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>Closed red today</td>'
                            . '<td '.$red.'>' . $k[5][0] .'</td>'
                            . '<td '.$red.'>' . $k[5][1] .'</td>'
                            . '<td '.$red.'>' . $temp1 = count($report->openOrClose($date, 'red', 'close', $carrier)) . '</td>';
                            $table .= '<td '.$red.'>' . $report->arrow($temp1, $intervals['rc1Day']) . '</td>'
                            . '<td '.$red.'>' . $intervals['rc1Day'] . '</td>'
                            . '<td '.$red.'>' . $report->arrow($temp1, $intervals['rc1Week']) . '</td>'
                            . '<td '.$red.'>' . $intervals['rc1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total closed today</td>'
                            . '<td '.$without.'>' . ($k[3][0]+$k[4][0]+$k[5][0]) .'</td>'
                            . '<td '.$without.'>' . ($k[3][1]+$k[4][1]+$k[5][1]) .'</td>'
                            . '<td '.$without.'>' . $temp1 = count($report->totalTicketsClosed($date, $carrier)) . '</td>';
                            $table .= '<td '.$without.'>' . $report->arrow($temp1, $intervals['tc1Day']) . '</td>'
                            . '<td '.$without.'>' . $intervals['tc1Day'] . '</td>'
                            . '<td '.$without.'>' . $report->arrow($temp1, $intervals['tc1Week']) . '</td>'
                            . '<td '.$without.'>' . $intervals['tc1Week'] . '</td>'
                        . '</tr>'
                    
                        . '<tr>'
                            . '<td '.$white.'>No activity white today</td>'
                            . '<td '.$white.'>' . $k[6][0] .'</td>'
                            . '<td '.$white.'>' . $k[6][1] .'</td>'
                            . '<td '.$white.'>' . $temp1 = count($report->withoutDescription($date, 'white', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$white.'>' . $report->arrow($temp1, $intervals['naW1Day']) . '</td>'
                            . '<td '.$white.'>' . $intervals['naW1Day'] . '</td>'
                            . '<td '.$white.'>' . $report->arrow($temp1, $intervals['naW1Week']) . '</td>'
                            . '<td '.$white.'>' . $intervals['naW1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>No activity yellow today</td>'
                            . '<td '.$yellow.'>' . $k[7][0] . '</td>'
                            . '<td '.$yellow.'>' . $k[7][1] . '</td>'
                            . '<td '.$yellow.'>' . $temp1 = count($report->withoutDescription($date, 'yellow', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['naY1Day']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['naY1Day'] . '</td>'
                            . '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['naY1Week']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['naY1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>No activity red today</td>'
                            . '<td '.$red.'>' . $k[8][0] . '</td>'
                            . '<td '.$red.'>' . $k[8][1] . '</td>'
                            . '<td '.$red.'>' . $temp1 = count($report->withoutDescription($date, 'red', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$red.'>' . $report->arrow($temp1, $intervals['naR1Day']) . '</td>'
                            . '<td '.$red.'>' . $intervals['naR1Day'] . '</td>'
                            . '<td '.$red.'>' . $report->arrow($temp1, $intervals['naR1Week']) . '</td>'
                            . '<td '.$red.'>' . $intervals['naR1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total no activity today</td>'
                            . '<td '.$without.'>' . ($k[6][0]+$k[7][0]+$k[8][0]) . '</td>'
                            . '<td '.$without.'>' . ($k[6][1]+$k[7][1]+$k[8][1]) . '</td>'
                            . '<td '.$without.'>' . $temp1 = count($report->totalWithoutDescription($date, $carrier)) . '</td>';
                            $table .= '<td '.$without.'>' . $report->arrow($temp1, $intervals['tna1Day']) . '</td>'
                            . '<td '.$without.'>' . $intervals['tna1Day'] . '</td>'
                            . '<td '.$without.'>' . $report->arrow($temp1, $intervals['tna1Week']) . '</td>'
                            . '<td '.$without.'>' . $intervals['tna1Week'] . '</td>'
                        . '</tr>'
                    
                        . '<tr>'
                            . '<td '.$white.'>Escalated white today</td>'
                            . '<td '.$white.'>' . $k[9][0] . '</td>'
                            . '<td '.$white.'>' . $k[9][1] . '</td>'
                            . '<td '.$white.'>' . $temp1 = count($report->ticketEscaladed($date, 'white', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$white.'>' . $report->arrow($temp1, $intervals['eW1Day']) . '</td>'
                            . '<td '.$white.'>' . $intervals['eW1Day'] . '</td>'
                            . '<td '.$white.'>' . $report->arrow($temp1, $intervals['eW1Week']) . '</td>'
                            . '<td '.$white.'>' . $intervals['eW1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>Escalated yellow today</td>'
                            . '<td '.$yellow.'>' . $k[10][0] . '</td>'
                            . '<td '.$yellow.'>' . $k[10][1] . '</td>'
                            . '<td '.$yellow.'>' . $temp1 = count($report->ticketEscaladed($date, 'yellow', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['eY1Day']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['eY1Day'] . '</td>'
                            . '<td '.$yellow.'>' . $report->arrow($temp1, $intervals['eY1Week']) . '</td>'
                            . '<td '.$yellow.'>' . $intervals['eY1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>Escalated red today</td>'
                            . '<td '.$red.'>' . $k[11][0] . '</td>'
                            . '<td '.$red.'>' . $k[11][1] . '</td>'
                            . '<td '.$red.'>' . $temp1 = count($report->ticketEscaladed($date, 'red', 'open', $carrier)) . '</td>';
                            $table .= '<td '.$red.'>' . $report->arrow($temp1, $intervals['eR1Day']) . '</td>'
                            . '<td '.$red.'>' . $intervals['eR1Day'] . '</td>'
                            . '<td '.$red.'>' . $report->arrow($temp1, $intervals['eR1Week']) . '</td>'
                            . '<td '.$red.'>' . $intervals['eR1Week'] . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total Escalated today</td>'
                            . '<td '.$without.'>' . ($k[9][0]+$k[10][0]+$k[11][0]) . '</td>'
                            . '<td '.$without.'>' . ($k[9][1]+$k[10][1]+$k[11][1]) . '</td>'
                            . '<td '.$without.'>' . $temp1 = count($report->totalTicketEscaladed($date, $carrier)) . '</td>';
                            $table .= '<td '.$without.'>' . $report->arrow($temp1, $intervals['eR1Week']) . '</td>'
                            . '<td '.$without.'>' . $intervals['eR1Week'] . '</td>'
                            . '<td '.$without.'>' . $report->arrow($temp1, $intervals['te1Week']) . '</td>'
                            . '<td '.$without.'>' . $intervals['te1Week'] . '</td>'
                        . '</tr>'
                    . '</tbody>';
        $table .= '</table>';
        
        return $caption . $table;
    }
    
    /**
     * Contenido de la tabla
     * @param array $data La data del ticket
     * @param int $idUser El id del usuario
     * @return string
     */
    private function _contentTable($data, $idUser = false) 
    {
        $contentTable = '<tbody>';
        foreach ($data as $tickets) {
            $contentTable .= '<tr>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . ' >' . Utility::formatTicketNumber($tickets->ticket_number) . '</td>';
                $contentTable .= $this->_defineUserOrCarrier($tickets, $idUser);
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' . $tickets->ticket_number . '</td>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' . $tickets->idFailure->name . '</td>';
                if (TestedNumber::getNumber($tickets->id) != false) $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' . TestedNumber::getNumber($tickets->id)->idCountry->name . '</td>';
                else $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>&nbsp;</td>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' . $tickets->date . ' / ' . $tickets->hour . '</td>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' . $tickets->lifetime . '</td>';
            $contentTable .= '</tr>';
        }
        return  $contentTable . '</tbody>';
    }
    
    /**
     * Retorna el carrier o el username dependiento de option_open
     * @param array $tickets La data de los tickets
     * @param int $idUser El id del usuario
     * @return string
     */
    private function _defineUserOrCarrier($tickets, $idUser = false)
    {
        $contentTable = '';
        if (CrugeAuthassignment::getRoleUser(false, $idUser) != 'C') {
            if ($tickets->option_open == 'etelix_to_carrier') {
               if (isset($tickets->idUser->username)) $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' . $tickets->idUser->username . '</td>';
            } else {
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' .  Carrier::getCarriers(true, $tickets->id) . '</td>';
            }
            $contentTable .= '<td ' . $this->_cssTickets($tickets->color, $tickets->id_status) . '>' . Carrier::getCarriers(true, $tickets->id) . '</td>';
        }
        return $contentTable;
    }


    /**
     * Consulta sql para obtner los tickets dependiendo de los ids que se pasen como parametro
     * @param array $ids El id's de los ticket
     * @param strign $date La fecha para buscar los tickets
     * @return array
     */
    private function _getData($ids, $date = false)
    {
        $currentTime = "(to_char(NOW(), 'YYYY-MM-DD') || ' ' || to_char(NOW(), 'HH24:MI:SS'))::timestamp";
        $createTicket = "(date::text || ' ' || hour::text)::timestamp";
        
        if ($date) {
            $colorAndLifeTime = "(CASE WHEN lifetime < '1 days'::interval THEN 'white' 
                                WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN 'yellow'
                                WHEN lifetime >= '2 days'::interval THEN 'red' END) AS color  
                                FROM (
                                SELECT *,
                                (CASE WHEN (date::text || ' ' || hour::text)::timestamp <= '$date' THEN 
                                age('$date', (date::text || ' ' || hour::text)::timestamp) ELSE
                                age((date::text || ' ' || hour::text)::timestamp, '$date' ) END) AS lifetime";
        } 
        else {
            $colorAndLifeTime = "(CASE WHEN id_status = 1 THEN
                                    CASE WHEN lifetime < '1 days'::interval THEN 'white' 
                                    WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN 'yellow'
                                    WHEN lifetime >= '2 days'::interval THEN 'red' END
                                  WHEN id_status = 2 THEN 'green' WHEN id_status = 3 THEN 'gray' END) AS color
                                FROM (SELECT *, (
                                CASE WHEN id_status = 1 OR id_status = 3 THEN
                                    (CASE WHEN $createTicket <= $currentTime THEN 
                                    age($currentTime, $createTicket) ELSE
                                    age($createTicket, $currentTime) END) 
                                ELSE
                                    age(close_ticket::timestamp, $createTicket) END) AS lifetime";
        }
        
        $sql = "SELECT *,
                $colorAndLifeTime, 
                (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' 
				THEN 'Supplier' 
			WHEN ticket_number LIKE '%C%' 
				THEN 'Customer' 
			END
                ) AS carrier
                FROM ticket
                WHERE id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) AND
                id IN(" . implode(",", $ids) . ")
                ) AS consulta ORDER BY color ASC, carrier ASC";
        return Ticket::model()->findAllBySql($sql);
    }
    
    /**
     * Retorna el thead de la tabla
     * @param int $idUser Id del usuario
     * @return string
     */
    private function _thead($idUser = false)
    {
        $thead = '<thead><tr>';
        if (CrugeAuthassignment::getRoleUser(false, $idUser) === 'C') {
            $thead .= '<th ' . $this->_cssTh . ' width:10%;" >Type</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:30%;" >Ticket Number</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:15%;" >Failure</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:15%;" >Country</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:15%;" >Created</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:15%;" >Lifetime</th>';
        } else {
            $thead .= '<th ' . $this->_cssTh . ' width:10%;" >Type</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3;width:10%;" >User</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:10%;" >Carrier</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:20%;" >Ticket Number</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:10%;" >Failure</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:10%;" >Country</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:10%;" >Created</th>';
            $thead .= '<th ' . $this->_cssTh . ' border-left:1px solid #d3d3d3; width:20%;" >Lifetime</th>';
        }
        $thead .= '</tr></thead>';
        return $thead;
    }
    
    /**
     * Retorna el color del ticket dependiendo del tiempo y el status
     * @param string $color El color del ticket
     * @param int $status El status del ticket
     * @return string
     */
    private function _cssTickets($color, $status = false)
    {
        $bold = '#5A5A5A';
        if ($status) {
            if ($status == 3) {
                $bold = '#000';
            } else {
                $bold = '#5A5A5A';
            }
        }
        
        $style = 'style="padding: 3px !important; margin: 0 !important; text-align: center; color:'.$bold.'; font-size:0.88em; background:';
        switch ($color) {
            case 'white': $style .= '#FFF;"'; break;
            case 'yellow': $style .= '#FFDC51;"'; break;
            case 'red': $style .= '#EEB8B8;"'; break;
            case 'green': $style .= '#61CF61;"'; break;
            case 'gray': $style .= '#D0DEEE;"'; break;
            default: $style .= '#FDFFDF;"'; break;
        }
        return $style;
    }
    
    /**
     * Muestra la vista de impresión del ticket
     * @param array $key Key es un arreglo con toda la data del ticket, es decir, sus atributos
     * @param string $optionalInformation Información opcional que se mostrará en la vista de impresión 
     * @return string
     */
    public function printTicket($key, $optionalInformation = false)
    {
        parent::__construct($key);
        return $this->_getDetailTicket($optionalInformation);
    }
    
}
