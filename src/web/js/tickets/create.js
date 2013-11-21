$(document).on('ready', function(){
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

        $('.div-agregar_correo').toggle('slow');
        
    });
    
    /***************************************************************************
     *      
     *      AGREGAR CORREOS AL SELECT DE ABAJO
     *      
     ***************************************************************************/
    var clickAgregarMail = 0;
    $(document).on('click', '.a-bajar_correo', function(){
        if ($('#cargar_mails').val()) { // Si hay valor en la carga de mail se ejecutará el código
        
            clickAgregarMail += 1;

            if (clickAgregarMail > 5){
                alert('Límite alcanzado')
                return false;
            }
            
            $('#Tickets_mail').append('<option value="'+$('#cargar_mails').val()+'">'+$('#cargar_mails option:selected').html()+'</option>');
        }
    });
    
    /***************************************************************************
     * 
     *  Funcion para cargar destinations en los selects generados en el evento
     *  onclick
     * 
     ***************************************************************************/
    var getDestination = function(){
        $.post(_root_ + 'tickets/destinations', '', function(data){
                $('[name="Tickets[destination][]"]').html('<option>Country</option>');
                for (var i = 0; i < data.length; i++) {
                    $('[name="Tickets[destination][]"]').append('<option value="'+ data[i].id +'">'+ data[i].destino +'</option>');
                }
            }, 'json');
    };
    
    /***************************************************************************
     * 
     *  Delegate para agregar el datepicker dinamicamente
     * 
     ***************************************************************************/
    $('#tickets-form').delegate('.fecha','focusin',function(){
        $(this).datetimepicker({
            dateFormat: "yy-mm-dd",
            controlType: 'select',
            timeFormat: 'HH:mm'
        }); 
    });
    

    /***************************************************************************
     * 
     *  Boton para agregar más tested_numbers, destinatios y fecha
     * 
     ***************************************************************************/
    
    var clickAgregarNumber = 0; // Varible que permite cambiar los numeros del id del div que contiene a tested number
    $(document).on('click', '._agregar', function(){
        clickAgregarNumber += 1; 
        getDestination();// Se llama a la función para cargar el select de destinations
        $('.container_agregar').append(
            '<div id="div_'+clickAgregarNumber+'" style="display:none;">'+
                '<div class="input-control text span3">' +
                    '<input type="text" name="Tickets[tested_numbers][]" placeholder="Tested numbers" >' +
                '</div>' +

                '<div class="input-control select span2 country2" style="margin-left: 5px;">' +
                    '<select name="Tickets[destination][]" class="destinos">' +

                    '</select>' +        // Se carga el select con getDestination()
                '</div>' +

                '<div class="input-control text span2" style="margin-left: 5px;">' +
                    '<input type="text" class="fecha" name="Tickets[fecha][]" placeholder="Date" >' +
                '</div>' +
                '<a href="javascript:void(0)" style="margin-left: 15px;"  class="_cancelar input-control text span1"><i class="icon-cancel-2 fg-red "></i></a>' +
            '</div>'
        );
        
        $("#div_"+clickAgregarNumber).show('slow')

    });
        
    /***************************************************************************
     * 
     *  REMOVER LAS FILAS QUE SE HAYAN CREADO DE TESTED NUMBER
     * 
     ***************************************************************************/
    $(document).on('click', '._cancelar', function(){
        $(this).parent('div').hide('slow', function(){
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

