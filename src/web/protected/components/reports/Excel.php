<?php
//Yii::import('webroot.protected.extensions.phpexcel.Classes.PHPExcel');
abstract class Excel
{
    protected $_phpExcel;
    
    public function __construct() 
    {
        $this->_phpExcel = new PHPExcel();
    }
    
    /**
     * La clase que lo herede, obligatoriamente deberá tener un método  genExcel
     */
    public abstract function genExcel($params);
    
    /**
     * Setear los títulos de la hoja
     */
    protected abstract function _setTitle();

    /**
     * Data que contendra la hoja
     */
    protected abstract function _setData($params);

    /**
     * Estilos de los títulos
     */
    protected abstract function _setStyleHeader();
    
    /**
     * Auto ajustar el tamaño de las columnas
     */
    protected abstract function _setAutoSize();

}