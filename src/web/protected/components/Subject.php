<?php

/**
 * Description of Subject
 *
 * @author Nelson Marcano
 */
class Subject 
{
    /**
     * El subject propio del correo
     * @var string 
     */
    private $_subject;
    
    /**
     * El tipo de carrier (customer/supplier)
     * @var string
     */
    private $_carrier;
    
    /**
     * Método que retornará el subject al abrir un ticket
     * 
     * @param string $ticketNumber El numero de ticket
     * @param string $nameCarrier El nombre del carrier
     * @param string $optionOpen EL tipo de apertura del ticket
     * @return string
     */
    public function subjectOpenTicket($ticketNumber, $nameCarrier, $optionOpen)
    {
        $this->_subject=$this->_firstElementSubject($optionOpen, $ticketNumber, $nameCarrier);
        return $this->_subject;
    }
    
    /**
     * Método que retorna el subject al cerrar un ticket
     * 
     * @param string $ticketNumber El numero del ticket
     * @param string $nameCarrier El nombre del carrier
     * @param string $timeTicket El tiempo de vida del ticket
     * @param int $id El id del usuario
     * @return string
     */
    public function subjectCloseTicket($ticketNumber, $nameCarrier, $timeTicket, $id = false)
    {
        $idTicket=Ticket::getId($ticketNumber);
        $optionOpen=Ticket::getOptionOpen($idTicket);
        
        $user = 'Etelix';
        
        if (CrugeAuthassignment::getRoleUser(false, $id) == 'C') $user = $nameCarrier;
        
        if ($optionOpen == 'etelix_as_carrier')
            $this->_subject = 'TT '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.' to Etelix, Closed TT (by '.$user.' on ETTS), <'.$ticketNumber.'> ('.$timeTicket.')';
        if ($optionOpen == 'etelix_to_carrier')
            $this->_subject = 'TT Etelix to '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', Closed TT (by '.$user.' on ETTS), <'.$ticketNumber.'> ('.$timeTicket.')';
        if ($optionOpen == 'carrier_to_etelix')
            $this->_subject = 'TT '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.' to Etelix, Closed TT (by '.$user.' on ETTS), <'.$ticketNumber.'> ('.$timeTicket.')';
        if ($optionOpen == '')
            $this->_subject = 'TT '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.' to Etelix, Closed TT (by '.$user.' on ETTS), <'.$ticketNumber.'> ('.$timeTicket.')';
        
        return $this->_subject;
    }
        
    /**
     * Retorna el subject del correo al dar una nueva repuesta
     * @param string $ticketNumber El numero del ticket
     * @param string $timeTicket El tiempo de vida del ticket
     * @param null $internalAsCarrier Si la respuesta se da de parte de etelix como el carrier
     * @return string
     */
    public function subjectNewAnswer($ticketNumber, $timeTicket, $internalAsCarrier = null)
    {
        $idTicket=Ticket::getId($ticketNumber);
        $optionOpen=Ticket::getOptionOpen($idTicket);
        $this->_setCarrier($ticketNumber);
        
        $this->_subject = 'TT '. $this->_formatTicketNumber($ticketNumber) .' '.$this->_carrier.' to Etelix, New ';
        $lastStringSubject = '<'.$ticketNumber.'> ('.$timeTicket.')';
        $user = 'Etelix';
        $byEtelix = '';
        
        if (CrugeAuthassignment::getRoleUser() == 'C') {
            $user = $this->_carrier;
        } else {
            if ($internalAsCarrier != null ) {
                $user = $this->_carrier;
                $byEtelix = '(by Etelix on ETTS)';
            }
        }
        
        if ($optionOpen == 'etelix_as_carrier' || $optionOpen == 'carrier_to_etelix') 
            $this->_subject .= $user . ' Status '.$byEtelix.', ' . $lastStringSubject;
        if ($optionOpen == 'etelix_to_carrier') 
            $this->_subject = 'TT Etelix to '. $this->_formatTicketNumber($ticketNumber) .' '.$this->_carrier.', New '.$user.' Status ' . $lastStringSubject;
        if ($optionOpen == '')
            $this->_subject = $this->_formatTicketNumber($ticketNumber) . ' New '  . $this->_carrier . $lastStringSubject;
        
        return $this->_subject;
    }
    
    /**
     * Retorna el subject al crear un usuario
     * @return string
     */
    public function subjectNewUser()
    {
        $this->_subject = 'User information (ETTS)';
        
        return $this->_subject;
    }
    
    /**
     * Dice sin un numero de ticket es de customer o supplier
     * @param string $ticketNumber EL numero del ticket
     * @return string
     */
    private function _formatTicketNumber($ticketNumber)
    {
        if (strpos($ticketNumber, 'C'))
            return 'Customer';
        if (strpos($ticketNumber, 'S') || strpos($ticketNumber, 'P'))
            return 'Supplier';
    }

    /**
     * Metodo encargado de definir el subject cuando se abre el ticket 
     * @param string $optionOpen EL tipo de apertura del ticket
     * @param string $ticketNumber El numero del ticket
     * @param stirng $nameCarrier El nombre del carrier
     * @return string
     */
    private function _firstElementSubject($optionOpen, $ticketNumber, $nameCarrier)
    {
        if ($optionOpen == 'etelix_as_carrier') 
            return 'TT '.$this->_formatTicketNumber($ticketNumber).' '.$nameCarrier.' to Etelix (by Etelix on ETTS), New TT, <'. $ticketNumber.'> (00:00)';
        if ($optionOpen == 'etelix_to_carrier')
            return 'TT Etelix to '.$this->_formatTicketNumber($ticketNumber).' '.$nameCarrier.', New TT, <'.$ticketNumber.'> (00:00)';
        if ($optionOpen == 'carrier_to_etelix') 
           return 'TT '.$this->_formatTicketNumber($ticketNumber).' '.$nameCarrier.' to Etelix, New TT, <'.$ticketNumber.'> (00:00)';
    }
    
    /**
     * Define el nombre del carrier buscando por numero de ticket
     * @param type $ticketNumber El numero de ticket
     */
    private function _setCarrier($ticketNumber)
    {
        $this->_carrier=Carrier::getNameByUser(CrugeUser2::getUserTicket(Ticket::getId($ticketNumber),true)->iduser);
    }
}