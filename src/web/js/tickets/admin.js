(function($) {
/*
 * Function: fnGetColumnData
 * Purpose:  Return an array of table values from a particular column.
 * Returns:  array string: 1d data array
 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
 *           int:iColumn - the id of the column to extract the data from
 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
 */
$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
    // check that we have a column id
    if ( typeof iColumn == "undefined" ) return new Array();
     
    // by default we only want unique data
    if ( typeof bUnique == "undefined" ) bUnique = true;
     
    // by default we do want to only look at filtered data
    if ( typeof bFiltered == "undefined" ) bFiltered = true;
     
    // by default we do not want to include empty values
    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
     
    // list of rows which we're going to loop through
    var aiRows;
     
    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay;
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers
 
    // set up data array   
    var asResultData = new Array();
     
    for (var i=0,c=aiRows.length; i<c; i++) {
        iRow = aiRows[i];
        var aData = this.fnGetData(iRow);
        var sValue = aData[iColumn];
         
        // ignore empty values?
        if (bIgnoreEmpty == true && sValue.length == 0) continue;
 
        // ignore unique values?
        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
         
        // else push the value onto the result data array
        else asResultData.push(sValue);
    }
     
    return asResultData;
}}(jQuery));

function fnCreateSelect( aData )
{
    var r='<select><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ )
    {
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return r+'</select>';
}

// Función para agregar archivos en el description
function attachFile()
{
    var settings = {
                url: "/file/uploadjquery",
                dragDrop:false,
                showDone: false,
                fileName: "myfile",
                allowedTypes:"pdf,gif,jpeg,png,jpg,xlsx,xls,txt,cap,pcap,csv",	
                returnType:"json",
                showFileCounter:false,
                     onSuccess:function(files,data,xhr)
                {
                     $('div.ajax-file-upload-filename:last').attr('name', data[0]); 
                },
                showDelete:true,
                deleteCallback: function(data,pd){
                    for(var i=0;i<data.length;i++)
                    {
                        $.post("/file/deletejquery",{op:"delete",name:data[i]},
                        function(resp, textStatus, jqXHR)
                        {
                            //Show Message  
                            $("#status").html("");      
                        });
                     }      
                    pd.statusbar.remove(); //You choice to hide/not.
                }
            }
    var uploadObj = $("#mulitplefileuploader").uploadFile(settings); 
}


// Asociar mas correos al ticket creado
function seeOptions(e)
{
    $('.options-hide').show('fast');
    $(e).text('hide');
    $(e).attr('onclick', 'hideOptions(this)');
}
function hideOptions(e)
{
    $('.options-hide').hide('fast');
    $(e).text('Add more email\'s');
    $(e).attr('onclick', 'seeOptions(this)');
}

// Bajar correos a la lista a donde se enviará la nota al cerrar o dar una respuesta al ticket
function bajarCorreo(e)
{
    var totalMails = $('#mails option:selected'), mails = [];

    for (var i=0; i<totalMails.length; i++) mails.push(totalMails[i].value);
    
    var settings = {
        save:true,
        idTicket:$('#id_ticket'),
        mail:mails,
        select:$('#mostrar-mails')
    };
    
    $ETTS.UI.appendOptions($(e), $('#mails'), $('#open-ticket'), settings);
}

function newMailTicket(e)
{
    if ($('#new_mail').val().length > 0) 
        $ETTS.ajax.saveMail($('#new_mail'),'',$('#user-ticket'),null,$('#mostrar-mails'),$('#open-ticket'),$('#id_ticket').val());
}

function borrarCorreo(e)
{
    var longitudTotal = $('#mostrar-mails option').length, 
    longitudSeleccionados = $('#mostrar-mails option:selected').length,
    options = $('#mostrar-mails option:selected'),
    total=longitudTotal - longitudSeleccionados, 
    _idMailticket=[];
    
    if ($('#mostrar-mails').val()) 
    {
        if (total !== 0)
        {
            for (var i = 0; i < longitudSeleccionados; i++) _idMailticket.push(options[i].value);
            var settings = {
                idMailTicket:_idMailticket,
                select:$('#mails'),
                select2:$('#mostrar-mails'),
                idUser:$('#user-ticket'),
                idTicket:$('#id_ticket')
            };
            $ETTS.ajax.deleteMailTicket(settings);
        }
    }
}

function show(e, show)
{
    $(show).show('fast');
}
function hide(e, show)
{
    $(show).hide('fast');
}

/*
* Guarda la respuesta de la descripcion
*/
function saveMessage()
{
    var fileName=$('div.ajax-file-upload-filename'),
    _length=fileName.length,
    _fileServer=[],
    _files=[],
    _internalAsCarrier=null;
    
    if ($('#internalAsCarrier')) {
        if ($('#internalAsCarrier').is(':checked'))
            _internalAsCarrier=$('#internalAsCarrier').val();
    }
    
    for(var i=0; i<_length; i++) {
        _files.push(fileName[i].innerHTML);
        _fileServer.push(fileName[i].getAttribute('name'));

    }
    
    if ($('#answer').val() !== '') {
        
        var _idSpeech = null,
        _message=$('#answer').val(),
        _idTicket=$('#id_ticket').val();
        
        if ($('select#speech').val())  _idSpeech = $('select#speech option:selected').val();
        
        $('#answer').val('')
        $('div#area-add-file').empty();
        $('[name="myFile[]"]').val('');
        
        if ($('#close-ticket').is(':checked')) {
            $.ajax({
                type:'POST',
                url:'/ticket/updatestatus/' + _idTicket,
                dataType:'html',
                data:{
                    idStatus:'2',
                    idSpeech: _idSpeech,
                    message:  _message,
                    idTicket: _idTicket,
                    files:_files,
                    fileServer:_fileServer,
                    internalAsCarrier:_internalAsCarrier
                },
                beforeSend:function(){
                    $('div.pre-loader').html(
                        '<div style="width:100% !important; text-align:center !important;">' +
                            '<div style="margin:auto;"><img src="/images/preloader.GIF"></div>' +
                        '</div>'
                    );
                },
                success:function(data){
                    if (data != 'false') {
                        $('div.answer-ticket, div.pre-loader').empty();
                        $('div.answer-ticket').html(data);
                        $('div.answer-ticket').append('<div class="get-mails"></div><div class="pre-loader"></div>');
                        $('div.answer-ticket').scrollTop(100000);
                        $('#only-open').slideUp('slow');
                        $('.a-agregar-correo').hide('fast');
                    } else {
                        $.Dialog({
                            content:data
                        });
                    }
                }
            });
            return false;
        }
        
        $.ajax({
            type:"POST",
            url:"/descriptionticket/savedescription",
            data: {
                idSpeech: _idSpeech,
                message:  _message,
                idTicket: _idTicket,
                files:_files,
                fileServer:_fileServer,
                internalAsCarrier:_internalAsCarrier
            },
            beforeSend:function(){
                $('div.pre-loader').html(
                    '<div style="width:100% !important; text-align:center !important;">' +
                        '<div style="margin:auto;"><img src="/images/preloader.GIF"></div>' +
                    '</div>'
                );
            },
            success:function(data){
                if (data !== 'false') {
                    $('div.answer-ticket, div.pre-loader').empty();
                    $('div.answer-ticket').html(data);
                    $('div.answer-ticket').append('<div class="get-mails"></div><div class="pre-loader"></div>');
                    $('div.answer-ticket').scrollTop(100000);
                }
            }
        });
    }
}

/**
 * Botones para exportar
 * @param {object} boton
 * @returns {void}
 */
function initExport(boton)
{
    var settings = {
        'url': boton.prop('rel'),
        'id': $('.preview'),
        'date': null,
        'status': $('#status').val()
    };
    
    if (boton.prop('id') === 'print-btn') {
        settings.async = false;
        settings.print = true;
        $ETTS.export.print(settings);
    } else if (boton.prop('id') === 'excel-btn') {
        $ETTS.export.excelForm($('#form-excel'), $('.preview'));
    } else {
        settings.async = true;
        settings.print = false;
        $ETTS.export.mail(settings);
    }
}

/**
*Función para refrescar la vista admin.php cada 5 minutos. Si se da un preview del
*ticket se interrrumpe el proceso y al cerrar el preview se vuelven a contar los 
*cinco minutos.
*/
var timeRefresh = 300000, 
    refreshInterval = setInterval(function(){
        window.location.reload(true);
    }, timeRefresh);
            
/**
 * Imprime el ticket que ya esta guardado en base de datos
 * @returns {void}
 */
function printTicketBd()
{
    var settings = {
        'url': '/ticket/printticket',
        'async': false,
        'print': true,
        'id': $('#id_ticket').val()
    };
    $('#print-ticket').on('click', function(){
       $ETTS.export.printPreviewTicket(settings); 
    });
}

/**
 * Función para escalar tickets
 * @returns {void}
 */
function previewEscaladeTicket()
{
    $('#escalade-ticket').on('click', function(){
       var idTicket = $('#id_ticket').val(), 
       tags = ['eykiss@etelix.com', 'nathaliag@etelix.com', 'alvaroquintana@etelix.com', 'ceo@etelix.com', 'jclopezsilva@etelix.com'];
       $.Dialog.close();
       $.Dialog({
            shadow: true,
            overlay: true,
            overlayClickClose: true,
            overlayClickCloseDefault: false,
            flat:true,
            icon: "<span class=icon-eye-2></span>",
            title: "Escalade Ticket",
            width: '450px',
            height: '30%',
            padding:20,
            draggable: true,
            functionOverlayClickClose: function(_dialog){
                // Al cerrar la ventana, se vuelve a contar los 5 munitos
                refreshInterval = setInterval(function(){
                   window.location.reload(true);
                }, timeRefresh);
                
                $.Dialog.close();
            },
            onShow: function(_dialog){
                $('#myTags').tagit({
                    placeholderText:'Write an email',
                    availableTags:tags
                });  
//                var mails = $("#mail-escalade").kendoMultiSelect({placeholder: "Select mails",}).data("kendoMultiSelect");
//                $.post('/mail/autocomplete', null, function(data){$('#myTags').val(data);}); 
//                setTimeout(function(){$('#myTags').tagit();}, 800);
                                 
                $('#bt-escalade').on('click', function() {
                    var mails = [];
                    $('.tagit-label').each(function(i){
                       mails[i] = $(this).text(); 
                    });
                    var settings = {
                        data : {
                            'mails':mails,
                            'idTicket':idTicket,
                            'message':$('#message').val(),
                            'subject':$('#subject').val()
                        }
                    };

                    if ($('#message').val() === '' || mails.length === 0) 
                        return false;

                    escaladedTicket(settings);
                });
                
                efectBorder('#message');
            },
            sysBtnCloseClick: function(event){
                // Al cerrar la ventana, se vuelve a contar los 5 munitos
                refreshInterval = setInterval(function(){
                   window.location.reload(true);
                }, timeRefresh);
            },
            content:
            '<div style="max-width:450px !important"><h3 class="ticket-information">Escalade ticket</h3><br>' +
            '<!--<div class="input-control select">' +
                '<select id="mail-escalade" multiple="multiple">' +
                    '<option value="tsu.nelsonmarcano@gmail.com">Nelson gmail</option>'+
                    '<option value="tsu.nelsonmarcano@hotmail.com">Nelson hotmail</option>' +
                    '<option value="nelson_redimi2@hotmail.com">Nelson hotmail2</option>' +
                    '<option value="nelsonm@sacet.biz">Nelson sacet</option>' +
                '</select>' +
            '</div><p></p>-->' +
            '<input type="text" id="myTags" value="eykiss@etelix.com, nathaliag@etelix.com, alvaroquintana@etelix.com, ceo@etelix.com, jclopezsilva@etelix.com">' +
            '<div class="input-control textarea" data-role="input-control">' +
                '<textarea class="textarea-integrado" name="message" id="message"></textarea>' +
            '</div>' +
            '<div class="panel-down-textarea">' +
                '<div class="option-panel right">' +
                    '<input type="button" value="Send" id="bt-escalade" class="primary">' +
                '</div>' +
                '<div class="option-panel right">' +
                    '<input type="button" onclick="previewTicket('+ idTicket +')" value="Cancel" >' +
                '</div>' +
            '</div></div>'
        });
    });
}

function escaladedTicket(settings)
{
    $.ajax({
        type:'POST',
        url:'/ticket/scalade',
        data:{
            'data':settings.data
        },
        beforeSend:function(data) {
            $.Dialog.close();
            $ETTS.UI.message('Sending email...<h2><img src="/images/loader.GIF">');
        },
        success:function(response) {
            if (response === 'true') {
                $.Dialog.close();
                $ETTS.UI.message('Success');
            } else {
                $.Dialog.close();
                $ETTS.UI.message('Error ' + response);
            }
        }
    });
}

/**
 * Muestra el preview del ticket
 * @param {int} idTicket
 * @param {object} boton
 * @returns {void}
 */
function previewTicket(idTicket, boton)
{   
    $.Dialog.close();
    setTimeout(function(){
        $('.tab-control').tabcontrol({
            effect: 'fade' // or 'slide'
        });
    }, 1000);
    // Se detiene el refresh
    clearInterval(refreshInterval);
    // Se oculta el div para agregar correo
    setTimeout(function(){$('.options-hide, .mails-associates').hide();}, 500);

    $.ajax({
        type:"POST",
        url:"/ticket/getdataticket/" + idTicket,
        success:function(data){
            $.Dialog({
                shadow: true,
                overlay: true,
                overlayClickClose: true,
                overlayClickCloseDefault: false,
                flat:true,
                icon: "<span class=icon-eye-2></span>",
                title: "Ticket Information",
                width: 1024,
                height: 540,
                padding:0,
                paddingBottom: 0,
                draggable: true,
                content:data,
                functionOverlayClickClose: function(_dialog){
                    // Al cerrar la ventana, se vuelve a contar los 5 munitos
                    refreshInterval = setInterval(function(){
                       window.location.reload(true);
                    }, timeRefresh);
                    
                    $.Dialog.close();
                },
                onShow:function(_dialog) {
                  loadFunctions();  
                },
                sysBtnCloseClick: function(event){
                    // Al cerrar la ventana, se vuelve a contar los 5 munitos
                    refreshInterval = setInterval(function(){
                       window.location.reload(true);
                    }, timeRefresh);
                }
            });
            // Scroll abajo al cargar el detalle del ticket
            $('div.answer-ticket').scrollTop(100000);
            // Click para cargar los corres entrantes con imap
            $('.see-email').on('click', function () {
                var settings = {
                    ticketNumber:$(this).attr('id'),
                    loader:$('.pre-loader'),
                    answer:$('.answer-ticket'),
                    optionOpen:$('#open-ticket').val(),
                    idTicket:$('#id_ticket').val()
                };

                $ETTS.ajax.getMailsImap(settings);
            });
        }
    });

    if (boton) 
    {
        if (boton.parent().parent().attr('class').toLowerCase().indexOf("blink") >= 0)
        {
            $ETTS.UI.removeBlink(boton);
            $ETTS.ajax.removeBlink(idTicket);
        }
    }
}

function loadFunctions()
{
    printTicketBd();
    previewEscaladeTicket();
    attachFile();
}

function efectBorder(element)
{
    $(document).on('focus', element, function(){
       $('div.panel-down-textarea').css('border-bottom', '1px solid grey')
       $('div.panel-down-textarea, select#speech').css('border-left', '1px solid grey')
       $('div.panel-down-textarea, select#speech').css('border-right', '1px solid grey')
       $('select#speech').css('border-top', '1px solid grey')
    });
    
    $(document).on('blur', element, function(){
        $('div.panel-down-textarea').css('border-bottom', '1px solid #d9d9d9')
        $('div.panel-down-textarea, select#speech').css('border-left', '1px solid #d9d9d9')
        $('div.panel-down-textarea, select#speech').css('border-right', '1px solid #d9d9d9')
        $('select#speech').css('border-top', '1px solid #d9d9d9')
    }); 
}

$(document).on('ready', function() {
    // Exportables
    $(document).on('click', '.itemreporte', function(){
        initExport($(this));
    });
        
    // Leyenda de colores
    $('.botones-sociales .social').mouseenter(function(){
        $(this).stop();
        $(this).find('span').first().css('display', 'none');
        $(this).animate({width:'270'}, 500, 'easeOutBounce',function(){}); 
    });

    $('.botones-sociales .social').mouseleave(function(){
        $(this).stop();
        $(this).find('span').first().css('display', 'block');
        $(this).animate({width:'58'}, 500, 'easeOutBounce',function(){});
    });
    
    // Llamado de refresh
    refreshInterval;

    //Tooltip del status y el tiempo que lleva desde que se abrió
    $( document ).tooltip({track: true});

    //Append Speech
    $(document).on('change', 'select#speech', function(){
        if ($(this).val()){
            var settings = {
                failure:$('#Ticket_id_failure'), 
                country:$('#Ticket_country')
            };
            $ETTS.ajax.getSpeech($(this).val(), $('#answer'), settings); 
        } else {
            $('#answer').val('')
        }
    });

    // Llamado del preview del ticket
    $(document).on('click', '.preview', function () {
        previewTicket($(this).attr('rel'), $(this));
    });
    
    // Efecto seleccion de border al tener foco en un textarea
    efectBorder('textarea#answer');
});