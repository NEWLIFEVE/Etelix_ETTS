<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Export extends TicketDesign
{
    private $_cssTh;
    private $_cssTable;
    
    public function __construct() 
    {
        $this->_cssTh = 'style="color:#FFF; font-size: 0.8em; background: #2E62B4; border-bottom: 1px solid #d3d3d3 !important; padding: 3px !important; margin: 0 !important; text-align: center; font-weight: normal; ';
        $this->_cssTable = 'border="0" cellspacing="0" align="center width="100%"';
    }
    
    /**
     * Tabla de los tickets
     * @param arrray $ids
     * @return string
     */
    public function table($ids, $date = false)
    {
        if (!is_array($ids)) {
            $ids = explode (",", $ids);
        }
        $data = $this->_getData($ids, $date);
        $table = null;
        if (count($data)) {
            $table = '<table ' . $this->_cssTable . '>' . 
                    $this->_thead() .
                    $this->_contentTable($data) .
                    '</table>';
        }
        return $table;
    }
    
    /**
     * Tabla del resumen de los tickets
     * @param string $carrier
     * @param string $date
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
                            . '<th '.$th.'>Total</th>'
                        . '</tr>'
                    . '</thead>';
            $table .= '<tbody>'
                        . '<tr>'
                            . '<td '.$white.'>Open white</td>'
                            . '<td '.$white.'>' . count($report->openOrClose($date, 'white', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>Open yellow</td>'
                            . '<td '.$yellow.'>' . count($report->openOrClose($date, 'yellow', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>Open red</td>'
                            . '<td '.$red.'>' . count($report->openOrClose($date, 'red', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total open</td>'
                            . '<td '.$without.'>' . count($report->totalTicketsPending($date, $carrier)) . '</td>'
                        . '</tr>'
                    
                        . '<tr>'
                            . '<td '.$white.'>Closed white</td>'
                            . '<td '.$white.'>' . count($report->openOrClose($date, 'white', 'close', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>Closed yellow</td>'
                            . '<td '.$yellow.'>' . count($report->openOrClose($date, 'yellow', 'close', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>Closed red</td>'
                            . '<td '.$red.'>' . count($report->openOrClose($date, 'red', 'close', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total closed</td>'
                            . '<td '.$without.'>' . count($report->totalTicketsClosed($date, $carrier)) . '</td>'
                        . '</tr>'
                    
                        . '<tr>'
                            . '<td '.$white.'>No activity white</td>'
                            . '<td '.$white.'>' . count($report->withoutDescription($date, 'white', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>No activity yellow</td>'
                            . '<td '.$yellow.'>' . count($report->withoutDescription($date, 'yellow', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>No activity red</td>'
                            . '<td '.$red.'>' . count($report->withoutDescription($date, 'red', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total no activity</td>'
                            . '<td '.$without.'>' . count($report->totalWithoutDescription($date, $carrier)) . '</td>'
                        . '</tr>'
                    
                        . '<tr>'
                            . '<td '.$white.'>Escalated white</td>'
                            . '<td '.$white.'>' . count($report->ticketEscaladed($date, 'white', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$yellow.'>Escalated yellow</td>'
                            . '<td '.$yellow.'>' . count($report->ticketEscaladed($date, 'yellow', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$red.'>Escalated red</td>'
                            . '<td '.$red.'>' . count($report->ticketEscaladed($date, 'red', 'open', $carrier)) . '</td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td '.$without.'>Total Escalated</td>'
                            . '<td '.$without.'>' . count($report->totalTicketEscaladed($date, $carrier)) . '</td>'
                        . '</tr>'
                    . '</tbody>';
        $table .= '</table>';
        
        return $caption . $table;
    }
    
    /**
     * Contenido de la tabla
     * @param array $data
     * @return string
     */
    private function _contentTable($data) 
    {
        $contentTable = '<tbody>';
        foreach ($data as $tickets) {
            $contentTable .= '<tr>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . ' >' . Utility::formatTicketNumber($tickets->ticket_number) . '</td>';
                $contentTable .= $this->_defineUserOrCarrier($tickets);
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' . $tickets->ticket_number . '</td>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' . $tickets->idFailure->name . '</td>';
                if (TestedNumber::getNumber($tickets->id) != false) $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' . TestedNumber::getNumber($tickets->id)->idCountry->name . '</td>';
                else $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>&nbsp;</td>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' . $tickets->date . ' / ' . $tickets->hour . '</td>';
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' . $tickets->lifetime . '</td>';
            $contentTable .= '</tr>';
        }
        return  $contentTable . '</tbody>';
    }
    
    /**
     * Retorna el carrier o el username dependiento de option_open
     * @param array $tickets
     * @return string
     */
    private function _defineUserOrCarrier($tickets)
    {
        $contentTable = '';
        if (CrugeAuthassignment::getRoleUser() != 'C') {
            if ($tickets->option_open == 'etelix_to_carrier') {
               if (isset($tickets->idUser->username)) $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' . $tickets->idUser->username . '</td>';
            } else {
                $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' .  Carrier::getCarriers(true, $tickets->id) . '</td>';
            }
            $contentTable .= '<td ' . $this->_cssTickets($tickets->color) . '>' . Carrier::getCarriers(true, $tickets->id) . '</td>';
        }
        return $contentTable;
    }


    /**
     * Consulta sql para obtner los tickets dependiendo de los ids que se pasen como parametro
     * @param array $ids
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
                $colorAndLifeTime
                FROM ticket
                WHERE id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) AND
                id IN(" . implode(",", $ids) . ")
                ORDER BY id_status, date, hour ASC) AS consulta";
        return Ticket::model()->findAllBySql($sql);
    }
    
    /**
     * Retorna el thead de la tabla
     * @return string
     */
    private function _thead()
    {
        $thead = '<thead><tr>';
        if (CrugeAuthassignment::getRoleUser() === 'C') {
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
     * @param string $color
     * @return string
     */
    private function _cssTickets($color)
    {
        $style = 'style="padding: 3px !important; margin: 0 !important; text-align: center; color:#5A5A5A; font-size:0.88em; background:';
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
    
    public function printTicket($key, $optionalInformation = false)
    {
        parent::__construct($key);
        return $this->_getDetailTicket($optionalInformation);
    }
    
}
