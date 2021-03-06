/**
 * Módulo de peticiones ajax
 */
$ETTS.ajax=(function(){
   
   function _limpiarForm(miForm, optionOpen) {
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
        
        if (optionOpen != 'carrier_to_etelix') $('select#mails').empty();
        $('select#Ticket_mail, select#cc, select#bbc, div.nicEdit-main, #content_attached_file').empty();
        $('#uploadFile').find('ul').empty();
    }
    
    function _getMailUser(mails, user, _etelixAsCarrier, idTicket){
        
        if (!idTicket) idTicket = null;
            
        $.post('/mailuser/getmailuser', 'iduser='+user+'&etelixAsCarrier='+_etelixAsCarrier+'&idTicket='+idTicket, function(data){
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
        getSpeech:function(idSpeech, append, settings){
            var _country = settings.country.find('option:selected').text(),
            _failure = settings.failure.find('option:selected').text();
            
            if (_country == '') _country = settings.country.first().text();
            if (_failure == '') _failure = settings.failure.val();
            
            $.ajax({
                type:'POST',
                url:'/speech/gettextspeech',
                data: {
                  _idSpeech:idSpeech,
                  failure:_failure,
                  country:_country
                },
                success:function(data) {
                   $(append).val(data);
                }
             });
        },
        getSpeechSupplier:function(settings){
            $.ajax({
                type:'POST',
                url:'/speech/getspeechsupplier',
                data: {
                  idFailure:settings.failure.val(),
                  failure:settings.failure.find('option:selected').text(),
                  country:settings.country.find('option:selected').text()
                },
                dataType:'json',
                success:function(data) {
                    if (data.x != 'false') 
                    {
                        var count = data.length;
                        settings.speech.html('<option value=""></option>');
                        settings.append.val('');
                        
                        settings.speech.append('<optgroup label="English">');
                        for (var i = 0; i < count; i++)
                        {
                            if (data[i].idLanguage == '1') 
                                settings.speech.append('<option value="'+data[i].idSpeech+'">'+data[i].title+'</option>');
                        } 
                        settings.speech.append('</optgroup>');
                        settings.speech.append('<optgroup label="Spanish">');
                        for (var i = 0; i < count; i++)
                        {
                            if (data[i].idLanguage == '2') 
                                settings.speech.append('<option value="'+data[i].idSpeech+'">'+data[i].title+'</option>');
                        }  
                        settings.speech.append('</optgroup>');
                    }
                    else
                    {
                        settings.append.val('');
                        settings.speech.html('');
                    }
                }
             });
        },
        getSpeechCustomer:function(speech){
            $.ajax({
                type:'POST',
                url:'/speech/getspeechcustomer',
                dataType:'json',
                success:function(data) {
                    var count = data.length;
                    speech.html('<option value=""></option>');
                    
                    speech.append('<optgroup label="English">');
                    for (var i = 0; i < count; i++)
                    {
                        if (data[i].id_language == '1') 
                            speech.append('<option value="'+data[i].id+'">'+data[i].title+'</option>');
                    } 
                    speech.append('</optgroup>');
                    speech.append('<optgroup label="Spanish">');
                    for (var i = 0; i < count; i++)
                    {
                        if (data[i].id_language == '2') 
                            speech.append('<option value="'+data[i].id+'">'+data[i].title+'</option>');
                    }  
                    speech.append('</optgroup>');
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
        getMailsByUser:function(id, selectMail, clear, _etelixAsCarrier){
            $(clear).empty();
            if (id.length > 0) 
            {
                $.ajax({
                       type: 'POST',
                       url: '/mailuser/getmailuser',
                       data:{
                           iduser:id,
                           etelixAsCarrier:_etelixAsCarrier
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
                        formulario, _optionOpen, _carrier){
                            
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
            
            if (_optionOpen) 
                _optionOpen=_optionOpen;
            else
                _optionOpen=false;
            
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
            _textoUser=null,
            _typeUser=null;
            
            if (_gmt){
                idGmt=_gmt.val();
                textoGmt=_gmt.text();
            }
            
            if (_user){
                _idUser=_user.val();
                _textoUser=_user.text();
            }
            // Si es la interfaz de abrirle ticket a proveedor
            if ($('#class')) {
                _typeUser=$('#class').val()
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
                    _hour: hourArray,
                    typeUser:_typeUser,
                    optionOpen:_optionOpen
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
                          
                          _limpiarForm(formulario, _optionOpen);
                          
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
        
        /**
         * Este método guarda los mails desde la interfaz crear ticket(Todos los casos),
         * también lo hace en la interfaz del detalle del ticket pero a diferencia de las
         * demas vistas, en el detalle también guarda en la tabla mail_ticket
         */
        saveMail:function(_newMail,_typeUser,_user,contentMail,to,_option,_idTicket){
            
            var _etelixAsCarrier = false;
            if (_option.val() == 'etelix_as_carrier') _etelixAsCarrier = true;
            
            if (_user.val())
            {
                $.ajax({
                   type:'POST',
                   url:'/mail/setmail',
                   data:{
                       mail: _newMail.val(),
                       user:_user.val(),
                       option:_option.val(),
                       idTicket:_idTicket
                   },
                   success:function(data){
                       if(data == 'tope alcanzado') 
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
                                    overlayClickClose: false,
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
                       else 
                       {
                           if (contentMail != null)
                           {
                                _getMailUser(contentMail, _user.val(), _etelixAsCarrier);
                                setTimeout(function(){
                                    var option = contentMail.find('option:last-child');
                                    to.append('<option value="'+option.val()+'" >'+option.text()+'</option>');
                                },500);
                           }
                           else
                           {
                               if (to != null)
                               {
                                   to.html('');
                                   for (var i = 0; i < data.length; i++)
                                   {
                                       to.append('<option value="'+data[i].id+'">'+data[i].mail+'</option>');
                                   }
                               }
                           }
                           _newMail.val('');
                       }
                   }
                });
            }
        },
        
        removeBlink:function(_idTicket){
            $.ajax({
               type:'POST',
               url:'/descriptionticket/read',
               data:{
                   idTicket:_idTicket
               }
            });
        },
        
        
        /**
         * Este método guardará uno o varios correos en la tabal mail_ticket 
         * asociados a un usuario. Para esto ya debe existir el mail más no debe
         * estar en mail_ticket
         * @param {object} settings
         */
        saveMailTicket:function(settings){
            $.ajax({
               type:'POST',
               url:'/mailticket/savemailticket',
               data:{
                   idTicket:settings.idTicket.val(),
                   mail:settings.mail
               },
               dataType:'json',
               success:function(data){
                   if (data != 'false')
                   {
                       settings.select.html('');
                       for (var i = 0; i < data.length; i++)
                       {
                           settings.select.append('<option value="'+data[i].id+'">'+data[i].mail+'</option>');
                       }
                   }
               }
            });
        },
        /**
         * Borrará uno o varios mails de mail_ticket
         */
        deleteMailTicket:function(settigns){
            $.ajax({
               type:'POST',
               url:'/mailticket/delete',
               data:{
                   idMailTicket:settigns.idMailTicket
               },
               success:function(data){
                   settigns.select2.find('option:selected').remove();
                    _getMailUser(settigns.select, settigns.idUser.val(), 'false', settigns.idTicket.val());
               }
            });
        },
        getMailsImap:function(settings){
            $.ajax({
               type:'POST',
               url:'/ticket/getmailsimap',
               data:{
                   ticketNumber:settings.ticketNumber,
                   optionOpen:settings.optionOpen,
                   idTicket:settings.idTicket
               },
               success:function(data){
                   if (data !== 'false') {
                       settings.answer.empty();
                       settings.loader.empty();
                       settings.answer.html(data);
                       settings.answer.append('<div class="pre-loader"></div>');
                       settings.answer.scrollTop(100000);
                   } else {
                       settings.loader.empty();
                   }
               },
               beforeSend:function(){
                   settings.loader.html(
                        '<div style="width:100% !important; text-align:center !important;">' +
                            '<div style="margin:auto;"><img src="/images/preloader.GIF"></div>' +
                        '</div>'
                    );
               }
            });
        }
    }
})();