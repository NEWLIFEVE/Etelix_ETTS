<?php
/*date_default_timezone_set('America/Caracas');
//Definimos nuestro servidor de produccion
define('SERVER_NAME_PROD','etts.etelix.com');
//Definimos nuestro servidor de preproduccion
define('SERVER_NAME_PRE_PROD', 'deve.sacet.com.ve');
//Definimos nuestro servidor de desarrollo
define('SERVER_NAME_DEV','etts.local');*/
//Obtenemos el nombre del servidor actual
$server=$_SERVER['SERVER_NAME'];
echo $server;
// change the following paths if necessary
/*$yii='../../../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
switch ($server)
{
	case 'SERVER_NAME_PROD':
		defined('YII_DEBUG') or define('YII_DEBUG',false);
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
		define('SERVER_DB','localhost');
		define('SORI_DB','sori');
		define('ETTS_DB','etts');
		define('PASS_DB','Nsusfd8263');
		break;
	case 'SERVER_NAME_PRE_PROD':
		defined('YII_DEBUG') or define('YII_DEBUG',true);
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
		define('SERVER_DB','localhost');
		define('SORI_DB','dev_sori');
		define('ETTS_DB','dev_etts');
		define('PASS_DB','Nsusfd8263');
		break;
	case 'SERVER_NAME_DEV':
		defined('YII_DEBUG') or define('YII_DEBUG',true);
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
		define('SERVER_DB','172.16.17.190');
		define('SORI_DB','sori');
		define('ETTS_DB','etts');
		define('PASS_DB','123');
		break;
}

require_once($yii);
Yii::createWebApplication($config)->run();*/