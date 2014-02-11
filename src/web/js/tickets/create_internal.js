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
    
    // Remove mails
    $(document).on('click', 'a.a-borrar-correo', function(){
        $ETTS.UI.borrarOptionSelect($(this))
    });
    
    /*************************************************************************
     * 
     *                      EVENT(keyup)
     * 
     ************************************************************************/
    // Event keyup para direccioenes ip
    $(document).on('keyup', 'input._ip', function(e){
        $ETTS.UI.direccionesIp($(this), e);
    });
    
    /*************************************************************************
     * 
     *                      Just call the module
     * 
     ************************************************************************/
    // Bajar los correos
    //$ETTS.UI.moveMails('a.a-bajar-correo', '#mails');
    $(document).on('click', 'a.a-bajar-correo', function(){
        $ETTS.UI.appendOptions($(this), $('#mails'));
    });    
    
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
                
                if (originationIP == '...') originationIP = '';
                if (destinationIP == '...') destinationIP = '';
                
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
                        null,
                        null,
                        null,
                        null,
                        null,
                        $('#user option:selected').text(),                      // USER
                        $('[name="Ticket[mail][]"] option'),                    // TO
                        $('#cc option'),                                        // CC
                        $('#bbc option'),                                       // BBC
                        $('#Ticket_id_failure').val(),                          // FAILURE
                        $('#Ticket_id_failure option:selected').text(),
                        originationIP,                                          // Origination IP            
                        destinationIP,                                          // Destination IP
                        $('#Ticket_prefix').val(),                              // PREFIX
                        $('#statu option:selected'),                            // STATUS
                        $('#Ticket_id_manager option:selected').text(),         // Account Manager
                        $('#speech option:selected').text(),                    // SPEECH
                        $('div.nicEdit-main').html(),                           // DESCRIPTION $('div.nicEdit-main').text()
                        $('[name="attachFile[]"]'),                             // FILE REAL NAME
                        $('[name="attachFileSave[]"]'),                         // FILE SAVE NAME
                        $('[name="attachFileSize[]"]'),                         // FILE SIZE
                        '1',                                                    // Si es cliente = 0 de lo contrario = 1
                        $("#ticket-form")                                       // Limpiar Formulario
                     );
                });
            }
        }
     });
});

