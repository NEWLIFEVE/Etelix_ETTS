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
        getCarrierByClass:function(type, selectUser, selectMail){
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
                            for (var i=0; i<data.length; i++) {
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
        getMailsByUser:function(id, selectMail){
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
                                for (var i=0; i<data.length; i++) {
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
        }
    }
})();