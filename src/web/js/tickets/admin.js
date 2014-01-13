/* Formating function for row details */
function fnFormatDetails ( oTable, nTr )
{
        var widthTicket = $('th#th-ticket-number').clone().outerWidth();
        var widthFailure = $('th#th-failure').clone().outerWidth();
        var widthStatus = $('th#th-status').clone().outerWidth();
        var widthOip = $('th#th-oip').clone().outerWidth();
        var widthDip = $('th#th-dip').clone().outerWidth();
        var widthDate = $('th#th-date').clone().outerWidth();
        var widthPreview = $('th#th-preview').clone().outerWidth();
        
        var aData = oTable.fnGetData( nTr );
        var sOut = '<table class="display">';
        var style = '';
        
        for(var i= 0; i < aData[8].split('|').length - 1; i++) {
            
            if (i%2 == 0)
                style = '#C0C0C0';
            else
                style = '#D3D3D3';
            
            sOut +=  '<tr style="background:'+style+'"><td>&nbsp;&nbsp;</td><td style="width:'+(widthTicket+13)+'px !important; ">' + 
                aData[8].split('|')[i] + '</td><td style="width:'+(widthFailure+13)+'px !important; ">' + 
                aData[9].split('|')[i] + '</td><td style="width:'+(widthStatus+9)+'px !important; ">' + 
                aData[10].split('|')[i] + '</td><td style="width:'+(widthOip+11)+'px !important; ">' + 
                aData[11].split('|')[i] + '</td><td style="width:'+(widthDip+12)+'px !important; ">' + 
                aData[12].split('|')[i] + '</td><td style="width:'+(widthDate+9)+'px !important; ">' + 
                aData[13].split('|')[i] + '</td><td style="width:'+(widthPreview+11)+'px !important; ">' +
                aData[14].split('|')[i] + '</td></tr>';
        }
        
        sOut += '</table>';
        
        return sOut;
}

$(document).ready(function() {
       // Boton para aparecer la opciones del status del ticket
       $(document).on('click', '#example tbody tr td a.edit-status', function () {
           $(this).parent('span.span-status').hide();
           $(this).parent('span.span-status').parent('td').prepend($('#status').clone().removeAttr('class'));
       });
       
       // Boton para abrir el preview del ticket
       $(document).on('click', 'table#example tbody tr td a.preview', function () {
                $.ajax({
                    type:"POST",
                    url:"getdataticket",
                    data:{idTicket:$(this).attr('rel')},
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
        
        // Evento para cambiar el status
        $(document).on('change', 'table#example tbody tr td select#status', function(){
            
            _select = $(this);
            _tr = $(this).parent('td').parent('tr');
            _status = $(this).val();
            $.ajax({
                type:'POST',
                url:'updatestatus',
                data:{
                      idTicket:$(this).parent('td').attr('id'),
                      idStatus:_status
                },
                success:function(data){
                   $(location).attr('href', _root_ + 'ticket/admin');
//                    if (_status == 2) {
//                        _select.next('span.span-status').show().children('span').text('close');
//                        _select.remove('select')
//                        _tr.addClass('gradeX')
//                    } else {
//                        _select.next('span.span-status').show().children('span').text('open');
//                        _select.remove('select')
//                        _tr.removeClass('gradeX')
//                    }
                }
            });
        });
        
        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement( 'th' );
        var nCloneTd = document.createElement( 'td' );
        nCloneTd.innerHTML = '<img class="detalle" width="12" height="12" src="/images/details_open.png">';
        nCloneTd.className = "center";
        
        $('#example thead tr').each( function () {
                this.insertBefore( nCloneTh, this.childNodes[0] );
        } );

        $('#example tbody tr').each( function () {
                this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
        } );
        
        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#example').dataTable( {
//                "sScrollY": "400px",
//                "bScrollCollapse": true,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0,15 ] }
                ],
                "aaSorting": [[2, 'desc']]
                
        });

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#example tbody td img.detalle').live('click', function () {
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
                        oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
                }
        } );
} );