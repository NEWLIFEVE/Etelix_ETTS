<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('webroot.protected.extensions.phpexcel.Classes.PHPExcel');
Yii::import('webroot.protected.components.reports.Excel');

class Report extends Excel 
{    
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Método para generar el excel
     */
    public function genExcel($args) 
    {
        $sheetName = array(
            'Open today',
            'Pending yellow',
            'Pending red', 
            'Without activity',
            'Close white',
            'Close yellow',
            'Close red',
            'Total pending',
            'Total close'
        );
        
        foreach ($sheetName as $key => $value) {
            $params = array(
                'nameSheet' => $value,
                'index' => $key,
                'data' => $args
            );
            $this->_setData($params);
        }
        
        
        $this->_phpExcel->setActiveSheetIndexByName($this->_matchSheetName($args['option']));
        $objWriter = PHPExcel_IOFactory::createWriter($this->_phpExcel, 'Excel2007');
        $file = 'ETTS Report '. $this->_matchSheetName($args['option']) . '-' . date('Y-m-d His') . '.xlsx';
        if ($args['octetStream'] === true) {
            $this->_octetStream($objWriter, $file);
        }
        $objWriter->save('uploads' . DIRECTORY_SEPARATOR . $file);
        unset($this->objWriter);
        unset($this->_phpExcel);
        Yii::app()->end();
    }
    
    
   /**
    * Generando los titulos de la hoja
    */
    protected function _setTitle() 
    {
        $titles = array(
            'A' => 'N°',
            'B' => 'Failure',
            'C' => 'Status',
            'D' => 'Origination ip',
            'E' => 'Destination ip',
            'F' => 'Date',
            'G' => 'Hour',
            'H' => 'Machine ip',
            'I' => 'Gmt',
            'J' => 'Ticket Number',
            'K' => 'Prefix',
            'L' => 'Country',
            'M' => 'Lifetime',
        );
        foreach ($titles as $key => $value) {
            $i = 1;
            $this->_phpExcel->getActiveSheet()->setCellValue($key . $i, $value);
        }
    }
    
    /**
     * Seteamos la data a la hoja
     * @param array $params
     */
    protected function _setData($params) 
    {
        $sheet = new PHPExcel_Worksheet($this->_phpExcel, $params['nameSheet']);
        $this->_phpExcel->addSheet($sheet, $params['index']);
        $this->_phpExcel->setActiveSheetIndexByName($params['nameSheet']);
        //Asigno los nombres de las columnas al principio
        $this->_setTitle();
        //Asigno colores a la primra fila
        $this->_setStyleHeader();
        //Habilito un  auto tamaño en las columnas
        $this->_setAutoSize();
        //cargo los datos en las celdas
        $i = 2;
        
        $data = $this->optionStatistics($params['index'], $params['data']['date'], $params['data']['carrier']);
        if ($data !== null) {
            foreach ($data as $key => $value) {
                $gmt = $value->idGmt;
                $country = TestedNumber::getNumber($value->id);
                $this->_phpExcel->setActiveSheetIndex($params['index'])
                    ->setCellValue('A' . $i, ($key + 1))
                    ->setCellValue('B' . $i, $value->idFailure->name)
                    ->setCellValue('C' . $i, $value->idStatus->name)
                    ->setCellValue('D' . $i, $value->origination_ip)
                    ->setCellValue('E' . $i, $value->destination_ip)
                    ->setCellValue('F' . $i, $value->date)
                    ->setCellValue('G' . $i, $value->hour)
                    ->setCellValue('H' . $i, $value->machine_ip)
                    ->setCellValue('I' . $i, $gmt !== null ? $gmt->name : '')
                    ->setCellValue('J' . $i, $value->ticket_number)
                    ->setCellValue('K' . $i, $value->prefix)
                    ->setCellValue('L' . $i, $country !== false ? $country->idCountry->name : '')
                    ->setCellValue('M' . $i, $value->lifetime);
                $row = $key + 2;
                $this->_setStyleBody('A' . $row. ':M' . $row, $value->color);       
                $i++;
            }
        }
    }

