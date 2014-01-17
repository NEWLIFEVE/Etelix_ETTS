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
             sOut += '<td style="width:'+(widthUser+4)+'px !important; ">'+aData[i].user +'</td>';
             sOut += '<td style="width:'+(widthCarrier+11)+'px !important; ">'+aData[i].carrier+'</td>';
             sOut += '<td style="width:'+(widthTicket+7)+'px !important; ">'+aData[i].ticket_number+'</td>';
             sOut += '<td style="width:'+(widthFailure+5)+'px !important; ">'+aData[i].failure+'</td>';
             sOut += '<td father="'+id+'" son="'+aData[i].id_ticket+'" style="width:'+(widthStatus+15)+'px !important; " >';
             sOut += '<span class="span-status">';
             sOut += '<span>'+aData[i].status_ticket+'</span>';
             sOut += '</span>';
             sOut += '</td>';
             sOut += '<td style="width:'+(widthOip+17 )+'px !important; ">'+aData[i].origination_ip + '</td>';
             sOut += '<td style="width:'+(widthDip+9)+'px !important; ">' +aData[i].destination_ip + '</td>';
             sOut += '<td style="width:'+(widthDate+16)+'px !important; ">' + aData[i].date + '</td>';
             sOut += '<td style="width:'+(widthPreview+14)+'px !important; "><a href="javascript:void(0)" class="preview" rel="'+aData[i].id_ticket+'"><img width="12" height="12" src="/images/view.gif"></a></td>';
             sOut += '</tr>';
        }

        sOut += '</table>';
        return sOut
        
}


function getTicketsRelated(id, nTr, oTable)
{
    $.ajax({
        type:"POST",
        url:"Getticketrelation/"+id,
        dataType:'json',
        success:function(data){
            oTable.fnOpen( nTr, fnFormatDetails(data, id) , 'details' );
        }
    });
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
            var id = $(this).parent('td').attr('id'),
            _select = $(this),
            _status = $(this).val();
            
            $.ajax({
                type:'POST',
                url:'updatestatus',
                data:{
                      idTicket:$(this).parent('td').attr('id'),
                      idStatus:_status
                },
                success:function(data){
                    if (_status == 2) {
                       $("td[id='"+id+"'], td[son='"+id+"']").children('span.span-status').children('span').text('close');
                         _select.next('span.span-status').show()
                         $("td[id='"+id+"']").parent('tr').removeAttr('class')
                         $("td[id='"+id+"']").parent('tr').addClass('close even')
                        _select.remove('select')
                        
                    } else {
                        $("td[id='"+id+"'], td[son='"+id+"']").children('span.span-status').children('span').text('open');
                        _select.next('span.span-status').show()
                        $("td[id='"+id+"']").parent('tr').removeAttr('class')
                         $("td[id='"+id+"']").parent('tr').addClass('open even')
                        _select.remove('select')
                    }
                }
            });
        });
        
        $(document).on('blur', 'table#example tbody tr td select#status', function(){
            $(this).next('span.span-status').show();
            $(this).remove('select')
        });
        
        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#example').dataTable( {
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0,9 ] }
                ],
                "aaSorting": [[3, 'desc']]
                
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