/**
 * Módulo de peticiones ajax
 */
$ETTS.ajax=(function(){
   
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
        saveTicket:function(_user,_responseTo,_cc,_bbc,_failure,_originationIp,_destinationIp,_prefix,_status,_accountManager,_speech,_description,attachFile){
            
            var responseToArray=[],
            ccArray=[],
            bbcArray=[],
            lengtTo=_responseTo.length,
            lengthCc=_cc.length,
            lengthBbc=_bbc.length,
            _isInternal=1;
            
            for (var i = 0; i < lengtTo; i++) responseToArray.push(_responseTo[i].value);
            
            for (var i = 0; i < lengthCc; i++) ccArray.push(_cc[i].value);
            
            for (var i = 0; i < lengthBbc; i++) bbcArray.push(_bbc[i].value);

            $.ajax({
                type:'POST',
                url:'/ticket/saveticket',
                data: {
                    user:_user,
                    responseTo:responseToArray,
                    cc:ccArray,
                    bbc:bbcArray,
                    failure:_failure,
                    originationIp:_originationIp,
                    destinationIp:_destinationIp,
                    prefix:_prefix,
                    status:_status,
                    accountManager:_accountManager,
                    speech:_speech,
                    description:_description,
                    _attachFile:attachFile,
                    isInternal:_isInternal
                    
                },
                success:function(data) {
                    alert(data)
                }
             });
        }
    }
})();