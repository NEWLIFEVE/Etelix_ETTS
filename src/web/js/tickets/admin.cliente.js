// Asociar mas correos al ticket creado
function toggleMails()
{
    $('.div-agregar-correo, .down-mail').toggle('fast');
}

// Bajar correos a la lista a donde se enviará la nota al cerrar o dar una respuesta al ticket
function bajarCorreo()
{
    $ETTS.UI.appendOptions($('a.a-bajar-correo'), $('#mails'));
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

$(document).ready(function() {
       //Tooltip del statu y el tiempo que lleva desde que se abrió
        $( document ).tooltip({
            track: true
        });
        
       // Boton para abrir el preview del ticket
       $(document).on('click', 'a.preview', function () {
                setTimeout(function(){$('.div-agregar-correo, .down-mail').hide();}, 500);

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
                            content:"<div id=content_detail>"+data+"</div>"
                        });
                        $('div.answer-ticket').scrollTop(100000);
                        $('.see-email').on('click', function () {
                            var settings = {
                                ticketNumber:$(this).attr('id'),
                                loader:$('.pre-loader'),
                                answer:$('.answer-ticket'),
                                optionOpen:$('#open-ticket').val(),
                                idTicket:$('#id_ticket').val()
                            };
                            
                            $ETTS.ajax.getMailsImap(settings);
                        });
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
            "bAutoWidth": false,
            "bDestroy": true,
            "sPaginationType": "full_numbers",
            "aoColumnDefs": [
                    { "aDataSort": false, "aTargets": [ 0,6 ] },
                    { "bSortable": false, "aTargets": [ 6 ] }
            ],
            "aaSorting": [[ 0, "desc" ]]

       });
        
} );