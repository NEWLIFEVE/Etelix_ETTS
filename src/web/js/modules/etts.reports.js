/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$ETTS.reports=(function(){
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
     * @param {bool} print Si es true, se retorna lo que trae response
     * @returns {jqXHR.responseText}
     */
    function _urlReport(_url, _id, _async, _success, _beforesend, print) {
        var response = $.ajax({ 
                            type: 'POST',   
                            url: _url,
                            data:{id:_id},
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
            ids[i] = $(this).prop('rel'); 
        });
        return ids;
    }
    
    /**
     * Ventana modal para informar los procesos de exportación
     * @param {string} text
     * @param {string} icon
     * @returns {undefined}
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
         * @returns {void}
         */
        print:function(element, url) {
            var ids = _getIds(element);
            // Si hay datos en la tabla
            if (ids.length > 0) {
                var content = _head + _urlReport(url, ids, false, null, null, true) + _footer,
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
                _window('Generating excel');
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
                _window('Generating excel');
                form.submit();
                setTimeout(function(){_window('The file has been generated');}, 3500);
            }
        },
        /**
         * Método para enviar mail
         * @param {obj} element
         * @param {string} url
         * @returns {undefined}
         */
        mail:function(element, url) {
            var ids = _getIds(element);
            if (ids.length > 0) {
                _urlReport(url, ids, true, 
                function(data){_window('Success');}, 
                function(data){_window('Wait a few seconds...');});
            }
        }
    };
})();