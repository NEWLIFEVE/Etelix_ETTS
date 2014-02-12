
// Objeto Global
var $ETTS={};

/**
 * Sub módulo de interfaz
 */
$ETTS.UI=(function(){
   
    var _tables=[{
            // Table Ticket
            ticket:{
                id:'',
                id_failure:'',
                id_status:'',
                origination_ip:'',
                destination_ip:'',
                date:'',
                machine_ip:'',
                hour:'',
                id_gmt:'',
                ticket_number:'',
                // Relations 
                id_mail_ticket:[],
                id_ticket:[],
                id_mail_user:[],
                id_type_mailing:[]
            },
            
            // Table mail_ticket
            mail_ticket:{
                id:[],
                id_ticket:[],
                id_mail_user:[],
                id_type_mailing:[]
            }
    }];
   
    function _ticketCompleto(clase,user,to,cc,bbc,falla,originationIp,destinationIp,prefijo,speech,descripcion){
       
            if (originationIp == '') originationIp='...';
            if (destinationIp == '') destinationIp='...';
       
            var i= 0, 
            arrayTo=[], 
            arrayCc=[], 
            arrayBbc=[],
            lengthTo=to.length, 
            lengthCc=cc.length, 
            lengthBbc=bbc.length,
            oip=originationIp.split('.'),
            dip=destinationIp.split('.'),
            toCompleto='',
            ccCompleto='',
            bbcCompleto='';
            
            for (i=0 ; i<lengthTo; i++) arrayTo.push(to[i].text);
            
            for (i=0; i<lengthCc; i++) arrayCc.push(cc[i].text);
            
            for (i=0; i<lengthBbc; i++) arrayBbc.push(bbc[i].text);
            
            if (to.length > 0) 
            {
                toCompleto='<div class="input-control textarea" data-role="input-control"" >'+
                                'To'+
                                '<textarea disabled class="textarea-corto">'+arrayTo.join('\n')+'</textarea>' +
                           '</div>';
            }
            
            if (cc.length > 0) 
            {
                ccCompleto='<div class="input-control textarea" data-role="input-control"" >'+
                                'CC'+
                                '<textarea disabled class="textarea-corto">'+arrayCc.join('\n')+'</textarea>' +
                           '</div>';
            }
            
            if (bbc.length > 0) 
            {
                bbcCompleto='<div class="input-control textarea" data-role="input-control"" >'+
                                'BBC'+
                                '<textarea disabled class="textarea-corto">'+arrayBbc.join('\n')+'</textarea>' +
                            '</div>';
            }
            
            
                
            return '<div id="content_preview">' + 
                        '<div class="input-control text block" >'+
                            'Class'+
                            '<input type="text" value="'+clase+'" disabled>' +
                        '</div>'+
                        
                        '<div class="input-control text block" >'+
                            'User'+
                            '<input type="text" value="'+user+'" disabled>' +
                        '</div>'+
                        
                        toCompleto+
                        
                        ccCompleto+
                        
                        bbcCompleto+
                        
                        '<div class="input-control text block" >'+
                            'Failure'+
                            '<input type="text" value="'+falla+'" disabled>' +
                        '</div>'+
                        
                        '<div class="_label">Origination IP <small class="text-muted "><em>(Customer IP)</em></small><span class="margen_17px"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DestinationIP  <small class="text-muted "><em>(Etelix IP)</em></small></div>'+
                        '<div class="input-control text block" data-role="input-control">'+
                            '<input type="text" value="'+oip[0]+'" disabled class="_ip" disabled>' +
                            '<input type="text" value="'+oip[1]+'" disabled class="_ip" disabled>' +
                            '<input type="text" value="'+oip[2]+'" disabled class="_ip" disabled>'+
                            '<input type="text" value="'+oip[3]+'" disabled class="_ip" disabled>'+

                            '<span class="margen_22px"></span>'+

                            '<input type="text" value="'+dip[0]+'" disabled class="_ip" disabled>' +
                            '<input type="text" value="'+dip[1]+'" disabled class="_ip" disabled>' +
                            '<input type="text" value="'+dip[2]+'" disabled class="_ip" disabled>' +
                            '<input type="text" value="'+dip[3]+'" disabled class="_ip" disabled>' +
                        '</div>'+
                        
                        '<div class="input-control text block" >'+
                            'Prefix'+
                            '<input type="text" value="'+prefijo+'" disabled>' +
                        '</div>'+
                        
                        '<div class="input-control text block" >'+
                            'Speech'+
                            '<input type="text" value="'+speech+'" disabled>' +
                        '</div>'+
                        
                        '<div>Description<br>' +descripcion + '</div>' +
                   '</div>' +
                   '<div id="preview_buttons">' +
                        '<button  class="primary large" id="save_ticket">Send Ticket Information</button> <a  href="#" id="imprimir"><i class="icon-printer on-right"></i></a>' +
                   '</div>';
    }
    
    function _quitarValidacion(select){
            if (select.find('option').length > 0)
                select.removeClass('validate[required]');
            else
                select.addClass('validate[required]');
    }
    
    return {
        
        tables:function(){
            return _tables[0];
        },
        
        /**
         * Método para mostrar un confirm personalizado
         * @param string mensaje
         * @param obj aceptar
         * @param obj cancelar
         */
        confirmar:function(mensaje, aceptar, cancelar) {
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-rocket"></span>',
                title: false,
                width: 500,
                padding: 10,
                content: 
                    '<div id="content_mensaje"><h2>' + mensaje + '</h2></div>' + 
                    '<div id="content_botones">' +
                        '<button class="primary large" id="'+aceptar+'" type="button">OK</button>' +
                        '<button class="primary large" id="'+cancelar+'" type="button">Cancel</button>' +
                    '</div>'
            });
        },
        /**
         * Método para pasar los mails de un select hasta otro select
         * 
         * @param obj boton
         * @param obj element
         */
        moveMails:function(boton, element){
            $(document).on('click', boton, function(){
                if ($(element).val()) 
                {
                    var select = $(this).parent().children('select');
                    $(this).parent().children('select').append('<option value="'+$(element).val()+'">'+$(element+' option:selected').html()+'</option>');
                    $(element+' option:selected').attr('selected',false);
                    _quitarValidacion(select);
                }
            });
        },
        /**
         * Método para mostrar un tooltip
         * 
         * @param obj element
         * @param boolean statusTrack
         */
        tooltip:function(element, statusTrack){
            $(element).tooltip({
                track: statusTrack
            });
        },
        
        /**
         * 
         */
        previewTicket:function(clase,user,to,cc,bbc,falla,originationIp,destinationIp,prefijo,speech,descripcion){
            $.Dialog({
                shadow: true,
                overlay: true,
                flat:true,
                icon: '<span class="icon-eye-2"></span>',
                title: 'Preview Ticket',
                width: 510,
                padding: 0,
                draggable: true,
                content:_ticketCompleto(clase,user,to,cc,bbc,falla,originationIp,destinationIp,prefijo,speech,descripcion)
            });
        },
        direccionesIp:function(element, e){
          
            var valor = element.val();
            // Para IE
            if (window.event)
            {
                if (window.event.keyCode == 190 || window.event.keyCode == 110) 
                {
                    element.val(valor.replace('.', ''));
                    element.next('input').focus();
                }
            }
            else
            {
                // Para Chrome, Firefox, etc.
                if(e)
                {
                    if (e.which == 190 || e.which == 110)
                    {
                        element.val(valor.replace('.', ''));
                        element.next('input').focus();
                    }
                }
            }
            
            if (element.val().length === 3) 
            {
                if (element.val() > 255) 
                {
                    element.val('255');
                }
                element.next('input').focus();
            }
        },
        borrarOptionSelect:function(select){
              var element = select.parent().children('select');
              if(element.val()) 
              {
                  element.find('option:selected').remove();
                  _quitarValidacion(element);
              }
        },
        appendOptions:function(boton, select){
            
            var select2 = boton.parent().children('select');
            
            if(select.val()) 
            {
                var option = select.find('option:selected'),
                longitud=option.length;
                
                for (var i=0; i < longitud; i++)
                {
                    select2.append('<option value="'+option[i].value+'">'+option[i].text+'</option>');
                }
                select.find('option:selected').attr('selected',false);
                _quitarValidacion(select2);
            }
        }
        
    }
    
})();

