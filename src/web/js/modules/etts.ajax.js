/**
 * Módulo de peticiones ajax
 */
$ETTS.ajax=(function(){
   
   function _limpiarForm(miForm, toCcBcc, textAreaEnriquecido) {
        // recorremos todos los campos que tiene el formulario
        $(':input', miForm).each(function() {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            //limpiamos los valores de los campos…
            if (type == 'text' || type == 'password' || tag == 'textarea')
                this.value = "";
            // excepto de los checkboxes y radios, le quitamos el checked
            // pero su valor no debe ser cambiado
            else if (type == 'checkbox' || type == 'radio')
                this.checked = false;
            // los selects le ponesmos el indice a -
            else if (tag == 'select')
                this.selectedIndex = -1;
        });
        
        $('div.nicEdit-main').empty();
        $('select#mails, select#Ticket_mail, select#cc, select#bbc').empty();
    }
   
    return {
        
        /**
	 * @param int idSpeech
         * @param obj append
         */
        getSpeech:function(idSpeech, append){
            $.ajax({
                type:'POST',
                url:'/speech/gettextspeech',
                data: {
                  _idSpeech:idSpeech   
                },
                success:function(data) {
                   $(append).text(data);
                   $(append).val(data);
                }
             });
        },
        /**
         * @param obj selectTop
	 * @param obj selectDown
         * @param obj mailSeleccionado
         */
        deleteMailByConfirm:function(selectTop, selectDown, mailSeleccionado){
            $.ajax({
                   type: 'POST',
                   url: '/mailUser/deletemail',
                   data:"id="+mailSeleccionado,
                   success:function(data){
                       $('#'+selectTop+' option[value='+mailSeleccionado+']').remove();
                   }
                });
                $('#'+selectDown+' option[value='+mailSeleccionado+']').remove();
                $.Dialog.close();
        },
        /**
         * @param string type
         * @param obj selectUser
         * @param obj selectMail
         */
        getCarrierByClass:function(type, selectUser, selectMail, clear){
            $(clear).empty();
            $(selectMail).html('');
            $.ajax({
                   type: 'POST',
                   url: '/ticket/carriersbyclass',
                   data:{
                       _type:type
                   },
                   success:function(data){
                       if (data != null)
                       {
                            $(selectUser).html('');
                            $(selectUser).append('<option value=""></option>');
                            for (var i=0; i<data.length; i++) 
                            {
                                $(selectUser).append('<option value="'+data[i].iduser+'">'+data[i].username+'</option>');
                            }
                       }
                       else
                       {
                           $(selectUser).html('');
                       }
                   }
            });
        },
        /**
         * @param int id
         * @param obj selectMail
         */
        getMailsByUser:function(id, selectMail, clear){
            $(clear).empty();
            if (id.length > 0) 
            {
                $.ajax({
                       type: 'POST',
                       url: '/mailUser/getmailuser',
                       data:{
                           iduser:id
                       },
                       dataType:'json',
                       success:function(data){
                           if (data != null)
                           {
                                $(selectMail).html('');
                                for (var i=0; i<data.length; i++) 
                                {
                                    $(selectMail).append('<option value="'+data[i].id+'">'+data[i].mail+'</option>');
                                }
                           }
                           else
                           {
                               $(selectMail).html('');
                           }
                       }
                    });
            }
            else
            {
                $(selectMail).html('');
            }
        },
        saveTicket:function(
                        _gmt,
                        _testedNumber,
                        _country,
                        _date,
                        _hour,
                        _user,
                        _responseTo,
                        _cc,
                        _bbc,
                        _failure,
                        _failureText,
                        _originationIp,
                        _destinationIp,
                        _prefix,
                        _status,
                        _accountManager,
                        _speech,
                        _description,
                        attachFile,
                        attachFileSave,
                        attachFileSize,
                        _isInternal, formulario){
                            
            var responseToArray=[],
            responseToText=[],
            ccArray=[],
            ccText=[],
            bbcArray=[],
            bbcText=[],
            attachfileArray=[],
            attachFileSaveArray=[],
            attachFileSizeArray=[],
            lengtTo=_responseTo.length,
            lengthCc=_cc.length,
            lengthBbc=_bbc.length,
            lengthAttachFile=attachFile.length;
            
            for (var i = 0; i < lengtTo; i++) 
            {
                responseToArray.push(_responseTo[i].value);
                responseToText.push(_responseTo[i].text);
            }
            
            for (var i = 0; i < lengthCc; i++) 
            {
                ccArray.push(_cc[i].value);
                ccText.push(_cc[i].text);
            }
            
            for (var i = 0; i < lengthBbc; i++)
            {
                bbcArray.push(_bbc[i].value);
                bbcText.push(_bbc[i].text);
            }
            
            for (var i = 0; i < lengthAttachFile; i++) 
            {
                attachfileArray.push(attachFile[i].value);
                attachFileSaveArray.push(attachFileSave[i].value);
                attachFileSizeArray.push(attachFileSize[i].value);
            }

            $.ajax({
                type:'POST',
                url:'/ticket/saveticket',
                beforeSend:function(){
                       $.Dialog.close();
                       $.Dialog({
                             shadow: true,
                             overlay: false,
                             icon: '<span class="icon-rocket"></span>',
                             title: 'Sending email',
                             width: 500,
                             padding: 10,
                             content: '<center><h2>Wait a few seconds...<h2><img src="/images/loader.GIF"></center>'
                       });
                },
                data: {
                    user:_user,
                    responseTo:responseToArray,
                    cc:ccArray,
                    bbc:bbcArray,
                    failure:_failure,
                    failureText:_failureText,
                    originationIp:_originationIp,
                    destinationIp:_destinationIp,
                    prefix:_prefix,
                    status:_status.val(),
                    statusText:_status.text(),
                    accountManager:_accountManager,
                    speech:_speech,
                    description:_description,
                    _attachFile:attachfileArray,
                    _attachFileSave:attachFileSaveArray,
                    _attachFileSize:attachFileSizeArray,
                    isInternal:_isInternal,
                    emails:responseToText,
                    direccionCC:ccText,
                    direccionBBC:bbcText
                },
                success:function(data) {
                    if (data == 'success') {
                           $.Dialog.close();
                           $.Dialog({
                                shadow: true,
                                overlay: false,
                                icon: '<span class="icon-rocket"></span>',
                                title: 'Operation complete',
                                width: 500,
                                padding: 10,
                                content: '<center><h2>Success<h2></center>'
                          });
                          
                          _limpiarForm(formulario);
                          
                       } else {
                           $.Dialog.close();
                           $.Dialog({
                                shadow: true,
                                overlay: false,
                                icon: '<span class="icon-rocket"></span>',
                                title: 'Error',
                                width: 500,
                                padding: 10,
                                content: '<center>'+data+'</center>'
                          });
                      }
                }
             });
        }
    }
})();