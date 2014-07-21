function deleteSession(idSession)
{
    $ETTS.UI.confirmar('Delete Session?', 'ok_confirm', 'cancel_confirm'); 
    $('#ok_confirm').on('click', function(){
        $.get('/cruge/ui/sessionadmindelete/?id=' + idSession, '', function(data){
            if (data === 'true') {
                $.Dialog.close();
                window.location = '/cruge/ui/sessionadmin';
            }
        });
    });
    
    $('#cancel_confirm').on('click', function(){
        $.Dialog.close();
    });
}

$(document).on('ready', function(){
   var oTable = $('#example').dataTable( {
        "bJQueryUI": true,
        "bAutoWidth": true,
        "bDestroy": false,
        "sPaginationType": "full_numbers",
        "aaSorting":[[ 0, 'desc' ]],
        "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 8 ] },
        ]
    }); 
    
    $(document).on('click', '#deleteSession', function(){
        deleteSession($(this).attr('rel')); 
    });
});