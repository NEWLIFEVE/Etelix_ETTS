<?php 

$user=CrugeUser2::getUserTicket($datos->id, true)->iduser;
$description=DescriptionTicket::getDescription($datos->id);
foreach ($description as $value) {
    
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
                $upload.= '<br>'.CHtml::link($file->real_name,'/'.$file->rute, array('target' => '_blank', 'class' => 'link'))  .'<br>';
            }
        }
        
        echo '<div class="msg-ticket '.$float.'">' . 
                $value->description . $upload . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong>User: </strong>' . $value->idUser->username .  
             '</div>';   
    } 
}
?>
<div class="pre-loader"></div>