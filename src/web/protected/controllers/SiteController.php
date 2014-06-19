<?php
/**
 *
 */
class SiteController extends Controller
{
	/**
	 *
	 */
	public function init()
	{
		Yii::app()->setComponents(array(
			'user'=>array(
				'loginUrl'=>Yii::app()->createUrl('/site/index'),
				)
			)
		);
	}
    
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
		return array();
	}
    
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect('/ticket/admin');
		}
		else
		{
			$this->redirect(Yii::app()->user->ui->loginUrl);
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->baseUrl . '/ticket');
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
                        
        /**
         * Exportable de imprimir
         */
        public function actionPrint()
        {
            $exports = new Export();
            $date = false;
            $withoutDescription = false;
            if (isset($_POST['date']) && !empty($_POST['date'])) $date = $_POST['date'] . ' ' . date('H:i:s');
            if (isset($_POST['rb-report']) && !empty($_POST['rb-report'])) {
                if ($_POST['rb-report'] == '4') $withoutDescription = true;
            }
            $table = $exports->table($_POST['id'], $date, $withoutDescription);
            if ($table !== null) {
                echo $table;
            }
        }
        
        /**
         * Exportable excel
         */
        public function actionExcel()
        { 
            ob_end_clean();
            $reports = new Export();
            $date = false;
            $status = '';
            
            if (isset($_POST['date']) && !empty($_POST['date'])) $date = $_POST['date'];
            if (isset($_POST['status']) && !empty($_POST['status'])) $status = $_POST['status'];
            if (isset($_POST['rb-report']) && !empty($_POST['rb-report'])) $status = $this->_defineNameReport($_POST['rb-report']);
            
            $table = $reports->table($_REQUEST['id'], $date);
            $name = $this->_setNameExport($status);
            
            header('Content-type: application/octet-stream');
            header("Content-Disposition: attachment; filename={$name}.xls");
            header("Pragma: cache");
            header("Expires: 0");
            
            if ($table !== null) {
                echo $table;
            }
        }
        
        /**
         * Exportable en formato excel con el componente yii excel
         */
        public function actionYiiexcel()
        {
            Yii::import('webroot.protected.components.reports.Report');
            $report = new Report;
            
            $date = date('Y-m-d H:i:s');
            $option = '0';
            $carrier = 'both';
        
            if (isset($_POST['date']) && !empty($_POST['date'])) $date = $_POST['date'] . ' ' .date('H:i:s');
            if (isset($_POST['rb-report']) && !empty($_POST['rb-report'])) $option = $_POST['rb-report'];
            if (isset($_POST['carrier']) && !empty($_POST['carrier'])) $carrier = $_POST['carrier'];
        
            if (isset($option)) {
                $args = array(
                    'date' => $date,
                    'option' => $option,
                    'carrier' => $carrier,
                    'octetStream' => true,
                    'nameReport' => 'ETTS Report '. $this->_matchSheetName($option) . '-' . date('Y-m-d His') . '.xlsx'
                );
                $report->genExcel($args);
            }
        }
        
        /**
         * Exportable en formato .xls con el componente yii excel
         */
        public function actionMailyiiexcel()
        {
            Yii::import('webroot.protected.components.reports.Report');
            $report = new Report;
            $export = new Export;
            
            $date = date('Y-m-d H:i:s');
            $option = '0';
            $carrier = 'both';
        
            if (isset($_POST['date']) && !empty($_POST['date'])) $date = $_POST['date'] . ' ' . date('H:i:s');;
            if (isset($_POST['rb-report']) && !empty($_POST['rb-report'])) $option = $_POST['rb-report'];
            if (isset($_POST['carrier']) && !empty($_POST['carrier'])) $carrier = $_POST['carrier'];
        
            if (isset($option)) {
                $nameReport = 'REPORT ETTS, '. strtoupper($this->_matchSheetName($option)) . '-' . date('Y-m-d His');
                $args = array(
                    'date' => $date,
                    'option' => $option,
                    'carrier' => $carrier,
                    'octetStream' => false,
                    'nameReport' => $nameReport . '.xlsx'
                );
                $report->genExcel($args);
                
                $table = $export->tableSummary($carrier, $date) . '<center><h3>'. substr($nameReport, 0, -7) .'</h3></center>' . $export->table($_POST['id'], $date);
                if ($table !== null) {
                    $mail = new EnviarEmail;
                    $subject = 'REPORT ETTS, '. strtoupper($this->_matchSheetName($option)) . ', ' . date('Y-m-d') . ', Hour ' . date('H:i:s');
                    $mail->enviar($table, Yii::app()->user->email, '', $subject, 'uploads/' . $nameReport . '.xlsx');   
                } 
            }
        }
        
        /**
        * Retorna el nombre del reporte, este debe ser igual al de la hoja excel
        * @param int $option Categoría seleccionada
        * @return string
        */
        private function _matchSheetName($option)
        {
            switch ($option) {
                case '1': return 'Open today';  break;
                case '2': return 'Pending yellow';  break;
                case '3': return 'Pending red';  break;
                case '4': return 'Without activity';  break;
                case '5': return 'Close white';  break;
                case '6': return 'Close yellow';  break;
                case '7': return 'Close red';  break;
                case '8': return 'Total pending';  break;
                case '9': return 'Total close';  break;
                case '10': return 'Ticket Escaladed'; break;
                default : 'Open today'; break;
            }
        }        
        
        /**
         * Nombre de los exportables en statistics
         * @param int $name El tipo de exportable que se ha seleccionado
         * @return string
         */
        private function _defineNameReport($name)
        {
            $return = '';
            switch ($name) {
                case '1': $return = 'Report - tickets open today'; break;
                case '2': $return = 'Report - tickets pending yellow';  break;
                case '3': $return = 'Report - tickets pending red';  break;
                case '4': $return = 'Report - tickets pending without activity';  break;
                case '5': $return = 'Report - tickets closed white';  break;
                case '6': $return = 'Report - tickets closed yellow';  break;
                case '7': $return = 'Report - tickets closed red';  break;
                case '8': $return = 'Report - total tickets pendings';  break;
                case '9': $return = 'Report - total tickets closed';  break;
            }
            return $return;
        }
        
        
        /**
         * Exportable email
         */
        public function actionMail()
        {
            $mail = new EnviarEmail();
            $export = new Export();
            $date = false;
            $status = '';
            
            if (isset($_POST['date']) && !empty($_POST['date'])) $date = $_POST['date'];
            if (isset($_POST['status']) && !empty($_POST['status'])) $status = $_POST['status'];
            if (isset($_POST['rb-report']) && !empty($_POST['rb-report'])) $status = $this->_defineNameReport($_POST['rb-report']);
            
            $table = $export->table($_POST['id'], $date);
            $name = $this->_setNameExport($status);
            if ($table !== null) {
                $this->_writeFile($name, $table);
                $mail->enviar($table, Yii::app()->user->email, '', $name, 'uploads/' . $name . '.xls');
            }
        }
                
        /**
         * Escribe el archivo excel
         * @param string $name
         * @param string $table
         */
        private function _writeFile($name, $table)
        {
            $ruta = Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR;
            $fp = fopen($ruta . "$name.xls", "w+");
            $cuerpo = "<!DOCTYPE html>
                        <html>
                            <head>
                                <meta charset='utf-8'>
                                <meta http-equiv='Content-Type' content='application/vnd.ms-excel charset=utf-8'>
                            </head>
                            <body>
                            $table
                            </body>
                        </html>";
            fwrite($fp, $cuerpo);
        }
        
        /**
         * Define el nombre que contendra el exportable dependiendo del status del ticket
         * @param int|string $status
         * @return string
         */
        private function _setNameExport($status)
        {
            if ($status === '1') {
                $string = 'Open tickets';
            } elseif ($status === '2') {
                $string = 'Closed tickets';
            } else {
                $string = $status;
            }
            return 'ETTS ' . $string . '-' . date('Y-m-d H-i-s');
        }

	/**
	 * @access public
	 * @static
	 * @return array
	 */
	public static function controlAcceso()
	{
		$tipoUsuario=CrugeAuthassignment::getRoleUser();
		// ADMIN
		if($tipoUsuario=="A")
		{
			return array(
                array(
                    'label'=>'Closed',
                    'url'=>array('/ticket/adminclose')
					),
				array(
					'label'=>'Open TT Customer/Supplier to Etelix by Etelix',
					'url'=>array('/ticket/createascarrier')
					),
                                 array(
					'label'=>'Open TT Etelix to Customer/Supplier',
					'url'=>array('/ticket/createtocarrier')
					),
                                array(
                                        'label'=>'Statistics',
                                        'url'=>array('/ticket/statistics')
                                        )
				);
		}
		// SUBADMIN
		if($tipoUsuario=="S")
		{
			return array(
                                array(
                                    'label'=>'Closed',
                                    'url'=>array('/ticket/adminclose')
                                                        ),
				array(
					'label'=>'Open TT Customer/Supplier to Etelix by Etelix',
					'url'=>array('/ticket/createascarrier')
					),
                                array(
					'label'=>'Open TT Etelix to Customer/Supplier',
					'url'=>array('/ticket/createtocarrier')
					),
                                array(
                                        'label'=>'Statistics',
                                        'url'=>array('/ticket/statistics')
                                        )
				);
		}
		// CLIENTE
		if($tipoUsuario=="C")
		{
			return array(
				array(
					'label'=>'Closed TT',
					'url'=>array('/ticket/adminclose')
					),
				array(
					'label'=>'Open ticket',
					'url'=>array('/ticket/create')
					),
                );
		}
		// INTERNO
		if($tipoUsuario=="I")
		{
			return array(
				array(
                    'label'=>'Closed',
                    'url'=>array('/ticket/adminclose')
                    ),
                array(
					'label'=>'Open TT Customer/Supplier to Etelix by Etelix',
					'url'=>array('/ticket/createascarrier')
					),
                array(
					'label'=>'Open TT Etelix to Customer/Supplier',
					'url'=>array('/ticket/createtocarrier')
					),
                            array(
                                        'label'=>'Statistics',
                                        'url'=>array('/ticket/statistics')
                                        )
                );
		}
	}
}