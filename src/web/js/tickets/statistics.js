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
            for (var i = 0; i < data.length; i++) {
                 $('.display-data').eq(i).text(data[i].totalByColors);
                 $('.display-supplier').eq(i).text(data[i].totalByCarriers.Supplier != null ? data[i].totalByCarriers.Supplier : 0);
                 $('.display-customer').eq(i).text(data[i].totalByCarriers.Customer != null ? data[i].totalByCarriers.Customer : 0);
            }
            $('.total-data').eq(0).text(data[0].totalByColors + data[1].totalByColors + data[2].totalByColors);
            $('.total-data').eq(1).text(data[3].totalByColors + data[4].totalByColors + data[5].totalByColors);
            $('.total-data').eq(2).text(data[6].totalByColors + data[7].totalByColors + data[8].totalByColors);
            $('.total-data').eq(3).text(data[9].totalByColors + data[10].totalByColors + data[11].totalByColors);
            var totalSupplier1 = parseInt($('.display-supplier').eq(0).html()) + parseInt($('.display-supplier').eq(1).html()) + parseInt($('.display-supplier').eq(2).html()),
                totalSupplier2 = parseInt($('.display-supplier').eq(3).html()) + parseInt($('.display-supplier').eq(4).html()) + parseInt($('.display-supplier').eq(5).html()),
                totalSupplier3 = parseInt($('.display-supplier').eq(6).html()) + parseInt($('.display-supplier').eq(7).html()) + parseInt($('.display-supplier').eq(8).html()),
                totalSupplier4 = parseInt($('.display-supplier').eq(9).html()) + parseInt($('.display-supplier').eq(10).html()) + parseInt($('.display-supplier').eq(11).html()),
                totalCustomer1 = parseInt($('.display-customer').eq(0).html()) + parseInt($('.display-customer').eq(1).html()) + parseInt($('.display-customer').eq(2).html()),
                totalCustomer2 = parseInt($('.display-customer').eq(3).html()) + parseInt($('.display-customer').eq(4).html()) + parseInt($('.display-customer').eq(5).html()),
                totalCustomer3 = parseInt($('.display-customer').eq(6).html()) + parseInt($('.display-customer').eq(7).html()) + parseInt($('.display-customer').eq(8).html()),
                totalCustomer4 = parseInt($('.display-customer').eq(9).html()) + parseInt($('.display-customer').eq(10).html()) + parseInt($('.display-customer').eq(11).html());
           
            $('.total-supplier').eq(0).text(totalSupplier1);
            $('.total-supplier').eq(1).text(totalSupplier2);
            $('.total-supplier').eq(2).text(totalSupplier3);
            $('.total-supplier').eq(3).text(totalSupplier4);
            
            $('.total-customer').eq(0).text(totalCustomer1);
            $('.total-customer').eq(1).text(totalCustomer2);
            $('.total-customer').eq(2).text(totalCustomer3);
            $('.total-customer').eq(3).text(totalCustomer4);
                       
        }
    });
}

/**
 * Cambio de los colores de los tr dependiendo del color del ticket
 * @returns {void}
 */
function changeBackground()
{
    $('#tbl-datatable tbody tr').each(function(i){
        $('#tbl-datatable tbody tr')
                .eq(i)
                .css('background', $(this).find('td').find('input[name="color[]"]').val());
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

$(document).on('ready', function(){
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
});