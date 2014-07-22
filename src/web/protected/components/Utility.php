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
     * @param string $date Fecha de creado
     * @param string $hour Hora creado
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
    
    /**
     * Resta dos horas retornando en un formato legible
     * @param string $horaini
     * @param string $horafin
     * @param int $timestamp
     * @return string
     */
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
    
    /**
     * Retorna si un carrier es customer o supplier dependiendo del número del ticket
     * @param string $ticketNumber Número de ticket
     * @return string
     */
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
    
    /**
     * Retorna los dias de semana según una fecha
     * @param string $date La fecha en formato Y-m-d
     * @param string $lang El lenguaje de salida
     * @return type
     */
    public static function formatWeek($date, $lang = 'EN')
    {
        $date = explode('-', $date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        $format = strtotime($day . '-' . $month . '-' . $year); 
        
        switch (date('w', $format)) {
            case '0': return $lang == 'EN' ? 'Sunday' : 'Domingo'; break;
            case '1': return $lang == 'EN' ? 'Monday' : 'Lunes';  break;
            case '2': return $lang == 'EN' ? 'Tuesday' : 'Martes'; break;
            case '3': return $lang == 'EN' ? 'Wednesday' : utf8_decode('Miércoles'); break;
            case '4': return $lang == 'EN' ? 'Thursday' : 'Jueves'; break;
            case '5': return $lang == 'EN' ? 'Friday' : 'Viernes'; break;
            case '6': return $lang == 'EN' ? 'Saturday' : utf8_decode('Sábado'); break;
        }
    }
    
    /**
     * Retorna el día del mes, puede ser en ingles o español
     * @param int $month
     * @param string $lang
     * @return string
     */
    public static function formatMonth($month, $lang = 'EN')
    {
        switch ($month) {
            case '0': return $lang == 'EN' ? 'December' : 'Diciembre'; break;
            case '1': return $lang == 'EN' ? 'January' : 'Enero'; break;
            case '2': return $lang == 'EN' ? 'February' : 'Febrero';  break;
            case '3': return $lang == 'EN' ? 'March' : 'Marzo'; break;
            case '4': return $lang == 'EN' ? 'April' : 'Abril'; break;
            case '5': return $lang == 'EN' ? 'May' : 'Mayo'; break;
            case '6': return $lang == 'EN' ? 'June' : 'Junio'; break;
            case '7': return $lang == 'EN' ? 'July' : 'Julio'; break;
            case '8': return $lang == 'EN' ? 'August' : 'Agosto'; break;
            case '9': return $lang == 'EN' ? 'September' : 'Septiembre';  break;
            case '10': return $lang == 'EN' ? 'October' : 'Octubre'; break;
            case '11': return $lang == 'EN' ? 'November' : 'Noviembre'; break;
            
        }
    }
    
    /**
     * @param string $date
     * @param string $lang
     * @return string
     */
    public static function formatDate($date, $lang = 'EN')
    {
        $_date = $date;
        $date = explode('-', $date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        
        if ($lang != 'EN')
            return self::formatWeek($_date, $lang) . ' ' . $day . ' de ' . self::formatMonth($month, $lang) . ' de ' . $year;
        else
            return self::formatWeek($_date, $lang) . ' ' . $day . ' de ' . self::formatMonth($month, $lang) . ' de ' . $year;
    }
    
    /**
     * Retorna el icono que contendrá los elementos del menú
     * @param string $label el label del menú
     * @return string
     */
    public static function menuIcon($label)
    {
        $icono = '';
        if (is_string($label)) {
            switch (strtolower($label)) {
                case 'tickets': 
                case 'ticket': 
                    $icono = 'icon-box-add on-right on-left'; break;
                case 'manage user': 
                case 'manage users': 
                    $icono = 'icon-user on-right on-left'; break;
            }
        }
        return $icono;
    }
}
