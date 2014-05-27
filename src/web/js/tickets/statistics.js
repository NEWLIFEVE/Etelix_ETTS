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
 * Inicializando gráficos estadísticos
 * @returns {void}
 */
function initHighChart()
{
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                        enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Statisctics'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Percentage',
            data: getDataPieChart()
        }]
    });
}

/**
 * Retorna un array de las estadísticas
 * @returns {Array}
 */
function getDataPieChart()
{
    var data = $.parseJSON($.ajax({
        type:'POST',
        url:'/ticket/ajaxstatistics',
        dataType:'json',
        async: false,
        data:{
            date:$('#date').val()
        }
    }).responseText);
    
    var result = [];

    for(var i in data)
        result.push([i, data[i]]);
    
    return result;
}

/**
 * Retorna la cantidad de tickets por categoria
 * @param {string} date
 * @param {string} carrier
 * @returns {void}
 */
function getData(date, carrier)
{
    $.ajax({
        type:'POST',
        url:'/ticket/ajaxstatistics',
        dataType:'json',
        data:{'date':date, 'carrier':carrier},
        success:function(data) {
            $('.display-data').eq(0).text(data.ticketPendingWhite);
            $('.display-data').eq(1).text(data.ticketCloseWhite);
            $('.display-data').eq(2).text(data.ticketPendingYellow);
            $('.display-data').eq(3).text(data.ticketCloseYellow);
            $('.display-data').eq(4).text(data.ticketPendingRed );
            $('.display-data').eq(5).text(data.ticketCloseRed);
            $('.display-data').eq(6).text(data.ticketWithoutDescription);
            $('.set-total').eq(0).text(data.totalPending);
            $('.set-total').eq(1).text(data.totalClosed);
        }
    });
}

/**
 * Cambio de los colores de los tr dependiendo de la categoria del ticket
 * @returns {void}
 */
function changeBackground()
{
    var radio = $('input[type="radio"]:checked').val()
    switch(radio) {
         case '1': case '5': $('#tbl-datatable tr').css('background', 'white'); break;

         case '2': case '6': $('#tbtbl-datatablel-datatable tr').css('background', 'yellow'); break;

         case '3': case '7': $('#tbl-datatable tr').css('background', 'pink'); break;

    }
}

$(document).on('ready', function(){
    $('.date').datepicker({
        'dateFormat':'yy-mm-dd',
        'changeYear':true,
        'changeMonth':true,
        'maxDate':'0'
    });
    
    // Carga de los datos al cargar el documento
    getData(null, null);
   
    // Carga de los datos al introducir una fecha
    $(document).on('change', '.date, #select-carrier', function(){
        getData($('.date').val(), $('#select-carrier').val());
    });
    
    $(document).on('change', '.date, input[type="radio"], #select-carrier', function(){
        initDatatable($('.date').val(), $('input[type="radio"]:checked').val(), $('#select-carrier').val());
    });
    
    // Inicializando datatable
    initDatatable();
});