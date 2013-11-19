<?php

class TicketsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        
        public function init() 
        {
            Yii::app()->setComponents(array(
                'user'=>array(
                    'loginUrl'=>Yii::app()->createUrl('/site/index'),
                )));
        }
        
        /**
         * Funcion para retornar los detinos 
         */
        public function actionDestinations()
        {
            $destinos = Destinos::model()->findAll();
            echo CJSON::encode($destinos);
        }

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'destinations'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
        
        

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{       
                
		$model=new Tickets;
                /*Instancio los modelos donde se harán inserts*/
                $modelTestedNumbers= new TestedNumbers;
                $modelDescripcionTicket= new DescripcionTicket;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tickets']))
		{
//                    echo '<pre>';
//                    print_r($_POST);
//                    Yii::app()->end();
                        
			$model->attributes=$_POST['Tickets'];
                        
                        //Demás atributos que no estan en el formualrio
                        $model->statu_id = 1;
                        $model->fecha_ticket = new CDbExpression('NOW()');
                        $model->ip_maquina = Yii::app()->request->userHostAddress;
                        
//                        echo '<pre>';
//                        print_r($model->attributes);
//                        Yii::app()->end();
                        
			if($model->save()) {
                                
                                // Guardo en TestedNumbers
//                                $modelTestedNumbers->tickets_id = $model->primaryKey;
//                                $modelTestedNumbers->destinos_id = $_POST['Tickets']['destination'];
//                                $modelTestedNumbers->numero = $_POST['Tickets']['tested_numbers'];
                               
                                $countDestination = $_POST['Tickets']['destination'];
                                $countTestedNumbers = $_POST['Tickets']['tested_numbers'];
                                $countFecha = $_POST['Tickets']['fecha'];
                                
                                for ($i = 0; $i < count($countTestedNumbers); $i++) {
                                    $model->addTestedNumbers(
                                            $model->primaryKey, 
                                            $countDestination[$i], 
                                            $countTestedNumbers[$i], 
                                            $countFecha[$i]
                                            );
                                }
                                
                                // Guardo en DescripcionTicket
                                $modelDescripcionTicket->tickets_id = $model->primaryKey;
                                $modelDescripcionTicket->descripcion = $_POST['Tickets']['descripcion'];
                                $modelDescripcionTicket->fecha_mensaje = new CDbExpression('NOW()');
                                
                                $modelTestedNumbers->save();
                                $modelDescripcionTicket->save();
                                
				$this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tickets']))
		{
			$model->attributes=$_POST['Tickets'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{   
            
		$dataProvider=new CActiveDataProvider('Tickets');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tickets('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tickets']))
			$model->attributes=$_GET['Tickets'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tickets the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tickets::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tickets $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tickets-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
