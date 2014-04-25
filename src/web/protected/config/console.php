<?php
$server=gethostname();
if($server==SERVER_NAME_PROD)
{
	$server=dirname(__FILE__);
	$nuevo=explode(DIRECTORY_SEPARATOR,$server);
	$num=count($nuevo);
	if($nuevo[$num-3]==DIRECTORY_NAME_PRE_PROD)
	{
		$server_db='localhost';
                $etts_db='dev_etts';
                $user_db='postgres';
                $pass_db='Nsusfd8263';
	}
	else
	{
		$server_db='localhost';
                $etts_db='etts';
                $user_db='postgres';
                $pass_db='Nsusfd8263';
	}
}
else
{
	$server_db='172.16.17.190';
        $etts_db='etts';
        $user_db='postgres';
        $pass_db='123';
}
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
        'import'=>array(
		'application.models.*',
                'application.components.Imap.*',
		),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
                        'class'=>'system.db.CDbConnection',
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
        'params'=>array(
            'IMAP_HOST'=>'{mail.etelix.com:995/pop3/ssl/novalidate-cert}INBOX',
            'IMAP_USER'=>'etts@etelix.com',
            'IMAP_PASS'=>'3t3l1x.etts'
        ),
);