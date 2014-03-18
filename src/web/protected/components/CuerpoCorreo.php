<?php
/**
 * version 1.1
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
    private $_ticketNumber;
    private $_username;
    private $_emails;
    private $_failure;
    private $_originationIp;
    private $_destinationIp;
    private $_prefix;
    private $_gmt;
    private $_testedNumber;
    private $_country;
    private $_date;
    private $_hour;
    private $_description;
    private $_cc;
    private $_bcc;
    private $_speech;
    private $_idTicket;

    public function __construct($key)
    {
        $this->_ticketNumber = $key['ticketNumber'];
        $this->_username = $key['username'];
        $this->_emails = $key['emails'];
        $this->_failure = $key['failure'];
        $this->_originationIp = $key['originationIp'];
        $this->_destinationIp = $key['destinationIp'];
        $this->_prefix = $key['prefix'];
        $this->_gmt = $key['gmt'];
        $this->_testedNumber = $key['testedNumber'];
        $this->_country = $key['country'];
        $this->_date = $key['date'];
        $this->_hour = $key['hour'];
        $this->_description = $key['description'];
        $this->_cc = $key['cc'];
        $this->_bcc = $key['bcc'];
        $this->_speech = $key['speech'];
        $this->_idTicket = $key['idTicket'];
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
    }
    
    public function getBodyOpenTicket($optionOpen)
    {
        return $this->_getHeader() . $this->_getInfoOpenTicket($optionOpen) . $this->_getDetailTicket() . $this->_footerCustomer;
    }
    
    public function getBodyNewAnwer()
    {
        return $this->_getHeader() . $this->_getInfoNewAnswer() . $this->_getDetailTicket() . $this->_footerCustomer;
    }
    
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
        if (!empty($this->_ticketNumber))
        {
            return '<div style="width:100%">
                    <img src="http://deve.sacet.com.ve/images/logo.jpg" height="100"/>
                    <hr>
                    <div style="text-align:right">Ticket Confirmation<br>Ticket #: '.$this->_ticketNumber.'</div>';
        }
        return '';
    }
    
    /**
     * Retorna la cabecera cuando un customer abre un ticket
     * @return string
     */
    private function _getInfoOpenTicket($optionOpen)
    {
        if (!empty($this->_username))
        {
            return '<div>
                        <h2>Hello "'. $this->_username .'"</h2>
                        <p style="text-align:justify">
                            <div>Dear '.$this->formatTicketNumber().':</div>
                            <br/>
                            <div>
                            '.$this->_getHeaderInfo($optionOpen).'
                            </div>
                            <br/>
                            Etelix NOC Team.
                        </p>
                    </div>
                    <hr>
                </div>';
        }
        return '';
    }
    
    private function _getHeaderInfo($optionOpen)
    {
        $info='Thanks for using our online tool "Etelix Trouble Ticket System" (etts.etelix.com).<br/>
                      Your issue has been opened with the TT Number (please see below).<br/>
                      Your TT will be answered by an Etelix Analyst soon.';
        if ($optionOpen == 'etelix_as_carrier') {
            if ($this->formatTicketNumber() != 'Customer'){
                $info=$info;
            } else {
                $info=$info;
            }
        }
            
        if ($optionOpen == 'carrier_to_etelix'){
            if ($this->formatTicketNumber() != 'Customer') {
                $info=$info;
            } else {
                $info=$info;
            }
        }
            
        if ($optionOpen == '' || $optionOpen == false) {
            if ($this->formatTicketNumber() != 'Customer'){
                $info=$info;
            } else {
                $info=$info;
            }
        }
        return $info;
    }


    private function _getInfoNewAnswer()
    {
        if (!empty($this->_username))
        {
            return '<div>
                        <h2>Hello "'.$this->_username.'"</h2>
                        <p style="text-align:justify">
                            <div>Dear '.$this->formatTicketNumber().':</div>
                            <br/>
                            <div>There is a new message related to your TT</div>
                            <br/>
                            Etelix NOC Team.
                        </p>
                      </div>
                      <hr>
                    </div>';
        }
        return '';
    }
    
    private function _getInfoCloseTicekt($status)
    {
        if (!empty($this->_username))
        {
            return '<div>
                        <h2>Hello "'.$this->_username.'"</h2>
                        <p style="text-align:justify">
                            <div>Dear '.$this->formatTicketNumber().':</div>
                            <br/>
                            <div>Change status: "'. $status .'"</div>
                            <br/>
                            Etelix NOC Team.
                        </p>
                       </div>
                       <hr>
                    </div>';
        }
        return '';
    }

    public function getChat()
    {
        if (!empty($this->_idTicket))
        {
            $description=DescriptionTicket::getDescription($this->_idTicket);
            $chat = '<div>';
            foreach ($description as $value) {
                if($value->idUser !==null){
                    $usuario=CrugeAuthassignment::getRoleUser(false, $value->id_user);
                    if (($usuario == 'I' || $usuario == 'C' || $usuario == 'A' || $usuario == 'S') && $value->id_user != $value->response_by) {
                        $style='float: left; color: #3e454c; background: rgba(196, 191, 191, 0.5);';
                    }

                    if ($usuario == 'C' && $value->id_user == $value->response_by) {
                        $style='float: left; color: #3e454c; background: white;';
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
                            $value->description . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong>User: </strong>' . $value->idUser->username .  
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
        if (!empty($this->_failure))
        {
            return '<tr>
                        <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Failure</th>
                    </tr>
                    <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_failure.'</td>
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
        if (!empty($this->_emails))
        {
            return '<tr>
                        <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">'.$title.'</th>
                    </tr>
                    <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_emails) .'</td>
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
        if(is_array($this->_cc))
        { 
            return '<tr>
                        <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">CC</th>
                    </tr>
                    <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_cc) .'</td>
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
        if(is_array($this->_bcc))
        {
            return '<tr>
                        <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">BCC</th>
                    </tr>
                    <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_bcc) .'</td>
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
        if (!empty($this->_originationIp) || !empty($this->_destinationIp))
        {
            return '<tr>
                        <th colspan="1" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Origination IP</th>
                        <th colspan="3" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Destination IP</th>
                    </tr>
                    <tr>
                        <td colspan="1" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_originationIp.'</td>
                        <td colspan="3" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_destinationIp.'</td>
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
        if (!empty($this->_prefix))
        {
            return '<tr>
                        <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Prefix</th>
                    </tr>
                    <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_prefix.'</td>
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
        if (!empty($this->_gmt))
        {
            return '<tr>
                        <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">GMT</th>
                    </tr>
                    <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_gmt.'</td>
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
        if (!empty($this->_testedNumber))
        {
            return '<tr>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Tested number</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Country</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Date</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Hour</th>
                    </tr>
                    <tr>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_testedNumber) .'</td>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_country) .'</td>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_date) .'</td>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_hour) .'</td>
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
        if (!empty($this->_description))
        {
            return '<tr>
                        <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Description</th>
                    </tr>
                    <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->getChat().'</td>
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
    
    public function formatTicketNumber($ticketNumber = false)
    {
        if (!isset($this->_ticketNumber) || empty($this->_ticketNumber)) {
            if ($ticketNumber) {
                $this->_ticketNumber = $ticketNumber;
            } else {
                return false;
            }
        } else {
            $this->_ticketNumber = $this->_ticketNumber;
        }
        
        if (strpos($this->_ticketNumber, 'C'))
            return 'Customer';
        if (strpos($this->_ticketNumber, 'S') || strpos($this->_ticketNumber, 'P'))
            return 'Supplier';
    }
}