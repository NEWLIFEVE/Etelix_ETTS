// Función para agregar archivos en el description
function attachFile()
{
    var settings = {
                url: "/file/uploadjquery",
                dragDrop:false,
                showDone: false,
                fileName: "myfile",
                allowedTypes:"jpg,png,gif,doc,docx,xls,xlsx,pdf,zip",	
                returnType:"json",
                     onSuccess:function(files,data,xhr)
                {
                   // alert((data));
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
                    pd.statusbar.hide(); //You choice to hide/not.
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
        
        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#example').dataTable( {
            "bJQueryUI": true,
            "bAutoWidth": false,
            "bDestroy": true,
            "sPaginationType": "full_numbers",
            "aoColumnDefs": [
                    { "aDataSort": false, "aTargets": [ 0,7 ] },
                    { "bSortable": false, "aTargets": [ 7 ] }
            ],
            "aaSorting": [[ 0, "desc" ]]

       });
        
} );