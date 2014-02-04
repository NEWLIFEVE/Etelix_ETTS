/* Formating function for row details */
function fnFormatDetails ( data,id )
{
        var widthThPlus = $('th#th-plus').clone().outerWidth(),
        widthUser = $('th#th-user').clone().outerWidth(),
        widthCarrier = $('th#th-carrier').clone().outerWidth(),
        widthTicket = $('th#th-ticket-number').clone().outerWidth(),
        widthFailure = $('th#th-failure').clone().outerWidth(),
        widthStatus = $('th#th-status').clone().outerWidth(),
        widthOip = $('th#th-oip').clone().outerWidth(),
        widthDip = $('th#th-dip').clone().outerWidth(),
        widthDate = $('th#th-date').clone().outerWidth(),
        widthPreview = $('th#th-preview').clone().outerWidth(),
        aData = data,
        sOut = '<table class="display">',
        length = data.length;
        
        for(var i= 0; i < length; i++)
        {
             sOut += '<tr style="background:#C0C0C0">';
             sOut += '<td style="width:'+(widthThPlus+11)+'px !important; ">&nbsp;&nbsp;</td>';
             sOut += '<td style="width:'+(widthUser+7)+'px !important; ">'+aData[i].user +'</td>';
             sOut += '<td style="width:'+(widthCarrier+9)+'px !important; ">'+aData[i].carrier+'</td>';
             sOut += '<td style="width:'+(widthTicket+12)+'px !important; ">'+aData[i].ticket_number+'</td>';
             sOut += '<td style="width:'+(widthFailure+12)+'px !important; ">'+aData[i].failure+'</td>';
             sOut += '<td father="'+id+'" son="'+aData[i].id_ticket+'" style="width:'+(widthStatus+14)+'px !important; " >';
             sOut += '<span class="span-status">';
             sOut += '<span>'+aData[i].status_ticket+'</span>';
             sOut += '</span>';
             sOut += '</td>';
             sOut += '<td style="width:'+(widthOip+15)+'px !important; ">'+aData[i].origination_ip + '</td>';
             sOut += '<td style="width:'+(widthDip+10)+'px !important; ">' +aData[i].destination_ip + '</td>';
             sOut += '<td style="width:'+(widthDate+8)+'px !important; ">' + aData[i].date + '</td>';
             sOut += '<td>&nbsp;</td>';
             sOut += '<td style="width:'+(widthPreview+12)+'px !important; "><a href="javascript:void(0)" class="preview" rel="'+aData[i].id_ticket+'"><img width="12" height="12" src="/images/view.gif"></a></td>';
             sOut += '</tr>';
        }

        sOut += '</table>';
        return sOut
        
}

// Función con ajax para traer los tickets relacionados
function getTicketsRelated(id, nTr, oTable)
{
    $.ajax({
        type:"POST",
        url:"/ticket/Getticketrelation/"+id,
        dataType:'json',
        success:function(data){
            oTable.fnOpen( nTr, fnFormatDetails(data, id) , 'details' );
        }
    });
}

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
        content: '<center><p>El status del ticket ha sido cambiado, se ha mandado un correo con el detalle del mismo</p></center>'
    });
    
    $("td[id='"+id+"'], td[son='"+id+"']").children('span.span-status').children('span').text(status);
    select.next('span.span-status').show()
    $("td[id='"+id+"']").parent('tr').removeAttr('class')
    $("td[id='"+id+"']").parent('tr').addClass(_class)
    select.remove('select');
    
    
}

// Función para agregar archivos en el description
function attachFile()
{
    
    var settings = {
                url: "/file/uploadjquery",
                dragDrop:false,
                showDone: false,
                fileName: "myfile",
                allowedTypes:"pdf,gif,jpeg,png,jpg,xlsx,xls,txt,cap,pcap,csv",	
                returnType:"json",
                showFileCounter:false,
                     onSuccess:function(files,data,xhr)
                {
                     $('div.ajax-file-upload-filename:last').attr('name', data[0]); 
                },
                showDelete:true,
                deleteCallback: function(data,pd){
                    for(var i=0;i<data.length;i++)
                    {
                        $.post("/file/deletejquery",{op:"delete",name:data[i]},
                        function(resp, textStatus, jqXHR)
                        {
                            //Show Message  
                            $("#status").html("");      
                        });
                     }      
                    pd.statusbar.remove(); //You choice to hide/not.
                }
            }
    var uploadObj = $("#mulitplefileuploader").uploadFile(settings); 
}


