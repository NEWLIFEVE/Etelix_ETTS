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
                if (data !== 'false') {
                    
                    $('div.answer-ticket').empty();
                    $('div.answer-ticket').html(data);
                    $('div.answer-ticket').scrollTop(100000);
                    $('#answer').val('')
                    
                } else {
                    alert('error al guardar');
                }
            }
        });
    }
}