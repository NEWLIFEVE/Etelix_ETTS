$(document).on('ready', function(){
    /*************************************************************************
     * 
     *                      EVENT(change)
     * 
     ************************************************************************/
     $(document).on('change', '#class, #Ticket_id_failure, #Ticket_country', function(){
        // Speechs para supplier
        if ($('#class').val() == 'supplier')
        {
            if ($('#class').val() && $('#Ticket_id_failure').val() && $('#Ticket_country').val()) 
            {
                    var settings = {
                        supplier:true,
                        failure:$('#Ticket_id_failure'),
                        country:$('#Ticket_country'),
                        append:$('#Ticket_description'),
                        speech:$('#speech')
                    }
                    $ETTS.ajax.getSpeechSupplier(settings);
            }
            else
            {
               $('#Ticket_description').val('');
               $('#speech').html('');
            }
        }
        else if ($('#class').val() == 'customer')
        {
            $('#Ticket_description').val('');
            $ETTS.ajax.getSpeechCustomer($('#speech'));
        }
        else
        {
            $('#Ticket_description').val('');
            $('#speech').html('');
        }
    });
     
     // Append speech
    $(document).on('change', '#speech', function(){
       var settings = {failure:$('#Ticket_id_failure'), country:$('#Ticket_country')};
       $ETTS.ajax.getSpeech($(this).val(), $('#Ticket_description'), settings); 
    });
    
    // Get Carrier by Class
    $(document).on('change', '#class', function(){
        if ($('#open-ticket').val() != 'carrier_to_etelix')
            $ETTS.ajax.getCarrierByClass($(this).val(), '#user', '#mails', '#Ticket_mail, select#cc, select#bbc');
    });
    
    // Get mails by user
    $(document).on('change', '#user', function(){
        var etelixAsCarrier = false;
        if ($('#open-ticket').val() == 'etelix_as_carrier') {
            etelixAsCarrier = true;
        }
        $ETTS.ajax.getMailsByUser($(this).val(), '#mails', '#Ticket_mail', etelixAsCarrier);
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
    
    $(document).on('click', '.a-agregar-correo', function(){
        $('.div-agregar-correo').toggle('fast')
    });
    
    $(document).on('click', 'input[name="preview"]', function(){
        var originationIP = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val(),
        destinationIP = $('#dip1').val() + '.' + $('#dip2').val() + '.' + $('#dip3').val() + '.' + $('#dip4').val();
//        description = $('div.nicEdit-main').text();
        
        if (originationIP === '...') originationIP = '';
        if (destinationIP === '...') destinationIP = '';
        
        $('#originationIp').val(originationIP); 
        $('#destinationIp').val(destinationIP);
//        $('#areaDescription').val(description);
    });
    
    // Remove mails
    $(document).on('click', 'a.a-borrar-correo', function(){
        
        var mailSeleccionado = $('#mails option:selected').val();
        
        if ($('#mails').val()) { 
            $ETTS.UI.confirmar('Delete Mail?', 'ok_confirm', 'cancel_confirm'); 
            $('#ok_confirm').on('click', function(){
                $ETTS.ajax.deleteMailByConfirm('mails', 'Ticket_mail', mailSeleccionado)
            });
            $('#cancel_confirm').on('click', function(){
                $.Dialog.close();
            });
        }
        $ETTS.UI.borrarOptionSelect($(this))
    });
    
    // Append options
    $(document).on('click', 'a.a-bajar-correo', function(){
        $ETTS.UI.appendOptions($(this), $('#mails'), $('#open-ticket'));
    });  
    
    $(document).on('click', '#Ticket_mail', function(){
        $ETTS.UI.clearOptions($('#mails'));
    });  
    
    /**
     *   Add mails
     */
    $(document).on('click', '.btn-agregar-correo', function(){
        $ETTS.ajax.saveMail($('#new_mail'),'1',$('#user'),$('#mails'),$('#Ticket_mail'), $('#open-ticket'));
    });
    
    // Add all emails
    $(document).on('click', '.add-all-email', function(){
        $ETTS.UI.addAllEmails($('#Ticket_mail'),$('#mails'))
    });
    
    // Add tested numbers
    $(document).on('click', '.agregar-tested-number', function(){
        $ETTS.UI.addTestedNumber();
    });
    
    // Remove tested numbers
    $(document).on('click', '._cancelar', function(){
        $ETTS.UI.removeTestedNumber($(this));
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
    // Tooltips para bbc y cc
    $ETTS.UI.tooltip('span.toggle', true);
    
    /*************************************************************************
     * 
     *                      Auto hidden
     * 
     ************************************************************************/
    // CC y BBC
    $('div#div-cc, div#div-bbc, .div-agregar-correo').hide();
    
    
    /*************************************************************************
     * 
     *                      Datepicker and timeEntry
     * 
     ************************************************************************/
    $('.fecha').datepicker({dateFormat: "yy-mm-dd"}); 
    $('.hour').timeEntry({show24Hours: true, showSeconds: true});
    
    /*************************************************************************
     * 
     * Validate and preview ticket etelix to carrier
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
                    $('select#speech option:selected').text(),
                    $('#Ticket_description').val(),
                    null,
                    $('[name="Ticket[tested_numbers][]"]'),
                    $('[name="Ticket[country][]"]'),
                    $('[name="Ticket[date_number][]"]'),
                    $('[name="Ticket[hour_number][]"]')
                );

                // Save Ticket
                $('#save_ticket').on('click', function(){
                    $ETTS.ajax.saveTicket(
                        null,
                        $('[name="Ticket[tested_numbers][]"]'),
                        $('[name="Ticket[country][]"]'),
                        $('[name="Ticket[date_number][]"]'),
                        $('[name="Ticket[hour_number][]"]'),
                        $('#user option:selected'),                             // USER
                        $('[name="Ticket[mail][]"] option'),                    // TO
                        $('#cc option'),                                        // CC
                        $('#bbc option'),                                       // BBC
                        $('#Ticket_id_failure').val(),                          // FAILURE
                        $('#Ticket_id_failure option:selected').text(),
                        originationIP,                                          // Origination IP            
                        destinationIP,                                          // Destination IP
                        $('#Ticket_prefix').val(),                              // PREFIX
                        $('#speech option:selected').text(),                    // SPEECH
                        $('#Ticket_description').val(),                         // DESCRIPTION $('div.nicEdit-main').text()
                        $('[name="attachFile[]"]'),                             // FILE REAL NAME
                        $('[name="attachFileSave[]"]'),                         // FILE SAVE NAME
                        $('[name="attachFileSize[]"]'),                         // FILE SIZE
                        '1',                                                    // Si es cliente = 0 de lo contrario = 1
                        $("#ticket-form"),                                      // Limpiar Formulario,
                        $('#open-ticket').val(),
                        $('select#class option:selected').text()
                     );
                });
            }
        }
     });
     
     /*************************************************************************
     * 
     * Validate and preview ticket etelix as carrier
     * 
     ************************************************************************/
     $("#ticket-form-to-client").validationEngine('attach',{
        autoHidePrompt:true,
        onValidationComplete:function(form, status){
            
            if (status==true)
            {
                var originationIP = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val(),
                destinationIP = $('#dip1').val() + '.' + $('#dip2').val() + '.' + $('#dip3').val() + '.' + $('#dip4').val();
                
                if (originationIP == '...') originationIP = '';
                if (destinationIP == '...') destinationIP = '';
                
                $ETTS.UI.previewTicket(
                    null,
                    $('select#user option:selected').text(),
                    $('select#Ticket_mail option'),
                    [],
                    [],
                    $('select#Ticket_id_failure option:selected').text(),
                    originationIP,
                    destinationIP,
                    $('#Ticket_prefix').val(),
                    null,
                    $('#Ticket_description').val(),
                    $('select#Ticket_idGmt option:selected').text(),
                    $('[name="Ticket[tested_numbers][]"]'),
                    $('[name="Ticket[country][]"]'),
                    $('[name="Ticket[date_number][]"]'),
                    $('[name="Ticket[hour_number][]"]')
                );

                // Save Ticket(interno como cliente)
                $('#save_ticket').on('click', function(){
                    $ETTS.ajax.saveTicket(
                        $('#Ticket_idGmt option:selected'),
                        $('[name="Ticket[tested_numbers][]"]'),
                        $('[name="Ticket[country][]"]'),
                        $('[name="Ticket[date_number][]"]'),
                        $('[name="Ticket[hour_number][]"]'),
                        $('#user option:selected'),                             // USER
                        $('[name="Ticket[mail][]"] option'),                    // TO
                        [],                                                     // CC
                        [],                                                     // BBC
                        $('#Ticket_id_failure').val(),                          // FAILURE
                        $('#Ticket_id_failure option:selected').text(),         // Texto de la falla para enviar por correo
                        originationIP,                                          // Origination IP            
                        destinationIP,                                          // Destination IP
                        $('#Ticket_prefix').val(),                              // PREFIX
                        null,                                                   // SPEECH
                        $('#Ticket_description').val(),                         // DESCRIPTION $('div.nicEdit-main').text()
                        $('[name="attachFile[]"]'),                             // FILE REAL NAME
                        $('[name="attachFileSave[]"]'),                         // FILE SAVE NAME
                        $('[name="attachFileSize[]"]'),                         // FILE SIZE
                        '0',                                                    // Si es cliente = 0 de lo contrario = 1
                        $("#ticket-form-to-client"),                            // Limpiar Formulario
                        $('#open-ticket').val(),
                        $('select#class option:selected').text()
                     );
                });
            }
        }
     });

     /*************************************************************************
     * 
     *  Validate and preview ticket carrier to etelix
     * 
     ************************************************************************/
     $("#form-carrier-to-etelix").validationEngine('attach',{
        autoHidePrompt:true,
        onValidationComplete:function(form, status){
            
            if (status==true)
            {
                var originationIP = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val(),
                destinationIP = $('#dip1').val() + '.' + $('#dip2').val() + '.' + $('#dip3').val() + '.' + $('#dip4').val();
                
                if (originationIP == '...') originationIP = '';
                if (destinationIP == '...') destinationIP = '';
                
                $ETTS.UI.previewTicket(
                    null,
                    null,
                    $('select#Ticket_mail option'),
                    [],
                    [],
                    $('select#Ticket_id_failure option:selected').text(),
                    originationIP,
                    destinationIP,
                    $('#Ticket_prefix').val(),
                    null,
                    $('#Ticket_description').val(),
                    $('select#Ticket_idGmt option:selected').text(),
                    $('[name="Ticket[tested_numbers][]"]'),
                    $('[name="Ticket[country][]"]'),
                    $('[name="Ticket[date_number][]"]'),
                    $('[name="Ticket[hour_number][]"]')
                );

                $('#save_ticket').on('click', function(){
                    $ETTS.ajax.saveTicket(
                        $('#Ticket_idGmt option:selected'),
                        $('[name="Ticket[tested_numbers][]"]'),
                        $('[name="Ticket[country][]"]'),
                        $('[name="Ticket[date_number][]"]'),
                        $('[name="Ticket[hour_number][]"]'),
                        null,                                                   // USER
                        $('[name="Ticket[mail][]"] option'),                    // TO
                        [],                                                     // CC
                        [],                                                     // BBC
                        $('#Ticket_id_failure').val(),                          // FAILURE
                        $('#Ticket_id_failure option:selected').text(),         // Texto de la falla para enviar por correo
                        originationIP,                                          // Origination IP            
                        destinationIP,                                          // Destination IP
                        $('#Ticket_prefix').val(),                              // PREFIX
                        null,                                                   // SPEECH
                        $('#Ticket_description').val(),                         // DESCRIPTION $('div.nicEdit-main').text()
                        $('[name="attachFile[]"]'),                             // FILE REAL NAME
                        $('[name="attachFileSave[]"]'),                         // FILE SAVE NAME
                        $('[name="attachFileSize[]"]'),                         // FILE SIZE
                        '0',                                                    // Si es cliente = 0 de lo contrario = 1
                        $("#form-carrier-to-etelix"),                            // Limpiar Formulario
                        $('#open-ticket').val(),
                        $('select#class option:selected').text()
                     );
                });
            }
        }
     });
});