function getSpeech(idSpeech)
{
    $.ajax({
       type:'POST',
       url:'/speech/gettextspeech',
       data: {
         _idSpeech:idSpeech   
       },
       success:function(data) {
          $('#answer').val(data);
       }
    });
}

$(document).on('ready', function() {
        
        // Los usuarios que no sean clientes contendran esta clase en el div page
        $('div.page').addClass('width-page');
        
        //Tooltip del statu y el tiempo que lleva desde que se abrió
        $( document ).tooltip({
            track: true
        });
    
        //Append Speech
        $(document).on('change', 'select#speech', function(){
            if ($(this).val()){
               var idTitle=$('#speech option:selected').val();
               getSpeech(idTitle)
            }
        });
        
       // Boton para aparecer las opciones del status del ticket
       $(document).on('click', '#example tbody tr td a.edit-status', function () {
           $(this).parent('span.span-status').hide();
           $(this).parent('span.span-status').parent('td').prepend($('#status').clone().removeAttr('class'));
       });
       
       // Boton para abrir el preview del ticket
       $(document).on('click', 'table#example tbody tr td a.preview', function () {
                var idTicket = $(this).attr('rel');
                $.ajax({
                    type:"POST",
                    url:"/ticket/getdataticket/" + idTicket,
                    success:function(data){
                       
                        $.Dialog({
                            shadow: true,
                            overlay: true,
                            flat:true,
                            icon: "<span class=icon-eye-2></span>",
                            title: "Ticket Information",
                            width: 510,
                            height: 300,
                            paddingBottom: 20,
                            draggable: true,
                            content:"<div id=content_detail>"+data+"</div>"
                        });
                        $('div.answer-ticket').scrollTop(100000);
                    }
                });
                setTimeout('attachFile()', 1000);
        } );
        
        // Evento para cambiar el status
        $(document).on('change', 'table#example tbody tr td select#status', function(){
            var id = $(this).parent('td').attr('id'),
            select = $(this),
            _status = $(this).val(),
            _date = $(this).parent('td').attr('time');
            
            $.ajax({
                type:'POST',
                url:'/ticket/updatestatus/' + id,
                dataType:'html',
                data:{
                      idStatus:_status
                },
                success:function(data){
                    if (data == 'true') {
                        if (_status == 2) {
                              changeStatus(id, select, 'close', 'close even')
                        } else {
                            // Si _date es mayor a 86400 segundos(24 horas)
                            if(_date > 86400) {
                                changeStatus(id, select, 'open', 'late even')
                            } else {
                                changeStatus(id, select, 'open', 'open even')
                            }
                        }
                    } else {
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
        
        // Al perder el foco del select del cambio de statu
        $(document).on('blur', 'table#example tbody tr td select#status', function(){
            $(this).next('span.span-status').show();
            $(this).remove('select')
        });
        
        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#example').dataTable( {
                "bJQueryUI": true,
                "bDestroy": true,
//                "bAutoWidth": false,
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [
                        { "aDataSort": false, "aTargets": [ 0,10 ] },
                        { "bSortable": false, "aTargets": [ 0,10 ] }
                ]
                
        });

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $(document).on('click', '#example tbody td img.detalle', function () {
                id=$(this).parents('tr').children('td[name="id"]').attr('id');
                var nTr = $(this).parents('tr')[0];
                if ( oTable.fnIsOpen(nTr) )
                {
                        /* This row is already open - close it */
                        this.src = "/images/details_open.png";
                        oTable.fnClose( nTr );
                }
                else
                {
                        /* Open this row */
                        this.src = "/images/details_close.png";
                        oTable.fnOpen( nTr, getTicketsRelated(id, nTr, oTable) , 'details' );
                }
        } );
        
        
} );