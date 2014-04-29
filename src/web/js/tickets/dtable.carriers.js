$(document).on('ready', function(){
    $('div.page').css('width', '70%');
    /*
     * Initialse DataTables, with no sorting on the 'details' column
     */
    var oTable = $('#example').dataTable( {
        "bJQueryUI": true,
        "bAutoWidth": false,
        "bDestroy": true,
        "sPaginationType": "full_numbers",
        "aoColumnDefs": [
                { "aDataSort": false, "aTargets": [ 0,7] },
                { "bSortable": false, "aTargets": [ 7 ] }
        ],
        "aaSorting": [[ 0, "desc" ]]

    }); 
    
    /* Add a select menu for each TH element in the table footer */
    $(".test-select th").each( function ( i  ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), i );
        } );
    } );
    
    $('.test-select').find('th').last().html('');
    
    $(document).on('click', '.itemsocial', function(){
        oTable.fnFilter( $(this).attr('rel') );
    });
    
    $(document).on('dblclick', '.itemsocial', function(){
        oTable.fnFilter('');
    });
});