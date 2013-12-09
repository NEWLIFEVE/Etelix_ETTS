/*******************************************************************************
 *          FUNCION PARA CARGAR EL ULTIMO OPTION Y PASARLO A RESPONSE TO
 ******************************************************************************/
function setResponseTo() 
{
    var valor = $('#cargar_mails option:last').val();
    var texto = $('#cargar_mails option:last').html();
    $('#Ticket_mail').append('<option value="'+valor+'">'+texto+'</option>');
}

function appendResponseTo()
{
    $('#Ticket_mail option').clone().appendTo($('#preview_response_to'));
}

$(document).on('ready', function(){
    
    $(document).on('click', '#add_all_email', function(){
       $('#Ticket_mail').html('');
       $('#cargar_mails option').clone().appendTo($('#Ticket_mail'));
       $('#Ticket_mail').removeClass('validate[required]');
    });
    
    
    
    /*******************************************************************************
    *          FUNCION AJAX PARA MOSTRAR LOS CORREOS QUE SE VAYAN INSERTANDO
    ******************************************************************************/
    var getMailUser = function(){
        $.post('/MailUser/GetMailUser', '', function(data){
            $('#cargar_mails').html('');
            for (var i = 0; i < data.length; i++) {
                $('#cargar_mails').append('<option value="'+ data[i].id +'">'+ data[i].mail +'</option>');
            }
        }, 'json');
    }
    
    
    
    /***************************************************************************
     *
     *          INSERTAR CORREO - AJAX
     *
     **************************************************************************/
    $(document).on('click', '.btn-agregar-correo', function(){
       $.ajax({
          url:  '/Mail/SetMail',
          type: 'post',
          data:{mail: $('#new_mail').val()},
          success: function(data){
              if (data == 'ok') {
                  $('#new_mail').val('');
                  getMailUser();
                  setTimeout('setResponseTo()', 1000);
              } else if(data == 'tope_alcanzado') {
                  alert('Only five emails allowed')
              } else if (data == 'no') {
                  alert('Error')
              }
          }
       });
    });
    
    /***************************************************************************
     *      
     *      AREA DE DESTINATION IP
     *      
     ***************************************************************************/
    $(document).on('keyup', '._ip', function(e){
//        alert(e.keyCode)
        var valor = $(this).val();
        
        if (e.keyCode == 190 || e.keyCode == 110) {
            $(this).val(valor.replace('.', ''));
            $(this).next('._ip').focus();
        }
        
        if ($(this).val().length === 3) {
            
            if ($(this).val() > 255) {
                $(this).val('255');
            }
            
            $(this).next('._ip').focus();
        }
    });
    
    /***************************************************************************
     *      
     *      INPUT PARA AGREGAR CORREOS
     *      
     ***************************************************************************/
    $('.div-agregar_correo').hide(); // El div de agregar correo inicia oculto
    
    $(document).on('click', '.a-agregar_correo', function(){

        $('.div-agregar_correo').toggle('fast');
        
    });
    
    /***************************************************************************
     *      
     *      AGREGAR CORREOS AL SELECT DE ABAJO
     *      
     ***************************************************************************/
    $(document).on('click', '.a-bajar_correo', function(){
        if ($('#cargar_mails').val()) { // Si hay valor en la carga de mail se ejecutará el código
            
            if ($('#Ticket_mail option').length <= 4) {
                $('#Ticket_mail').append('<option value="'+$('#cargar_mails').val()+'">'+$('#cargar_mails option:selected').html()+'</option>');
                $('#Ticket_mail').removeClass('validate[required]');
            } else {
                alert('Only five emails allowed')
            }
        }
    });
    
    
    /***************************************************************************
     *      
     *      ELIMINAR CORREOS DEL SELECT DE ABAJO
     *      
     ***************************************************************************/
    $(document).on('click', '.a-borrar_correo', function(){
        if ($('#Ticket_mail').val()) { 
           $('#Ticket_mail option:selected').remove();
           
           if ($('#Ticket_mail option').length == 0) {
                $('#Ticket_mail').addClass('validate[required]');
           }
        }
    });
    
    
    /***************************************************************************
     * 
     *  Delegate para agregar el datepicker dinamicamente
     * 
     ***************************************************************************/
    $('#ticket-form').delegate('.fecha','focusin',function(){
        $('.fecha').datepicker({
            dateFormat: "yy-mm-dd"
        }); 
    });
    
    $('#ticket-form').delegate('.hour','focusin',function(){
        $('.hour').timeEntry({show24Hours: true, showSeconds: true});
    });
    

    /***************************************************************************
     * 
     *  Boton para agregar más tested_numbers, destinatios y date_number
     * 
     ***************************************************************************/
    
    var clickAgregarNumber = 0; // Varible que permite cambiar los numeros del id del div que contiene a tested number
    $(document).on('click', '._agregar', function(){
        
        clickAgregarNumber += 1;
        
        var country = $('#content_country').clone();
        country.children().children('br').remove();

        $('.container_agregar').append(
            '<div id="div_'+clickAgregarNumber+'" style="display:none">'+
                '<div class="input-control text span3">' +
                    '<input type="text" class="validate[required]" name="Ticket[tested_numbers][]" placeholder="Without prefix" >' +
                '</div>' +
                
                country.html() +

                '<div class="input-control text span2 margen-number fecha_div">' +
                    '<input type="text" class="fecha" name="Ticket[date_number][]" placeholder="Date" readonly="readonly" >' +
                '</div>' +
                
                '<div class="input-control text span1 margen-number hour_div">' +
                    '<input type="text" name="Ticket[hour_number][]" placeholder="Hour" class="hour" >' +
                '</div>' +
                '<a href="javascript:void(0)" style="margin-left: 5px; padding-top: 5px; width: 10px !important;"  class="_cancelar input-control text span1"><i class="icon-cancel-2 fg-red "></i></a>' +
            '</div>'
            
        );
        $("#div_"+clickAgregarNumber).fadeIn('fast');

    });
        
    /***************************************************************************
     * 
     *  REMOVER LAS FILAS QUE SE HAYAN CREADO DE TESTED NUMBER
     * 
     ***************************************************************************/
    $(document).on('click', '._cancelar', function(){
        $(this).parent('div').fadeOut('fast', function(){
            $(this).remove();
        });
    });
    
    
    /***************************************************************************
    *
    *  VALIDACIONES
    * 
    ****************************************************************************/
   var _originationIp = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val();
   
   
   $(document).on('click', 'input[name="preview"]', function(){
       var originationIP = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val();
       var destinationIP = $('#dip1').val() + '.' + $('#dip2').val() + '.' + $('#dip3').val() + '.' + $('#dip4').val();
       
       $('#originationIp ').val(originationIP); 
       $('#destinationIp').val(destinationIP);
      
   });
   
   
    $("#ticket-form").validationEngine('attach', 
    {
        autoHidePrompt:true,
//        promptPosition:'left',
        onValidationComplete:function(form, status){
            
         if (status == true) {           
            // INPUTS DE ARREGLO
            var responseTo = $('[name="Ticket[mail][]"] option');
            var testedNumbers = $('[name="Ticket[tested_numbers][]"]');
            var country = $('[name="Ticket[country][]"]');
            var dateNumber = $('[name="Ticket[date_number][]"]');
            var hourNumber = $('[name="Ticket[hour_number][]"]');
            var attachFile = $('[name="attachFile[]"]');
            var attachFileSave = $('[name="attachFileSave[]"]'); 
            var attachFileSize = $('[name="attachFileSize[]"]'); 

            var responseToArray = [];
            var emailsArray = [];
            var testedNumbersArray = [];
            
            var countryArray = [];
            var countryTextArray = [];
            
            var dateArray = [];
            var hourArray = [];
            var attachFileArray = [];
            var attachFileSaveArray = [];
            var attachFileSizeArray = [];

            var i = 0;

            for (i = 0; i < responseTo.length; i++)
                responseToArray.push(responseTo[i].value);

            for (i = 0; i < testedNumbers.length; i++)
                testedNumbersArray.push(testedNumbers[i].value);

            for (i = 0; i < country.length; i++)
                countryArray.push(country[i].value);
            
            for (i = 0; i < country.length; i++)
                countryTextArray.push(country[i].options[country[i].selectedIndex].text);

            for (i = 0; i < dateNumber.length; i++)
                dateArray.push(dateNumber[i].value);

            for (i = 0; i < hourNumber.length; i++)
                hourArray.push(hourNumber[i].value);

            for (i = 0; i < responseTo.length; i++)
                emailsArray.push(responseTo[i].text);

            for (i = 0; i < attachFile.length; i++)
                attachFileArray.push(attachFile[i].value);

            for (i = 0; i < attachFileSave.length; i++)
                attachFileSaveArray.push(attachFileSave[i].value);

            for (i = 0; i < attachFileSize.length; i++)
                attachFileSizeArray.push(attachFileSize[i].value);
            /**
             *  Construyendo la tabla de tested number
             **/
            var tablaNumber = '<div><table id="tabla_preview"><thead><tr><th>Tested Numbers</th><th>Country</th><th>Date</th><th>Hour</th></tr></thead><tbody>';

            for(i= 0; i < testedNumbers.length; i++) {
                 tablaNumber = tablaNumber + '<tr><td>' + testedNumbers[i].value + '</td>'+ 
                                                 '<td>' + country[i].options[country[i].selectedIndex].text + '</td>'+ 
                                                 '<td>' + dateNumber[i].value + '</td>'+ 
                                                 '<td>' + hourNumber[i].value + '</td></tr>';   
            }

            tablaNumber = tablaNumber+'</tbody></table></div>';

            setTimeout('appendResponseTo()', 500);
            var ticketComplete = '<div id="content_preview">' +
                        '<div class="input-control select block">' +
                            'Response to' +
                            '<select multiple="multiple" disabled="disabled" id="preview_response_to">' +
                            '</select>' +
                        '</div>' +

                        '<div class="input-control text block">'+
                            'Failure'+
                            '<input type="text" value="'+$('#Ticket_id_failure option:selected').html()+'" disabled>' +
                        '</div>'+

                        '<div class="grid" >' +
                            '<div class="row" id="separador-prefijo"></div>' +
                        '</div>' +

                        '<div class="_label">Origination IP <small class="text-muted "><em>(Customer IP)</em></small><span class="margen_17px"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DestinationIP  <small class="text-muted "><em>(Etelix IP)</em></small></div>'+
                        '<div class="input-control text block" data-role="input-control">'+
                            '<input type="text" value="'+$('#oip1').val()+'" disabled class="_ip" disabled id="oip1" maxlength="3">' +
                            '<input type="text" value="'+$('#oip2').val()+'" disabled class="_ip" disabled id="oip2" maxlength="3">' +
                            '<input type="text" value="'+$('#oip3').val()+'" disabled class="_ip" disabled id="oip3" maxlength="3">'+
                            '<input type="text" value="'+$('#oip4').val()+'" disabled class="_ip" disabled id="oip4" maxlength="3">'+

                            '<span class="margen_22px"></span>'+

                            '<input type="text" value="'+$('#dip1').val()+'" disabled class="_ip" disabled id="dip1" maxlength="3">' +
                            '<input type="text" value="'+$('#dip2').val()+'" disabled class="_ip" disabled id="dip2" maxlength="3">' +
                            '<input type="text" value="'+$('#dip3').val()+'" disabled class="_ip" disabled id="dip3" maxlength="3">' +
                            '<input type="text" value="'+$('#dip4').val()+'" disabled class="_ip" disabled id="dip4" maxlength="3">' +
                        '</div>'+

                        '<div class="input-control text block" >'+
                            'Prefix'+
                            '<input type="text" value="'+$('#Ticket_prefix').val()+'" disabled>' +
                        '</div>'+

                        '<div class="grid" >'+
                            '<div class="row" id="separador-prefijo"></div>'+
                       '</div>'+

                        '<div class="input-control text block">'+
                            'GMT'+
                            '<input type="text" value="'+$('#Ticket_idGmt option:selected').html()+'" disabled>' +
                        '</div>'+

                        '<div class="grid" >' +
                            '<div class="row" id="separador-prefijo"></div>' +
                        '</div>' +

                        '<div class="grid" >' +
                            '<div class="row" id="separador-prefijo"></div>' +
                        '</div>' +

                        '<div id="tabla_tested_number" class="grid">'+
                            tablaNumber + 
                        '</div>'+

                        '<div class="input-control textarea" data-role="input-control">'+
                                'Description' +
                                '<textarea disabled>'+$('#Ticket_description').val()+'</textarea>' +
                        '</div>'+
                    '</div>' +
                    '<div id="preview_buttons">' +
                        '<button  class="primary large" id="save_ticket">Send Ticket Information</button> <a  href="#" id="imprimir"><i class="icon-printer on-right"></i></a>' +
                    '</div>';
                
            $.Dialog({
                shadow: true,
                overlay: true,
                flat:true,
                icon: '<span class="icon-eye-2"></span>',
                title: 'Preview Ticket',
                width: 510,
                height: 300,
                padding: 0,
                draggable: true,
                content:ticketComplete
                    
            });
            $('#save_ticket').on('click',  function(){
                var _originationIp = $('#oip1').val() + '.' + $('#oip2').val() + '.' + $('#oip3').val() + '.' + $('#oip4').val();
                var _destinationIp = $('#dip1').val() + '.' + $('#dip2').val() + '.' + $('#dip3').val() + '.' + $('#dip4').val();

                $.ajax({
                   type:'POST',
                   url:'saveTicket',
                   beforeSend:function(){
                       $.Dialog.close();

                        $.Dialog({
                             shadow: true,
                             overlay: false,
                             icon: '<span class="icon-rocket"></span>',
                             title: 'Sending email',
                             width: 500,
                             padding: 10,
                             content: '<center><h2>Wait a few seconds...<h2></center>'
                       });
                   },
                   data:{
                       responseTo: responseToArray,
                       failure:$('#Ticket_id_failure').val(),
                       failureText:$('#Ticket_id_failure option:selected').text(),
                       originationIp: _originationIp,
                       destinationIp: _destinationIp,
                       prefix: $('#Ticket_prefix').val(),
                       gmt: $('#Ticket_idGmt').val(),
                       gmtText: $('#Ticket_idGmt option:selected').text(),
                       testedNumber: testedNumbersArray,
                       _country: countryArray,
                       _countryText: countryTextArray,
                       _date: dateArray,
                       _hour: hourArray,
                       description: $('#Ticket_description').val(),
                       emails: emailsArray,
                       _attachFile: attachFileArray,
                       _attachFileSave: attachFileSaveArray,
                       _attachFileSize: attachFileSizeArray,
                       _ticketComplete: ticketComplete
                   },
                   success:function(data){
                       if (data == 'success') {
                           $.Dialog.close();

                           $.Dialog({
                                shadow: true,
                                overlay: false,
                                icon: '<span class="icon-rocket"></span>',
                                title: 'Operation complete',
                                width: 500,
                                padding: 10,
                                content: '<center><h2>Success<h2></center>'
                          });
                       }
                   }
                });
            });         
            
        } // Fin if del status
                    
                    
            }  
    }); // Fin de validaciones
    
});

/***************************************************************************
* 
*              MARCAR OPCIONES DEL SELECT MULTIPLE
*              SIN TENER QUE PULSAR LA TECLA CTRL
* 
***************************************************************************/
//todos = new Array();
/*function marcar(s) 
{
   cual = s.selectedIndex;
   for(y = 0; y < s.options.length; y++){
       if(y == cual){
           s.options[y].selected = (todos[y] == true) ? false : true;
           todos[y]=(todos[y] == true) ? false : true;
       }else{
           s.options[y].selected = todos[y];
       }
   }
}*/





