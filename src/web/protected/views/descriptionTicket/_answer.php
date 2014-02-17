<?php 
sleep(2);
$user=CrugeUser2::getUserTicket($datos->id, true)->iduser;
foreach ($datos->descriptionTickets as $value) {
    
    if($value->idUser !==null){
        if ($value->idUser->iduser === $user)
            $float = 'left';
        else
            $float = 'right';
        
        $upload='';
        if (isset($value->files))
        {
            foreach ($value->files as $file) 
            {
                $upload.= '<br><br>'.CHtml::link($file->real_name,'/'.$file->rute, array('target' => '_blank'))  .'<br>';
            }
        }
        
        echo '<div class="msg-ticket '.$float.'">' . 
                $value->description . $upload . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong>User: </strong>' . $value->idUser->username .  
             '</div>';   
    } 
}
?>