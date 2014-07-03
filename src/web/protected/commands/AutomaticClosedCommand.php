<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AutomaticClosedCommand
 *
 * @author nelson
 */
class AutomaticClosedCommand extends CConsoleCommand 
{
    public function run()
    {
        $interval = '30 days';
        
        $spanish = "Estimado carrier,<br>su ticket ha sido cerrado automáticamente por pasar $interval de no haber recibido actividad,<br>saludos cordiales";
        
        $english = "Estimated carrier,<br>your ticket has been automatically closed from $interval of having received no activity,<br>best regards";
        /**
         * Por defecto se cambiará a status 2 (closed) a los tickets con fecha actual del servidor, 
         * y se buscarán los tickets que su tiempo de vida sea mayor o igual a diez dias
         */
        return new ChangeStatus('2', date('Y-m-d H:i:s'), $interval, $spanish . '<br><br>' . $english);
    }
}
