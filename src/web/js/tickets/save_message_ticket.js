/*
* Save msg
*/
function saveMessage()
{
    var fileName=$('div.ajax-file-upload-filename'),
    _length=fileName.length,
    _fileServer=[],
    _files=[];
    
    for(var i=0; i<_length; i++) {
        _files.push(fileName[i].innerHTML);
        _fileServer.push(fileName[i].getAttribute('name'));

    }
    
    if ($('#answer').val() !== '') {
        
        var _idSpeech = null;
        if ($('select#speech').val())  _idSpeech = $('select#speech option:selected').val();
        
        var _message=$('#answer').val(),
            _idTicket=$('#id_ticket').val();
        
        $('#answer').val('')
        $('div#area-add-file').empty();
        $('[name="myFile[]"]').val('')
        
        $.ajax({
            type:"POST",
            url:"/descriptionticket/savedescription",
            data: {
                idSpeech: _idSpeech,
                message:  _message,
                idTicket: _idTicket,
                files:_files,
                fileServer:_fileServer
            },
            beforeSend:function(){
                $('div.answer-ticket').html('<center><img src="/images/loader.GIF"></center>');
            },
            success:function(data){
                if (data !== 'false') {
                    $('div.answer-ticket').empty();
                    $('div.answer-ticket').html(data);
                    $('div.answer-ticket').scrollTop(100000);
                }
            }
        });
    }
}

$(document).on('ready', function(){
   $(document).on('focus', 'textarea#answer', function(){
       $('div.panel-down-textarea').css('border-bottom', '1px solid grey')
       $('div.panel-down-textarea, select#speech').css('border-left', '1px solid grey')
       $('div.panel-down-textarea, select#speech').css('border-right', '1px solid grey')
       $('select#speech').css('border-top', '1px solid grey')
   })
   $(document).on('blur', 'textarea#answer', function(){
       $('div.panel-down-textarea').css('border-bottom', '1px solid #d9d9d9')
       $('div.panel-down-textarea, select#speech').css('border-left', '1px solid #d9d9d9')
       $('div.panel-down-textarea, select#speech').css('border-right', '1px solid #d9d9d9')
       $('select#speech').css('border-top', '1px solid #d9d9d9')
   }) 
});