/* Formating function for row details */
function fnFormatDetails ( oTable, nTr )
{
        var aData = oTable.fnGetData( nTr );
        
        //Tested numbers
        var number = aData[10].split(',');
        var date = aData[11].split(',');
        var hour = aData[12].split(',');
        var country = aData[13].split('|');
        // end tested numbers
        
        // Response to
//        var mails = aData[14].split(',');
        // end response to
        
        var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td>Description:</td><td>'+aData[7]+'</td></tr>';
        sOut += '<tr><td>Prefix:</td><td>'+aData[8]+'</td></tr>';
        sOut += '<tr><td>GMT:</td><td>'+aData[9]+'</td></tr>';
        sOut += '<tr><td>Tested Number:</td><td>'+number.join('<br>')+'</td></tr>';
        sOut += '<tr><td>Date:</td><td>'+date.join('<br>')+'</td></tr>';
        sOut += '<tr><td>Hour:</td><td>'+hour.join('<br>')+'</td></tr>';
        sOut += '<tr><td>Country:</td><td>'+country.join('<br>')+'</td></tr>';
//        sOut += '<tr><td>Response to:</td><td>'+mails.join('<br>')+'</td></tr>';
        sOut += '</table>';

        return sOut;
}

$(document).ready(function() {
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
                "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0 ] }
                ],
                "aaSorting": [[1, 'desc']],
                "sPaginationType": "full_numbers"
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