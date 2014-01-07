/* Formating function for row details */
function fnFormatDetails ( oTable, nTr )
{
        var aData = oTable.fnGetData( nTr );
        var sOut = '<table class="tablas">';
        
        for(var i= 0; i < aData[7].split('|').length - 1; i++) {
            sOut +=  '<tr><td>&nbsp;</td><td>' + 
                aData[7].split('|')[i] + '</td><td>' + 
                aData[8].split('|')[i] + '</td><td>' + 
                aData[9].split('|')[i] + '</td><td>' + 
                aData[10].split('|')[i] + '</td><td>' + 
                aData[11].split('|')[i] + '</td><td>' + 
                aData[12].split('|')[i] + '</td></tr>';
        }
        
        sOut += '</table>';
        
        return sOut;
}

$(document).ready(function() {
        
        $(document).on('change', 'select#status', function(){
//           $(this).closest('td').find("input").each(function() {
//                alert(this.value)
//           });
            _tr = $(this).parent('div').parent('td').parent('tr');
            _status = $(this).val();
            $.ajax({
                type:'POST',
                url:'updatestatus',
                data:{
                      idTicket:$(this).next('input').val(),
                      idStatus:_status
                },
                success:function(data){
                    if (_status == 2) {
                        _tr.addClass('gradeX')
                    } else {
                        _tr.removeClass('gradeX')
                    }
                }
            });
        });
        
        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement( 'th' );
        var nCloneTd = document.createElement( 'td' );
        nCloneTd.innerHTML = '<img src="/images/details_open.png">';
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
                        { "bSortable": false, "aTargets": [ 0 ] }
                ],
                "aaSorting": [[1, 'desc']]
                
        });

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#example tbody td img').live('click', function () {
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