<?php
/**
 * Description of ChangeStatus:
 * 
 * Componente que se encargará de cerrar automáticamente los tickets que cumplan
 * la condiciones dadas para ejecutar el cierre automatico
 *
 * @author Nelson Marcano
 */
class ChangeStatus 
{
    /**
     * Array de los id's del los tickets
     * @var array 
     */
    private $_ids;
    
    /**
     * id del status
     * @var int 
     */
    private $_status;
    
    /**
     * Fecha de búsqueda de los tickets
     * @var string
     */
    private $_date;
    
    /**
     * Intervalo para la fecha de búsqueda
     * @var string
     */
    private $_interval;
    
    /**
     * Descripción que ser verá en el chat del ticket al cerrar el mismo
     * @var string 
     */
    private $_description;

    /**
     * El constructor recibe el status, fecha y la fecha tope para cerrar tickets.
     * @param integer $status Status al cual se cambiará el o los tickets
     * @param string $date Fecha para buscar los tickets
     * @param string $interval Fecha tope para cerrar tickets. Ejemplo: '5 days'
     * @param string $description Descripción que se guardará al cambiar el status del ticket
     */
    public function __construct($status, $date, $interval, $description) 
    {
        $this->_status = $status;
        $this->_date = $date;
        $this->_interval = $interval;
        $this->_description = $description;
        $this->_ids = $this->_getTickets();
        $this->_run();
    }
    
    /**
     * Retorna el id de los tickets que no estén cerrados y la última descripción sea del noc
     * @return array
     */
    private function _getTickets()
    {
        $ids = array();
        $data = DescriptionTicket::model()->findAllBySql(
                "SELECT id_ticket, MAX((date::text || ' ' || hour::text)::timestamp) AS last_description
                 FROM description_ticket
                 WHERE (id_ticket NOT IN(
                    SELECT  dt.id_ticket 
                    FROM description_ticket dt, cruge_authassignment ca
                    WHERE dt.id_user = ca.userid AND itemname IN('cliente') AND dt.date <= '".substr($this->_date, 0, 10)."'::timestamp - '$this->_interval'::interval
                    ) OR id_ticket IN(
                        SELECT id_ticket
                        FROM description_ticket
                        WHERE id_user = 1 AND date <= '".substr($this->_date, 0, 10)."'::timestamp - '$this->_interval'::interval
                        )
                    ) AND date <= '".substr($this->_date, 0, 10)."'::timestamp - '$this->_interval'::interval AND id_ticket IN(
                        SELECT id 
                        FROM ticket
                        WHERE id_status IN(
                            SELECT id 
                            FROM status 
                            WHERE name IN('open', 'escalated')) AND id IN(
                                SELECT id_ticket 
                                FROM mail_ticket 
                                WHERE id_mail_user IN(
                                    SELECT id 
                                    FROM mail_user
                                    )
                                ) AND date <= '".substr($this->_date, 0, 10)."'::timestamp - '$this->_interval'::interval)
                 GROUP BY id_ticket ORDER BY id_ticket ASC"
            );
        if($data!=null)
        {
            foreach($data as $id)
            {
                $ids[] = $id->id_ticket;
            }
        }
        return $ids;
    }
    
    /**
     * Cambia el status del ticket dependiendo de los parámetros que se le pasen al constructor,
     * si devuelve true, se guardará la descripción que sea pasada por el constructor
     */
    private function _run()
    {
        if (!empty($this->_ids)) {
            $isOk = Ticket::model()->updateAll(array('id_status' => $this->_status, 'close_ticket' => $this->_date), 'id IN('.implode(",", $this->_ids).')');
            if ($isOk) {
                $this->_saveDescription();
            }
        }
    }
    
    /**
     * Descripción al cambiar el status del ticket
     */
    private function _saveDescription()
    {
        if (!empty($this->_description)) {
            foreach ($this->_ids as $id) {
                $model = new DescriptionTicket;
                $model->id_ticket = $id;
                $model->description = $this->_description;
                $model->date = substr($this->_date, 0, 10);
                $model->hour = substr($this->_date, 11, 8);
                $model->id_user = 1;       // Siempre se guardará como si el admin cerró el ticket
                $model->read_carrier = 0;  // Estará como no leído para el carrier
                $model->read_internal = 0; // Estará como no leído para los usuarios internos
                $model->response_by = 1;   // Respondido por el admin
                if ($model->save()) {
                    $this->_sendMail($id);
                }
            }
        }
    }
    
    /**
     * Método para manejar el envío del correo
     * @param int $id El id del ticket
     */
    private function _sendMail($id)
    {
        if (!empty($id)) {
            $data = $this->_dataTicket($id);
            // Instancia de los componentes para manejar el subject, el cuerpo del correo y el envío del mail
            $asunto = new Subject;
            $cuerpoCorreo = new CuerpoCorreo($data);
            $mailer = new EnviarEmail;
            // Definiendo el cuerpo
            $body = $cuerpoCorreo->getBodyCloseTicket($data['statusName']);
            // Definiendo el asunto
            $floor = floor(Utility::getTime($data['createDate'], $data['createHour']) / (60 * 60 * 24));
            $restarHoras = Utility::restarHoras($data['createHour'], date('H:i:s'), $floor);
            $subject = $asunto->subjectCloseTicket($data['ticketNumber'], Carrier::getCarriers(true, $id), $restarHoras, 1);
            // Envío del correo
            $mailer->enviar($body, Mail::getNameMails($id), '', $subject);
        }
    }
    
    /**
     * La data del ticket para enviar al correo
     * @param integer $id El id del ticket
     * @return array
     */
    private function _dataTicket($id)
    {
        $data = Ticket::model()->findByPk($id);
        $testedNumber = TestedNumber::getTestedNumberArray($id);
        return array(
            'ticketNumber' => $data->ticket_number, 
            'username' => CrugeUser2::getUserTicket($id),
            'emails' => Mail::getNameMails($id),
            'failure' => $data->idFailure->name,
            'originationIp' => $data->origination_ip,
            'destinationIp' => $data->destination_ip,
            'prefix' => $data->prefix,
            'gmt' => $data->idGmt != null ? $data->idGmt->name : null,
            'testedNumber' => $testedNumber != null ? $testedNumber['number'] : null,
            'country' => $testedNumber != null ? $testedNumber['country'] : null,
            'date' => $testedNumber != null ? $testedNumber['date'] : null,
            'hour' => $testedNumber != null ? $testedNumber['hour'] :  null,
            'description' => 'description',
            'cc' => Mail::getNameMailsCC($id),
            'bcc' => Mail::getNameMailsBcc($id),
            'speech' => null,
            'idTicket' => $id,
            'optionOpen' => $data->option_open,
            'createDate' => $data->date,
            'createHour' => $data->hour,
            'statusName' => $data->idStatus != null ? $data->idStatus->name : null
        );
    }
}
