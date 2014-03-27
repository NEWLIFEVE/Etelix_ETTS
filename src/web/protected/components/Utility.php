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
    
    public static function restarHoras($horaini, $horafin, $timestamp)
    {
            $horai=substr($horaini,0,2);
            $mini=substr($horaini,3,2);
            $segi=substr($horaini,6,2);

            $horaf=substr($horafin,0,2);
            $minf=substr($horafin,3,2);
            $segf=substr($horafin,6,2);

            $ini=((($horai*60)*60)+($mini*60)+$segi);
            $fin=((($horaf*60)*60)+($minf*60)+$segf);

            $dif=$fin-$ini;

            $difh=floor($dif/3600);
            $difm=floor(($dif-($difh*3600))/60);
            $difs=$dif-($difm*60)-($difh*3600);
            $date = date("H:i",mktime($difh,$difm,$difs));
            
            if ($timestamp == 0) {
                return $date;
            } elseif ($timestamp == 1) {
                return $timestamp . ' day ' . $date;
            } elseif ($timestamp >= 2 && $timestamp <= 6) {
                return $timestamp . ' days ' . $date;
            } elseif ($timestamp == 7) {
                return '1 week ' . $date;
            } elseif ($timestamp > 7) {
                return $timestamp . ' days ' . $date;
            } 
    }
    
    public static function formatTicketNumber($ticketNumber)
    {
        if (strpos($ticketNumber, 'C'))
            return 'Customer';
        if (strpos($ticketNumber, 'S') || strpos($ticketNumber, 'P'))
            return 'Supplier';
    }
    
    /**
     * Retorna las iniciales del día de la semana y del mas junto con el día y el año
     * @param string $fecha
     * @return string
     */
    public static function getDayByDate($fecha)
    {
        $fecha = explode('-', $fecha);
        $anio = $fecha[0];
        $mes = $fecha[1];
        $dia = $fecha[2];

        $fechats = strtotime($dia . '-' . $mes . '-' . $anio);  
        return  date('D', $fechats) . ', ' . date('M', $fechats) . ' ' . $dia . ', ' . $anio;
    }
    
    
    
}
?>
