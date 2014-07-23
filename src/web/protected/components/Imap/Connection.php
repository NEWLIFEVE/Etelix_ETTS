<?php
/**
 * Clase para establecer la conexión y cierre de imap
 *
 * @author Nelson Marcano <nelsonm@sacet.biz>
 * @package Imap
 */
abstract class Connection
{
    /**
     * Es el llamado imap_open
     * @var object 
     */
    private $_con;
    
    /**
     * En el contructor se inicia la conexión a imap
     * @param array $key Opcioanl para configurar el host, usuario y contraseña
     * @return object
     * @throws Exception
     */
    protected function __construct($key = false)
    {
        if ($key)
            $this->_con = imap_open($key['IMAP_HOST'], $key['IMAP_USER'], $key['IMAP_PASS']);
        else
            $this->_con = imap_open(Yii::app()->params['IMAP_HOST'], Yii::app()->params['IMAP_USER'], Yii::app()->params['IMAP_PASS']);
        
        if ($this->_con) 
            return $this->_con;
        else
            throw new Exception('Error: ' . imap_last_error());
    }
    
    /**
     * Cierra la conexión a imap
     * @throws Exception
     */
    protected function _disconnect()
    {
        if (!imap_close($this->_con))
            throw new Exception('Error: ' . imap_last_error());
    }
}

