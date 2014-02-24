<?php 
$description=DescriptionTicket::getDescription($datos->id);

foreach ($description as $value) {
    $usuarioAmostrar='By '.$value->idUser->username.' (Etelix NOC) on ETTS';
    if($value->idUser !==null){
        $usuario=CrugeAuthassignment::getRoleUser(false, $value->id_user);
        if (($usuario == 'I' || $usuario == 'C' || $usuario == 'A' || $usuario == 'S') && $value->id_user != $value->response_by) {
            $style='float: left; color: #3e454c; background: rgba(196, 191, 191, 0.5);';
        }
        
        if ($usuario == 'C' && $value->id_user == $value->response_by) {
            $usuarioAmostrar='By '.$value->idUser->username;
            $style='float: left; color: #3e454c; background: white;';
        }
        
        if ($usuario != 'C' && $value->id_user == $value->response_by) {
            $style='float: right; color: #fff; background: #6badf6;';
        }
        
        $upload='';
        if (isset($value->files))
        {
            foreach ($value->files as $file) 
            {
                $upload.= '<br>'.CHtml::link($file->real_name,'/'.$file->rute, array('target' => '_blank', 'class' => 'link'))  .'<br>';
            }
        }
        
        echo '<div style="'.$style.'" class="msg-ticket">' . 
                $value->description . $upload . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong> </strong>' . $usuarioAmostrar .  
             '</div>';   
    } 
}
?>
<div class="pre-loader"></div>