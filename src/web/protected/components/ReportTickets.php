<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ReportTickets
{
    private $_cssTd;
    private $_cssTh;
    private $_rowThead;
    
    public function __construct() 
    {
        $this->_cssTd = 'style="padding: 3px !important; margin: 0 !important; text-align: center;"';
        $this->_cssTh = 'style="padding: 3px !important; margin: 0 !important; text-align: center; font-weight: normal; border-left:1px solid silver;"';
        $this->_rowThead = 'style="color: rgb(90, 90, 90); font-size: 0.8em; background: #e6e6e6 url(images/ui-bg_glass_75_e6e6e6_1x400.png) 50% 50% repeat-x; border-bottom: 1px solid #d3d3d3 !important; "';
    }
    
    /**
     * Tabla de los tickets
     * @param arrray $ids
     * @return string
     */
    public function table($ids)
    {
        if (!is_array($ids)) {
            $ids = explode (",", $ids);
        }
        $data = $this->_getData($ids);
        $table = null;
        if (count($data)) {
            $table = '<table border="0" cellspacing="0" align="center">' . 
                    $this->_thead() .
                    $this->_contentTable($data) .
                    '</table>';
        }
        return $table;
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
            $contentTable .= '<tr ' . $this->_backgroundTicket($tickets->color) . '>';
                $contentTable .= '<td ' . $this->_cssTd . '>' . Utility::formatTicketNumber($tickets->ticket_number) . '</td>';
                $contentTable .= $this->_defineUserOrCarrier($tickets);
                $contentTable .= '<td ' . $this->_cssTd . '>' . $tickets->ticket_number . '</td>';
                $contentTable .= '<td ' . $this->_cssTd . '>' . $tickets->idFailure->name . '</td>';
                if (TestedNumber::getNumber($tickets->id) != false) $contentTable .= '<td ' . $this->_cssTd . '>' . TestedNumber::getNumber($tickets->id)->idCountry->name . '</td>';
                else $contentTable .= '<td ' . $this->_cssTd . '>&nbsp;</td>';
                $contentTable .= '<td ' . $this->_cssTd . '>' . $tickets->date . ' / ' . $tickets->hour . '</td>';
                $contentTable .= '<td ' . $this->_cssTd . '>' . substr($tickets->lifetime, 0, -3) . '</td>';
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
               if (isset($tickets->idUser->username)) $contentTable .= '<td ' . $this->_cssTd . '>' . $tickets->idUser->username . '</td>';
            } else {
                $contentTable .= '<td ' . $this->_cssTd . '>' .  Carrier::getCarriers(true, $tickets->id) . '</td>';
            }
            $contentTable .= '<td ' . $this->_cssTd . '>' . Carrier::getCarriers(true, $tickets->id) . '</td>';
        }
        return $contentTable;
    }


    /**
     * Consulta sql para obtner los tickets dependiendo de los ids que se pasen como parametro
     * @param array $ids
     * @return array
     */
    private function _getData($ids)
    {
        $sql = "SELECT *,(
                CASE WHEN id_status = 1 THEN
                        CASE WHEN lifetime <= '12 hours'::interval THEN 'white'
                        WHEN lifetime > '12 hours'::interval AND lifetime <= '36 hours'::interval THEN 'yellow'
                        ELSE 'red' END
                ELSE 'green' END
                ) AS color
                FROM (SELECT *, (
                                 CASE WHEN id_status = 1 THEN
                                        age((to_char(NOW(), 'YYYY-MM-DD') || ' ' || to_char(NOW(), 'HH24:MI:SS'))::timestamp, (to_char(date, 'YYYY-MM-DD') || ' ' || to_char(hour, 'HH24:MI:SS'))::timestamp)
                                 ELSE
                                        age(close_ticket::timestamp, (to_char(date, 'YYYY-MM-DD') || ' ' || to_char(hour, 'HH24:MI:SS'))::timestamp)
                                 END
                        ) AS lifetime
                        FROM ticket
                        WHERE id IN (SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) AND
                        id IN(" . implode(",", $ids) . ")
                        ORDER BY id_status, id ASC
                ) AS consulta";
        return Ticket::model()->findAllBySql($sql);
    }
    
    /**
     * Retorna el thead de la tabla
     * @return string
     */
    private function _thead()
    {
        if (CrugeAuthassignment::getRoleUser() === 'C') {
            $data = array('Type', 'Ticket Number', 'Failure', 'Country', 'Created', 'Lifetime');
        } else {
            $data = array('Type', 'User', 'Carrier', 'Ticket Number', 'Failure', 'Country', 'Created', 'Lifetime');
        }
        $count = count($data);
        $thead = '<thead><tr ' . $this->_rowThead . ' >';
        for ($i = 0; $i < $count; $i++) {
            $thead .= '<th ' . $this->_cssTh . ' >' . $data[$i] . '</th>';
        }
        $thead .= '</tr></thead>';
        
        return $thead;
    }
    
    /**
     * Retorna el color del ticket dependiendo del tiempo y el status
     * @param string $color
     * @return string
     */
    private function _backgroundTicket($color)
    {
        $style = 'style="color:rgb(90, 90, 90); font-size:0.88em; background:';
        switch ($color) {
            case 'white':
                $style .= '#FFF;"';
                break;
            case 'yellow':
                $style .= '#FFDC51;"';
                break;
            case 'red':
                $style .= '#EEB8B8;"';
                break;
            case 'green':
                $style .= '#61CF61;"';
                break;
            default:
                break;
        }
        return $style;
    }
    
}
