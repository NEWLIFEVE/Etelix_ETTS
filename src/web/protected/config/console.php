<?php
$server=$_SERVER['SERVER_NAME'];
switch ($server)
{
	case SERVER_NAME_PROD:
		$server_db='localhost';
		$sori_db='sori';
		$etts_db='etts';
		$pass_db='Nsusfd8263';
		break;
	case SERVER_NAME_PRE_PROD:
		$server_db='localhost';
		$sori_db='dev_sori';
		$etts_db='dev_etts';
		$pass_db='Nsusfd8263';
		break;
	case SERVER_NAME_DEV:
	default:
		$server_db='172.16.17.190';
		$sori_db='sori';
		$etts_db='etts';
		$pass_db='123';
		break;
}
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'pgsql:host='.$server_db.';port=5432;dbname='.$etts_db,
			'emulatePrepare' => true,
			'username' => 'postgres',
			'password' => $pass_db,
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);