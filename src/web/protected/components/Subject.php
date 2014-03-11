<?php

/**
 * Description of Subject
 *
 * @author Nelson Marcano
 */
class Subject 
{
    private $_subject;
    
    /**
     * Método que retornará el subject al abrir un ticket
     * 
     * @param string $ticketNumber
     * @param string $nameCarrier
     * @param string $etelixAsCustomer
     * @return string
     */
    public function subjectOpenTicket($ticketNumber, $nameCarrier, $etelixAsCustomer)
    {
        $nameCarrier2 = $nameCarrier;
        
        if ($etelixAsCustomer == 'yes') $nameCarrier2 = 'Etelix';
        
        if (CrugeAuthassignment::getRoleUser() == 'C') {
            $this->_subject = 'TT from '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', New TT (by '.$nameCarrier2.' on ETTS), '.$ticketNumber.' (00:00)';
        } else {
            $this->_subject = 'TT for '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', New TT (by '.$nameCarrier2.' on ETTS), '.$ticketNumber.' (00:00)';
        }
        
        return $this->_subject;
    }
    
    /**
     * Método que retorna el subject al cerrar un ticket
     * 
     * @param string $ticketNumber
     * @param string $nameCarrier
     * @param string $timeTicket
     * @return string
     */
    public function subjectCloseTicket($ticketNumber, $nameCarrier, $timeTicket)
    {
        if (CrugeAuthassignment::getRoleUser() == 'C') {
            $this->_subject = 'TT from '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', Closed TT, '.$ticketNumber.' ('.$timeTicket.')';
        } else {
            $this->_subject = 'TT for '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', Closed TT, '.$ticketNumber.' ('.$timeTicket.')';
        }
        
        return $this->_subject;
    }
    
    /**
     * Método para retornar el asunto cuando se responde un ticket
     * 
     * @param string $ticketNumber
     * @param string $nameCarrier
     * @param string $timeTicket
     * @param integer $etelixAsCustomer
     * @return string
     */
    public function subjectNewAnswer($ticketNumber, $nameCarrier, $timeTicket, $etelixAsCustomer)
    {
        $nameCarrier2 = $nameCarrier;
        
        if ($etelixAsCustomer == 1) $nameCarrier2 = 'Etelix';
        
        if(CrugeAuthassignment::getRoleUser() == 'C'){
            $this->_subject = 'TT from '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', New '.$nameCarrier2.' Status (by Carrier on ETTS) '.$ticketNumber.' ('.$timeTicket.')';
        } else {
            $this->_subject = 'TT for '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', New Etelix Status (by Carrier on ETTS), '.$ticketNumber.' ('.$timeTicket.')';
        }
        
        return $this->_subject;
    }
    
    public function subjectNewUser()
    {
        $this->_subject = 'User information (ETTS)';
        
        return $this->_subject;
    }
    
    /**
     * @param string $ticketNumber
     * @return string
     */
    private function _formatTicketNumber($ticketNumber)
    {
        if (strpos($ticketNumber, 'C'))
            return 'Customer';
        if (strpos($ticketNumber, 'S') || strpos($ticketNumber, 'P'))
            return 'Supplier';
    }
}

