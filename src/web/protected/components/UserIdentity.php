<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
                $atts = array(
                        'username' => $this->username, //traspasa el "nombre" mandado por formulario (models / LoginForm.php)
                );

                $usuario = User::model()->findByAttributes($atts); //busca este nombre en la bdd usando el USER.PHP creado con el CRUD que esta en la carpeta Model
                if(($usuario===null))
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
                elseif($usuario->password !== md5($this->password))
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                else {
                    
                    Yii::app()->getSession()->open();
                    Yii::app()->getSession()->add('type', $usuario->id_type_of_user);
                    Yii::app()->getSession()->add('id_user', $usuario->id);
                    $this->errorCode=self::ERROR_NONE;
                }

                
                return !$this->errorCode;
	}
}