<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MacAddress
 *
 * @author nelson
 */
class MacAddress
{
    private $_returnAarray; 
    public $macAddr; 
    
    /**
     * @param string $osType El tipo de sistema operativo(Linux, Windows, etc)
     * @return string
     */
    public function __construct($osType) 
    {
        $this->_returnAarray = array();
        switch (strtolower($osType)) {
            case 'linux': $this->_forLinux(); break; 
            case 'solaris': break; 
            case 'unix': break; 
            case 'aix': break; 
            default: $this->_forWindows(); break; 
        } 
        
        $tempArray = array(); 
        foreach ($this->_returnAarray as $value) {
            if (preg_match('/((?:[0-9a-f]{2}[:-]){5}[0-9a-f]{2})/i', $value, $tempArray)) {
                $this->macAddr = $tempArray[0]; 
                break; 
            }
        }
        unset($tempArray); 
        return trim($this->macAddr); 
    }
    
    /**
     * Retorna un arreglo con las configuraciones de red del sistema
     * @return array
     */
    private function _forWindows() 
    {
        exec('ipconfig /all', $this->_returnAarray); 
        if ($this->_returnAarray) 
            return $this->_returnAarray; 
        else 
            $ipconfig = $_SERVER['WINDIR']; 
        
        if (is_file($ipconfig)) 
            exec($ipconfig. '/', $this->_returnAarray); 
        else 
            exec($_SERVER['WINDIR'], $this->_returnAarray); 
        
        return utf8_decode($this->_returnAarray); 
    }
    
    /**
     * Retorna un arreglo con las configuraciones de red del sistema
     * @return array
     */
    private function _forLinux() 
    {
        exec('ifconfig -a', $this->_returnAarray); 
        return $this->_returnAarray; 
    } 
}