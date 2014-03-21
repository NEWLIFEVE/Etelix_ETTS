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
     * @param string $optionOpen
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
     * @param string $ticketNumber
     * @param string $nameCarrier
     * @param string $timeTicket
     * @return string
     */
    public function subjectCloseTicket($ticketNumber, $nameCarrier, $timeTicket)
    {
        $idTicket=Ticket::getId($ticketNumber);
        $optionOpen=Ticket::getOptionOpen($idTicket);
        
        $user = 'Etelix';
        
        if (CrugeAuthassignment::getRoleUser() == 'C') $user = $nameCarrier;
        
        if ($optionOpen == 'etelix_as_carrier')
            $this->_subject = 'TT '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.' to Etelix, Closed TT (by '.$user.' on ETTS), '.$ticketNumber.' ('.$timeTicket.')';
        if ($optionOpen == 'etelix_to_carrier')
            $this->_subject = 'TT Etelix to '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.', Closed TT (by '.$user.' on ETTS), '.$ticketNumber.' ('.$timeTicket.')';
        if ($optionOpen == 'carrier_to_etelix')
            $this->_subject = 'TT '. $this->_formatTicketNumber($ticketNumber) .' '.$nameCarrier.' to Etelix, Closed TT (by '.$user.' on ETTS), '.$ticketNumber.' ('.$timeTicket.')';
        if ($optionOpen == '')
            $this->_subject = 'Asunto no disponible';
        
        return $this->_subject;
    }
    
    
//    /**
//     * Método para retornar el asunto cuando se responde un ticket
//     * 
//     * @param string $ticketNumber
//     * @param string $nameCarrier
//     * @param string $timeTicket
//     * @param integer $etelixAsCustomer
//     * @return string
//     */
//    public function subjectNewAnswer($ticketNumber,$idUser,$idResponseBy,$timeTicket)
//    {
//        $this->_setCarrier($ticketNumber);
//        //Primera parte del subject
//        $this->_subject="TT ".$this->_formatTicketNumber($ticketNumber)." ".$this->_carrier." to Etelix, ";
//        //Segunda parte del subject
//        $this->_subject.=$this->_defineStatus($idUser,$idResponseBy);
//        //Tercera parte del subject
//        $this->_subject.=$ticketNumber." (".$timeTicket.")";
//        return $this->_subject;
//    }
    
    /**
     * Retorna el subject del correo al dar una nueva repuesta
     * @param string $ticketNumber
     * @param string $nameCarrier
     * @param string $timeTicket
     * @return string
     */
    public function subjectNewAnswer($ticketNumber, $timeTicket, $internalAsCarrier = null)
    {
        $idTicket=Ticket::getId($ticketNumber);
        $optionOpen=Ticket::getOptionOpen($idTicket);
        $this->_setCarrier($ticketNumber);
        
        $this->_subject = 'TT '. $this->_formatTicketNumber($ticketNumber) .' '.$this->_carrier.' to Etelix, New ';
        $lastStringSubject = ' Status, '.$ticketNumber.' ('.$timeTicket.')';
        $user = 'Etelix';
        
        if (CrugeAuthassignment::getRoleUser() == 'C') {
            $user = $this->_carrier;
        } else {
            if ($internalAsCarrier != null ) $user = $this->_carrier;
        }
        
        if ($optionOpen == 'etelix_as_carrier' || $internalAsCarrier != null) 
            $this->_subject .= $user . ' (by Etelix on ETTS)' . $lastStringSubject;
        if ($optionOpen == 'etelix_to_carrier') 
            $this->_subject = 'TT Etelix to '. $this->_formatTicketNumber($ticketNumber) .' '.$this->_carrier.', New '.$user.' ' . $lastStringSubject;
        if ($optionOpen == 'carrier_to_etelix')
            $this->_subject .= $user . $lastStringSubject;
        if ($optionOpen == '')
            $this->_subject .= $user . $lastStringSubject;
        
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
    
    /**
     * Metodo encargado de definir el subject cuando se abre el ticket 
     */
    private function _firstElementSubject($optionOpen, $ticketNumber, $nameCarrier)
    {
        if ($optionOpen == 'etelix_as_carrier') 
            return 'TT '.$this->_formatTicketNumber($ticketNumber).' '.$nameCarrier.' to Etelix (by Etelix on ETTS), New TT, '. $ticketNumber.' (00:00)';
        if ($optionOpen == 'etelix_to_carrier')
            return 'TT Etelix to '.$this->_formatTicketNumber($ticketNumber).' '.$nameCarrier.', New TT, '.$ticketNumber.' (00:00)';
        if ($optionOpen == 'carrier_to_etelix') 
           return 'TT '.$this->_formatTicketNumber($ticketNumber).' '.$nameCarrier.' to Etelix, New TT, '.$ticketNumber.' (00:00)';
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