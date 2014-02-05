$(document).on('ready', function(){
    
    // Append speech
    $(document).on('change', '#speech', function(){
       $ETTS.ajax.getSpeech($(this).val(), $('#Ticket_description')); 
    });
    
});