/*
* Save msg
*/
function saveMessage()
{
    var fileName=$('div.ajax-file-upload-filename'),
    _length=fileName.length,
    _fileServer=[],
    _files=[],
    _internalAsCarrier=null;
    
    if ($('#internalAsCarrier')) {
        if ($('#internalAsCarrier').is(':checked'))
            _internalAsCarrier=$('#internalAsCarrier').val();
    }
    
    for(var i=0; i<_length; i++) {
        _files.push(fileName[i].innerHTML);
        _fileServer.push(fileName[i].getAttribute('name'));

    }
    
    if ($('#answer').val() !== '') {
        
        var _idSpeech = null,
        _message=$('#answer').val(),
        _idTicket=$('#id_ticket').val();
        
        if ($('select#speech').val())  _idSpeech = $('select#speech option:selected').val();
        
        $('#answer').val('')
        $('div#area-add-file').empty();
        $('[name="myFile[]"]').val('');
        
        if ($('#close-ticket').is(':checked')) {
            $.ajax({
                type:'POST',
                url:'/ticket/updatestatus/' + _idTicket,
                dataType:'html',
                data:{
                    idStatus:'2',
                    idSpeech: _idSpeech,
                    message:  _message,
                    idTicket: _idTicket,
                    files:_files,
                    fileServer:_fileServer,
                    internalAsCarrier:_internalAsCarrier
                },
                beforeSend:function(){
                    $('div.pre-loader').html(
                        '<div style="width:100% !important; text-align:center !important;">' +
                            '<div style="margin:auto;"><img src="/images/preloader.GIF"></div>' +
                        '</div>'
                    );
                },
                success:function(data){
                    if (data != 'false') {
                        $('div.answer-ticket, div.pre-loader').empty();
                        $('div.answer-ticket').html(data);
                        $('div.answer-ticket').append('<div class="get-mails"></div><div class="pre-loader"></div>');
                        $('div.answer-ticket').scrollTop(100000);
                        $('#only-open').slideUp('slow');
                        $('.a-agregar-correo').hide('fast');
                    } else {
                        $.Dialog({
                            content:data
                        });
                    }
                }
            });
            return false;
        }
        
        $.ajax({
            type:"POST",
            url:"/descriptionticket/savedescription",
            data: {
                idSpeech: _idSpeech,
                message:  _message,
                idTicket: _idTicket,
                files:_files,
                fileServer:_fileServer,
                internalAsCarrier:_internalAsCarrier
            },
            beforeSend:function(){
                $('div.pre-loader').html(
                    '<div style="width:100% !important; text-align:center !important;">' +
                        '<div style="margin:auto;"><img src="/images/preloader.GIF"></div>' +
                    '</div>'
                );
            },
            success:function(data){
                if (data !== 'false') {
                    $('div.answer-ticket, div.pre-loader').empty();
                    $('div.answer-ticket').html(data);
                    $('div.answer-ticket').append('<div class="get-mails"></div><div class="pre-loader"></div>');
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