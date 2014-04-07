<?php
/**
 * Description of Imap
 *
 * @author Nelson Marcano
 */
class Imap extends Connection
{
    private $_inbox;
    private $_message;
    private $_count;

    public function __construct() 
    {
        $this->_inbox = parent::__construct();
        $this->_message = array();
        $this->_count = imap_num_msg($this->_inbox);
    }
    
    /**
     * Retorna todos los mensajes con el subject, from, to, date y el cuerpo
     * @return array
     */
    public function getMessages()
    {
        for ($i = 1; $i <= $this->_count; $i++) {
            $this->_message[] = array(
                'subject' => $this->getSubject($i),
                'from' => $this->getFrom($i),
                'to' => $this->getTo($i),
                'date' => $this->getDate($i),
                'body' => $this->getBody($i),
            );
        }
        return $this->_message;
    }

    /**
     * Retorna un array de un mensaje dado, pasando como parametro el ticketNumber
     * @param string $ticketNumber
     * @return array
     */
    public function messageByTicketNumber($ticketNumber)
    {
        foreach ($this->getIdMessage($ticketNumber) as $idMessage) {
            $this->_message[] = array(
                'subject' => $this->getSubject($idMessage),
                'from' => $this->getFrom($idMessage),
                'to' => $this->getTo($idMessage),
                'date' => $this->getDate($idMessage),
                'body' => $this->getBody($idMessage) 
            );
        }
        return $this->_message;
    }
    
    /**
     * Retorna la respuesta de los mensajes asociados a un ticketnumber
     * @param string $ticketNumber
     * @return array
     */
    public function allBodysByTicketNumber($ticketNumber)
    {
        foreach ($this->getIdMessage($ticketNumber) as $idMessage) {
            $cadena = $this->getBody($idMessage); 
            $subcadena = '<'; 
            $posicionSubcadena = strpos ($cadena, $subcadena); 
            $retorno = substr ($cadena, 0,($posicionSubcadena));
            
            if ($retorno != null) {
                $this->_message[] = array(
                    'body' => $retorno 
                );
            }
        }
        return $this->_message;
    }
    
    /**
     * Retorna el texto del ultimo mensaje enviado asociado a un ticketnumber
     * @param string $ticketNumber
     * @return string
     */
    public function lastBodyByTicketNumber($ticketNumber)
    {
        $idMail = $this->getIdMessage($ticketNumber);
        $lastMail = end($idMail);
        $cadena = $this->getBody($lastMail); 
        $subcadena = '<'; 
        $posicionSubcadena = strpos ($cadena, $subcadena); 
        $retorno = substr ($cadena, 0,($posicionSubcadena)); 
        return $retorno;
    }
    
    /**
     * Retorna formateado el o los mensaje filtrado por ticketNumber
     * @param string $ticketNumber
     * @return string
     */
    public function formatMessage($ticketNumber)
    {
        $message = '<div class="answer-ticket">';
        foreach ($this->messageByTicketNumber($ticketNumber) as $value) {
            
            $cadena = $value['body']; 
            $subcadena = '<'; 
            $posicionSubcadena = strpos ($cadena, $subcadena); 
            $retorno = substr ($cadena, 0,($posicionSubcadena));
            
            $cadena2 = $retorno; 
            $subCadena2 = 'quoted-printable';
            $posicionSubcadena2 = strpos ($cadena2, $subCadena2); 
            $retorno2 = substr ($cadena2, ($posicionSubcadena2 + 0)); 
            $retorno2 = preg_replace('/quoted-printable/', '', $retorno2);
            
            if ($retorno != null) {
                $message .= '<div style="float: left; border:1px solid silver; color: #3e454c; background: white;" class="msg-ticket">';
                $message .= '<strong>Mensajes enviados desde el correo:</strong><br> ' . $retorno2;
                $message .= '</div>';
            }
            
        }
        $message .= '</div>';
        return $message;
    }
    
    /**
     * Retorna el subject del mensaje
     * @param integer $messageID
     * @return string
     */
    public function getSubject($messageID)
    {
        try {
            $header = imap_header($this->_inbox, $messageID);
            return utf8_decode(imap_utf8(imap_qprint($header->subject)));
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    /**
     * Retorna un array con todos los subject del buzón
     * @return array
     */
    public function getAllSubject()
    {
        $subject = array();
        for ($i = 1; $i <= $this->_count; $i++) {
            $subject[] = $this->getSubject($i);
        }
        return $subject;
    }
    
    /**
     * Retorna el id del o los mensajes dependiendo del ticketNumber
     * @param string $ticketNumber
     * @return array
     */
    public function getIdMessage($ticketNumber)
    {
        return imap_search($this->_inbox, 'SUBJECT "'.$ticketNumber.'" ');
    }
    
    /**
     * Retorna el último mensaje del buzón
     * @return array
     */
    public function lastMessage()
    {
        return array(
                'subject' => $this->getSubject($this->_count),
                'from' => $this->getFrom($this->_count),
                'to' => $this->getTo($this->_count),
                'date' => $this->getDate($this->_count),
                'body' => $this->getBody($this->_count) 
            );
    }
    
    /**
     * Retorna el to del mensaje
     * @param integer $messageID
     * @return string
     */
    public function getTo($messageID)
    {
        try {
            $header = imap_header($this->_inbox, $messageID);
            return utf8_decode(imap_utf8(imap_qprint($header->toaddress)));
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    /**
     * Retorna el form del mensaje
     * @param integer $messageID
     * @return string
     */
    public function getFrom($messageID)
    {
        try {
            $header = imap_header($this->_inbox, $messageID);
            return utf8_decode(imap_utf8(imap_qprint($header->fromaddress)));
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    /**
     * Retorna la fecha del mensaje
     * @param integer $messageID
     * @return string
     */
    public function getDate($messageID)
    {
        try {
            $header = imap_header($this->_inbox, $messageID);
            return utf8_decode(imap_utf8(imap_qprint($header->date)));
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    /**
     * Retorna el cuerpo del mensaje
     * @param integer $messageID
     * @return string
     */
    public function getBody($messageID)
    {
        try {
            return utf8_decode(imap_utf8(imap_qprint(imap_fetchbody($this->_inbox, $messageID, 1))));
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    /**
     * Cerrar la conexón imap
     */
    public function close()
    {
        parent::_disconnect();
    }
    
}
