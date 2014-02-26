//Función para agregar o quitar estilos al cambiar el status
function changeStatus(id, select, status, _class)
{   
    $.Dialog.close();
    $.Dialog({
        shadow: true,
        overlay: false,
        icon: '<span class="icon-rocket"></span>',
        title: 'Change status',
        width: 300,
        padding: 10,
        content: '<center><p>The status of the ticket has been changed, it has sent an email with details thereof</p></center>'
    });
    if (status == 'close')
    {
        $("td[id='"+id+"']").html('close');
        $("td[id='"+id+"']").parent('tr').removeAttr('class')
        $("td[id='"+id+"']").parent('tr').addClass(_class)
        
    }
    else
    {
        $("td[id='"+id+"'], td[son='"+id+"']").children('span.span-status').children('span').text(status);
        select.next('span.span-status').show()
        $("td[id='"+id+"']").parent('tr').removeAttr('class')
        $("td[id='"+id+"']").parent('tr').addClass(_class)
        select.remove('select');
    }
}

$(document).on('ready', function(){
    // Boton para aparecer las opciones del status del ticket
    $(document).on('click', '#example tbody tr td a.edit-status', function () {
        $(this).parent('span.span-status').hide();
        $(this).parent('span.span-status').parent('td').prepend($('#status').clone().removeAttr('class'));
    });
    
   // Evento para cambiar el status
    $(document).on('change', 'table#example tbody tr td select#status', function(){
        var id = $(this).parent('td').attr('id'),
        select = $(this),
        _status = $(this).val(),
        _date = $(this).parent('td').attr('time');

        // Se llama al confirm
        $ETTS.UI.confirmCloseTicket(select);

        // Si le da clic a cancelar
        $('#cancel_confirm').on('click', function(){$.Dialog.close()});

        // Si le da clic a ok
        $('#ok_confirm').on('click', function(){
            $.Dialog.close();

            if (_status == 2) 
            {
                changeStatus(id, select, 'close', 'close even')
            } 
            else 
            {
                // Si _date es mayor a 86400 segundos(24 horas)
                if(_date > 86400) {
                    changeStatus(id, select, 'open', 'late even')
                } else {
                    changeStatus(id, select, 'open', 'open even')
                }
            }

            $.ajax({
            type:'POST',
            url:'/ticket/updatestatus/' + id,
            dataType:'html',
            data:{idStatus:_status},
            success:function(data){
                    if (data != 'true') 
                    {
                        $.Dialog({
                                shadow: true,
                                overlay: false,
                                icon: '<span class="icon-rocket"></span>',
                                title: 'Error',
                                width: 500,
                                padding: 10,
                                content: '<center>'+data+'</center>'
                          });
                    }
                }
            });
        });
    });

    // Al perder el foco del select del cambio de statu
    $(document).on('blur', 'table#example tbody tr td select#status', function(){
        var select=$(this)
        setTimeout(function(){
            select.next('span.span-status').show()
            select.remove('select')
        }, 1000)
    }); 
});