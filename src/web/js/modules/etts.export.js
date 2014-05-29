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
     * @param {string} _url Url de la petición ajax
     * @param {array} _id Los id's que se muestren en datatable
     * @param {bool} _async Se especifica si es asincrono o no la petición ajax
     * @param {function} _success Si se desea mandar una función al success del ajax
     * @param {function} _beforesend Si se desea mandar una función al beforesend del ajax
     * @param {int} _status Si es 1 son tickets abiertos, 2 para tickets cerrados
     * @param {bool} print Si es true, se retorna lo que trae response
     * @param {string} _date Fecha para determinar el lifetime y el color del ticket
     * @returns {jqXHR.responseText}
     */
    function _xhr(_url, _id, _async, _success, _beforesend, _status, print, _date) {
        var response = $.ajax({ 
                            type: 'POST',   
                            url: _url,
                            data:{id:_id, status:_status, date:_date},
                            async: _async,
                            success:_success,
                            beforeSend:_beforesend
                        }).responseText;
        if (print === true) {
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
         * @param {obj} element
         * @param {string} url
         * @param {int} status
         * @param {string} date
         * @returns {void}
         */
        print:function(element, url, status, date) {
            var ids = _getIds(element);
            // Si hay datos en la tabla
            if (ids.length > 0) {
                var content = _head + _xhr(url, ids, false, null, null, status,  true, date) + _footer,
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
        excelForm:function(form, input) {
            if (input.length > 0) {
                _window('Generating excel...<h2><img src="/images/loader.GIF">');
                form.submit();
                setTimeout(function(){_window('The file has been generated');}, 3500);
            }
        },
        /**
         * Método para enviar mail
         * @param {obj} element
         * @param {string} url
         * @param {int} status
         * @returns {undefined}
         */
        mail:function(element, url, status, date) {
            var ids = _getIds(element);
            if (ids.length > 0) {
                _xhr(url, 
                    ids, 
                    true, 
                    function(data){_window('Success');}, 
                    function(data){_window('Sending email...<h2><img src="/images/loader.GIF">');}, 
                    status,
                    date);
            }
        }
    };
})();