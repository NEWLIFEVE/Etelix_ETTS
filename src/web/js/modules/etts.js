
// Objeto Global
var $ETTS={};

/**
 * Sub módulo de interfaz
 */
$ETTS.UI=(function(){
   
    /**
     * Retorna el detalle del ticket
     * @param {string} clase Si es customer o supplier
     * @param {string} user El usuario del ticket
     * @param {array} to Correos del ticket
     * @param {array} cc Copiar correo
     * @param {array} bbc Copia oculta de correo
     * @param {string} falla Falla del ticket
     * @param {string} originationIp Puerto ip de origen
     * @param {string} destinationIp Puerto ip de destino
     * @param {string} prefijo Prefijo del ticket
     * @param {string} speech Speech seleccionado de darse el caso
     * @param {string} descripcion Descripción del ticket
     * @param {string} gmt Gmt seleccioando 
     * @param {array} testedNumber Los números de prueba
     * @param {array} country El pais al que pertenece el número
     * @param {array} date La fecha es que se marcó el número
     * @param {array} hour La hora en que se marcó el número
     * @returns {String}
     * @private
     */
    function _ticketCompleto(clase,
                             user,
                             to,
                             cc,
                             bbc,
                             falla,
                             originationIp,
                             destinationIp,
                             prefijo,
                             speech,
                             descripcion,
                             gmt,
                             testedNumber,
                             country,
                             date,
                             hour){
       
            if (originationIp == '') originationIp='...';
            if (destinationIp == '') destinationIp='...';
       
            var i= 0, 
            arrayTo=[], 
            arrayCc=[], 
            arrayBbc=[],
            lengthTo=to.length, 
            lengthCc=cc.length, 
            lengthBbc=bbc.length,
            logintudNumber=testedNumber.length,
            oip=originationIp.split('.'),
            dip=destinationIp.split('.'),
            toCompleto='',
            ccCompleto='',
            bbcCompleto='',
            claseCompleto='',
            userCompleto='',
            gmtCompleto='',
            speechCompleto='',
            tableTestedNumber='';
            
            for (i=0 ; i<lengthTo; i++) arrayTo.push(to[i].text);
            
            for (i=0; i<lengthCc; i++) arrayCc.push(cc[i].text);
            
            for (i=0; i<lengthBbc; i++) arrayBbc.push(bbc[i].text);
            

            if (clase !== null)
            {
                claseCompleto='<div class="input-control text block" >'+
                            'Class'+
                            '<input type="text" value="'+clase+'" disabled>' +
                      '</div>';
            }
            
            if (user !== null)
            {
                userCompleto='<div class="input-control text block" >'+
                            'User'+
                            '<input type="text" value="'+user+'" disabled>' +
                      '</div>';
            }
            if (gmt !== null)
            {
                gmtCompleto='<div class="input-control text block" >'+
                                'Gmt'+
                                '<input type="text" value="'+gmt+'" disabled>' +
                            '</div>';
            }
            if (speech !== null)
            {
                speechCompleto='<div class="input-control text block" >'+
                                    'Speech'+
                                    '<input type="text" value="'+speech+'" disabled>' +
                               '</div>';
            }
            
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
            
            var tablaNumber = '<div><table id="tabla_preview"><thead><tr><th>Tested Numbers</th><th>Country</th><th>Date</th><th>Hour</th></tr></thead><tbody>';

            for(i= 0; i < logintudNumber; i++) 
            {
                 tablaNumber += '<tr>' +
                                    '<td>' + testedNumber[i].value + '</td>'+ 
                                    '<td>' + country[i].options[country[i].selectedIndex].text + '</td>'+ 
                                    '<td>' + date[i].value + '</td>'+ 
                                    '<td>' + hour[i].value + '</td>' +
                                '</tr>';   
            }
            tablaNumber += '</tbody></table></div>';
            
            if (logintudNumber > 0)
            {
                tableTestedNumber='<p></p><p></p><div id="tabla_tested_number">'+
                                    tablaNumber + 
                                  '</div><p></p>';
            }
                
            return '<div id="content_preview">' + 
                        
                        claseCompleto+
                        
                        userCompleto+
                        
                        toCompleto+
                        
                        ccCompleto+
                        
                        bbcCompleto+
                        
                        '<div class="input-control text block" >'+
                            'Failure'+
                            '<input type="text" value="'+falla+'" disabled>' +
                        '</div>'+
                        
                        '<div class="_label">Origination IP<span class="margen_17px"></span>' +
                        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                        'DestinationIP </div>'+
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
                        
                        gmtCompleto +
                        
                        tableTestedNumber +
                        
                        speechCompleto +
                        
                        '<div class="input-control textarea" data-role="input-control">' +
                            'Description' +
                            '<label>' +
                                '<textarea disabled="disabled">' +descripcion +'</textarea>' +
                            '</label>' +
                        '</div>' +
                   '</div>' +
                   '<div id="preview_buttons">' +
                        '<button  class="primary large" id="save_ticket">Send Ticket Information</button> <a  href="javascript:void(0)" id="imprimir"><i class="icon-printer on-right"></i></a>' +
                   '</div>';
    }
    
    /**
     * Quita la validación que está en el select de "Response to"
     * @param {object} select
     * @returns {undefined}
     * @private
     */
    function _quitarValidacion(select){
            if (select.find('option').length > 0)
                select.removeClass('validate[required]');
            else
                select.addClass('validate[required]');
    }
    
    /**
     * Es un confirm personalizado con el tema de metro ui.
     * 
     * Para hacer uso del confirm, se debe especificar la pregunta o mensaje que 
     * contendrá la ventana mostrada, luego se debe llamar a los eventos onClick 
     * de ambos botones para especificar que acción tomar cuando se pulse sobre ellos
     * @param {string} mensaje
     * @param {type} aceptar
     * @param {type} cancelar
     * @returns {undefined}
     * @private
     */
    function _confirmar(mensaje, aceptar, cancelar) {
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-rocket"></span>',
                title: false,
                width: 500,
                padding: 10,
                content: 
                    '<div id="content_mensaje">' + mensaje + '</div>' + 
                    '<div id="content_botones">' +
                        '<button class="primary large" id="ok_confirm" type="button">Continue</button>' +
                        '<button class="primary large" id="cancel_confirm" type="button">Cancel</button>' +
                    '</div>'
            });
    }
    
    /**
    * Muestra la vista de impresión del ticket
    * @param {object} ticketDetails El detalle del ticket
    * @returns {void}
    * @private
    */
    function _printOpenTicket(ticketDetails) {
        var _head   = '<!DOCTYPE html><html><meta charset="es"><head></head><body>',
        _footer = '<script>function printPage() { window.focus(); window.print();return; }</script>'+
              '</body></html>',
        content = _head + _designTicket(ticketDetails) + _footer,
        newIframe = document.createElement('iframe');
        newIframe.width = '0';
        newIframe.height = '0';
        newIframe.src = 'about:blank';
        document.body.appendChild(newIframe);
        newIframe.contentWindow.contents = content;
        newIframe.src = 'javascript:window["contents"]';
        newIframe.focus();
        newIframe.contentWindow.printPage();
        return;
    }
    
    /**
    * Diseño que contendrá el imprimible del ticket
    * @param {object} ticketDetails El detalle del ticket
    * @returns {string}
    * @private
    */
    function _designTicket(ticketDetails) {
        var information = '<h2>Ticket Details</h2>',
        _th = 'colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;"',
        _td = 'colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;"';
        information += '<table style="border-spacing: 0; width:100%; border: solid #ccc 1px;">';
        
        // To, CC, BCC
        if (ticketDetails.to.length > 0) {
            var temp = ticketDetails.to.map(function() {return $(this).text();}).get();
            information += '<tr>';
                information += '<th '+_th+' >TO</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td '+_td+' >' + temp.join('<br>') + '</td>';
            information += '</tr>';
        }
        if (ticketDetails.cc.length > 0) {
            var temp = ticketDetails.cc.map(function() {return $(this).text();}).get();
            information += '<tr>';
                information += '<th '+_th+' >CC</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td '+_td+' >' + temp.join('<br>') + '</td>';
            information += '</tr>';
        }
        if (ticketDetails.bcc.length > 0) {
            var temp = ticketDetails.bcc.map(function() {return $(this).text();}).get();
            information += '<tr>';
                information += '<th '+_th+' >BCC</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td '+_td+' >' + temp.join('<br>') + '</td>';
            information += '</tr>';
        }

        // Failure
        if (ticketDetails.failure) {
            information += '<tr>';
                information += '<th '+_th+' >Failure</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td '+_td+' >' + ticketDetails.failure + '</td>';
            information += '</tr>';
        }

        // Ip
        if (ticketDetails.oip && ticketDetails.dip) {
           information += '<tr>';
                information += '<th colspan="1" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Origination IP</th>';
                information += '<th colspan="3" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Destination IP</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td colspan="1" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">' + ticketDetails.oip + '</td>';
                information += '<td colspan="3" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">' + ticketDetails.dip + '</td>';
            information += '</tr>';
        }

        // Prefix
        if (ticketDetails.prefix) {
            information += '<tr>';
                information += '<th '+_th+' >Prefix</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td '+_td+' >' + ticketDetails.prefix + '</td>';
            information += '</tr>';
        }

        // gmt
        if (ticketDetails.gmt) {
            information += '<tr>';
                information += '<th '+_th+' >Gmt</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td '+_td+' >' + ticketDetails.gmt + '</td>';
            information += '</tr>';
        }

        // Tested Number
        if (ticketDetails.number) {
            var temp1 = ticketDetails.number.map(function() {return $(this).val();}).get(),
            temp2 = ticketDetails.country.find(':selected').map(function() {return $(this).text();}).get(),
            temp3 = ticketDetails.date.map(function() {return $(this).val();}).get(),
            temp4 = ticketDetails.hour.map(function() {return $(this).val();}).get();
    
            information += '<tr>';
                information += '<th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Tested number</th>';
                information += '<th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Country</th>';
                information += '<th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Date</th>';
                information += '<th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Hour</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">' + temp1.join('<br>') + '</td>';
                information += '<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">' + temp2.join('<br>') + '</td>';
                information += '<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">' + temp3.join('<br>') + '</td>';
                information += '<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">' + temp4.join('<br>') + '</td>';
            information += '</tr>';
        }

        // Description
        if (ticketDetails.description) {
            information += '<tr>';
                information += '<th '+_th+' >Description</th>';
            information += '</tr>';
            information += '<tr>';
                information += '<td '+_td+' >' + ticketDetails.description + '</td>';
            information += '</tr>';
        }
            
        information += '</table>';
        
        return information;               
    }
    
    return {
       
        /**
         * Puede ser usada para mensajes de confirmación, errores, etc
         * @param {string} text El texto del mensaje
         * @param {string} icon El icono usado para mostrar en la parte superior izquierda
         * @returns {undefined}
         * @public
         */
        message:function(text, icon) {
            if (!icon) {
                icon = 'icon-rocket';
            }
            $.Dialog.close();
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="' + icon + '"></span>',
                title: false,
                width: 500,
                padding: 10,
                content: '<center><h3>' + text + '</h3></center>'
            });
        },
        
        /**
        * Es un confirm personalizado con el tema de metro ui.
        * 
        * Para hacer uso del confirm, se debe especificar la pregunta o mensaje que 
        * contendrá la ventana mostrada, luego se debe llamar a los eventos onClick 
        * de ambos botones para especificar que acción tomar cuando se pulse sobre ellos
        * @param {string} mensaje Mensaje a mostrar en la ventana
        * @param {string} aceptar El botón para aceptar
        * @param {string} cancelar El botón para cancelar
        * @returns {undefined}
        * @public
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
         * Método para mostrar un tooltip
         * 
         * @param obj element
         * @param boolean statusTrack
         * @public
         */
        tooltip:function(element, statusTrack){
            $(element).tooltip({
                track: statusTrack
            });
        },
        
        /**
        * Muestra el preview del ticekt antes de ser guardado
        * 
        * @param {string} clase Si es customer o supplier
        * @param {string} user El usuario del ticket
        * @param {array} to Correos del ticket
        * @param {array} cc Copiar correo
        * @param {array} bbc Copia oculta de correo
        * @param {string} falla Falla del ticket
        * @param {string} originationIp Puerto ip de origen
        * @param {string} destinationIp Puerto ip de destino
        * @param {string} prefijo Prefijo del ticket
        * @param {string} speech Speech seleccionado de darse el caso
        * @param {string} descripcion Descripción del ticket
        * @param {string} gmt Gmt seleccioando 
        * @param {array} testedNumber Los números de prueba
        * @param {array} country El pais al que pertenece el número
        * @param {array} date La fecha es que se marcó el número
        * @param {array} hour La hora en que se marcó el número
        * @returns {undefined}
        * @public
        */
        previewTicket:function(clase,
                             user,
                             to,
                             cc,
                             bbc,
                             falla,
                             originationIp,
                             destinationIp,
                             prefijo,
                             speech,
                             descripcion,
                             gmt,
                             testedNumber,
                             country,
                             date,
                             hour){
            
            var ticketDetails = {
                'to':to,
                'cc':cc,
                'bcc':bbc,
                'failure':falla,
                'oip':originationIp,
                'dip':destinationIp,
                'prefix':prefijo,
                'gmt':gmt,
                'number':testedNumber,
                'country':country,
                'date':date,
                'hour':hour,
                'description':descripcion
            };
            
            $.Dialog({
                shadow: true,
                overlay: true,
                flat:true,
                icon: '<span class="icon-eye-2"></span>',
                title: 'Preview Ticket',
                width: 510,
                padding: 0,
                draggable: true,
                onShow: function(_dialog) {
                    $('#imprimir').on('click', function(){
                       _printOpenTicket(ticketDetails); 
                    });
                },
                content:_ticketCompleto(clase,
                             user,
                             to,
                             cc,
                             bbc,
                             falla,
                             originationIp,
                             destinationIp,
                             prefijo,
                             speech,
                             descripcion,
                             gmt,
                             testedNumber,
                             country,
                             date,
                             hour)
            });
        },
        
        /**
         * Valida las direccioens ip
         * 
         * @param {object} element
         * @returns {void}
         */
        direccionesIp:function(element){
            $(element).on('keyup', function(e){
                var keyNum = window.event ? window.event.keyCode : e.which;
                
                if ($(this).val().length === 3) {
                    if ($(this).val() > 255) {
                        $(this).val(255);
                    }
                    $(this).next('input').focus();
                    e.preventDefault();
                }
                
                
            });
            
            $(element).on('keypress', function(e){
                var keyNum = window.event ? window.event.keyCode : e.which;
                
                if (keyNum === 46) {
                    if ($(this).val() > 255) {
                        $(this).val(255);
                    }
                    $(this).next('input').focus();
                    e.preventDefault();
                } else {
                    if (keyNum < 48 || keyNum > 57) {
                        e.preventDefault();
                    }
                }
            });
        },
        
        /**
         * Borra los options de cualquier select que se le pase por parámetro
         * 
         * @param {object} select
         * @returns {undefined}
         */
        borrarOptionSelect:function(select){
              var element = select.parent().children('select');
              if(element.val()) 
              {
                  element.find('option:selected').remove();
                  _quitarValidacion(element);
              }
        },
        
        /**
         * Envía los options de un select a otro select
         * 
         * @param {obj} boton
         * @param {obj} select
         * @param {string} optionOpen Depende de come se abrá el ticket: carrier_to_etelex, etelix_to_carrier o etelix_by_carrier
         * @param {boolean} save
         * @returns {Boolean}
         * @public
         */
        appendOptions:function(boton, select, optionOpen, settings){
            var select2 = boton.parent().children('select');
            if (select2.length === 0) select2 = boton.parent().parent().children('select');
            
            if(select.val()) 
            {
                var option = select.find('option:selected'),
                longitud=option.length;
                if (optionOpen.val() == 'carrier_to_etelix' || optionOpen.val() == 'etelix_as_carrier') {
                    if (select2.find('option').length > 4) {
                        alert('Only five emails allowed');
                        return false;
                    }
                }
                
                if (!settings) 
                {
                    for (var i=0; i < longitud; i++) select2.append('<option value="'+option[i].value+'">'+option[i].text+'</option>');
                    
                    select.find('option:selected').attr('selected',false);
                    _quitarValidacion(select2);
                }
                else
                {
                    if (settings.save === true) 
                    {
                        select.find('option:selected').remove()
                        $ETTS.ajax.saveMailTicket(settings);
                    }
                }
            }
        },
        
        /**
         * Deselecciona un option de un select multiple
         * @param {object} select
         * @returns {undefined}
         * @public
         */
        clearOptions:function(select){
            if(select.val()) 
            {
                select.find('option:selected').attr('selected',false);
            }
        },
        
        /**
         * Agrega todos los options de un select a un segundo select
         * @param {object} select
         * @param {object} select2
         * @returns {undefined}
         * @public
         */
        addAllEmails:function(select, select2){
                select.html('');
                select2.find('option').clone().appendTo(select);
                select.removeClass('validate[required]');
        },
        
        /**
         * Clona la fila de tested number(numero, país, fecha y hora) para duplicarla
         * @returns {undefined}
         * @public
         */
        addTestedNumber:function(){
            var $html = $('#elemento').clone().css('display', 'none');
            $html.find('span,br').remove();
            $html.find('input').val('');
            $html.find('input.fecha').removeAttr('id').removeClass('hasDatepicker').datepicker({dateFormat: "yy-mm-dd"});
            $html.find('input.hour').removeAttr('id').removeClass('hasTimeEntry').timeEntry({show24Hours: true, showSeconds: true});
            $html.find('a').removeClass('agregar-tested-number').addClass('_cancelar input-control text span1');
            $html.find('a').find('i').removeClass('icon-plus-2').addClass('icon-cancel-2 fg-red');
            $('#preview_tested_number').append($html.fadeIn('fast')); 
        },
        
        /**
         * Borra una fila clonada de tested number
         * @param {object} boton
         * @returns {undefined}
         * @public
         */
        removeTestedNumber:function(boton){
            boton.parent().parent().fadeOut('fast', function(){
                boton.parent().parent().remove();
            });
        },
        
        /**
         * Confirma si se quiere cerrar o no un ticket
         * @param {object} select
         * @returns {undefined}
         * @public
         */
        confirmCloseTicket:function(select){
            if (select.val())
            {   if (select.val() == '2')
                {
                    _confirmar('You are about to close a ticket, this change is erreversible, if you are sure click continue')
                }
                else
                {
                     _confirmar('Message');
                }    
            }
        },
        
        /**
         * Remueve la clase blink que muestran los tickets que tienen una respuesta nueva y no la han visto
         * @param {object} boton
         * @returns {undefined}
         * @public
         */
        removeBlink:function(boton){
            boton.parent().parent().removeClass('blink');
        }
    }
    
})();

