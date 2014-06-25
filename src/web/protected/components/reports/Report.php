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
               
        $this->_phpExcel->getDefaultStyle()->applyFromArray(
            array(
                'fill' => array(
                    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'FFFFFF')
                ),
            )
        );
        
        // Titulo de las hojas
        $sheetName = array(
            'Open white',
            'Open yellow',
            'Open red', 
            'Closed white',
            'Closed yellow',
            'Closed red',
            'No activity white',
            'No activity yellow',
            'No activity red',
            'Escalated white',
            'Escalated yellow',
            'Escalated red',
            'Total open',
            'Total closed',
            'Total no activity',
            'Total escalated'
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
        
        // Activamos la hoja dependiendo del radiobutton que sea seleccioando
        $this->_phpExcel->setActiveSheetIndex($args['option']);
        $objWriter = PHPExcel_IOFactory::createWriter($this->_phpExcel, 'Excel2007');
        $file = $args['nameReport'];
        if ($args['octetStream'] === true) {
            $this->_octetStream($objWriter, $file);
        }
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('uploads' . DIRECTORY_SEPARATOR . $file);
        unset($this->objWriter);
        unset($this->_phpExcel);
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
            'B' => 'Total'
        );
        
        foreach ($titles as $key => $value) {
            $this->_phpExcel->getActiveSheet()->setCellValue($key . '2', $value);
        }
        
        $this->_setStyleHeader('A2:B2');
        $this->_setStyleBody('A3:B3', '#FFF');
        $this->_setStyleBody('A4:B4', '#FFDC51');
        $this->_setStyleBody('A5:B5', '#EEB8B8');
        $this->_setStyleBody('A6:B6', '');
        $this->_setStyleBody('A7:B7', '#FFF');
        $this->_setStyleBody('A8:B8', '#FFDC51');
        $this->_setStyleBody('A9:B9', '#EEB8B8');
        $this->_setStyleBody('A10:B10', '');
        $this->_setStyleBody('A11:B11', '#FFF');
        $this->_setStyleBody('A12:B12', '#FFDC51');
        $this->_setStyleBody('A13:B13', '#EEB8B8');
        $this->_setStyleBody('A14:B14', '');
        $this->_setStyleBody('A15:B15', '#FFF');
        $this->_setStyleBody('A16:B16', '#FFDC51');
        $this->_setStyleBody('A17:B17', '#EEB8B8');
        $this->_setStyleBody('A18:B18', '');
      
        $this->_phpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(90);
        $this->_phpExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setSize(42);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $this->_phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
        
        $this->_getLogo();
        $this->_backgroundLogo('A1:B1');
        
        $this->_phpExcel->setActiveSheetIndex(0)
                    ->setCellValue('B1', 'Summary')
                
                    ->setCellValue('A3', 'Open white')
                    ->setCellValue('B3', count($this->openOrClose($args['date'], 'white', 'open', $args['carrier'])))
                    ->setCellValue('A4', 'Open yellow')
                    ->setCellValue('B4', count($this->openOrClose($args['date'], 'yellow', 'open', $args['carrier'])))
                    ->setCellValue('A5', 'Open red')
                    ->setCellValue('B5', count($this->openOrClose($args['date'], 'red', 'open', $args['carrier'])))
                    ->setCellValue('A6', 'Total open')
                    ->setCellValue('B6', count($this->totalTicketsPending($args['date'], $args['carrier'])))
                
                    ->setCellValue('A7', 'Closed white')
                    ->setCellValue('B7', count($this->openOrClose($args['date'], 'white', 'close', $args['carrier'])))
                    ->setCellValue('A8', 'Closed yellow')
                    ->setCellValue('B8', count($this->openOrClose($args['date'], 'yellow', 'close', $args['carrier'])))
                    ->setCellValue('A9', 'Closed red')
                    ->setCellValue('B9', count($this->openOrClose($args['date'], 'red', 'close', $args['carrier'])))
                    ->setCellValue('A10', 'Total closed')
                    ->setCellValue('B10', count($this->totalTicketsClosed($args['date'], $args['carrier'])))
