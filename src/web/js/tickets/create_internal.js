$(document).on('ready', function(){
    
    $('span.toggle').tooltip({
            track: true
        });
    
    // Append speech
    $(document).on('change', '#speech', function(){
       $ETTS.ajax.getSpeech($(this).val(), $('#Ticket_description')); 
    });
    
    // Get Carrier by Class
    $(document).on('change', '#class', function(){
        $ETTS.ajax.getCarrierByClass($(this).val(), '#user', '#mails');
    });
    
    // Get mails by user
    $(document).on('change', '#user', function(){
        $ETTS.ajax.getMailsByUser($(this).val(), '#mails');
    });
    
    // Bajar los correos
    $ETTS.UI.moveMails('a.a-bajar-correo', '#mails');
    
    // CC y BBC
    $('div#div-cc, div#div-bbc').hide();
    $(document).on('click', 'span.toggle.cc', function(){
        $('div#div-cc').toggle('fast')
    });
    $(document).on('click', 'span.toggle.bbc', function(){
        $('div#div-bbc').toggle('fast')
    });
    
});