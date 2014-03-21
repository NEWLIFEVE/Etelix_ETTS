<?php 
$description=DescriptionTicket::getDescription($datos->id);

foreach ($description as $value) {
    if($value->idUser !==null){
        $usuario=CrugeAuthassignment::getRoleUser(false, $value->id_user);
        $usuarioAmostrar='By '.$value->idUser->username.' (by Etelix) on ETTS';
        
        if (($usuario == 'I' || $usuario == 'C' || $usuario == 'A' || $usuario == 'S') && $value->id_user != $value->response_by) {
            $style='float: left; color: #3e454c; border:1px solid silver; background: white;';
        }
        
        if ($usuario == 'C' && $value->id_user == $value->response_by) {
            $style='float: left; color: #3e454c; background: rgba(196, 191, 191, 0.5);';
            $usuarioAmostrar='By '.$value->idUser->username.' on ETTS';
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