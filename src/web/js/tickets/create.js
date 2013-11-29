/*******************************************************************************
 *          FUNCION PARA CARGAR EL ULTIMO OPTION Y PASARLO A RESPONSE TO
 ******************************************************************************/
function setResponseTo() 
{
    var valor = $('#cargar_mails option:last').val();
    var texto = $('#cargar_mails option:last').html();
    $('#Ticket_mail').append('<option value="'+valor+'">'+texto+'</option>');
}

$(document).on('ready', function(){
    
 
    
    
    $(document).on('click', '#add_all_email', function(){
       $('#Ticket_mail').html('');
       $('#cargar_mails option').clone().appendTo($('#Ticket_mail'));
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
            '<div id="div_'+clickAgregarNumber+'" style="display:none;">'+
                '<div class="input-control text span3">' +
                    '<input type="text" name="Ticket[tested_numbers][]" placeholder="Without prefix" >' +
                '</div>' +
                
                country.html() +

                '<div class="input-control text span2 margen-number fecha_div">' +
                    '<input type="text" class="fecha" name="Ticket[date_number][]" placeholder="Date" >' +
                '</div>' +
                
                '<div class="input-control text span1 margen-number hour_div">' +
                    '<input type="text" name="Ticket[hour_number][]" placeholder="Hour" class="hour" >' +
                '</div>' +
                '<a href="javascript:void(0)" style="margin-left: 5px; padding-top: 5px; width: 10px !important;"  class="_cancelar input-control text span1"><i class="icon-cancel-2 fg-red "></i></a>' +
            '</div>'
            
        );
        $("#div_"+clickAgregarNumber).show('fast')

    });
        
    /***************************************************************************
     * 
     *  REMOVER LAS FILAS QUE SE HAYAN CREADO DE TESTED NUMBER
     * 
     ***************************************************************************/
    $(document).on('click', '._cancelar', function(){
        $(this).parent('div').hide('fast', function(){
            $(this).remove();
        });
    });
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


$('input[name="preview"]').on('click', function(e){
    e.preventDefault();
    
    // INPUTS DE ARREGLO
    var responseTo = $('[name="Ticket[mail][]"] option');
    var testedNumbers = $('[name="Ticket[tested_numbers][]"]');
    var country = $('[name="Ticket[country][]"]');
    var dateNumber = $('[name="Ticket[date_number][]"]');
    var hourNumber = $('[name="Ticket[hour_number][]"]');

    var responseToArray = [];
    var testedNumbersArray = [];
    var countryArray = [];
    var dateNumberArray = [];
    var hourNumberArray = [];

    var i = 0;

    for(i= 0; i < responseTo.length; i++)
        responseToArray.push(responseTo[i].value)

    for(i= 0; i < testedNumbers.length; i++)
        testedNumbersArray.push(testedNumbers[i].value)

    for(i= 0; i < country.length; i++)
        countryArray.push(country[i].value)

    for(i= 0; i < dateNumber.length; i++)
        dateNumberArray.push(dateNumber[i].value)

    for(i= 0; i < hourNumber.length; i++)
        hourNumberArray.push(hourNumber[i].value)
    
    $.Dialog({
        shadow: true,
        overlay: false,
        icon: '<span class="icon-rocket"></span>',
        title: 'Title',
        width: 500,
        height:600,
        padding: 50,
        draggable: true,
        content:

            'Response to: ' + responseToArray + '<br>' +
            'Failure:' + $('#Ticket_id_failure').val() + '<br>' +
            'Origination ip:' + $('#oip1').val()+'.'+$('#oip2').val()+'.'+$('#oip3').val()+'.'+$('#oip4').val()+ '<br>' +
            'Destination ip:' + $('#dip1').val()+'.'+$('#dip2').val()+'.'+$('#dip3').val()+'.'+$('#dip4').val()+ '<br>' +
            'Prefix:' + $('#Ticket_prefix').val() + '<br>' +
            'GMT:' + $('#Ticket_idGmt').val() + '<br>' +

            'Tested numbers:' + testedNumbersArray + '<br>' +
            'Country:' + countryArray + '<br>' +
            'Date:' + dateNumberArray + '<br>' +
            'Hour:' + hourNumberArray + '<br>' +

            'Description:' + $('#Ticket_description').val() + '<br>' +
            '<button type="button" class="default">Send</button> &nbsp; <button type="button" class="default">Cancel</button>'
        
    });
});

