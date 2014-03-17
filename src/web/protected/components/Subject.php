<?php

/**
 * Description of Subject
 *
 * @author Nelson Marcano
 */
class Subject 
{
    private $_subject;
    private $_carrier;
    
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
        
        $this->_subject='TT'.$this->_defineFromForNewTicket().' '.$this->_formatTicketNumber($ticketNumber);
        $this->_subject.=' '.$nameCarrier.', New TT '. $this->_defineBy($nameCarrier2).$ticketNumber.' (00:00)';
        
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
    public function subjectNewAnswer($ticketNumber,$idUser,$idResponseBy,$timeTicket)
    {
        $this->_setCarrier($ticketNumber);
        //Primera parte del subject
        $this->_subject="TT".$this->_defineFromFor($ticketNumber)." ".$this->_formatTicketNumber($ticketNumber)." ".$this->_carrier.", ";
        //Segunda parte del subject
        $this->_subject.=$this->_defineStatus($idUser,$idResponseBy);
        //Tercera parte del subject
        $this->_subject.=$ticketNumber." (".$timeTicket.")";
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

    /**
     * Metodo encargado de definir el from
     */
    private function _defineFromFor($ticketNumber)
    {
        if(CrugeAuthassignment::getRoleUser(false,Ticket::getFirstUser($ticketNumber)) == 'C')
        {
            $body=' from ';
        }
        else
        {
            $body=' for ';
        }
        return $body;
    }
    
    private function _defineFromForNewTicket()
    {
        if(CrugeAuthassignment::getRoleUser() == 'C')
        {
            $body=' from ';
        }
        else
        {
            $body=' for ';
        }
        return $body;
    }
    
    /**
     *
     */
    private function _defineStatus($idUser,$idResponseBy)
    {
        $body="New ";
        $final=", ";
        if(CrugeAuthassignment::getRoleUser(false,$idUser) == 'C')
        {
            $body.=$this->_carrier;
            if(CrugeAuthassignment::getRoleUser(false,$idResponseBy) != 'C')
            {
                $final=" (by Etelix on ETTS), ";
            }
        }
        else
        {
            $body.="Etelix";
        }
        $body.=" Status";
        return $body.$final;
    }

    /**
     * 
     */
    private function _setCarrier($ticketNumber)
    {
        $this->_carrier=Carrier::getNameByUser(CrugeUser2::getUserTicket(Ticket::getId($ticketNumber),true)->iduser);
    }
    
    /**
     * 
     * @param string $nameCarrier
     * @return string
     */
    private function _defineBy($nameCarrier)
    {
        if ($nameCarrier == 'Etelix')
        {
            return '(by Etelix on ETTS), ';
        }
        
        return ', ';
    }
}