/*
* Save msg
*/
function saveMessage()
{
    _idSpeech = null;
    if ($('select#speech').val()) {
        _idSpeech = $('select#speech option:selected').val();
    }
    if ($('#answer').val() !== '') {
        $.ajax({
            type:"POST",
            url:"/descriptionticket/savedescription",
            data: {
                idSpeech: $('select#speech option:selected').val(),
                message:  $('#answer').val(),
                idTicket: $('#id_ticket').val()
            },
            success:function(data){
                if (data == 'true') {
                    alert('guardo')
                } else {
                    alert('error al guardar')
                }
            }
        });
    }
}