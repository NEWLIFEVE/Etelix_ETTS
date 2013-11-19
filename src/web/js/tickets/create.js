todos = new Array();
var contador = 0;                      // Varible que permite cambiar los numeros del id del div que contiene a tested number

/***************************************************************************
* 
*              MARCAR OPCIONES DEL SELECT MULTIPLE
*              SIN TENER QUE PULSAR LA TECLA CTRL
* 
***************************************************************************/
function marcar(s) 
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
}


$(document).on('ready', function(){
    
    $('.div-agregar_correo').hide();
    
    $(document).on('click', '.a-agregar_correo', function(){
        $('.div-agregar_correo').toggle();
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
            changeMonth:true,
            changeYear:true,
            dateFormat: "yy-mm-dd"
        }); 
    });

 
    /***************************************************************************
     * 
     *  Boton para agregar más tested_numbers, destinatios y fecha
     * 
     ***************************************************************************/
    
    $(document).on('click', '._agregar', function(){
        contador += 1; 
        getDestination();// Se llama a la función para cargar el select de destinations
        $('.container_agregar').append(
            '<div id="div_'+contador+'">'+
                '<div class="input-control text span3">' +
                    '<input type="text" class="efecto" style="display: none;" name="Tickets[tested_numbers][]" placeholder="Tested numbers" >' +
                '</div>' +

                '<div class="input-control select span2 country2" style="margin-left: 5px;">' +
                    '<select name="Tickets[destination][]" class="efecto destinos">' +

                    '</select>' +        // Se carga el select con getDestination()
                '</div>' +

                '<div class="input-control text span2" style="margin-left: 5px;">' +
                    '<input type="text" class="efecto fecha" style="display: none;" name="Tickets[fecha][]" placeholder="Date" >' +
                '</div>' +
                    '<a href="javascript:void(0)" style="margin-left: 15px;"  class="_cancelar input-control text span1"><i class="icon-cancel-2 fg-red "></i></a>' +
            '</div>'
        );
        $('.efecto').show('fast')

    });
    
    
    /***************************************************************************
     * 
     *  REMOVER LAS FILAS QUE SE HAYAN CREADO DE TESTED NUMBER
     * 
     ***************************************************************************/
    $(document).on('click', '._cancelar', function(){
        $(this).parent('div').remove();
    });
});






