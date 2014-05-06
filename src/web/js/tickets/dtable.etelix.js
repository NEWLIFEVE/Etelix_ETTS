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
         
$(document).on('ready', function() {
    // Los usuarios que no sean clientes contendran esta clase en el div page
    $('div.page').css('width', '85%');
    
    
    /*
    * Initialse DataTables, with no sorting on the 'details' column
    */
    var oTable = $('#example').dataTable( {
           "bJQueryUI": true,
           "bDestroy": true,
           "bInfo":true,
           "bAutoWidth": false,
           "sPaginationType": "full_numbers",
           "aoColumnDefs": [
                   { "aDataSort": false, "aTargets": [ 0,10 ] },
                   { "bSortable": false, "aTargets": [ 0,10 ] }
           ],
           "fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
               $('#example_length label').append('<span id="pruebas"></span>');
               setTimeout(function(){$('#pruebas').html(', ' + $('#example_info').html())}, 300);
            }
    });
    
    /* Add a select menu for each TH element in the table footer */
    $(".test-select th").each( function ( i  ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), i );
        } );
    } );
    
    $(document).on('click', '.itemsocial', function(){
        oTable.fnFilter( $(this).attr('rel') );
    });
    
    $(document).on('dblclick', '.itemsocial', function(){
        oTable.fnFilter('');
    });
    
    $('.test-select').find('th').first().html('');
    $('.test-select').find('th').last().html('');

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
});