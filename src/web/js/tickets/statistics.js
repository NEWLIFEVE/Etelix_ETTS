/**
 * Inicializando datatable
 * @param {string} date
 * @param {string} option
 * @param {string} carrier
 * @returns {void}
 */
function initDatatable(date, option, carrier)
{
    if (!date) date = '';
    if (!option) option = '';
    if (!carrier) carrier = '';
    
    var oTable = $('#tbl-datatable').dataTable({
        "aaSorting":[],
        "bJQueryUI": true,
        "bPaginate": false,
        "bLengthChange": false,
        "bSort": false,
        "bDestroy": true,
        "bInfo":true,
        "bAutoWidth": false,
        "bProcessing": true,
        "sAjaxSource": '/ticket/datatable?date=' + date + '&option=' + option + '&carrier=' + carrier,
        "sAjaxDataProp": "aaData",
        "fnDrawCallback":function () {
            changeBackground();
        }  
   });
}

/**
 * Retorna la cantidad de tickets por categoria y los muestra en la primera tabla de estadísticas
 * @param {string} date
 * @param {string} carrier
 * @returns {void}
 */
function ajaxStatistics(date, carrier)
{
    $.ajax({
        type:'POST',
        url:'/ticket/ajaxstatistics',
        dataType:'json',
        data:{'date':date, 'carrier':carrier},
        success:function(data) {
            // Con el ciclo seteamos las cantidades separadas por tipo de carrier
            for (var i = 0; i < data.length; i++) {
                var a = $('.display-data').eq(i).text(data[i].totalByColors),
                b = $('.subtract-one-day').eq(i).text(data[i].subtractOneDay),
                c = $('.subtract-seven-days').eq(i).text(data[i].subtractSevenDays),
                d = $('.display-supplier').eq(i).text(data[i].totalByCarriers.Supplier != null ? data[i].totalByCarriers.Supplier : 0),
                e = $('.display-customer').eq(i).text(data[i].totalByCarriers.Customer != null ? data[i].totalByCarriers.Customer : 0);
                checkMargin(a.text(), b.text(), $('.arrow'), i);   
                checkMargin(a.text(), c.text(), $('.arrow2'), i);   
            }
            
            // Se setean los totales
            for (var i = 0; i < 4; i++) {
                var a = $('.total-data').eq(i).text(data[i * 3].totalByColors + data[(i * 3) + 1].totalByColors + data[(i * 3) + 2].totalByColors),
                b = $('.total-one-day').eq(i).text(data[i * 3].subtractOneDay + data[(i * 3) + 1].subtractOneDay + data[(i * 3) + 2].subtractOneDay),
                c = $('.total-seven-days').eq(i).text(data[i * 3].subtractSevenDays + data[(i * 3) + 1].subtractSevenDays + data[(i * 3) + 2].subtractSevenDays),
                d = $('.total-supplier').eq(i).text(parseInt($('.display-supplier').eq(i * 3).html()) + parseInt($('.display-supplier').eq((i * 3) + 1).html()) + parseInt($('.display-supplier').eq((i * 3) + 2).html())),
                e = $('.total-customer').eq(i).text(parseInt($('.display-customer').eq(i * 3).html()) + parseInt($('.display-customer').eq((i * 3) + 1).html()) + parseInt($('.display-customer').eq((i * 3) + 2).html()));
                checkMargin(a.text(), b.text(), $('.total-arrow'), i); 
                checkMargin(a.text(), c.text(), $('.total-arrow2'), i); 
            }         
        }
    });
}

/**
 * 
 * @param {int} a
 * @param {int} b
 * @param {object} div
 * @param {int} index
 * @returns {void}
 */
function checkMargin(a, b, div, index)
{
    if (parseInt(a) > parseInt(b)) {
        div.eq(index).html('<i class="icon-arrow-down fg-red"></i>');
    } else if (parseInt(a) < parseInt(b)) {
        div.eq(index).html('<i class="icon-arrow-up fg-green"></i>');
    } else if (parseInt(a) === parseInt(b)) {
        div.eq(index).html('<div class="rot90"><i class="icon-pause-2"></i></div>');
    } 
}

function diagram()
{
    
}

/**
 * Cambio de los colores de los tr dependiendo del color del ticket
 * @returns {void}
 */
function changeBackground()
{
    $('#tbl-datatable tbody tr').each(function(i){
        $('#tbl-datatable tbody tr').eq(i).css({
                        'background': $(this).find('td').find('input[name="color[]"]').val(),
                        'color': $(this).find('td').find('input[name="id_status[]"]').val(),
                        'fontWeight': $(this).find('td').find('input[name="id_status[]"]').attr('rel')
                    });
    });
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
        'id': $('input[name="id[]"]'),
        'date':$('.date').val(),
        'status':null,
        'nameReport':$('input[type="radio"]:checked').val()
    };
    
    if (boton.prop('id') === 'print-btn') {
        settings.async = false;
        settings.print = true;
        $ETTS.export.print(settings);
    } else if (boton.prop('id') === 'excel-btn') {
        $ETTS.export.excelForm($('#form'), $('input[name="id[]"]'));
    } else {
        settings.async = true;
        settings.print = false;
        $ETTS.export.mail(settings, true);
    }
}

/**
 * Función para mostrar el ancla en la primera tabla de estadísticas
 * @returns {void}
 */
function goLink()
{
    $('input[type="radio"]').each(function(i){
         if ($(this).is(':checked')) {
            $(this).parent().parent().parent().next().show('fast');
         } else {
            $(this).parent().parent().parent().next().hide('fast');
         }
    });
}

/**
 * Función para animar el scroll al darle click al ancla de la primera tabla de estadísticas
 * @returns {void}
 */
function animatedScrolling()
{
    $('a[href*=#]').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
             && location.hostname == this.hostname) {
            var $target = $(this.hash);

            $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

            if ($target.length) {

                 var targetOffset = $target.offset().top;

                 $('html,body').animate({scrollTop: targetOffset}, 1000);

                 return false;
            }
        }
   });
}

function load()
{
    $('.link-statistics').hide();
    
    goLink();
    
    animatedScrolling();
    
    $('.date').datepicker({
        'dateFormat':'yy-mm-dd',
        'changeYear':true,
        'changeMonth':true,
        'maxDate':'0'
    });
   
    $(document).tooltip({track: true});
    
    // Carga de los datos al cargar el documento
    ajaxStatistics(null, null);
    
    // Inicializando datatable
    initDatatable($('.date').val(), $('input[type="radio"]:checked').val(), $('#select-carrier').val());
   
    // Carga de los datos al introducir una fecha
    $(document).on('change', '.date, #select-carrier', function(){
        ajaxStatistics($('.date').val(), $('#select-carrier').val());
    });
    
    // Refrescar datable dependiando del change de los inputs
    $(document).on('change', '.date, input[type="radio"], #select-carrier', function(){
        initDatatable($('.date').val(), $('input[type="radio"]:checked').val(), $('#select-carrier').val());
    });
    
    // Exportar 
    $(document).on('click', '.itemreporte', function(){
        initExport($(this));
    });
    
    $('input[type="radio"]').on('change', function(){
        goLink();
    });
}

$(document).on('ready', function(){
    load();
});