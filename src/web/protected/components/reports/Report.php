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
        // Titulo de las hojas
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
        
        // Bucle para setear las hojas
        foreach ($sheetName as $key => $value) {
            $params = array(
                'nameSheet' => $value,
                'index' => $key,
                'data' => $args
            );
            $this->_setData($params);
        }
        
        // Se setea una hoja nueva que contendrá el resumen de los tickets
        $this->_setSummary($args);
        
        $this->_phpExcel->setActiveSheetIndexByName($this->_matchSheetName($args['option']));
        $objWriter = PHPExcel_IOFactory::createWriter($this->_phpExcel, 'Excel2007');
        $file = 'ETTS Report '. $this->_matchSheetName($args['option']) . '-' . date('Y-m-d His') . '.xlsx';
        if ($args['octetStream'] === true) {
            $this->_octetStream($objWriter, $file);
        }
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('uploads' . DIRECTORY_SEPARATOR . $file);
        unset($this->objWriter);
        unset($this->_phpExcel);
        Yii::app()->end();
    }
    
    /**
     * Setea la hoja con el resumen de los tickets por categorias
     * @param array $args
     */
    private function _setSummary($args)
    {
        $sheet = new PHPExcel_Worksheet($this->_phpExcel, 'Summary');
        $this->_phpExcel->addSheet($sheet, 0);
        $this->_phpExcel->setActiveSheetIndexByName('Summary');
        
        $titles = array(
            'A' => 'Category',
            'B' => 'Total',
            'C' => 'Category',
            'D' => 'Total'
        );
        
        foreach ($titles as $key => $value) {
            $this->_phpExcel->getActiveSheet()->setCellValue($key . '1', $value);
        }
        
        $this->_setStyleHeader('A1:D1');
        $this->_setStyleBody('A2:D2', '#FFF');
        $this->_setStyleBody('A3:D3', '#FFDC51');
        $this->_setStyleBody('A4:D4', '#EEB8B8');
        $this->_setStyleBody('A5:D5', '');
        
        $this->_phpExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        
        
        $this->_phpExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'Open today')
                    ->setCellValue('B2', count($this->openOrClose($args['date'], 'white', 'open', $args['carrier'])))
                    ->setCellValue('C2', 'Closed white')
                    ->setCellValue('D2', count($this->openOrClose($args['date'], 'white', 'close', $args['carrier'])))
                
                    ->setCellValue('A3', 'Pending yellow')
                    ->setCellValue('B3', count($this->openOrClose($args['date'], 'yellow', 'open', $args['carrier'])))
                    ->setCellValue('C3', 'Closed yellow')
                    ->setCellValue('D3', count($this->openOrClose($args['date'], 'yellow', 'close', $args['carrier'])))
                
                    ->setCellValue('A4', 'Pending red')
                    ->setCellValue('B4', count($this->openOrClose($args['date'], 'red', 'open', $args['carrier'])))
                    ->setCellValue('C4', 'Closed red')
                    ->setCellValue('D4', count($this->openOrClose($args['date'], 'red', 'close', $args['carrier'])))
                
                    ->setCellValue('A5', 'Pending without activity')
                    ->setCellValue('B5', count($this->withoutDescription($args['date'], $args['carrier'])))
                    ->setCellValue('C5', '')
                    ->setCellValue('D5', '')
                
                    ->setCellValue('A7', 'Total tickets pending')
                    ->setCellValue('B7', count($this->totalTicketsPending($args['date'], $args['carrier'])))
                    ->setCellValue('C7', 'Total tickets closed')
                    ->setCellValue('D7', count($this->totalTicketsClosed($args['date'], $args['carrier'])));
        
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
            $i = 2;
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
        $this->_phpExcel->setActiveSheetIndexByName($params['nameSheet'])->mergeCells('A1:C1');
        $this->_phpExcel->setActiveSheetIndexByName($params['nameSheet'])->mergeCells('D1:M1');
        
        $this->_phpExcel->getActiveSheet()->freezePane('A3');
        
        //Asigno los nombres de las columnas al principio
        $this->_setTitle();
        //Asigno colores a la segunda fila
        $this->_setStyleHeader('A2:M2');
        //Habilito un  auto tamaño en las columnas
        $this->_setAutoSize();
        
        $i = 3;
        // La data que contendrá las hojas dependiendo de la categoria
        $data = $this->optionStatistics(($params['index'] + 1), $params['data']['date'], $params['data']['carrier']);
        if ($data !== null) {
            $this->_phpExcel->getActiveSheet()->setAutoFilter('A2:M2');
            
            // Colocamos un logo a las hojas
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath('images/logo.jpg');

            $objDrawing->setCoordinates('A1');
            $objDrawing->setHeight(200);
            $objDrawing->setWidth(250);
            $objDrawing->setWorksheet($this->_phpExcel->getActiveSheet());
            
            // Definiendo un Subtitulo para la hoja
            $this->_getSubTitleHeader($params['index'], $params['nameSheet']);
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
                $row = $key + 3;
                $this->_setStyleBody('A' . $row. ':M' . $row, $value->color);       
                $i++;
            }
        }
    }
    
    /**
     * Define un subtitulo para cada hoja dependiendo su categoria
     * @param int $index La posición de la hoja
     * @param string $title El titulo de la hoja
     */
    private function _getSubTitleHeader($index, $title)
    {
        $this->_phpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(90);
        $this->_phpExcel->getActiveSheet()->getStyle('D1:M1')->getFont()->setSize(42);
        $this->_phpExcel
                ->getActiveSheet()
                ->getStyle('A1:M1')
                ->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_NONE
                                )
                            ),
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'startcolor' => array(
                                    'argb' => 'FFFFFF',
                                ),
                            )
                        )
                );
        $this->_phpExcel->setActiveSheetIndex($index)->setCellValue('D1', $title);
    }
    
    /**
     * Retorna los estilos de los títulos de la hoja
     * @param string $cell Las celdas a las que se le aplicaran los estilos
     * @return array
     */
    protected function _setStyleHeader($cell) 
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
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
        
        $this->_phpExcel->getActiveSheet()->getStyle($cell)->applyFromArray($style);
    }
    
    /**
     * Define el estilo de las filas dependiendo del color del ticket
     * @param string $cell
     * @param string $color
     */
    private function _setStyleBody($cell, $color)
    {
        $color = $this->_cssTickets($color);
        $style = array(
            'font' => array(
                'bold' => false,
                'color' => array(
                    'argb' => '333333'
                ),
            ),
            'aligment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
        $this->_phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(32);
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
     * @param string $carrier El tipo de carrier a consultar
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
     * @param string $carrier El tipo de carrier a consultar
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
     * @param string $carrier El tipo de carrier a consultar
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
     * @param string $carrier El tipo de carrier a consultar
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
            case '1': $statistcs = $this->openOrClose($date, 'white', 'open', $carrier); break;
            // Pending Yellow
            case '2': $statistcs = $this->openOrClose($date, 'yellow', 'open', $carrier); break;
            // Pending Red
            case '3': $statistcs = $this->openOrClose($date, 'red', 'open', $carrier); break;
            // Pending without activity
            case '4': $statistcs = $this->withoutDescription($date, $carrier); break;
            // Close white
            case '5': $statistcs = $this->openOrClose($date, 'white', 'close', $carrier); break;
            // Close yellow
            case '6': $statistcs = $this->openOrClose($date, 'yellow', 'close', $carrier); break;
            // Close red
            case '7': $statistcs = $this->openOrClose($date, 'red', 'close', $carrier); break;
            // Total tickets open
            case '8': $statistcs = $this->totalTicketsPending($date, $carrier); break;
            // Total tickets closed
            case '9': $statistcs = $this->totalTicketsClosed($date, $carrier); break;
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
            case '1': return 'Open today';  break;
            case '2': return 'Pending yellow';  break;
            case '3': return 'Pending red';  break;
            case '4': return 'Without activity';  break;
            case '5': return 'Close white';  break;
            case '6': return 'Close yellow';  break;
            case '7': return 'Close red';  break;
            case '8': return 'Total pending';  break;
            case '9': return 'Total close';  break;
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
            case '#FFDC51': $style = 'FFFF00'; break;
            case '#EEB8B8': $style = 'FF8080';  break;
            default : $style = 'FFFFCC';  break;
        }
        return $style;
    }
}
