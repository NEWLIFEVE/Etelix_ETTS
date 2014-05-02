<?php
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ETTS Console',
	'timeZone'=>'America/Caracas',
	// preloading 'log' component
	'preload'=>array('log'),
        'import'=>array(
        	'application.models.*',
			'application.components.Imap.*',
		),
	// application components
	'components'=>array(
		// uncomment the following to use a MySQL database
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