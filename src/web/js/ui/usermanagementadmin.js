$(document).on('ready', function(){
    var oTable = $('#example').dataTable( {
        "bJQueryUI": true,
        "bAutoWidth": false,
        "bDestroy": true,
        "sPaginationType": "full_numbers",
        "aaSorting":[[ 0, 'desc' ]],
        "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 4 ] }
        ]
    }); 
});