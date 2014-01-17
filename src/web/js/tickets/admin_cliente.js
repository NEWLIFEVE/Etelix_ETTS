$(document).ready(function() {
      
       // Boton para abrir el preview del ticket
       $(document).on('click', 'table#example tbody tr td a.preview', function () {
                var idTicket = $(this).attr('rel');
                $.ajax({
                    type:"POST",
                    url:"getdataticket/" + idTicket,
                    success:function(data){
                        $.Dialog({
                            shadow: true,
                            overlay: true,
                            flat:true,
                            icon: "<span class=icon-eye-2></span>",
                            title: "Ticket Information",
                            width: 510,
                            height: 300,
                            padding: 0,
                            draggable: true,
                            content:"<div id=content_preview>"+data+"</div>"
                        });
                    }
                });
        } );
        
        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#example').dataTable( {
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 6 ] }
                ]
        });
        
} );