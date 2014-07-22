<?php

class SpeechController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    
        /**
         *
         */
        public function filters()
        {
            return array(array('CrugeAccessControlFilter'));
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new Speech;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Speech']))
		{
			$model->attributes=$_POST['Speech'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->speech));
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

		if(isset($_POST['Speech']))
		{
			$model->attributes=$_POST['Speech'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->speech));
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
		$dataProvider=new CActiveDataProvider('Speech');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Speech('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Speech']))
			$model->attributes=$_GET['Speech'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Speech the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Speech::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Speech $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='speech-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    /**
     * Método para traer el texto de la tabla speech
     */
    public function actionGettextspeech()
    {
        $model=new Speech;
        $idSpeech=$_POST['_idSpeech'];
        if ($idSpeech != null)
        {
            $speech=$model::model()->findByPk($idSpeech)->speech;
            if ($speech != null)
            {
                if (isset($_POST['failure']) && !empty($_POST['failure'])) 
                    $speech=preg_replace('/FAILURE/', $_POST['failure'], $speech);
                if (isset($_POST['country']) && !empty($_POST['country'])) 
                    $speech=preg_replace('/COUNTRY/', $_POST['country'], $speech);
                
                echo $speech;
            }
        }
    }
    
    /**
     * Retorna un json con los speech asociados a los customer 
     */
    public function actionGetspeechcustomer()
    {
        $model=new Speech;
        $data = $model::model()->findAllBySql("SELECT * FROM speech WHERE code LIKE 'C%' ORDER BY id ASC");
        if ($data !== null) echo CJSON::encode($data);
    }
    
    /**
     * Retorna un json con los speech asociados a los suppliers dependiendo de la falla seleccionada por interfaz
     */
    public function actionGetspeechsupplier()
    {
            $model=new Speech;
            $idFailure=$_POST['idFailure'];
            $json=array();
            if ($idFailure != null) 
            {
                $data=$model::model()->findAllBySql(
                        "SELECT s.* FROM speech s, failure f, failure_speech fs
                        WHERE 
                        s.id = fs.id_speech AND 
                        f.id = fs.id_failure AND
                        f.id = $idFailure
                        ORDER BY s.id, f.id ASC");
                if ($data != null)
                {
                    foreach ($data as $value) {
                        $json[]=array(
                            'idSpeech'=>$value->id,
                            'speech'=>$value->speech,
                            'title'=>$value->title,
                            'idLanguage'=>$value->id_language,
                            'x'=>'true'
                        );
                    }
                    echo CJSON::encode($json);
                }
                else
                {
                    echo CJSON::encode(array('x'=>'false'));
                }
            }
    }
}
