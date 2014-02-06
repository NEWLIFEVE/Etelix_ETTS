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
    
    _idSvar fileName=$('div.ajax-file-upload-filename'),
    _length=fileName.length,
    _fileServer=[],
    _files=[];
    
    for(var i=0; i<_length; i++) {
        _files.push(fileName[i].innerHTML);
        _fileServer.push(fileName[i].getAttribute('name'));
    }peech = null;
    if ($('select#speech').val()) {
        _idSpeech = $('select#speech option:selected').val();
    }
    if ($('#answer').val() !== '') {
        $.ajax({
            type:"POST",
            url:"/descriptionTicket/savedescription",
            data: {
                idSpeech: $('select#speech option:selected').val(),
                message:  $('#answer').val(),
                idTicket: $('#id_ticket').val(),
                files:_files,
                fileServer:_fileServer
            },
            success:function(data){
                $('#answer').val('')
                $('div#area-add-file').empty();
                $('[name="myFile[]"]').val('')
                if (data !== 'false') {
                    $('div.answer-ticket').empty();
                    $('div.answer-ticket').html(data);
                    $('div.answer-ticket').scrollTop(100000);
                }
            }
        });
    }
}

function funcionEnter(evento) 
{ 
    //para IE 
    if (window.event) 
    { 
        if (window.event.keyCode==13) 
        { 
            saveMessage()
        } 
    } 
    else 
    { 
        //Firefox y otros navegadores 
        if (evento) 
        { 
            if(evento.which==13) 
            { 
                saveMessage()
            } 
        } 
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