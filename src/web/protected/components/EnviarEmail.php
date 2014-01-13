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
/*            $mailer->Host='smtp.gmail.com';
            $mailer->Port='587';
            $mailer->SMTPSecure='tls';
            $mailer->Username='sinca.test@gmail.com';
            $mailer->SMTPAuth=true;
            $mailer->Password="sincatest";*/
            $mailer->Host='mail.etelix.com';
            $mailer->Port='475';
//            $mailer->SMTPSecure='tls';
            $mailer->Username='etts@etelix.com';
            $mailer->SMTPAuth=true;
            $mailer->Password="3t3l1x.etts";
            $mailer->IsSMTP();
            $mailer->IsHTML(true);
//            $mailer->From='sinca.test@gmail.com';
            $mailer->From='etts@etelix.com';
//            $mailer->AddReplyTo('sinca.test@gmail.com');
//            $mailer->AddAddress($user);
            if($user!=null)
            {
                foreach ($user as $key => $value)
                {
                    $mailer->AddAddress($value);
                }
            }
            if($reply!=null)
            {
                foreach ($reply as $key => $value)
                {
                    $mailer->AddReplyTo($value);
                }
            }
            if($copia!=null)
            {
                foreach ($copia as $key => $value)
                {
                    $mailer->addCC($value);
                }
            }
            $mailer->FromName='ETTS';
            $mailer->CharSet='UTF-8';
            $mailer->Subject=Yii::t('', $asunto);
            
            if ($ruta!= null){ 
                foreach ($ruta as $key)
                {
                    $mailer->AddAttachment($key); //Archivo adjunto
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
