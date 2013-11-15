$(document).on('ready', function(){
    /***************************************************************************
     * 
     *  Funcion para cargar destinations en los selects generados en el evento
     *  onclick
     * 
     ***************************************************************************/
    var getDestination = function(){
        $.post(_root_ + 'tickets/destinations', '', function(data){
                $('[name="Tickets[destination][]"]').html('<option>Destination</option>');
                for (var i = 0; i < data.length; i++) {
                    $('[name="Tickets[destination][]"]').append('<option value="'+ data[i].id +'">'+ data[i].destino +'</option>');
                }
            }, 'json'
        );
    };
    
    /***************************************************************************
     * 
     *  Delegate para agregar el datepicker dinamicamente
     * 
     ***************************************************************************/
    $('#tickets-form').delegate('.fecha','focusin',function(){
        $(this).datetimepicker({
            changeMonth:true,
            changeYear:true
        }); 
    });


    /***************************************************************************
     * 
     *  Boton para agregar más tested_numbers, destinatios y fecha
     * 
     ***************************************************************************/
    $(document).on('click', '._agregar', function(){
        getDestination();// Se llama a la función para cargar el select de destinations
        $('.container_agregar').append(
            '<div class="input-control text span3">' +
                '<input type="text" class="efecto" style="display: none;" name="Tickets[tested_numbers][]" placeholder="Tested numbers" >' +
            '</div>' +
            
            '<div class="input-control select span2" style="margin-left: 5px;">' +
                '<select name="Tickets[destination][]" class="efecto destinos"></select>' +        // Se carga el select con getDestination()
            '</div>' +
            
            '<div class="input-control text span2" style="margin-left: 5px;">' +
                '<input type="text" class="efecto fecha" style="display: none;" name="Tickets[fecha][]" placeholder="Fecha" >' +
            '</div>' +
            '<div class="input-control text span1" style="margin-left: 15px; padding-top: 5px"><a href="javascript:void(0)" class="_cancelar"><i class="icon-cancel-2"></i></a></div>'
        );
        $('.efecto').show('fast')
    });
});