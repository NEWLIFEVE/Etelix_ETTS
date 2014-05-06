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
     * @param {string} _mail EL mail del usuario logueado donde se mandar el correo
     * @param {bool} _async Se especifica si es asincrono o no la petición ajax
     * @param {function} _success Si se desea mandar una función al success del ajax
     * @param {bool} print Si es true, se retorna lo que trae response
     * @returns {jqXHR.responseText}
     */
    function _urlReport(_url, _id, _mail, _async, _success, print) {
        var response = $.ajax({ 
                            type: 'GET',   
                            url: _url,
                            data:{id:_id, mail:_mail},
                            async: _async,
                            success:_success
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
    function _getIds(element){
        var ids = [];
        element.each(function(i){ 
            ids[i] = $(this).prop('rel'); 
        });
        return ids;
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
            if (ids !== '') {
                var content = _head + _urlReport(url, ids, null, false, null, true) + _footer,
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
            if (ids !== '') {
                setTimeout("window.open('"+url+"?id="+ids+"','_top');",500);
            }
        },
        /**
         * Método para enviar mail
         * @param {obj} element
         * @param {string} url
         * @param {string} email
         * @returns {undefined}
         */
        mail:function(element, url, email) {
            var ids = _getIds(element);
            if (ids !== '') {
                _urlReport(url, ids, email, true, null);
            }
        }
    };
})();