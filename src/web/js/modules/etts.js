// Objeto Global
var $ETTS={};

/**
 * Sub módulo de interfaz
 */
$ETTS.UI=(function(){
    
    
    return {
        // Método para mostrar un confirm personalizado
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
        }
    }
    
})();

