<?php
/**
 * Description of Imap
 *
 * @author Nelson Marcano
 */
class Imap extends Connection
{
    /**
     * La conexión a imap
     * @var object 
     */
    private $_inbox;
    
    /**
     * El cuerpo del mensaje
     * @var array
     */
    private $_message;
    
    /**
     * El conteo total de los mensajes en el buzón de entrada
     * @var int 
     */
    private $_count;
    
    /**
     * Mensaje de advertencia para especificar que se están obteniendo mensajes del correo y pueden llegar con errores
     * @var string 
     */
    private $_posBody;

    /**
     * @param array $connection Opcionalmente se puede establecer la conexión por el constructor
     */
    public function __construct($connection = false) 
    {
        $this->_inbox = parent::__construct($connection);
        $this->_message = array();
        $this->_count = imap_num_msg($this->_inbox);
        $this->_posBody = '<p></p><small>This answer has been read from an email, this function is on probation, the answer may be incomplete or part of it may be negligible. Thank you for your understanding.</small>';
    }
        
    /**
     * Retorna los mensajes que esten asociados a algun numero de ticket, si no 
     * encuentra, retornará un array vacío y borrará aquellos mensajes que no 
     * tenga numero de ticekt asociado
     * @param int $key El numero de mensajes a llamar, contando desde el último
     * @return array
     */
    public function runConsole($key = false)
    {
        if($key === false)  $key = 1;
        if ($key >= $this->_count) $key = 1;
        $resta = $this->_count - $key;
        $rigthRules = array('---', '> -', 'de:', 'from:', 'saludos', 'regards', '--Please', 'base64');
        $leftRules = array('quoted-printable');
        for ($i = $this->_count; $i > $resta; $i--) {
            if (!stripos($this->getSubject($i), 'delivery')) {
                if ($this->filterSubjectTicketsNumbers($i) != false) {
                    $idTicket = Ticket::getId(rtrim($this->filterSubjectTicketsNumbers($i)));
                    if ($idTicket != null) {
                        $this->_message[] = array(
                            'idTicket' => $idTicket,
                            'id' => $this->getUid($i),
                            'subject' => $this->filterSubjectTicketsNumbers($i),
                            'from' => $this->getFrom($i),
                            'to' => $this->getTo($i),
                            'date' => date('Y-m-d', $this->getDate($i)),
                            'hour' => date('H:m:s', $this->getDate($i)),
                            'body' => $this->getBody($i, $rigthRules, $leftRules) . $this->_posBody,
                        );
                    }
                }
            }
        }    
        return $this->_message;
    }
    
    /**
     * Filtra el cuerpo del mensaje mostrando solo la parte derecha del mismo
     * dependiendo de las reglas de filtrado que se pasen por el segundo parametro
     * 
     * @param string $body El cuerpo del mensaje
     * @param array $rules Las reglas de filtrado del mensaje
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
     * @param string $body El cuerpo del mensaje
     * @param string $rules Las reglas de filtrado
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
     * @param string $ticketNumber El número del ticket
     * @return array
     */
    public function messageByTicketNumber($ticketNumber)
    {
        $idMessages = $this->getIdMessage($ticketNumber);
        if ($idMessages != false) {
            $rigthRules = array('---', '> -', 'de:', 'from:', 'saludos', 'regards', '--Please', 'base64');
            $leftRules = array('quoted-printable');
            $idTicket = Ticket::getId($ticketNumber);
            foreach ($idMessages as $idMessage) {
                $this->_message[] = array(
                    'idTicket' => $idTicket,
                    'id' => $this->getUid($idMessage),
                    'subject' => $this->getSubject($idMessage),
                    'from' => $this->getFrom($idMessage),
                    'to' => $this->getTo($idMessage),
                    'date' => date('Y-m-d', $this->getDate($idMessage)),
                    'hour' => date('H:m:s', $this->getDate($idMessage)),
                    'body' => $this->getBody($idMessage, $rigthRules, $leftRules) . $this->_posBody
                );
            }
            return $this->_message;
        }
        return false;
    }
        
    /**
     * Retorna el subject del mensaje
     * @param integer $messageID El id del mensaje
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
     * Retorna el subject del mensaje si solo tiene un numero de ticket
     * @param integer $messageID EL id del mensaje
     * @return string
     */
    public function filterSubjectTicketsNumbers($messageID)
    {
        try {
            $header = imap_header($this->_inbox, $messageID);
            $subject = utf8_decode(imap_utf8(imap_qprint($header->subject)));
            if (strpos($subject, '<')) {
                $subject = substr($subject,  strpos($subject, '<') + 1, 17);
                $subject = preg_replace('/>/', '', $subject);
                return $subject;
            } else {
                imap_delete($this->_inbox, $messageID);
                imap_expunge($this->_inbox);
                return false;
            }
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
        
    /**
     * Retorna el id del o los mensajes dependiendo del ticketNumber
     * @param string $ticketNumber El número del ticket
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
     * @param int $messageID El id del mensaje
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
     * @param integer $messageID El id del mensaje
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
     * @param integer $messageID El id del mensaje
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
     * @param integer $messageID El id del mensaje
     * @return string
     */
    public function getDate($messageID)
    {
        try {
            $header = imap_header($this->_inbox, $messageID);
            return utf8_decode(imap_utf8(imap_qprint($header->udate)));
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
     * Borra los mensaje por su id y salva la descripción en base de datos
     * @param array $mails Los mails obtenidos del correo
     * @param bolean $save Si es true, se guardará en base de datos los datos los mails obtenidos
     */
    public function deleteMessage($mails, $save = false)
    {
        foreach ($mails as $value) {
            imap_delete($this->_inbox, $value['id'], FT_UID);
            imap_expunge($this->_inbox);
            if ($save) {
                $model = new DescriptionTicket;
                $model->id_ticket=$value['idTicket'];
                $model->description=$value['body'];
                $model->date=$value['date'];
                $model->hour=$value['hour'];
                $model->id_user=CrugeUser2::getUserTicket($value['idTicket'],true)->iduser;
                $model->read_carrier=1;
                $model->read_internal=0;
                $model->response_by=CrugeUser2::getUserTicket($value['idTicket'],true)->iduser;
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