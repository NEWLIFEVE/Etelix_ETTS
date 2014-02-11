<?php
/**
 * version 1.0
 * 
 * @package components
 */
class CuerpoCorreo
{
    // Propiedades de la estructura del correo
    private $_headerCustomer;
    private $_headerSupplier;
    private $_infoCustomer;
    private $_infoSupplier;
    private $_infoTT;
    private $_detail;
    private $_detailSupplier;
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
    private $_accountManager;
    private $_status;
    private $_cc;
    private $_bcc;
    private $_speech;

    public function init($ticketNumber,$username,$emails,$failure,$originationIp,$destinationIp,$prefix,$gmt,$testedNumber,$country,$date,$hour,$description,$accountManager=false,$status=false,$cc=false,$bcc=false,$speech=false)
    {
        $this->_emails = array();
        $this->_cc = array();
        $this->_bcc = array();
        $this->_testedNumber = array();
        $this->_country = array();
        $this->_date = array();
        $this->_hour = array();
        
        $this->_ticketNumber = $ticketNumber;
        $this->_username = $username;
        $this->_emails = $emails;
        $this->_failure = $failure;
        $this->_originationIp = $originationIp;
        $this->_destinationIp = $destinationIp;
        $this->_prefix = $prefix;
        $this->_gmt = $gmt;
        $this->_testedNumber = $testedNumber;
        $this->_country = $country;
        $this->_date = $date;
        $this->_hour = $hour;
        $this->_description = $description;
        $this->_accountManager = $accountManager;
        $this->_status = $status;
        $this->_cc = $cc;
        $this->_bcc = $bcc;
        $this->_speech = $speech;
        
        if (!is_array($this->_cc)) $this->_cc[] = '<span style="color:red">No data available</span>';
        if (!is_array($this->_bcc)) $this->_bcc[] = '<span style="color:red">No data available</span>';
        if (empty($this->_originationIp)) $this->_originationIp = '<span style="color:red">No data available</span>';
        if (empty($this->_destinationIp)) $this->_destinationIp = '<span style="color:red">No data available</span>';
        if (empty($this->_prefix)) $this->_prefix = '<span style="color:red">No data available</span>';
        if (empty($this->_speech)) $this->_speech = '<span style="color:red">No data available</span>';
        
        //Header of mail(customer)
        $this->_headerCustomer='<div style="width:100%">
                                    <img src="http://deve.sacet.com.ve/images/logo.jpg" height="100"/>
                                    <hr>
                                    <div style="text-align:right">Ticket Confirmation<br>Ticket #: '.$this->_ticketNumber.'</div>';
        //Header of mail(supplier)
        $this->_headerSupplier=$this->_headerCustomer;
        // Info to customer
        $this->_infoCustomer='<div>
                                    <h2>Hello "'. $this->_username .'"</h2>
                                    <p style="text-align:justify">
                                        <div>Dear Customer:</div>
                                        <br/>
                                        <div>
                                                Thanks for using our online tool "Etelix Trouble Ticket System" (etts.etelix.com).<br/>
                                                Your issue has been opened with the TT Number (please see below).<br/>
                                                Your TT will be answered by an Etelix Analyst soon.
                                        </div>
                                        <br/>
                                        Etelix NOC Team.
                                    </p>
                                </div>
                                <hr>
                            </div>';
        // Info to supplier
        $this->_infoSupplier='<div>
                                    <h2>Hello "'. $this->_username .'"</h2>
                                    <p style="text-align:justify">
                                        <div>Dear Supplier:</div>
                                        <br/>
                                        <div>
                                                Test para supplier
                                        </div>
                                        <br/>
                                        Etelix NOC Team.
                                    </p>
                                </div>
                                <hr>
                            </div>';
        // Infor mail tt
        $this->_infoTT='<div>
                            <h2>Hello</h2>
                            <p style="text-align:justify">
                                    You have a new ticket from <h2>"'. $this->_username .'"</h2>
                            </p>
                            </div>
                            <hr>
                        </div>';
        
        // Detail of ticket(Global)
        $this->_detail='<h2>Ticket Details</h2>
                                 <table style="border-spacing: 0; width:100%; border: solid #ccc 1px;">
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">Response to</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_emails) .'</td>
                            </tr>
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Failure</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_failure.'</td>
                            </tr>
                            <tr>
                                    <th colspan="1" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Origination IP</th>
                                    <th colspan="3" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Destination IP</th>
                            </tr>
                            <tr>
                                    <td colspan="1" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_originationIp.'</td>
                                    <td colspan="3" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_destinationIp.'</td>
                            </tr>
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Prefix</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_prefix.'</td>
                            </tr>
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">GMT</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_gmt.'</td>
                            </tr>
                            <tr>
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
                                    </tr>
                                    <tr>
                                            <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Description</th>
                                    </tr>
                                    <tr>
                                            <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_description.'</td>
                                    </tr>
                             </table>';
        
        // Detail of ticket(Supplier)
        $this->_detailSupplier='<h2>Ticket Details</h2>
                        <table style="border-spacing: 0; width:100%; border: solid #ccc 1px;">
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">To</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_emails) .'</td>
                            </tr>
                            
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">CC</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_cc) .'</td>
                            </tr>
                            
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">BCC</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $this->_bcc) .'</td>
                            </tr>
                            
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Failure</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_failure.'</td>
                            </tr>
                            <tr>
                                    <th colspan="1" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Origination IP</th>
                                    <th colspan="3" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Destination IP</th>
                            </tr>
                            <tr>
                                    <td colspan="1" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_originationIp.'</td>
                                    <td colspan="3" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_destinationIp.'</td>
                            </tr>
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Prefix</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_prefix.'</td>
                            </tr>
                            
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Status</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. $this->_status.'</td>
                            </tr>
                            
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Account Manager</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_accountManager.'</td>
                            </tr>
                            
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Speech</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_speech.'</td>
                            </tr>
                            <tr>
                                    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Description</th>
                            </tr>
                            <tr>
                                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$this->_description.'</td>
                            </tr>
                        </table>';
        
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
        $this->_footerTT='<div style="width:100%">
                            <p style="text-align:justify">
                                <br/>
                                <div style="font-style:italic;">Please do not reply to this email. Replies to this message are routed to an unmonitored mailbox.</div>
                            </p>
                        </div>';
    }
    
    public function getBodyCustumer()
    {
        return $this->_headerCustomer . $this->_infoCustomer . $this->_detail . $this->_footerCustomer;
    }
    
    public function getBodySupplier()
    {
        return $this->_headerSupplier . $this->_infoSupplier . $this->_detailSupplier . $this->_footerSupplier;
    }
    
    public function getBodyTT()
    {
        return $this->_headerCustomer . $this->_infoTT . $this->_detail . $this->_footerTT;
    }
}