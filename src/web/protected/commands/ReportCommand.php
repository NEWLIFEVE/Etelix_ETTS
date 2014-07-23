<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportCommand
 *
 * @author nelson
 */
class ReportCommand extends CConsoleCommand
{
    public function run($args)
    {
        $report = new Report;
        $export = new Export;
        // Fecha de la consulta, se establece al día actual
        $date = date('Y-m-d H:i:s');
        // La categoría del ticket, se establece en todos los abiertos
        $option = '13';
        // El tipo de carrier, se establece en ambos
        $carrier = 'both';
        // Los id's para mostrar la tabla de los tickets
        $ids = $report->getIdsByCategory($option, $date, $carrier);
        // El nombre que recibirá el reporte
        $nameReport = 'ETTS Automatic Report '. date('Y-m-d His');
        // Configuración del reporte en excel
        $config = array(
            'date' => $date,
            'option' => $option,
            'carrier' => $carrier,
            'octetStream' => false,
            'nameReport' => $nameReport . '.xlsx'
        );
        // Se genera el excel
        $report->genExcel($config);
        // Se genera la tabla con el resumen
        $table = $export->tableSummary();
        if ($table !== null) {
            $mail = new EnviarEmail;
            if(!YII_DEBUG) $Address='revista@etelix.com';
            else $Address='auto@sacet.biz';
            // Ruta para conseguir el excel
            $route=Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR . $nameReport . '.xlsx';
            // Se le anexa a la tabla del resumen la tabla con los tieckets dependiendo de la categoría seleccioanda
            $table .= '<center><h3>'. substr($nameReport, 0, -7) .'</h3></center>' . $export->table($ids, $date, 1);
            $mail->enviar($table, $Address, '', strtoupper($nameReport), $route);   
        } 
        
    }
}
