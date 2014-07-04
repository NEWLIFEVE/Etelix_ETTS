/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$ETTS.export=(function(){
    var _head   = '<!DOCTYPE html><html><meta charset="es"><head></head><body>',
        _footer = '<script>function printPage() { window.focus(); window.print();return; }</script>'+
                  '</body></html>';
    /**
     * Petición ajax para los exportables
     * @param {object} settings Url de la petición ajax
     * @returns {jqXHR.responseText}
     */
    function _xhr(settings) {
        var response = $.ajax({ 
                            type: 'POST',   
                            url: settings.url,
                            data:{
                                'id':settings.id, 
                                'status':settings.status, 
                                'date':settings.date,
                                'rb-report':settings.nameReport
                            },
                            async: settings.async,
                            success:settings.success,
                            beforeSend:settings.beforesend
                        }).responseText;
        if (settings.print === true) {
            return response;
        }
    }
    
    /**
    * Método para obtener los id's del ticket de lo que se está mostrando en datatable
    * @param {obj} element
    * @returns {Array}
    */
    function _getIds(element) {
        var ids = [];
        element.each(function(i){ 
            ids.push(element.eq(i).attr('rel')); 
        });
        return ids;
    }
    
    /**
     * Ventana modal para informar los procesos de exportación
     * @param {string} text
     * @param {string} icon
     * @returns {string}
     */
    function _window(text, icon) {
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
    }
            
    return {
        /**
         * Método para mostrar la vista de impresión
         * @param {object} settings
         * @returns {void}
         */
        print:function(settings) {
            settings.id = _getIds(settings.id);
            // Si hay datos en la tabla
            if (settings.id.length > 0) {
                settings.success = null;
                settings.beforesend = null;
                var content = _head + _xhr(settings) + _footer,
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
        },
        printPreviewTicket:function(settings) {
            settings.success = null;
            settings.beforesend = null;
            var content = _head + _xhr(settings) + _footer,
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
        },
        /**
         * Método para exportar a excel
         * @param {obj} element
         * @param {string} url
         * @returns {void}
         */
        excel:function(element, url) {
            var ids = _getIds(element);
            if (ids.length > 0) {
                _window('Generating excel...<h2><img src="/images/loader.GIF">');
                window.open(url + '?id=' + ids, '_top');
                setTimeout(function(){_window('The file has been generated');}, 3500);
            }
        },
        /**
         * Método para exportar a excel usando formulario
         * @param {obj} form
         * @param {obj} input
         * @returns {void}
         */
        excelForm:function(form, input, validate) {
            if (validate) {
                if (input.length === 0) {
                    return false;
                }
            }
            _window('Generating excel... <br><img src="/images/loader.GIF">');
            setTimeout(function(){_window('The file has been generated');}, 3000);
            setTimeout(form.submit(), 1000);
        },
        /**
         * Método para enviar mail
         * @param {object} settings
         * @returns {void}
         */
        mail:function(settings, validate) {
            settings.id = _getIds(settings.id);
            if (validate) {
                if (settings.id.length === 0) {
                    return false;
                }
            }
            settings.success = function() {
                                _window('Success');
                               };
            settings.beforesend = function() {
                                    _window('Sending email...<h2><img src="/images/loader.GIF">');
                                };
            _xhr(settings);
        }
    };
})();