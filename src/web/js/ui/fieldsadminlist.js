function deleteField(idField)
{
    $ETTS.UI.confirmar('Delete Field?', 'ok_confirm', 'cancel_confirm'); 
    $('#ok_confirm').on('click', function(){
        $.get('/cruge/ui/fieldsadmindelete/?id=' + idField, '', function(data){
            if (data === 'true') {
                $.Dialog.close();
                window.location = '/cruge/ui/fieldsadminlist';
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
                { "bSortable": false, "aTargets": [ 3 ] },
        ]
    }); 
    
    $(document).on('click', '#deleteField', function(){
        deleteField($(this).attr('rel')); 
    });
});