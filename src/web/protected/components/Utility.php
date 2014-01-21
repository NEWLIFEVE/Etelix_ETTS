<?php
/**
 * @package components
 */
abstract class Utility extends CApplicationComponent
{
    /**
     * Init method for the application component mode.
     */
    public function init()
    {
        
    }
    
    /**
     * Método para calcular el tiempo que ha pasado desde el primer momento que
     * se guarda un ticket, retornando en formato unix
     * 
     * @param string $date
     * @param string $hour
     * @return int
     */
    public static function getTime($date, $hour)
    {
        $_date = explode('-', $date);
        $_hour = explode(':', $hour);
        $timestamp = mktime($_hour[0],$_hour[1],$_hour[2], $_date[1],$_date[2],$_date[0]);
        $timeTicket = time() - $timestamp;
        return $timeTicket;
    }
    
}
?>
