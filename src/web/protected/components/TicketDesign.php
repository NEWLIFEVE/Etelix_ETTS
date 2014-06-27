<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TicketDesign
 *
 * @author nelson
 */
class TicketDesign 
{
    // Propiedades de la informacion del correo
    protected $_properties;
    // Estilos css
    private $_th;
    private $_td;
    
    /**
     * El constructor recibe el detalle del ticket
     * @param array $key
     */
    public function __construct($key = false)
    {
        if ($key) {
            $this->_properties = $key;
            $this->_th = 'colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;"';
            $this->_td = 'colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;"';    
        }
    }
    
    
    
    /**
     * Retorna el chat asociado a un ticket
     * @param integer $idTicket
     * @return string
     */
    protected function _getChat($idTicket = false)
    {
        if (!$idTicket) $idTicket = $this->_properties['idTicket'];
        
        if (!empty($idTicket))
        {
            $description=DescriptionTicket::getDescription($idTicket);
            $chat = '<div>';
            foreach ($description as $value) {
                if($value->idUser !==null){
                    $usuario=CrugeAuthassignment::getRoleUser(false, $value->id_user);
                    $usuarioAmostrar='By '.$value->idUser->username.' (by Etelix) on ETTS';
                    if (($usuario == 'I' || $usuario == 'C' || $usuario == 'A' || $usuario == 'S') && $value->id_user != $value->response_by) {
                        $style='float: left; color: #3e454c; background: white;';
                    }

                    if ($usuario == 'C' && $value->id_user == $value->response_by) {
                        $style='float: left; color: #3e454c; background: rgba(196, 191, 191, 0.5);';
                        $usuarioAmostrar='By '.$value->idUser->username.' on ETTS';
                    }

                    if ($usuario != 'C' && $value->id_user == $value->response_by) {
                        $style='float: right; color: #fff; background: #6badf6;';
                    }

                    $chat .= '<div style="border: 1px solid #dfdfdf;
                                        border: 1px solid rgba(0, 0, 0, .18);
                                        border-bottom-color: rgba(0, 0, 0, .29);
                                        -webkit-box-shadow: 0 1px 0 #dce0e6;
                                        line-height: 1.28;
                                        margin: 5px 5px 8px 0;
                                        min-height: 14px;
                                        padding: 4px 5px 3px 6px;
                                        position: relative;
                                        text-align: left;
                                        white-space: pre-wrap;
                                        word-wrap: break-word;
                                        min-width: 20%;
                                        max-width: 100%;
                                        clear: both; '.$style.'">' . 
                            $value->description . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong>User: </strong>' . $usuarioAmostrar .  
                         '</div>';   
                } 
            }
            $chat .= '</div>';
            return $chat;
        }
        return '';
    }
    
    
    /**
     * Retorna las fallas
     * @return string
     */
    private function _getFailure()
    {
        if (!empty($this->_properties['failure']))
        {
            return '<tr>
                        <th '.$this->_th.'>Failure</th>
                    </tr>
                    <tr>
                        <td '.$this->_td.'>'.$this->_properties['failure'].'</td>
                    </tr>';
        }
        return '';
    }
    
    /**
     * Retorna los correos
     * @param string $title
     * @return string
     */
    private function _getEmails($title)
    {
        if (!empty($this->_properties['emails']))
        {
            return '<tr>
                        <th '.$this->_th.'>'.$title.'</th>
                    </tr>
                    <tr>
                        <td '.$this->_td.'>'. implode('<br>', $this->_properties['emails']) .'</td>
                    </tr>';
        }
        return '';
    }
    
    /**
     * Retorna el o los cc
     * @return string
     */
    private function _getCc()
    {
        if(is_array($this->_properties['cc']))
        { 
            return '<tr>
                        <th '.$this->_th.'>CC</th>
                    </tr>
                    <tr>
                        <td '.$this->_td.'>'. implode('<br>', $this->_properties['cc']) .'</td>
                    </tr>';
        }
        return '';
    }
    
    /**
     * Retorna el o los bcc
     * @return string
     */
    private function _getBcc()
    {
        if(is_array($this->_properties['bcc']))
        {
            return '<tr>
                        <th '.$this->_th.'>BCC</th>
                    </tr>
                    <tr>
                        <td '.$this->_td.'>'. implode('<br>', $this->_properties['bcc']) .'</td>
                    </tr>';
        }
        return '';
    }
    

    /**
     * Retorna origination ip y destination ip
     * @return string
     */
    private function _getIp()
    {
        if (!empty($this->_properties['originationIp']) || !empty($this->_properties['destinationIp']))
        {
            return '<tr>
                        <th colspan="1" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Origination IP</th>
                        <th colspan="3" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Destination IP</th>
                    </tr>
                    <tr>
                        <td colspan="1" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_properties['originationIp'].'</td>
                        <td colspan="3" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_properties['destinationIp'].'</td>
                    </tr>';
        }
        return '';
    }
    
    /**
     * Retorna el prefijo
     * @return string
     */
    private function _getPrefix()
    {
        if (!empty($this->_properties['prefix']))
        {
            return '<tr>
                        <th '.$this->_th.'>Prefix</th>
                    </tr>
                    <tr>
                        <td '.$this->_td.'>'.$this->_properties['prefix'].'</td>
                    </tr>';
        }
        return '';
    }
    
    /**
     * Retorna el gmt
     * @return string
     */
    private function _getGmt()
    {
        if (!empty($this->_properties['gmt']))
        {
            return '<tr>
                        <th '.$this->_th.'>GMT</th>
                    </tr>
                    <tr>
                        <td '.$this->_td.'>'.$this->_properties['gmt'].'</td>
                    </tr>';
        }
        return '';
    }
    
    /**
     * Retorna el númerp, pais, fecha y hora
     * @return string
     */
    private function _getTestedNumber()
    {
        if (!empty($this->_properties['testedNumber']))
        {
            return '<tr>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Tested number</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Country</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Date</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Hour</th>
                    </tr>
                    <tr>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_properties['testedNumber']) .'</td>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_properties['country']) .'</td>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_properties['date']) .'</td>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_properties['hour']) .'</td>
                    </tr>';
        }
        return '';
    }
    
    /**
     * Obtener la descripción del ticket
     * @return string
     */
    private function _getDescription()
    {
        if (!empty($this->_properties['description']))
        {
            return '<tr>
                        <th '.$this->_th.'>Description</th>
                    </tr>
                    <tr>
                        <td '.$this->_td.'>'.$this->_getChat().'</td>
                    </tr>';
        }
        return '';
    }

    /**
     * Retorna el detalle del ticket
     * @return string
     */
    protected function _getDetailTicket($optionalInformation = false)
    {
        $date = Ticket::model()->findByPk($this->_properties['idTicket'])->date;
        $hour = Ticket::model()->findByPk($this->_properties['idTicket'])->hour;
        
        if ($optionalInformation) $information = 'Ticket #: ' . $this->_properties['ticketNumber'] . ' Created on ' . Utility::getDayByDate($date) . ' at ' . $hour;
        else $information = '';
                
        return '<h2>Ticket Details</h2>
               ' . $information . '
               <table style="border-spacing: 0; width:100%; border: solid #ccc 1px;">' . 
                $this->_getEmails('To') .
                $this->_getCc() .
                $this->_getBcc() .
                $this->_getFailure() .
                $this->_getIp() .
                $this->_getPrefix() .
                $this->_getGmt() .
                $this->_getTestedNumber() .
                $this->_getDescription() .
               '</table>';
    }
    
}
