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
    private $_posBody;

    public function __construct($connection = false) 
    {
        $this->_inbox = parent::__construct($connection);
        $this->_message = array();
        $this->_count = imap_num_msg($this->_inbox);
        $this->_posBody = '<p></p><small>This answer has been read from an email, this function is on probation, the answer may be incomplete or part of it may be negligible. Thank you for your understanding.</small>';
    }
    
    /**
     * Retorna todos los mensajes
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
     * Retorna una cantidad de mensajes dependiendo del parametro que se le setee 
     * @param int $key
     * @return array
     */
    public function getMessagesByQuantity($key = false)
    {
        if($key === false)  $key = 1;
        if ($key >= $this->_count) $key = 1;
        $resta = $this->_count - $key;
        $rigthRules = array('---', '> -', 'de:', 'from:', 'saludos', 'regards', '--Please', 'base64');
        $leftRules = array('quoted-printable');
        for ($i = $this->_count; $i > $resta; $i--) {
            if (!strpos($this->getSubject($i), 'delivery')) {
                $this->_message[] = array(
                    'subject' => $this->getSubject($i),
                    'from' => $this->getFrom($i),
                    'to' => $this->getTo($i),
                    'date' => $this->getDate($i),
                    'body' => $this->getBody($i, $rigthRules, $leftRules),
                );
            }
        }
        return $this->_message;
    }
    
    /**
     * Filtra el cuerpo del mensaje mostrando solo la parte derecha del mismo
     * dependiendo de las reglas de filtrado que se pasen por el segundo parametro
     * 
     * @param string $body
     * @param array $rules
     * @return string
     */
    private function _filterBodyToLeft($body, $rules)
    {
        $result = '';
        $positionSubString = stripos($body, $rules); 
        $result .= substr ($body, ($positionSubString));
        $result = preg_replace('/' . $rules . '/', '', $result);
        return $result;
    }
    
    /**
     * Filtra el cuerpo del mensaje mostrando solo la parte izquierda del mismo
     * dependiendo de la regla de filtrado que se pase por el segundo parametro
     * 
     * @param string $body
     * @param string $rules
     * @return string
     */
    private function _filterBodyToRight($body, $rules)
    {
        $result = '';
        if (stripos($body, $rules)) {
            $positionSubString = stripos($body, $rules); 
            $result = substr($body, 0, ($positionSubString + strlen($rules)));
        } else {
            $result = $body;
        }
        return $result;
    }

    /**
     * Retorna un array de un mensaje dado, pasando como parametro el ticketNumber
     * @param string $ticketNumber
     * @return array
     */
    public function messageByTicketNumber($ticketNumber)
    {
        $idMessages = $this->getIdMessage($ticketNumber);
        if ($idMessages != false) {
            $rigthRules = array('---', '> -', 'de:', 'from:', 'saludos', 'regards', '--Please', 'base64');
            $leftRules = array('quoted-printable');
            foreach ($idMessages as $idMessage) {
                $this->_message[] = array(
                    'id' => $this->getUid($idMessage),
                    'subject' => $this->getSubject($idMessage),
                    'from' => $this->getFrom($idMessage),
                    'to' => $this->getTo($idMessage),
                    'date' => $this->getDate($idMessage),
                    'body' => $this->getBody($idMessage, $rigthRules, $leftRules) . $this->_posBody
                );
            }
            return $this->_message;
        }
        return false;
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
        $body = $this->getBody($lastMail);
        if ($body != null) {
            return $body;
        }
        return false;
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
     * Retorna el id del o los mensajes dependiendo del ticketNumber
     * @param string $ticketNumber
     * @return array|boolean
     */
    public function getIdMessage($ticketNumber)
    {
        $idMessage = imap_search($this->_inbox, 'SUBJECT "'.$ticketNumber.'" ');
        if ($idMessage != null){
            return $idMessage;
        }
        return false;
    }
    
    /**
     * Retorna el id unico de cada mensaje
     * @param int $messageID
     * @return int
     */
    public function getUid($messageID)
    {
        try {
            return imap_uid($this->_inbox, $messageID);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
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
     * @param int $messageID Recibe el número del mensaje
     * @param array $filterRigth Reglas de filtrado que se aplican a la izquierda del cuerpo del mensaje
     * @param array $filterLeft Reglas de filtrado que se aplican a la derecha del cuerpo del mensaje
     * @return string
     */
    public function getBody($messageID, $filterRigth = false, $filterLeft = false)
    {
        try {
            $body =  utf8_decode(imap_utf8(imap_qprint(imap_fetchbody($this->_inbox, $messageID, 1))));
            if ($filterLeft) {
                if (is_array($filterLeft)) {
                    for ($i = 0; $i < count($filterLeft); $i++) {
                        $body = $this->_filterBodyToLeft($body, $filterLeft[$i]);
                    }
                }
            }
            if ($filterRigth) {
                if (is_array($filterRigth)) {
                    for ($i = 0; $i < count($filterRigth); $i++) {
                        $body = $this->_filterBodyToRight($body, $filterRigth[$i]);
                    }
                }
            }
            return $body;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
   /**
    * Borra los mensajes por su id
    * @param array $mails
    * @param string $optionOpen
    * @param int $idTicket
    */
    public function deleteMessage($mails, $optionOpen = false, $idTicket = false)
    {
        foreach ($mails as $value) {
            imap_delete($this->_inbox, $value['id'], FT_UID);
            imap_expunge($this->_inbox);
            if ($optionOpen && $idTicket) {
                $model = new DescriptionTicket;
                $model->id_ticket=$idTicket;
                $model->description=$value['body'];
                $model->date=new CDbExpression('NOW()');
                $model->hour=new CDbExpression('NOW()');
                $model->id_user=CrugeUser2::getUserTicket($idTicket,true)->iduser;
                $optionRead=DescriptionticketController::getUserNewDescription(false);
                $model->read_carrier=$optionRead['read_carrier'];
                $model->read_internal=$optionRead['read_internal'];
                $model->response_by=CrugeUser2::getUserTicket($idTicket,true)->iduser;
                $model->save();
            }
        }
    }
    
    /**
     * Cerrar la conexion imap
     */
    public function close()
    {
        parent::_disconnect();
    }
}