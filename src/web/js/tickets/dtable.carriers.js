$(document).on('ready', function(){
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
});