//                
                    ->setCellValue('A11', 'No activity white')
                    ->setCellValue('B11', count($this->withoutDescription($args['date'], 'white', 'open', $args['carrier'])))
                    ->setCellValue('A12', 'No activity yellow')
                    ->setCellValue('B12', count($this->withoutDescription($args['date'], 'yellow', 'open', $args['carrier'])))
                    ->setCellValue('A13', 'No activity red')
                    ->setCellValue('B13', count($this->withoutDescription($args['date'], 'red', 'open', $args['carrier'])))
                    ->setCellValue('A14', 'Total no activity')
                    ->setCellValue('B14', count($this->totalWithoutDescription($args['date'], $args['carrier'])))
                
                    ->setCellValue('A15', 'Escalated white')
                    ->setCellValue('B15', count($this->ticketEscaladed($args['date'], 'white', 'open', $args['carrier'])))
                    ->setCellValue('A16', 'Escalated yellow')
                    ->setCellValue('B16', count($this->ticketEscaladed($args['date'], 'yellow', 'open', $args['carrier'])))
                    ->setCellValue('A17', 'Escalated red')
                    ->setCellValue('B17', count($this->ticketEscaladed($args['date'], 'red', 'open', $args['carrier'])))
                    ->setCellValue('A18', 'Total escalated')
                    ->setCellValue('B18', count($this->totalTicketEscaladed($args['date'], $args['carrier'])));
        
    }
    
    
   /**
    * Generando los titulos de la hoja
    */
    protected function _setTitle() 
    {
        $titles = array(
            'A' => 'N°',
            'B' => 'Type',
            'C' => 'User',
            'D' => 'Carrier',
            'E' => 'Ticket Number',
            'F' => 'Failure',
            'G' => 'Country',
            'H' => 'Created',
            'I' => 'Closed',
            'J' => 'Lifetime',
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
        $this->_phpExcel->setActiveSheetIndexByName($params['nameSheet'])->mergeCells('D1:J1');
        
        $this->_phpExcel->getActiveSheet()->freezePane('A3');
        
        //Asigno los nombres de las columnas al principio
        $this->_setTitle();
        //Asigno colores a la segunda fila
        $this->_setStyleHeader('A2:J2');
        //Habilito un  auto tamaño en las columnas
        $this->_setAutoSize();
        
        $i = 3;
        // La data que contendrá las hojas dependiendo de la categoria
        $data = $this->optionStatistics(($params['index'] + 1), $params['data']['date'], $params['data']['carrier']);
        if ($data !== null) {
            $this->_phpExcel->getActiveSheet()->setAutoFilter('A2:J2');
            // Seteamos el logo
            $this->_getLogo();
            // Definiendo un Subtitulo para la hoja
            $this->_getSubTitleHeader($params['index'], $params['nameSheet']);
            foreach ($data as $key => $value) {
                $this->_phpExcel->setActiveSheetIndex($params['index'])
                    ->setCellValue('A' . $i, ($key + 1))
                    ->setCellValue('B' . $i, $value->carrier)
                    ->setCellValue('C' . $i, $value->user_open_ticket != null ? $value->idUser->username : Carrier::getCarriers(true, $value->id))
                    ->setCellValue('D' . $i, Carrier::getCarriers(true, $value->id))
                    ->setCellValue('E' . $i, $value->ticket_number)
                    ->setCellValue('F' . $i, $value->idFailure->name)
                    ->setCellValue('G' . $i, TestedNumber::getNumber($value->id) != false ? TestedNumber::getNumber($value->id)->idCountry->name : '')
                    ->setCellValue('H' . $i, $value->date . '/' . $value->hour)
                    ->setCellValue('I' . $i, $value->close_ticket)
                    ->setCellValue('J' . $i, $value->lifetime);
                $row = $key + 3;
                $this->_setStyleBody('A' . $row. ':J' . $row, $value->color);  
                $i++;
            }
        }
    }
    
    /**
     * Logo de las hojas
     */
    private function _getLogo()
    {
        // Colocamos un logo a las hojas
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('images/logo.jpg');

        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(200);
        $objDrawing->setWidth(250);
        $objDrawing->setWorksheet($this->_phpExcel->getActiveSheet());
    }

    /**
     * Define un subtitulo para cada hoja dependiendo su categoria
     * @param int $index La posición de la hoja
     * @param string $title El titulo de la hoja
     */
    private function _getSubTitleHeader($index, $title)
    {
        $this->_phpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(90);
        $this->_phpExcel->getActiveSheet()->getStyle('D1:J1')->getFont()->setSize(42);
        $this->_backgroundLogo('A1:J1');
        $this->_phpExcel->setActiveSheetIndex($index)->setCellValue('D1', $title);
    }
    
    private function _backgroundLogo($cell)
    {
        $this->_phpExcel
                ->getActiveSheet()
                ->getStyle($cell)
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
     * Método para retornar el string de la consulta que contendrá el color, lifetime y tipo de carrier
     * @param string $date Fecha de la consulta
     * @return string
     */
    public function getFullTicket($date)
    {
        $select="SELECT *,
                        (CASE WHEN lifetime < '1 days'::interval 
                                THEN '#FFF' 
                        WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval 
                                THEN '#FFDC51'
                        WHEN lifetime >= '2 days'::interval 
                                THEN '#EEB8B8' 
                        END
                        ) AS color
                FROM 
                        (SELECT *, 
                                (CASE WHEN (date::text || ' ' || hour::text)::timestamp <= '$date' 
                                        THEN age('$date', (date::text || ' ' || hour::text)::timestamp) 
                                ELSE
                                        age((date::text || ' ' || hour::text)::timestamp, '$date' ) 
                                END
                                ) AS lifetime 
                        FROM  
                                (SELECT *, 
                                        (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' 
                                                THEN 'Supplier' 
                                        WHEN ticket_number LIKE '%C%' 
                                                THEN 'Customer' 
                                        END
                                        ) AS carrier,
                                        
                                        (CASE WHEN option_open = 'etelix_to_carrier' 
                                                THEN id_user 
                                        END
                                        ) AS user_open_ticket  
                                FROM ticket 
                                WHERE id IN(SELECT DISTINCT id_ticket FROM mail_ticket WHERE id_mail_user IN(SELECT id FROM mail_user))
                                ) AS query1
                        ) AS query2  ";
        return $select;
    }
        
    /**
     * Retorna los tickets escalados
     * @param string $date
     * @param string $color Color del ticket dependiendo de su tiempo de vida
     * @param string $status Si el ticket es cerrado o abierto
     * @param string $carrier
     * @return array
     */
    public function ticketEscaladed($date, $color = 'white', $status = 'open', $carrier = 'both')
    {
        $select = $this->getFullTicket($date);
        $subQuery = $this->_subQuery($date, $color, $status);
        $selectCarrier = $this->_carrierInQuery($carrier);
        return Ticket::model()->findAllBySql("$select $subQuery $selectCarrier AND
                                            id_status = 3                                              
                                            ORDER BY id_status, date, hour ASC");
    }
    
    /**
     * tickets no gestionados en la fecha seleccionada(tickets que no tienes 
     * descripciones en esa fechan de parte del equipo Etelix)
     * @param string $date Fecha para hacer la consulta
     * @param string $color Color del ticket dependiendo de su tiempo de vida
     * @param string $status Si el ticket es cerrado o abierto
     * @param string $carrier El tipo de carrier a consultar
     * @return array
     */
    public function withoutDescription($date, $color = 'white', $status = 'open', $carrier = 'both')
    { 
        $select = $this->getFullTicket($date);
        $subQuery = $this->_subQuery($date, $color, $status);
        $selectCarrier = $this->_carrierInQuery($carrier);
        return Ticket::model()
                ->findAllBySql("$select $subQuery $selectCarrier AND
                                id NOT IN(SELECT id_ticket FROM description_ticket WHERE date = '".substr($date, 0, 10)."' GROUP BY id_ticket HAVING COUNT(id_ticket) >= 2) AND
                                option_open = 'etelix_to_carrier' 
                                ORDER BY id_status, date, hour ASC");
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
        $select = $this->getFullTicket($date);
        $subQuery = $this->_subQuery($date, $color, $status);
        $selectCarrier = $this->_carrierInQuery($carrier);
        return Ticket::model()->findAllBySql("$select $subQuery $selectCarrier ORDER BY id_status, date, hour ASC");
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
                    $subQuery = " WHERE lifetime < '1 days'::interval AND substr(close_ticket::text, 1, 10) = '".substr($date, 0, 10)."'";
                } else {
                    $subQuery = " WHERE lifetime < '1 days'::interval  AND date <= '".substr($date, 0, 10)."' AND (close_ticket IS NULL OR close_ticket > '$date')";
                }
            break;
                
            case 'yellow':
                if ($status === 'close') {
                    $subQuery = " WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval AND substr(close_ticket::text, 1, 10) = '".substr($date, 0, 10)."'";
                } else {
                    $subQuery = " WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval  AND date <= '".substr($date, 0, 10)."' AND (close_ticket IS NULL OR close_ticket > '$date')";
                }
            break;
            
            case 'red':
                if ($status === 'close') {
                    $subQuery = " WHERE lifetime >= '2 days'::interval AND substr(close_ticket::text, 1, 10) = '".substr($date, 0, 10)."'";
                } else {
                    $subQuery = " WHERE lifetime >= '2 days'::interval AND date <= '".substr($date, 0, 10)."' AND (close_ticket IS NULL OR close_ticket > '$date')";
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
        $select = $this->getFullTicket($date);
        $begin = "$select ";
        $query  = " $begin WHERE lifetime >= '2 days'::interval AND date <= '".substr($date, 0, 10)."' AND (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval  AND date <= '".substr($date, 0, 10)."' AND (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime < '1 days'::interval  AND date <= '".substr($date, 0, 10)."' AND (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier UNION ";
        $query .= " $begin WHERE date = '".substr($date, 0, 10)."' AND (close_ticket IS NULL OR close_ticket > '$date') AND id NOT IN(SELECT id_ticket FROM description_ticket WHERE date = '".substr($date, 0, 10)."' GROUP BY id_ticket HAVING COUNT(id_ticket) >= 2) AND option_open <> 'etelix_to_carrier' $selectCarrier ORDER BY id_status, date, hour ASC";
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
        $select = $this->getFullTicket($date);
        $begin = "$select ";
        $query  = " $begin WHERE lifetime >= '2 days'::interval AND substr(close_ticket::text, 1, 10) = '".substr($date, 0, 10)."' $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime >= '1 days'::interval AND lifetime < '2 days'::interval AND substr(close_ticket::text, 1, 10) = '".substr($date, 0, 10)."' $selectCarrier UNION ";
        $query .= " $begin WHERE lifetime < '1 days'::interval AND substr(close_ticket::text, 1, 10) = '".substr($date, 0, 10)."' $selectCarrier ORDER BY id_status, date, hour ASC";
        return Ticket::model()->findAllBySql($query);
    }
    
    /**
     * tickets no gestionados en la fecha seleccionada(tickets que no tienes 
     * descripciones en esa fechan de parte del equipo Etelix)
     * @param string $date Fecha para hacer la consulta
     * @param string $carrier El tipo de carrier a consultar
     * @return array
     */
    public function totalWithoutDescription($date, $carrier = 'both')
    { 
        $select = $this->getFullTicket($date);
        $selectCarrier = $this->_carrierInQuery($carrier);
        return Ticket::model()
                ->findAllBySql("$select WHERE date <= '".substr($date, 0, 10)."' AND
                                (close_ticket IS NULL OR close_ticket > '$date') $selectCarrier AND
                                id NOT IN(SELECT id_ticket FROM description_ticket WHERE date = '".substr($date, 0, 10)."' GROUP BY id_ticket HAVING COUNT(id_ticket) >= 2) AND
                                option_open = 'etelix_to_carrier' 
                                ORDER BY id_status, date, hour ASC");
    }
    
    /**
     * Retorna los tickets escalados
     * @param string $date
     * @param string $carrier
     * @return array
     */
    public function totalTicketEscaladed($date, $carrier = 'both')
    {
        $select = $this->getFullTicket($date);
        $selectCarrier = $this->_carrierInQuery($carrier);
        return Ticket::model()->findAllBySql("$select WHERE  date <= '".substr($date, 0, 10)."'
                                            $selectCarrier AND
                                            id_status = 3                                              
                                            ORDER BY id_status, date, hour ASC");
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
            // Open white
            case '1': $statistcs = $this->openOrClose($date, 'white', 'open', $carrier); break;
            // Open Yellow
            case '2': $statistcs = $this->openOrClose($date, 'yellow', 'open', $carrier); break;
            // Open Red
            case '3': $statistcs = $this->openOrClose($date, 'red', 'open', $carrier); break;
            // Closed white
            case '4': $statistcs = $this->openOrClose($date, 'white', 'close', $carrier); break;
            // Close yellow
            case '5': $statistcs = $this->openOrClose($date, 'yellow', 'close', $carrier); break;
            // Close red
            case '6': $statistcs = $this->openOrClose($date, 'red', 'close', $carrier); break;
            // No activity white
            case '7': $statistcs = $this->withoutDescription($date, 'white', 'open', $carrier); break;
            // No activity yellow
            case '8': $statistcs = $this->withoutDescription($date, 'yellow', 'open', $carrier); break;
            // No activity red
            case '9': $statistcs = $this->withoutDescription($date, 'red', 'open', $carrier); break;
            // Escalated whtie
            case '10': $statistcs = $this->ticketEscaladed($date, 'white', 'open', $carrier); break;
            // Escalated yellow
            case '11': $statistcs = $this->ticketEscaladed($date, 'yellow', 'open', $carrier); break;
            // Escalated red
            case '12': $statistcs = $this->ticketEscaladed($date, 'red', 'open', $carrier); break;
            
            // Total abiertos
            case '13': $statistcs = $this->totalTicketsPending($date, $carrier); break;
            // Total cerrados
            case '14': $statistcs = $this->totalTicketsClosed($date, $carrier); break;
            // Total sin actividad
            case '15': $statistcs = $this->totalWithoutDescription($date, $carrier); break;
            // Total escalados
            case '16': $statistcs = $this->totalTicketEscaladed($date, $carrier); break;
        }
        
        if ($statistcs !== null) {
            return $statistcs;
        }
        
        return null;
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
            case '#B3C9E2': $style = '808080';  break;
            default : $style = 'C0C0C0';  break;
        }
        return $style;
    }
}