    /**
     * Retorna los estilos de los títulos de la hoja
     * @return array
     */
    protected function _setStyleHeader() 
    {
        $style = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'argb' => '808080'
                ),
            ),
            'aligment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE,
                    'color' => array(
                        'argb' => '00000000',
                    )
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'argb' => 'C0C0C0',
                ),
            )
        );
        
        $this->_phpExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($style);
    }
    
    private function _setStyleBody($cell, $color)
    {
        $color = $this->_cssTickets($color);
        $style = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'argb' => '808080'
                ),
            ),
            'aligment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE,
                    'color' => array(
                        'argb' => '00000000',
                    )
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'argb' => $color,
                ),
            )
        );
        
        $this->_phpExcel->getActiveSheet()->getStyle($cell)->applyFromArray($style);
    }
    
    /**
     * Ajuste del tamaño de las celdas
     */
    protected function _setAutoSize() 
    {
        $this->_phpExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    }
    
        
    /**
     * Metodo para soltar el excel en pantalla
     * @param object $objWriter Llamado del PHPExcel_IOFactory::createWriter 
     * @param string $file Nombre del  archivo
     */
    private function _octetStream($objWriter, $file)
    {
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$file.'"');
        header('Pragma: cache');
        header('Expires: 0');
        $objWriter->save('php://output');
    }
    
    
    /**
     * tickets no gestionados en la fecha seleccionada(tickets que no tienes 
     * descripciones en esa fechan de parte del equipo Etelix)
     * @param string $date Fecha para hacer la consulta
     * @return array
     */
    public function withoutDescription($date, $carrier = 'both')
    {
        $selectCarrier = $this->_carrierInQuery($carrier);
        $colorAndLifeTime = "SELECT *,
                            (CASE WHEN lifetime < '1 days'::interval THEN '#FFF' 
                            WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN '#FFDC51'
                            WHEN lifetime >= '2 days'::interval THEN '#EEB8B8' END) AS color 
                            FROM (
                            SELECT *,
                            (CASE WHEN age(date, '$date') < '1 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END)  
                            WHEN age(date, '$date') >= '1 days'::interval AND age(date, '$date') < '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) 
                            WHEN age(date, '$date') >= '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) END) AS lifetime
                            FROM";
        
        return Ticket::model()
                ->findAllBySql("$colorAndLifeTime (SELECT *, 
                                (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' WHEN ticket_number LIKE '%C%' THEN 'Customer' END) AS carrier, 
                                (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                                FROM ticket WHERE id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) AND
                                id NOT IN(SELECT id_ticket FROM description_ticket WHERE date = '$date' GROUP BY id_ticket HAVING COUNT(id_ticket) >= 2)) AS tiempo) AS colores 
                                WHERE date <= '$date' AND (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier ORDER BY id ASC");
    }
    
    /**
     * Método para retornar los reportes estadísticos
     * @param string $date Fecha de la consulta
     * @param string $color Color del ticket dependiendo de su tiempo de vida
     * @param string $status Si el ticket es cerrado o abierto 
     * @return array
     */
    public function openOrClose($date, $color = 'white', $status = 'close', $carrier = 'both')
    {
        $subQuery = $this->_subQuery($date, $color, $status);
        $selectCarrier = $this->_carrierInQuery($carrier);
        $colorAndLifeTime = "SELECT *,
                            (CASE WHEN lifetime < '1 days'::interval THEN '#FFF' 
                            WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN '#FFDC51'
                            WHEN lifetime >= '2 days'::interval THEN '#EEB8B8' END) AS color 
                            FROM (
                            SELECT *,
                            (CASE WHEN age(date, '$date') < '1 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END)  
                            WHEN age(date, '$date') >= '1 days'::interval AND age(date, '$date') < '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) 
                            WHEN age(date, '$date') >= '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) END) AS lifetime
                            FROM";
        
        return Ticket::model()
                ->findAllBySql("$colorAndLifeTime  (SELECT *, 
                                (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' WHEN ticket_number LIKE '%C%' THEN 'Customer' END) AS carrier, 
                                (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                                FROM ticket WHERE 
                                id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user))) AS tiempo) AS colores 
                                $subQuery $selectCarrier ORDER BY id ASC");
    }
    
    /**
     * Retorna la condición que se pasara a los reportes estadísticos
     * @param string $date Fecha de la consulta
     * @param string $color Color del ticket dependiendo de su tiempo de vida
     * @param string $status Si el ticket es cerrado o abierto 
     * @return string
     */
    private function _subQuery($date, $color, $status)
    {
        $subQuery = '';
        
        switch ($color) {
            case 'white':
                if ($status === 'close') {
                    $subQuery = " WHERE lifetime < '1 days'::interval AND substr(close_ticket::text, 1, 10) = '$date'";
                } else {
                    $subQuery = " WHERE lifetime < '1 days'::interval  AND date = '$date' AND (close_ticket IS NULL OR close_ticket > '$date')";
                }
            break;
                
            case 'yellow':
                if ($status === 'close') {
                    $subQuery = " WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval AND substr(close_ticket::text, 1, 10) <= '$date'";
                } else {
                    $subQuery = " WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval  AND date <= '$date' AND (close_ticket IS NULL OR close_ticket > '$date')";
                }
            break;
            
            case 'red':
                if ($status === 'close') {
                    $subQuery = " WHERE lifetime >= '2 days'::interval AND substr(close_ticket::text, 1, 10) <= '$date'";
                } else {
                    $subQuery = " WHERE lifetime >= '2 days'::interval AND date <= '$date' AND (close_ticket IS NULL OR close_ticket > '$date')";
                }
            break;
        }
        
        return $subQuery;
    }
    
    /**
     * Filtra por carrier si es seleccionado alguno
     * @param string $carrier Carrier puede ser customer, supplier o both
     * @return stirng
     */
    private function _carrierInQuery($carrier)
    {
        $subQuery = '';
        
        if ($carrier != 'both') {
            $subQuery = " AND carrier = '$carrier'";
        }
        return $subQuery;
    }
    
    /**
     * Retorna la union de todos las consultas de reportes de tickets pendientes
     * @param string $date Fecha de la consulta
     * @return array
     */
    public function totalTicketsPending($date, $carrier = 'both')
    {
        $selectCarrier = $this->_carrierInQuery($carrier);
        $begin = "SELECT *,
                (CASE WHEN lifetime < '1 days'::interval THEN '#FFF' 
                WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN '#FFDC51'
                WHEN lifetime >= '2 days'::interval THEN '#EEB8B8' END) AS color 
                FROM (
                SELECT *,
                (CASE WHEN age(date, '$date') < '1 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END)  
                WHEN age(date, '$date') >= '1 days'::interval AND age(date, '$date') < '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) 
                WHEN age(date, '$date') >= '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) END) AS lifetime

                FROM

                (SELECT *, 
                (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' WHEN ticket_number LIKE '%C%' THEN 'Customer' END) AS carrier, 
                (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                FROM ticket WHERE id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) 
                ) AS tiempo) AS colores ";
        $query  = " $begin WHERE lifetime >= '2 days'::interval AND date <= '$date' AND (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval  AND date <= '$date' AND (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime < '1 days'::interval  AND date = '$date' AND (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier UNION ";
        $query .= " $begin WHERE date <= '$date' AND (close_ticket IS NULL OR close_ticket > '$date') AND id NOT IN(SELECT id_ticket FROM description_ticket WHERE date = '$date' GROUP BY id_ticket HAVING COUNT(id_ticket) >= 2) $selectCarrier ORDER BY id ASC";
        return Ticket::model()->findAllBySql($query);
    }
    
    /**
     * Retorna la union de todos las consultas de reportes de tickets cerrados
     * @param string $date Fecha de la consulta
     * @return type
     */
    public function totalTicketsClosed($date, $carrier = 'both')
    {
        $selectCarrier = $this->_carrierInQuery($carrier);
        $begin = "SELECT *,
                (CASE WHEN lifetime < '1 days'::interval THEN '#FFF' 
                WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN '#FFDC51'
                WHEN lifetime >= '2 days'::interval THEN '#EEB8B8' END) AS color 
                FROM (
                SELECT *,
                (CASE WHEN age(date, '$date') < '1 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END)  
                WHEN age(date, '$date') >= '1 days'::interval AND age(date, '$date') < '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) 
                WHEN age(date, '$date') >= '2 days'::interval THEN (CASE WHEN date < '$date' THEN age('$date', date) ELSE age(date, '$date') END) END) AS lifetime

                FROM

                (SELECT *, 
                (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' WHEN ticket_number LIKE '%C%' THEN 'Customer' END) AS carrier, 
                (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                FROM ticket WHERE id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) 
                ) AS tiempo) AS colores ";
        $query  = " $begin WHERE lifetime >= '2 days'::interval AND substr(close_ticket::text, 1, 10) <= '$date' $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval AND substr(close_ticket::text, 1, 10) <= '$date' $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime < '1 days'::interval AND substr(close_ticket::text, 1, 10) = '$date' $selectCarrier ORDER BY id ASC";
        return Ticket::model()->findAllBySql($query);
    }
    
    /**
     * Retorna los tickets dependiendo de la categoria
     * @param int $option La categoría 
     * @param string $date Fecha que se realiza la consulta
     * @param string $carrier Si se busca por carrier
     * @return null|array
     */
    public function optionStatistics($option, $date, $carrier)
    {
        switch ($option) {
            // Open Today
            case '0': $statistcs = $this->openOrClose($date, 'white', 'open', $carrier); break;
            // Pending Yellow
            case '1': $statistcs = $this->openOrClose($date, 'yellow', 'open', $carrier); break;
            // Pending Red
            case '2': $statistcs = $this->openOrClose($date, 'red', 'open', $carrier); break;
            // Pending without activity
            case '3': $statistcs = $this->withoutDescription($date, $carrier); break;
            // Close white
            case '4': $statistcs = $this->openOrClose($date, 'white', 'close', $carrier); break;
            // Close yellow
            case '5': $statistcs = $this->openOrClose($date, 'yellow', 'close', $carrier); break;
            // Close red
            case '6': $statistcs = $this->openOrClose($date, 'red', 'close', $carrier); break;
            // Total tickets open
            case '7': $statistcs = $this->totalTicketsPending($date, $carrier); break;
            // Total tickets closed
            case '8': $statistcs = $this->totalTicketsClosed($date, $carrier); break;
        }
            
        
        if ($statistcs !== null) {
            return $statistcs;
        }
        
        return null;
    }
    
    /**
     * Retorna el nombre del reporte, este debe ser igual al de la hoja excel
     * @param int $option Categoría seleccionada
     * @return string
     */
    private function _matchSheetName($option)
    {
        switch ($option) {
            case '0': return 'Open today';  break;
            case '1': return 'Pending yellow';  break;
            case '2': return 'Pending red';  break;
            case '3': return 'Without activity';  break;
            case '4': return 'Close white';  break;
            case '5': return 'Close yellow';  break;
            case '6': return 'Close red';  break;
            case '7': return 'Total pending';  break;
            case '8': return 'Total close';  break;
            default : 'Open today'; break;
        }
    }
    
    /**
     * Define  el color del reporte dependiendo la categoria y el lifetime del ticket
     * @param string $color
     * @return string
     */
    private function _cssTickets($color)
    {
        $style = '';
        switch ($color) {
            case '#FFF':    $style = 'FFFFFF'; break;
            case '#FFDC51': $style = 'FFFF99'; break;
            case '#EEB8B8': $style = 'FF8080';  break;
        }
        return $style;
    }
}
