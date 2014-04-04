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
        url:"/ticket/getticketrelation/"+id,
        dataType:'json',
        success:function(data){
            oTable.fnOpen( nTr, fnFormatDetails(data, id) , 'details' );
        }
    });
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


// Asociar mas correos al ticket creado
function seeOptions(e)
{
    $('.options-hide').show('fast');
    $(e).text('hide');
    $(e).attr('onclick', 'hideOptions(this)');
}
function hideOptions(e)
{
    $('.options-hide').hide('fast');
    $(e).text('Add more email\'s');
    $(e).attr('onclick', 'seeOptions(this)');
}

// Bajar correos a la lista a donde se enviará la nota al cerrar o dar una respuesta al ticket
function bajarCorreo(e)
{
    var totalMails = $('#mails option:selected'), mails = [];

    for (var i=0; i<totalMails.length; i++) mails.push(totalMails[i].value);
    
    var settings = {
        save:true,
        idTicket:$('#id_ticket'),
        mail:mails
    };
    
    $ETTS.UI.appendOptions($(e), $('#mails'), $('#open-ticket'), settings);
}

function newMailTicket(e)
{
    if ($('#new_mail').val().length > 0) 
        $ETTS.ajax.saveMail($('#new_mail'),'',$('#user-ticket'),null,$('#mostrar-mails'),$('#open-ticket'),$('#id_ticket').val());
}

function borrarCorreo(e)
{
    var longitudTotal = $('#mostrar-mails option').length, 
    longitudSeleccionados = $('#mostrar-mails option:selected').length,
    options = $('#mostrar-mails option:selected'),
    total=longitudTotal - longitudSeleccionados, 
    _idMailticket=[];
    
    if ($('#mostrar-mails').val()) 
    {
        if (total !== 0)
        {
            for (var i = 0; i < longitudSeleccionados; i++) _idMailticket.push(options[i].value);
            var settings = {
                idMailTicket:_idMailticket
            };
            $ETTS.ajax.deleteMailTicket(settings);
        }
    }
}

/**
*Función para refrescar la vista admin.php cada 5 minutos. Si se da un preview del
*ticket se interrrumpe el proceso y al cerrar el preview se vuelven a contar los 
*cinco minutos.
*/
var refreshInterval = setInterval(function(){
            window.location.reload(true);
            }, 300000);
            
$(document).on('ready', function() {
        // Llamado de refresh
        refreshInterval;
        // Los usuarios que no sean clientes contendran esta clase en el div page
        $('div.page').addClass('width-page');
        
        //Tooltip del statu y el tiempo que lleva desde que se abrió
        $( document ).tooltip({
            track: true
        });
    
        //Append Speech
        $(document).on('change', 'select#speech', function(){
            if ($(this).val()){
                var settings = {
                    failure:$('#Ticket_id_failure'), 
                    country:$('#Ticket_country')
                };
                $ETTS.ajax.getSpeech($(this).val(), $('#answer'), settings); 
            } else {
                $('#answer').val('')
            }
        });
       
       // Boton para abrir el preview del ticket
       $(document).on('click', 'table#example tbody tr td a.preview', function () {
                // Se detiene el refresh
                clearInterval(refreshInterval);
                // Se oculta el div para agregar correo
                 setTimeout(function(){$('.options-hide').hide();}, 500);
                
                var clase=$(this).parent().parent().attr('class'),
                idTicket = $(this).attr('rel');
                $.ajax({
                    type:"POST",
                    url:"/ticket/getdataticket/" + idTicket,
                    success:function(data){

                        $.Dialog({
                            shadow: true,
                            overlay: true,
                            overlayClickClose: false,
                            flat:true,
                            icon: "<span class=icon-eye-2></span>",
                            title: "Ticket Information",
                            width: 510,
                            height: 300,
                            paddingBottom: 20,
                            draggable: true,
                            content:"<div id=content_detail>"+data+"</div>",
                            sysBtnCloseClick: function(event){
                                // Al cerrar la ventana, se vuelve a contar los 5 munitos
                                refreshInterval = setInterval(function(){
                                   window.location.reload(true);
                                }, 300000);
                            }
                        });
                        $('div.answer-ticket').scrollTop(100000);
                    }
                });
                setTimeout('attachFile()', 1000);
                
                if (clase.toLowerCase().indexOf("blink") >= 0)
                {
                    $ETTS.UI.removeBlink($(this));
                    $ETTS.ajax.removeBlink(idTicket);
                }
        } );
        
        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#example').dataTable( {
                "bJQueryUI": true,
                "bDestroy": true,
                "bAutoWidth": false,
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [
                        { "aDataSort": false, "aTargets": [ 0,9 ] },
                        { "bSortable": false, "aTargets": [ 0,9 ] }
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