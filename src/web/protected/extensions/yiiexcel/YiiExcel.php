<?php
/**
 * 
 * Universidad Pedagógica Nacional Fracisco Morazán
 * Dirección de Tecnologías de Información
 * 
 * @author K'iin Balam <kbalam@upnfm.edu.hn>
 * 
 */

/**
 * YiiExcel class - wrapper for PHPExcel
 * 
 * This class provide a wrapper for PHPExcel Autoload. 
 * Please read the README file
 * 
 * This extension is an autoloader for PHPExcel on Yii framework 
 * 
 * @package YiiExcel
 * @author K'iin Balam <kbalam@upnfm.edu.hn>
 * @copyright Copyright (c) 2013 UPNFM
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version 1.0, 2013-01-18
 */
 
class YiiExcel {
    
    public static function Load($pObjectName){
        if ((class_exists($pObjectName)) || (strpos($pObjectName, 'PHPExcel') === False)) {
           return false;
        }
        // this is the code that shows what I am saying
        $pObjectFilePath =  PHPEXCEL_ROOT. str_replace('_',DIRECTORY_SEPARATOR,$pObjectName).'.php';

        if ((file_exists($pObjectFilePath) === false) || (is_readable($pObjectFilePath) === false)) {
            return false;
        }
        require($pObjectFilePath);
    }
}//EPHPExcelAutoloader end