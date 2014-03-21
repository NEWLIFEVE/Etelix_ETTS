<?php
/**
 * version 1.1.2
 * 
 * @package components
 */
class CuerpoCorreo
{
    // footer del correo
    private $_footerTT;
    private $_footerCustomer;
    private $_footerSupplier;
    // Propiedades de la informacion del correo
    private $_properties;
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
            // Footer to customer
            $this->_footerCustomer='<div style="width:100%">
                                        <p style="text-align:justify">
                                            <br/>
                                            <div style="font-style:italic;">Please do not reply to this email. Replies to this message are routed to an unmonitored mailbox.</div>
                                        </p>
                                    </div>';
            // Footer to supplier
            $this->_footerSupplier=$this->_footerCustomer;
            // Footer tt
            $this->_footerTT=$this->_footerCustomer;
            $this->_th = 'colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;"';
            $this->_td = 'colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;"';    
        }
    }
    
    /**
     * Retorna el texto que contendrá el correo cuando etelix abra, responda o cierre un ticket como 
     * el carrier
     * @param string $carrier
     * @return string
     */
    private function _ettsAsCarrier($carrier, $option, $status = false)
    {
        if ($option == 'open') {
            return 'Dear '.$carrier.':<br>
                    Thanks for using our online tool "Etelix Trouble Ticket System" (etts.etelix.com).<br>
                    Your issue has been opened with the TT Number (please see below).<br>
                    Your TT will be answered by an Etelix Analyst soon.<br>

                    Etelix NOC Team. ';
        } elseif ($option == 'close') {
            return '<div>Dear '.$carrier.':</div>
                    <br/>
                    <div>Change status: "'. $status .'"</div>
                    <br/>
                    Etelix NOC Team.';
        } elseif ($option == 'answer') {
            return '<div>Dear '.$carrier.':</div>
                    <br/>
                    <div>There is a new message related to your TT</div>
                    <br/>
                    Etelix NOC Team.';
        }
    }
    
    /**
     * Retorna el texto que contendrá el correo cuando el carrier le abra, responda o cierre un ticket
     * a etelix
     * @param string $carrier
     * @return strign
     */
    private function _carrierToEtts($carrier, $option)
    {
        return $this->_ettsAsCarrier($carrier, $option);
    }
    
    /**
     * Retorna el texto que contendrá el correo cuando etelix le abra, responda o cierre un ticket 
     * al carrier
     * @param string $carrier
     * @return string
     */
    private function _ettsToCarrier($carrier, $option, $status = false)
    {
        if ($option == 'open') {
            return 'Dear '.$carrier.':<br>
                Etelix NOC Team. ';
        } elseif ($option == 'close') {
            return '<div>Dear '.$carrier.':</div>
                    <br/>
                    <div>Change status: "'. $status .'"</div>
                    <br/>
                    Etelix NOC Team.';
        } elseif ($option == 'answer') {
            return '<div>Dear '.$carrier.':</div>
                    <br/>
                    <div>There is a new message related to your TT</div>
                    <br/>
                    Etelix NOC Team.';
        }
    }
    
    /**
     * Retorna el cuerpo completo del correo al abrir un ticket
     * @param string $optionOpen
     * @return string
     */
    public function getBodyOpenTicket($optionOpen)
    {
        return $this->_getHeader() . $this->_getInfoOpenTicket($optionOpen) . $this->_getDetailTicket() . $this->_footerCustomer;
    }
    
    /**
     * Retorna el cuerpo completo del correo al escribir una respuesta
     * @return string
     */
    public function getBodyNewAnwer()
    {
        return $this->_getHeader() . $this->_getInfoNewAnswer() . $this->_getDetailTicket() . $this->_footerCustomer;
    }
    
    /**
     * Retorna el cuerpo completo del correo al cerrar un ticket
     * @param string $status
     * @return string
     */
    public function getBodyCloseTicket($status)
    {
        return $this->_getHeader() . $this->_getInfoCloseTicekt($status) . $this->_getDetailTicket() . $this->_footerCustomer;
    }
    
    /**
     * Retorna el header del correo
     * @return string
     */
    private function _getHeader()
    {
        if (!empty($this->_properties['ticketNumber']))
        {
            return '<div style="width:100%">
                    <img src="http://deve.sacet.com.ve/images/logo.jpg" height="100"/>
                    <hr>
                    <div style="text-align:right">Ticket Confirmation<br>Ticket #: '.$this->_properties['ticketNumber'].'</div>';
        }
        return '';
    }
    
    /**
     * Retorna el texto que contendrá el correo dependiendo de quien abra el ticket
     * @param string $optionOpen
     * @return string
     */
    private function _getHeaderInfo($optionOpen, $operation, $status = false)
    {
        $info='';
        
        switch ($optionOpen) {
            case 'etelix_as_carrier':
                $info=$this->_ettsAsCarrier($this->formatTicketNumber(), $operation, $status);
                break;
            case 'carrier_to_etelix':
                $info=$this->_carrierToEtts($this->formatTicketNumber(), $operation, $status);
                break;
            case 'etelix_to_carrier':
                $info=$this->_ettsToCarrier($this->formatTicketNumber(), $operation, $status);
                break;

            default:
                $info=$this->_ettsToCarrier($this->formatTicketNumber(), $operation, $status);
                break;
        }
        
        return $info;
    }
    
    /**
     * Retorna la cabecera cuando se abre un ticket
     * @return string
     */
    private function _getInfoOpenTicket($optionOpen)
    {
        if (!empty($this->_properties['username']))
        {
            return '<div>
                        <h2>Hello "'. $this->_properties['username'] .'"</h2>
                        <p style="text-align:justify">
                            '.$this->_getHeaderInfo($optionOpen, 'open').'
                        </p>
                    </div>
                    <hr>
                </div>';
        }
        return '';
    }
    
    /**
     * Retorna la cabecera cuando se responde un ticket
     * @return string
     */
    private function _getInfoNewAnswer()
    {
        if (!empty($this->_properties['username']))
        {
            return '<div>
                        <h2>Hello "'.$this->_properties['username'].'"</h2>
                        <p style="text-align:justify">
                            '.$this->_getHeaderInfo($this->_properties['optionOpen'], 'answer').'
                        </p>
                      </div>
                      <hr>
                    </div>';
        }
        return '';
    }
    
    /**
     * Retorna la cabecera cuando se cierra un ticket
     * @param string $status
     * @return string
     */
    private function _getInfoCloseTicekt($status)
    {
        if (!empty($this->_properties['username']))
        {
            return '<div>
                        <h2>Hello "'.$this->_properties['username'].'"</h2>
                        <p style="text-align:justify">
                            '.$this->_getHeaderInfo($this->_properties['optionOpen'], 'close', $status).'
                        </p>
                       </div>
                       <hr>
                    </div>';
        }
        return '';
    }
    
    /**
     * Retorna el chat asociado a un ticket
     * @param integer $idTicket
     * @return string
     */
    public function getChat($idTicket = false)
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
                        $style='float: left; color: #3e454c; background: rgba(196, 191, 191, 0.5);';
                    }

                    if ($usuario == 'C' && $value->id_user == $value->response_by) {
                        $style='float: left; color: #3e454c; background: white;';
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
                        <td '.$this->_td.'>'.$this->getChat().'</td>
                    </tr>';
        }
        return '';
    }

    /**
     * Retorna el detalle del ticket
     * @return string
     */
    private function _getDetailTicket()
    {
        return '<h2>Ticket Details</h2>
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
    
    /**
     * Retorna si es customer o supplier dependiendo del ticketNumber
     * @param strign $ticketNumber
     * @return boolean|string
     */
    public function formatTicketNumber($ticketNumber = false)
    {
        if (!isset($this->_properties['ticketNumber']) || empty($this->_properties['ticketNumber'])) {
            if ($ticketNumber) {
                $this->_properties['ticketNumber'] = $ticketNumber;
            } else {
                return false;
            }
        } else {
            $this->_properties['ticketNumber'] = $this->_properties['ticketNumber'];
        }
        
        if (strpos($this->_properties['ticketNumber'], 'C'))
            return 'Customer';
        if (strpos($this->_properties['ticketNumber'], 'S') || strpos($this->_properties['ticketNumber'], 'P'))
            return 'Supplier';
    }
}