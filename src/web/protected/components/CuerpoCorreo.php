<?php
/**
 * version 1.1.3
 * 
 * @package components
 */
class CuerpoCorreo extends TicketDesign
{
    /**
     * El footer del correo en general
     * @var string
     */
    private $_footerTT;
    
    /**
     * El footer del correo para los customer
     * @var string
     */
    private $_footerCustomer;
    
    /**
     * El footer del correo para los supplier
     * @var string
     */
    private $_footerSupplier;
    
    /**
     * El constructor recibe el detalle del ticket
     * @param array $key Array con los datos del ticket
     */
    public function __construct($key = false)
    {
        parent::__construct($key);
        // Footer to customer
        $this->_footerCustomer='<div style="width:100%">
                                    <p style="text-align:justify">
                                        <br/>
                                        <div style="font-style:italic; color:red;">---Please do not reply to this email. Replies to this message are routed to an unmonitored mailbox.---</div>
                                    </p>
                                </div>';
        // Footer to supplier
        $this->_footerSupplier=$this->_footerCustomer;
        // Footer tt
        $this->_footerTT=$this->_footerCustomer;
        
    }
    
    /**
     * Retorna el texto que contendrá el correo cuando etelix abra, responda o 
     * cierre un ticket como el carrier
     * @param string $carrier El nombre del carrier
     * @param string $option Si es abierto, cerrado o una respuesta
     * @param type $status El nombre del status del ticket
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
     * @param stiring $carrier El nombre del carrier
     * @param string $option Si es abierto, cerrado o una respuesta
     * @param string $status El nombre del status del ticket
     * @return string
     */
    private function _carrierToEtts($carrier, $option, $status)
    {
        return $this->_ettsAsCarrier($carrier, $option, $status);
    }
    
    /**
     * Retorna el texto que contendrá el correo cuando etelix le abra, responda 
     * o cierre un ticket al carrier
     * @param stiring $carrier El nombre del carrier
     * @param string $option Si es abierto, cerrado o una respuesta
     * @param string $status El nombre del status del ticket
     * @return string
     */
    private function _ettsToCarrier($carrier, $option, $status = false)
    {
        if ($option == 'open') {
            return 'Dear '.$carrier.':<br>
                    Etelix NOC has opened a Trouble Ticket for the issue described below.<br>
                    Please enter our platform through the link: http://etts.etelix.com/ with your credentials to update and comment the issue.<br>
                    Thanks in advanced';
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
     * @param string $optionOpen El tipo de apertura del ticket
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
     * @param string $status El nombre del status del ticket
     * @return string
     */
    public function getBodyCloseTicket($status)
    {
        return $this->_getHeader() . $this->_getInfoCloseTicekt($status) . $this->_getDetailTicket() . $this->_footerCustomer;
    }
    
    /**
     * Retorna el cuerpo del mensaje cuando se escala un ticket
     * @param string $message El mensaje que se mandará al escalar un ticket
     * @return string
     */
    public function getBodyEscaladeTicket($message)
    {
        return $this->_getHeader() . '<p>'. $message . '</p>' . $this->_getDetailTicket() . $this->_footerCustomer;
    }
    
    /**
     * Retorna el header del correo
     * @return string
     */
    private function _getHeader()
    {
        if (!empty($this->_properties['ticketNumber']))
        {
            return '<p style="font-style:italic; color:red;">---Please do not reply to this email. Replies to this message are routed to an unmonitored mailbox.---</p><div style="width:100%">
                    <img src="http://deve.sacet.com.ve/images/logo.jpg" height="100"/>
                    <hr>
                    <div style="text-align:right">Ticket Confirmation<br>Ticket #: '.$this->_properties['ticketNumber'].'</div>';
        }
        return '';
    }
    
    /**
     * Retorna el texto que contendrá el correo dependiendo de quien abra el ticket
     * @param string $optionOpen El tipo de apertura del ticket (etelix_as_carrier, carrier_to_etelix, etelix_to_carrier)
     * @param string $operation Si es abierto, cerrado o una respuesta
     * @param status $status El nombre del status del ticket
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
     * @param string $optionOpen El tipo de apertura
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
     * @param string $status El nobmre del status del ticket
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
     * Retorna si es customer o supplier dependiendo del ticketNumber
     * @param strign $ticketNumber El número del ticket
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