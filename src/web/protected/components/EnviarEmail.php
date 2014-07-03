<?php
/**
 * @package components
 */
class EnviarEmail extends CApplicationComponent
{
    /**
     * Init method for the application component mode.
     */
    public function init()
    {
        
    }

    /**
     * Encargado de controlar el envio de correos
     * @access public
     * @static
     * @param string $html cuerpo del mail
     * @param string $user direcciones a quien sera enviado el mail
     * @param string $reply direcciones a quien sera respondido el mail
     * @param string $asunto es el asunto del correo
     * @param string $ruta es la ruta donde esta el archivo adjunto
     * @param array $copia direcciones que seran copiadas al envio del correo
     */
    public function enviar($html, $user, $reply, $asunto, $ruta=NULL, $copia=null)
    {
        if(isset($html) && isset($user))
        {
            $mailer=Yii::createComponent('application.extensions.mailer.EMailer');
            $mailer=new PHPMailer();
            $mailer->IsSMTP();
            $mailer->Host=Yii::app()->params['host'];
            $mailer->Port=Yii::app()->params['port'];
//            $mailer->SMTPSecure='tls';
            $mailer->Username=Yii::app()->params['username'];
            $mailer->SMTPAuth=true;
            $mailer->Password=Yii::app()->params['password'];
            $mailer->SetFrom('etts@etelix.com','ETELIX Trouble Ticket System (ETTS)');
            $mailer->IsSMTP();
            $mailer->IsHTML(true); 
            
            if($user!=null)
            {
                // Compruebo si es un array, si no el destino sera una cadena
                if(is_array($user))
                {
                    foreach($user as $key => $value)
                    {
                        $mailer->AddAddress($value);
                    }
                }
                else
                {
                    $mailer->AddAddress($user);
                }
            }
            
            if($reply!=null)
            {
                if(is_array($reply))
                {
                    foreach($reply as $key => $value)
                    {
                        $mailer->AddReplyTo($value);
                    }
                }
                else
                {
                    $mailer->AddReplyTo($reply);
                }
            }
            if(!YII_DEBUG)
            {
                $mailer->addCC('noc@etelix.com','NOC');
            }
            else
            {
                $mailer->addCC('mark182182@gmail.com','Eduardo Makoukdji');
            }
            if($copia!=null)
            {
                if(is_array($copia))
                {
                    foreach ($copia as $key => $value)
                    {
                        $mailer->addCC($value);
                    }
                }
                else
                {
                    $mailer->addCC($copia);
                }
            }
            $mailer->CharSet='UTF-8';
            $mailer->Subject=Yii::t('', $asunto);
            
            if($ruta!=null)
            { 
                if(is_array($ruta))
                {
                    foreach($ruta as $key)
                    {
                        $mailer->AddAttachment($key); //Archivo adjunto
                    }
                }
                else
                {
                    $mailer->AddAttachment($ruta); //Archivo adjunto
                }
            }
            $message=$html;
            $mailer->Body=$message;
            
            if($mailer->Send())
            {
                return true;
            }
            else
            {
                return $mailer->ErrorInfo;
            }
        }
    }
}
?>
