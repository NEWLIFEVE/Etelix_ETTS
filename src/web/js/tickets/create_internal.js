$(document).on('ready', function(){
    /*************************************************************************
     * 
     *                      EVENT(change)
     * 
     ************************************************************************/
     // Append speech
    $(document).on('change', '#speech', function(){
       $ETTS.ajax.getSpeech($(this).val(), $('div.nicEdit-main')); 
    });
    
    // Get Carrier by Class
    $(document).on('change', '#class', function(){
        $ETTS.ajax.getCarrierByClass($(this).val(), '#user', '#mails', '#Ticket_mail, select#cc, select#bbc');
    });
    
    // Get mails by user
    $(document).on('change', '#user', function(){
        $ETTS.ajax.getMailsByUser($(this).val(), '#mails', '#Ticket_mail, select#cc, select#bbc');
    });
    /*************************************************************************
     * 
     *                      EVENT(click)
     * 
     ************************************************************************/
    $(document).on('click', 'span.toggle.cc', function(){
        $('div#div-cc').toggle('fast')
    });
    $(document).on('click', 'span.toggle.bbc', function(){
        $('div#div-bbc').toggle('fast')
    });
    
    $(document).on('click', 'input[name="preview"]', function(){
        var originationIP = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val(),
        destinationIP = $('#dip1').val() + '.' + $('#dip2').val() + '.' + $('#dip3').val() + '.' + $('#dip4').val(),
        description = $('div.nicEdit-main').text();
        
        if (originationIP === '...') originationIP = '';
        if (destinationIP === '...') destinationIP = '';
        
        $('#originationIp').val(originationIP); 
        $('#destinationIp').val(destinationIP);
        $('#areaDescription').val(description);
    });
    
    /*************************************************************************
     * 
     *                      Just call the module
     * 
     ************************************************************************/
    // Bajar los correos
    $ETTS.UI.moveMails('a.a-bajar-correo', '#mails');
    
    // Tooltips para bbc y cc
    $ETTS.UI.tooltip('span.toggle', true);
    
    /*************************************************************************
     * 
     *                      Auto hidden
     * 
     ************************************************************************/
    // CC y BBC
    $('div#div-cc, div#div-bbc').hide();
    
    /*************************************************************************
     * 
     *                      Validate and preview ticket
     * 
     ************************************************************************/
     $("#ticket-form").validationEngine('attach',{
        autoHidePrompt:true,
        onValidationComplete:function(form, status){
            if (status==true)
            {
                var originationIP = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val(),
                destinationIP = $('#dip1').val() + '.' + $('#dip2').val() + '.' + $('#dip3').val() + '.' + $('#dip4').val();

                $ETTS.UI.previewTicket(
                    $('select#class option:selected').text(),
                    $('select#user option:selected').text(),
                    $('select#Ticket_mail option'),
                    $('select#cc option'),
                    $('select#bbc option'),
                    $('select#Ticket_id_failure option:selected').text(),
                    originationIP,
                    destinationIP,
                    $('#Ticket_prefix').val(),
                    $('select#statu option:selected').text(),
                    $('select#Ticket_id_manager option:selected').text(),
                    $('select#speech option:selected').text(),
                    $('div.nicEdit-main').html()
                );

                // Save Ticket
                $('#save_ticket').on('click', function(){
                    $ETTS.ajax.saveTicket(
                        null,                                                   // USER
                        $('[name="Ticket[mail][]"] option'),                    // TO
                        $('#cc option'),                                        // CC
                        $('#bbc option'),                                       // BBC
                        $('#Ticket_id_failure').val(),                          // FAILURE
                        originationIP,                                          // Origination IP            
                        destinationIP,                                          // Destination IP
                        $('#Ticket_prefix').val(),                              // PREFIX
                        $('#statu').val(),                                      // STATUS
                        null,                                                   // Account Manager
                        null,                                                   // SPEECH
                        $('div.nicEdit-main').text(),                           // DESCRIPTION
                        null                                                    // FILES
                    );
                });
            }
        }
     });
     
 
});

//     alert($ETTS.ajax.init('hola')._clase)