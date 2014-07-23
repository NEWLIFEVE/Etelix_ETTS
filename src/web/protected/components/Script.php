<?php
/**
 * @author Nelson Marcano <nelsonm@sacet.biz>
 * @package components
 */
abstract class Script
{
    /**
     * Registra el codigo css y js del datatable
     */
    public static function registerDataTable()
    {
        self::registerCss(array('datatable', 'demo_table_jui'));
        self::registerJqueryPlugins(array('dataTables.min'));
    }
    
    /**
     * Registra el plugin jquery.uploadfile
     */
    public static function registerUploadFile()
    {
        self::registerCss(array('uploadfile'));
        self::registerJqueryPlugins(array('uploadfile'));
    }


    /**
     * Registra los módulos que usará el action
     * @param array $modules Modulos que seran pasados como un arreglo
     * @throws Exception
     */
    public static function registerModules($modules = array())
    {
        $cs = Yii::app()->getClientScript();
        if (is_array($modules)) {
            foreach ($modules as $js) {
                $cs->registerScriptFile(Yii::app()->baseUrl . '/js/modules/etts.' . $js . '.js', CClientScript::POS_END);
            }
        } else {
            throw new Exception('Error in module javascript');
        }
    }
    
    /**
     * Registra los nombres de los plugins que se usaran en el sistema
     * @param array $jquery Array de los nombres de los plugins
     * @throws Exception
     */
    public static function registerPlugins($jquery = array())
    {
        $cs = Yii::app()->getClientScript();
        if (is_array($jquery)) {
            foreach ($jquery as $js) {
                $cs->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/' . $js . '.js', CClientScript::POS_END);
            }
        } else {
            throw new Exception('Error in pluging');
        }
    }
    
    /**
     * Registra plugins jquery que seran usados en actions
     * @param array $jquery Plugins Jquery
     * @throws Exception
     */
    public static function registerJqueryPlugins($jquery = array())
    {
        $cs = Yii::app()->getClientScript();
        if (is_array($jquery)) {
            foreach ($jquery as $js) {
                $cs->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.' . $js . '.js', CClientScript::POS_END);
            }
        } else {
            throw new Exception('Error in jquery');
        }
    }
    
    /*
     * Descomentar para usar highcharts
    public static function registerChartsPlugin()
    {
        $cs = Yii::app()->getClientScript();
        $javascript = array('highcharts', 'highcharts-3d', 'exporting');
        
        foreach ($javascript as $js) {
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/charts/' . $js . '.js', CClientScript::POS_END);
        }
    }*/
    
    /**
     * Registra los estilos css
     * @param array $style Estilos de la aplicacion
     * @throws Exception
     */
    public static function registerCss($style = array())
    {
        $cs = Yii::app()->getClientScript();
        if (is_array($style)) {
            foreach ($style as $css) {
                $cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/' . $css . '.css');
            }
        } else {
            throw new Exception('Error in css');
        }
    }
    
    /**
     * Registro los scripts propios de cada controller
     * @param array $javascript Nombres de los scripts que seran usados en el sistema
     * @param string $controller Nombre del controlado
     * @throws Exception
     */    
    public static function registerJsController($javascript = array(), $controller = false)
    {        
        $cs = Yii::app()->getClientScript();
        if ($controller) {
            $controller = $controller;
        } else {
            $controller = Yii::app()->getController()->id;
            if ($controller === 'ticket') $controller .= 's';
        }
        
        if (is_array($javascript)) {
            foreach ($javascript as $js) {
                $cs->registerScriptFile(Yii::app()->baseUrl . '/js/' . $controller . '/' . $js . '.js', CClientScript::POS_END);
            }
        } else {
            throw new Exception('Error in javascript');
        }
    }
    
    /**
     * Registra los scripts propios de cada action, siempre y cuando el archivo 
     * javascript tenga el mismo nombre del action, y la carpeta que lo contiene
     * tenga el nombre del controlador
     * @param string $controller El nombre del controlador
     * @param string $action El nombre del action
     */
    public static function registerJsAction($controller = false, $action = false)
    {
        $cs = Yii::app()->getClientScript();
        if ($controller) {
            $controller = $controller;
        } else {
            $controller = Yii::app()->getController()->id;
            if ($controller === 'ticket') $controller .= 's';
        }
        
        if ($action) {
            $action = $action;
        } else {
            $action = Yii::app()->getController()->action->id;
        }
        
        $path = YiiBase::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR .  'js' . DIRECTORY_SEPARATOR . $controller . DIRECTORY_SEPARATOR . $action . '.js';
        if (file_exists($path)) {
            $cs->registerScriptFile(Yii::app()->baseUrl . '/js/' . $controller . '/' . $action . '.js', CClientScript::POS_END);
        } else {
            return false;
        }
    }
}