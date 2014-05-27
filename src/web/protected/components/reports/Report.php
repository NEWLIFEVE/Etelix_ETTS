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
        $sheetName = array('Tickets a day', 'Total tickets');
        foreach ($sheetName as $key => $value) {
            $params = array(
                'nameSheet' => $value,
                'index' => $key,
                'method' => $this->_openTicketsOneDay($args)
            );
            $this->_setData($params);
        }
        $this->_phpExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($this->_phpExcel, 'Excel2007');
        $file = 'Tickets ' . date('Y-m-d His') . '.xlsx';
        $this->_octetStream($objWriter, $file);
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
        foreach ($params['method'] as $key => $value) {
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
            $i++;
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
                    'argb' => 'FF62C25E'
                ),
            ),
            'aligment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array(
                        'argb' => '00000000',
                    )
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'argb' => 'FF615E5E',
                ),
            )
        );
        
        $this->_phpExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($style);
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
     * Método para retornar el total de los tickets
     * @param int $index
     */
    private function _totalRows($index) 
    {
        $this->_phpExcel->setActiveSheetIndex($index)
                ->setCellValue('L' . ($this->_count + 3), 'Total')
                ->setCellValue('M' . ($this->_count + 3), $this->_count);
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
                            (CASE WHEN lifetime >= '0 hours'::interval AND lifetime <= '23:59 hours'::interval THEN 'white' 
                            WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN 'yellow'
                            WHEN lifetime >= '2 days'::interval THEN 'red' END) AS color 
                            FROM (

                            SELECT *,
                            (CASE WHEN date = '$date' AND close_ticket IS NULL THEN '23:59 hours'::interval  
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) = to_char('$date'::timestamp + '1 days'::interval, 'YYYY-MM-DD') THEN '1 days'::interval 
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) >= to_char('$date'::timestamp + '2 days'::interval, 'YYYY-MM-DD') THEN '2 days'::interval END) AS lifetime

                            FROM";
        
        return Ticket::model()
                ->findAllBySql("$colorAndLifeTime (SELECT *, 
                                (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' ELSE 'Customer' END) AS carrier,
                                (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                                FROM ticket WHERE id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) AND
                                id NOT IN(SELECT id_ticket FROM description_ticket GROUP BY id_ticket HAVING COUNT(id_ticket) >= 2) AND 
                                date = '$date' AND substr(close_ticket::text, 1, 10) <> '$date') AS tiempo) AS colores  $selectCarrier");
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
                            (CASE WHEN lifetime >= '0 hours'::interval AND lifetime <= '23:59 hours'::interval THEN 'white' 
                            WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN 'yellow'
                            WHEN lifetime >= '2 days'::interval THEN 'red' END) AS color 
                            FROM (

                            SELECT *,
                            (CASE WHEN date = '$date' AND close_ticket IS NULL THEN '23:59 hours'::interval  
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) = to_char('$date'::timestamp + '1 days'::interval, 'YYYY-MM-DD') THEN '1 days'::interval 
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) >= to_char('$date'::timestamp + '2 days'::interval, 'YYYY-MM-DD') THEN '2 days'::interval END) AS lifetime

                            FROM";
        
        return Ticket::model()
                ->findAllBySql("$colorAndLifeTime  (SELECT *, 
                                (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' ELSE 'Customer' END) AS carrier, 
                                (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                                FROM ticket WHERE 
                                id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) AND
                                $subQuery) AS tiempo) AS colores $selectCarrier ");
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
                    $subQuery = " date = '".$date."' AND substr(close_ticket::text, 1, 10) = '".$date."'";
                } else {
                    $subQuery = " date = '".$date."' AND close_ticket IS NULL";
                }
            break;
                
            case 'yellow':
                if ($status === 'close') {
                    $subQuery = " date = '".$date."'::timestamp - '1 days'::interval AND substr(close_ticket::text, 1, 10) = '".$date."'";
                } else {
                    $subQuery = " date = '".$date."' AND substr(close_ticket::text, 1, 10) = to_char('".$date."'::timestamp + '1 days'::interval, 'YYYY-MM-DD')";
                }
            break;
            
            case 'red':
                if ($status === 'close') {
                   $subQuery = " date <= '".$date."'::timestamp - '2 days'::interval AND substr(close_ticket::text, 1, 10) = '".$date."'";
                } else {
                    $subQuery = " date = '".$date."' AND substr(close_ticket::text, 1, 10) >= to_char('".$date."'::timestamp + '2 days'::interval, 'YYYY-MM-DD')";
                }
            break;

            default:
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
            $subQuery = " WHERE carrier = '$carrier' ";
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
        
        $query = '';
        $colorAndLifeTime = "SELECT *,
                            (CASE WHEN lifetime >= '0 hours'::interval AND lifetime <= '23:59 hours'::interval THEN 'white' 
                            WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN 'yellow'
                            WHEN lifetime >= '2 days'::interval THEN 'red' END) AS color 
                            FROM (

                            SELECT *,
                            (CASE WHEN date = '$date' AND close_ticket IS NULL THEN '23:59 hours'::interval  
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) = to_char('$date'::timestamp + '1 days'::interval, 'YYYY-MM-DD') THEN '1 days'::interval 
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) >= to_char('$date'::timestamp + '2 days'::interval, 'YYYY-MM-DD') THEN '2 days'::interval END) AS lifetime

                            FROM";
        
        $sql = "SELECT *, 
                 (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' ELSE 'Customer' END) AS carrier, 
                 (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                 FROM ticket WHERE 
                 id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) ";
         $query .= " $colorAndLifeTime ( $sql AND date = '".$date."' AND close_ticket IS NULL ";
         $query .= " UNION $sql AND date = '".$date."' AND substr(close_ticket::text, 1, 10) = to_char('".$date."'::timestamp + '1 days'::interval, 'YYYY-MM-DD') ";
         $query .= " UNION $sql AND date = '".$date."' AND substr(close_ticket::text, 1, 10) >= to_char('".$date."'::timestamp + '2 days'::interval, 'YYYY-MM-DD') ";
         $query .= " UNION $sql AND id NOT IN(SELECT id_ticket FROM description_ticket GROUP BY id_ticket HAVING COUNT(id_ticket) >= 2) AND date = '$date' AND substr(close_ticket::text, 1, 10) <> '$date') AS tiempo) AS colores $selectCarrier";
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
        $colorAndLifeTime = "SELECT *,
                            (CASE WHEN lifetime >= '0 hours'::interval AND lifetime <= '23:59 hours'::interval THEN 'white' 
                            WHEN lifetime >= '1 days'::interval AND lifetime < '2 days'::interval THEN 'yellow'
                            WHEN lifetime >= '2 days'::interval THEN 'red' END) AS color 
                            FROM (

                            SELECT *,
                            (CASE WHEN date = '$date' AND close_ticket IS NULL THEN '23:59 hours'::interval  
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) = to_char('$date'::timestamp + '1 days'::interval, 'YYYY-MM-DD') THEN '1 days'::interval 
                            WHEN date = '$date' AND substr(close_ticket::text, 1, 10) >= to_char('$date'::timestamp + '2 days'::interval, 'YYYY-MM-DD') THEN '2 days'::interval END) AS lifetime

                            FROM";
        $query = '';
        $sql = "SELECT *, 
                 (CASE WHEN ticket_number LIKE '%S%' OR ticket_number LIKE '%P%' THEN 'Supplier' ELSE 'Customer' END) AS carrier, 
                 (CASE WHEN option_open = 'etelix_to_carrier' THEN id_user END) AS user_open_ticket 
                 FROM ticket WHERE 
                 id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user)) ";
         $query .= "$colorAndLifeTime ( $sql AND date = '".$date."' AND substr(close_ticket::text, 1, 10) = '".$date."' ";
         $query .= " UNION $sql AND date = '".$date."'::timestamp - '1 days'::interval AND substr(close_ticket::text, 1, 10) = '".$date."' ";
         $query .= " UNION $sql AND date <= '".$date."'::timestamp - '2 days'::interval AND substr(close_ticket::text, 1, 10) = '".$date."') AS tiempo) AS colores $selectCarrier ";
         
        return Ticket::model()->findAllBySql($query);
    }
}
