<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TicketOneDay extends Report 
{
    private $_method;
    
    public function __construct($days) 
    {
        parent::__construct();
        $days = (int) $days;
        $this->_method = $this->_openTicketsOneDay($days);
    }
    
    /**
     * Método para generar el excel
     */
    public function genExcel() 
    {
        $sheetName = array('Tickets a day', 'Total tickets');
        foreach ($sheetName as $key => $value) {
            $params = array(
                'nameSheet' => $value,
                'index' => $key,
                'method' => $this->_method
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
     * Método para obtener los tickets abiertos de 1 día
     * @param int $days dias a consultar
     * @return array
     */
    private function _openTicketsOneDay($days)
    {
        $conditionUser = '';
        if (CrugeAuthassignment::getRoleUser() === 'C') {
            $conditionUser = ' WHERE id_user = ' . Yii::app()->user->id;
        }
        return Ticket::model()
                ->findAllBySql("SELECT *, (age((to_char(NOW(), 'YYYY-MM-DD') || ' ' || to_char(NOW(), 'HH24:MI:SS'))::timestamp, (to_char(date, 'YYYY-MM-DD') || ' ' || to_char(hour, 'HH24:MI:SS'))::timestamp)) AS lifetime
                               FROM ticket WHERE 
                               date >= NOW() - '$days days'::interval AND
                               id IN(SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user $conditionUser))");
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
    
}
