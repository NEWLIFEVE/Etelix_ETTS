<?php
/**
 * Description of Connection
 *
 * @author Nelson Marcano
 */
class Connection
{
    private $_con;
    
    protected function __construct()
    {
        $this->_con = imap_open(Yii::app()->params['IMAP_HOST'], Yii::app()->params['IMAP_USER'], Yii::app()->params['IMAP_PASS']);
        
        if ($this->_con) 
            return $this->_con;
        else
            throw new Exception('Error: ' . imap_last_error());
    }
    
    protected function _disconnect()
    {
        if (!imap_close($this->_con))
            throw new Exception('Error: ' . imap_last_error());
    }
}

