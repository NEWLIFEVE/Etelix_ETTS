<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ETTS',
	//'language' => 'en',
	'language'=>'en',
	'timeZone'=>'America/Caracas',
	'charset'=>'utf-8',
	'theme'=>'metroui',
	// preloading 'log' component
	'preload'=>array('log'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
        'application.controllers.*',
        'application.components.*',
        'application.components.Imap.*',
        'application.modules.cruge.components.*',
        'application.modules.cruge.extensions.crugemailer.*'
		),
	'modules'=>array(
	// uncomment the following to enable the Gii tool
		'cruge'=>array(
			'tableprefix'=>'cruge_',
			// para que utilice a protected.modules.cruge.models.auth.CrugeAuthDefault.php
			//
			// en vez de 'default' pon 'authdemo' para que utilice el demo de autenticacion alterna
			// para saber mas lee documentacion de la clase modules/cruge/models/auth/AlternateAuthDemo.php
			//
			'availableAuthMethods'=>array('default'),
			'availableAuthModes'=>array('username','email'),
			// url base para los links de activacion de cuenta de usuario
			'baseUrl'=>'http://etts.local/',
			// NO OLVIDES PONER EN FALSE TRAS INSTALAR
			'debug'=>false,
			'rbacSetupEnabled'=>false,
			'allowUserAlways'=>false,
			// MIENTRAS INSTALAS..PONLO EN: false
			// lee mas abajo respecto a 'Encriptando las claves'
			//
			'useEncryptedPassword'=>true,
			// Algoritmo de la función hash que deseas usar
			// Los valores admitidos están en: http://www.php.net/manual/en/function.hash-algos.php
			'hash'=>'md5',
			// Estos tres atributos controlan la redirección del usuario. Solo serán son usados si no
			// hay un filtro de sesion definido (el componente MiSesionCruge), es mejor usar un filtro.
			//  lee en la wiki acerca de:
			//   "CONTROL AVANZADO DE SESIONES Y EVENTOS DE AUTENTICACION Y SESION"
			//
			// ejemplo:
			//		'afterLoginUrl'=>array('/site/welcome'),  ( !!! no olvidar el slash inicial / )
			//		'afterLogoutUrl'=>array('/site/page','view'=>'about'),
			//
			'afterLoginUrl'=>array('/site/index'),
			'afterLogoutUrl'=>array('/site/index'),
			'afterSessionExpiredUrl'=>array('/site/index'),
			// manejo del layout con cruge.
			//
			'loginLayout'=>'//layouts/column2',
			'registrationLayout'=>'//layouts/column2',
			'activateAccountLayout'=>'//layouts/column2',
			'editProfileLayout'=>'//layouts/column2',
			// en la siguiente puedes especificar el valor "ui" o "column2" para que use el layout
			// de fabrica, es basico pero funcional.  si pones otro valor considera que cruge
			// requerirá de un portlet para desplegar un menu con las opciones de administrador.
			//
			'generalUserManagementLayout'=>'ui',
			// permite indicar un array con los nombres de campos personalizados,
			// incluyendo username y/o email para personalizar la respuesta de una consulta a:
			// $usuario->getUserDescription();
			'userDescriptionFieldsArray'=>array('email'),
			'superuserName'=>'ettsadmin',
			),
		),
	// application components
	'components'=>array(
		//'user'=>array(
		//enable cookie-based authentication
		//'allowAutoLogin'=>true,
		//),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
			),
		'mail'=>array(
			'class'=>"application.components.EnviarEmail",
			),
		'utility'=>array(
			'class'=>"application.components.Utility",
			),
			// uncomment the following to use a MySQL database
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
			),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
//				array(
//                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
//                ),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
				),
			),
		//  IMPORTANTE:  asegurate de que la entrada 'user' (y format) que por defecto trae Yii
        //               sea sustituida por estas a continuación:
        //
        'user'=>array(
        	'allowAutoLogin'=>true,
        	'class'=>'application.modules.cruge.components.CrugeWebUser',
        	'loginUrl'=>array('/cruge/ui/login')
        	),
        'authManager'=>array(
        	'class'=>'application.modules.cruge.components.CrugeAuthManager',
        	),
        'crugemailer'=>array(
            'class'=>'application.modules.cruge.components.CrugeMailer',
            'mailfrom'=>'etts@etelix.com',
            'subjectprefix'=>'Tu Encabezado del asunto - ',
            'debug'=>true,
            ),
        'format'=>array(
        	'datetimeFormat'=>"d M, Y h:m:s a",
        	),
        'session'=>array(
        	'timeout'=>86400,
                'autoStart' => true , 
                'gCProbability'  => 100 ,
        ),
        'clientScript'=>array(
              'scriptMap'=>array(
                  'jquery.js' => '/js/plugins/jquery/jquery.min.js',
                  'jquery.yii.js' => '/js/plugins/jquery/jquery.min.js',
              ),
            ),
            
            
        ),
        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
	'params'=>array(
	// this is used in contact page
            ),
	);
