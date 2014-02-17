/**
 * Módulo de peticiones ajax
 */
$ETTS.ajax=(function(){
   
   function _limpiarForm(miForm) {
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
        
        $('select#mails, select#Ticket_mail, select#cc, select#bbc, div.nicEdit-main, #content_attached_file').empty();
        $('#uploadFile').find('ul').empty();
    }
    
    function _getMailUser(mails, user){
        $.post('/mailuser/getmailuser', 'iduser='+user, function(data){
            mails.html('');
            for (var i = 0; i < data.length; i++) 
            {
                mails.append('<option value="'+ data[i].id +'">'+ data[i].mail +'</option>');
            }
        }, 'json');
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
                   url: '/mailuser/deletemail',
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
                       url: '/mailuser/getmailuser',
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
        /**
         * 
         */
        saveTicket:function(
                        _gmt,
                        _testedNumber,
                        _testedCountry,
                        _testedDate,
                        _testedHour,
                        _user,
                        _responseTo,
                        _cc,
                        _bbc,
                        _failure,
                        _failureText,
                        _originationIp,
                        _destinationIp,
                        _prefix,
                        _speech,
                        _description,
                        attachFile,
                        attachFileSave,
                        attachFileSize,
                        _isInternal, 
                        formulario){
                            
            var responseToArray=[],
            responseToText=[],
            ccArray=[],
            ccText=[],
            bbcArray=[],
            bbcText=[],
            attachfileArray=[],
            attachFileSaveArray=[],
            attachFileSizeArray=[],
            testedNumbersArray=[],
            countryArray=[],
            countryTextArray=[],
            dateArray=[],
            hourArray=[],
            lengtTo=_responseTo.length,
            lengthCc=_cc.length,
            lengthBbc=_bbc.length,
            lengthAttachFile=attachFile.length,
            lengthTestedNumber=_testedNumber.length;
            
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
            
            for (i = 0; i < lengthTestedNumber; i++)
            {
                testedNumbersArray.push(_testedNumber[i].value);
                countryArray.push(_testedCountry[i].value);
                countryTextArray.push(_testedCountry[i].options[_testedCountry[i].selectedIndex].text);
                dateArray.push(_testedDate[i].value);
                hourArray.push(_testedHour[i].value);
            }
            
            var idGmt=null,
            textoGmt=null,
            _idUser=null,
            _textoUser=null;
            
            if (_gmt){
                idGmt=_gmt.val();
                textoGmt=_gmt.text();
            }
            
            if (_user){
                _idUser=_user.val();
                _textoUser=_user.text();
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
                    user:_textoUser,
                    responseTo:responseToArray,
                    cc:ccArray,
                    bbc:bbcArray,
                    failure:_failure,
                    failureText:_failureText,
                    originationIp:_originationIp,
                    destinationIp:_destinationIp,
                    prefix:_prefix,
                    speech:_speech,
                    description:_description,
                    _attachFile:attachfileArray,
                    _attachFileSave:attachFileSaveArray,
                    _attachFileSize:attachFileSizeArray,
                    isInternal:_isInternal,
                    emails:responseToText,
                    direccionCC:ccText,
                    direccionBBC:bbcText,
                    idUser:_idUser,
                    gmt:idGmt,
                    gmtText:textoGmt,       
                    testedNumber:testedNumbersArray,
                    _country:countryArray,
                    _countryText:countryTextArray,                          
                    _date: dateArray,
                    _hour: hourArray
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
                                content: '<pre>'+data+'</pre>'
                          });
                      }
                }
             });
        },
        
        saveMail:function(_newMail,_typeUser, _user, contentMail, to, _option){
            if (_user.val())
            {
                
                if (_typeUser=='customer')
                    _typeUser=1;
                else if (_typeUser=='supplier')
                    _typeUser=0;
                else
                    _typeUser=_typeUser;
                
                $.ajax({
                   type:'POST',
                   url:'/mail/setmail',
                   data:{
                       mail: _newMail.val(),
                       typeUser:_typeUser,
                       user:_user.val(),
                       option:_option
                   },
                   success:function(data){
                       if (data == 'true') 
                       {    
                           _newMail.val('');
                           _getMailUser(contentMail, _user.val());
                           setTimeout(function(){
                               var option = contentMail.find('option:last-child');
                               to.append('<option value="'+option.val()+'" >'+option.text()+'</option>');
                           },500);
                       } 
                       else if(data == 'tope alcanzado') 
                       {
                            $.Dialog({
                                shadow: true,
                                overlay: false,
                                icon: '<span class="icon-rocket"></span>',
                                title: 'Error',
                                width: 500,
                                padding: 10,
                                content: '<center><h2>Only five emails allowed<h2></center>'
                          });

                       } 
                       else if (data == 'existe correo') 
                       {
                            $.Dialog({
                                    shadow: true,
                                    overlay: false,
                                    icon: '<span class="icon-rocket"></span>',
                                    title: 'Error',
                                    width: 500,
                                    padding: 10,
                                    content: '<center><h2>Error, email already exists, try another direction<h2></center>'
                              });
                       } 
                       else if (data == 'false') 
                       {
                            $.Dialog({
                                shadow: true,
                                overlay: false,
                                icon: '<span class="icon-rocket"></span>',
                                title: 'Error',
                                width: 500,
                                padding: 10,
                                content: '<center><h2>Error<h2></center>'
                            });
                       }
                   }
                });
            }
        }
    }
})();