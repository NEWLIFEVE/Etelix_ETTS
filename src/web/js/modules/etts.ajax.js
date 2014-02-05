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
        }
    }
})();