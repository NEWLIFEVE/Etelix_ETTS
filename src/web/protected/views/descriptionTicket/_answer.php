<?php 
$user=CrugeUser2::getUserTicket($datos->id, true)->iduser;
foreach ($datos->descriptionTickets as $value) {
    
    if($value->idUser !==null){
        if ($value->idUser->iduser === $user)
            $float = 'left';
        else
            $float = 'right';
        echo '<div class="msg-ticket '.$float.'">' . 
                $value->description . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong>User: </strong>' . $value->idUser->username .  
             '</div>';   
    } 
}
?>