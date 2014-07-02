<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChangeStatus
 *
 * @author nelson
 */
class ChangeStatus 
{

    private $_ids;
    private $_status;
    
    public function __construct($status, $date, $interval) 
    {
        $this->_status = $status;
        $this->_ids = $this->_getTickets($date, $interval);
    }
    
    public function run($date, $interval)
    {
        foreach ($this->_ids as $id) {
            Ticket::model()->updateByPk($id, array('id_status' => $this->_status, 'close_ticket' => $date));
        }
    }
    
    private function _getTickets($date, $interval)
    {
        $ids = array();
        $data = Ticket::model()->findAll("SELECT id
                                        FROM 
                                        (SELECT *, 
                                        (CASE WHEN (date::text || ' ' || hour::text)::timestamp <= '$date' 
                                                THEN age('$date', (date::text || ' ' || hour::text)::timestamp) 
                                        ELSE
                                                age((date::text || ' ' || hour::text)::timestamp, '$date' ) 
                                        END
                                        ) AS lifetime 
                                        FROM  
                                        (SELECT * 
                                        FROM ticket 
                                        WHERE id IN(SELECT DISTINCT id_ticket FROM mail_ticket WHERE id_mail_user IN(SELECT id FROM mail_user))
                                        ) AS query1
                                        ) AS query2 
                                        WHERE 
                                        id_status <> 2 AND lifetime >= '$interval'::interval");
        if ($data != null) {
            foreach ($data as $id) {
                $ids[] = $id->id;
            }
        }
        return $ids;
    }
    
}
