/**
 * Inicializando datatable
 * @returns {void}
 */
function initDatatable(date, option)
{
    if (!date) date = '';
    if (!option) option = '';
    var oTable = $('#example').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"lfr>t<"F"ip>',
        "bDestroy": true,
        "bInfo":false,
        "bAutoWidth": false,
        "bProcessing": true,
        "sAjaxSource": '/ticket/datatable?date=' + date + '&option=' + option,
        "sAjaxDataProp": "aaData"
        
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

function getData(date)
{
    $.ajax({
        type:'POST',
        url:'/ticket/ajaxstatistics',
        dataType:'json',
        data:{'date':date},
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



$(document).on('ready', function(){
    $('.date').datepicker({
        'dateFormat':'yy-mm-dd',
        'changeYear':true,
        'changeMonth':true,
        'maxDate':'0'
    });
    
    // Carga de los datos al cargar el documento
    getData(null);
    
    // Carga de los datos al introducir una fecha
    $(document).on('change', function(){
        getData($(this).val());
    });
    
    $(document).on('change', '.date, input[type="radio"]', function(){
        initDatatable($('.date').val(), $('input[type="radio"]:checked').val());
    });
    
    initDatatable();
    
//    initHighChart();
});