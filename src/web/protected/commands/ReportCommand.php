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
        $nameReport = 'ETTS Automatic Report '. date('Y-m-d His');
        $config = array(
            'date' => date('Y-m-d H:i:s'),
            'option' => '0',
            'carrier' => 'both',
            'octetStream' => false,
            'nameReport' => $nameReport . '.xlsx'
        );
        
        $report->genExcel($config);

        $table = $export->tableSummary();
        if ($table !== null) {
            $mail = new EnviarEmail;
            if(!YII_DEBUG) $Address='noc@etelix.com';
            else $Address='auto@sacet.biz';
            $mail->enviar($table, $Address, '', strtoupper($nameReport), 'uploads/' . $nameReport . '.xlsx');   
        } 
        
    }
}
