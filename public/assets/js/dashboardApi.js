jQuery(document).ready(function(){
    
    "use strict";

    function showTooltip(x, y, contents) {
    jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
        position: 'absolute',
        display: 'none',
        top: y + 5,
        left: x + 5
    }).appendTo("body").fadeIn(200);
    }
    
    /*****SIMPLE CHART*****/

    var fdate = $('#fdate').val();
    var tdate = $('#tdate').val();
    var date  = $('#date').val();
    var token  = $('#token').val();
    var sid  = $('#sid').val();
    $.ajax({
        url: '7daysSales?fdate='+fdate+'&tdate='+tdate+'&token='+token+'&sid='+sid,
        type: 'GET',
        success: function(result) {
            var arr = result.data;
            var newCust = new Array();
            for (var i = 0; i < arr.length; i++){
                newCust[i] = [arr[i].date, arr[i].total];
            }
            var area = new Morris.Area({
                    element: 'chart',
                    resize: true,
                    data: arr,
                    xkey: 'date',
                    xLabelAngle: 60,
                    parseTime: false,
                    ykeys: ['total'],
                    labels: ['Sales '],
                    lineColors:[ '#03c3c4'],
                    fillOpacity: 0.3,
                    preUnits : '$ ',
                    pointStrokeColors:[ '#' + Math.random().toString(16).slice(2, 8).toUpperCase()],
                    hideHover: 'auto'
            });
        }
    });
    $.ajax({
        url: '7daysCustomer?fdate='+fdate+'&tdate='+tdate+'&token='+token+'&sid='+sid,
        type: 'GET',
        success: function(result) {
            var arr = result.data;
            var newCust = new Array();
            for (var i = 0; i < arr.length; i++){
                newCust[i] = [arr[i].date, arr[i].total];
            }
            var area = new Morris.Area({
                    element: 'line-chart',
                    resize: true,
                    data: arr,
                    xkey: 'date',
                    xLabelAngle: 60,
                    parseTime: false,
                    ykeys: ['total'],
                    labels: ['Customer '],
                    lineColors:['#905dd1'],
                    fillOpacity: 0.3,
                    pointStrokeColors:[ '#' + Math.random().toString(16).slice(2, 8).toUpperCase()],
                    hideHover: 'auto'
            });
        }
    });

    /*$.ajax({
        url: '7daysCustomer?fdate='+fdate+'&tdate='+tdate,
        type: 'GET',
        success: function(result) {
            var arr = result.data;
            var newCust = new Array();
            for (var i = 0; i < arr.length; i++){
                newCust[i] = [arr[i].date, arr[i].total];
            }
            var line = new Morris.Line({
                    element: 'line-chart',
                    resize: true,
                    data: arr,
                    xkey: 'date',
                    ykeys: ['total'],
                    labels: ['Customer '],
                    lineColors:['#905dd1'],
                    hideHover: 'auto'
             });
        }
    });*/
    $.ajax({
        url: 'topCategory?fdate='+fdate+'&tdate='+tdate+'&token='+token+'&sid='+sid,
        type: 'GET',
        success: function(result) {
            var arr = result.data;
            var newCust = new Array();
            for (var i = 0; i < arr.length; i++){
                newCust[i] = [arr[i].date, arr[i].total];
            }
            var Bar = new Morris.Bar({
                    element: 'bar-chart',
                    resize: true,
                    data: arr,
                    xkey: 'category',
                    xLabelAngle: 30,
                    ykeys: ['total'],
                    labels: ['category '],
                    barColors: ['#bfff80'],
                    opacity: 0.3,
                    hideHover: 'auto'
            });
        }
    });
    // $.ajax({
    //  url: 'dailySales?fdate='+fdate+'&tdate='+tdate,
    //  type: 'GET',
    //  success: function(result) {
    //      var arr = result.data;
    //      var newCust = new Array();
    //      var color = new Array();
    //      for (var i = 0; i < arr.length; i++){
    //          newCust[i] = [arr[i].date, arr[i].total];
    //      }
    //      var Bar = new Morris.Bar({
 //                    element: 'daily-sales',
 //                    resize: true,
 //                    data: arr,
 //                    xkey: 'date',
 //                    xLabelAngle: 60,
 //                    ykeys: ['total_sale'],
    //                 labels: ['sales '],
 //                    barColors: ['#d699ff'],
 //                    hideHover: 'auto'
 //            });
    //  }
    // });
    $.ajax({
        url: 'topItem?fdate='+fdate+'&tdate='+tdate+'&token='+token+'&sid='+sid,
        type: 'GET',
        success: function(result) {
            var arr = result.data;
            var newCust = new Array();
            for (var i = 0; i < arr.length; i++){
                newCust[i] = [arr[i].date, arr[i].total];
            }
            var Bar = new Morris.Bar({
                    element: 'item-chart',
                    resize: true,
                    data: arr,
                    xkey: 'Item',
                    xLabelAngle: 30,
                    ykeys: ['Quantity'],
                    labels: ['Item'],
                    barColors: ['#ffcc99'],
                    opacity: 0.3,
                    hideHover: 'auto'
            });
            // Bar.options.data.forEach(function(label, i) {
            //         var legendItem = $('<span></span>').text( label['label'] + " ( " +label['value'] + " )" ).prepend('<br><span>&nbsp;</span>');
            //         legendItem.find('span')
            //           // .css('backgroundColor', donut.options.colors['#ffcc99'])
            //           .css('width', '20px')
            //           .css('display', 'inline-block')
            //           .css('margin', '5px');
            //         $('#legend').append(legendItem)
            //     });
        }
    });
    $.ajax({
        url: 'summary?fdate='+tdate+'&tdate='+tdate+'&token='+token+'&sid='+sid,
        type: 'GET',
        success: function(result) {
            var arr = result;
            var newCust = new Array();
            for (var i = 0; i < arr.length; i++){
                newCust[i] = [arr[i].date, arr[i].total];
            }
            var donut = new Morris.Donut({
                    element: 'sales-chart',
                    resize: true,
                    preUnits : '$ ',
                    colors: ["#80ff80", "#dfff80","#ff9f80","#cc99ff","#ff80ff","#ff8c66"," #dda8bb","#a3e4d7","#f0b27a","#85c1e9","#f9e79f","#45b39d ","#7fb3d5","#d4ac0d","#bfc9ca","#f5b041"],
                    data: [
                        {label: "Credit Card sale", value: arr[0]['ncreditcardsales']},
                        {label: "Tax Amount", value: arr[0]['ntaxtotal']},
                        {label: "Cash Pickup", value: arr[0]['npickup']},
                        {label: "Paid Out", value: arr[0]['npaidout']},
                        {label: "Opening Balance", value: arr[0]['nopeningbalance']},
                        {label: "Cash Added", value: arr[0]['naddcash']},
                        {label: "Cash Sales", value: arr[0]['ncashamount']},
                        {label: "Check Sales", value: arr[0]['ncheckamount']},
                        {label: "Debit Sales", value: arr[0]['ndebitsales']},
                        {label: "Discount", value: arr[0]['ndiscountamt']},
                        {label: "EBT Sales", value: arr[0]['nebtsales']},
                        {label: "Gift Sales", value: arr[0]['ngiftsales']},
                        {label: "Nontaxable Sales", value: arr[0]['nnontaxabletotal']},
                        {label: "Returns", value: arr[0]['nreturnamount']},
                        {label: "TaxableSale", value: arr[0]['ntaxable']}
                    ],
                    formatter: function (value, data) { return  '$ ' + value; },
                    hideHover: 'auto'
                });
                donut.options.data.forEach(function(label, i) {
                    var legendItem = $('<span></span>').text( label['label'] + " ( $ " +label['value'] + " )" ).prepend('<br><span>&nbsp;</span>');
                    legendItem.find('span')
                      .css('backgroundColor', donut.options.colors[i])
                      .css('width', '20px')
                      .css('display', 'inline-block')
                      .css('margin', '3px')
                      .css('vertical-align', 'middle');
                    $('#legend').append(legendItem)
                });
        }
    }); 
    $.ajax({
        url: 'customer?date='+date+'&token='+token+'&sid='+sid,
        type: 'GET',
        success: function(result) {
            var arr = result.data;
            var newCust = new Array();
            for (var i = 0; i < arr.length; i++){
                newCust[i] = [arr[i].date, arr[i].total];
            }
            var area = new Morris.Area({
                    element: 'cust-chart',
                    resize: true,
                    data: arr,
                    xkey: 'date',
                    xLabelAngle: 60,
                    parseTime: false,
                    ykeys: ['total'],
                    labels: ['Customer'],
                    lineColors:[ '#3c8dbc'],
                    fillOpacity: 0.3,
                    pointStrokeColors:[ '#' + Math.random().toString(16).slice(2, 8).toUpperCase()],
                    hideHover: 'auto'
            });
        }
    });

    setTimeout(function(){
        jQuery('#bar-chart svg').css('height','350px'); 
        jQuery('#item-chart svg').css('height','350px'); 
    }, 2000);
    
    
});