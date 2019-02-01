$("#submit").on('click', function(event){
event.preventDefault();
$.ajax({
    url: '',
    data: { fdate:$('#fdate').val() , tdate:$('#tdate').val() , store:$('#storeId').val(),option1:$('#option1').val()},
    type : 'POST',
    }).done(function(response){
        if(response.data ==""){
           /* bootbox.alert({ 
                size: 'small',
                message: "No Result Found", 
                callback: function(){ /* your callback code  }
            });*/
          //  $("#item-chart").html("");
            $('#alert-message').removeClass("hidden");
            return false;
        }

        $("#item-chart").html("");
        $("#item1-chart").html("");
        $("#alert-message").html("");

        var store = $('#storeId').val();
        var temp1 = $('#option1').val();
       
        if(temp1 == 'Sales'){
            $( "#report-chart" ).removeClass( "hidden" );
                var arr = response.data;
                var area = new Morris.Area({
                    element: 'item-chart',
                    resize: true,
                    data: arr,
                    fillOpacity: 0.3,
                    xkey: 'date',
                    xLabelAngle: 60,
                    parseTime: false,
                    ykeys: ['total'],
                    labels: ['Sales'],
                    lineColors:[ '#03c3c4'],
                    resize: true,
                    pointStrokeColors:[ '#' + Math.random().toString(16).slice(2, 8).toUpperCase()],
                    hideHover: 'auto',
                    //xLabels: ["day","week","month","year"],
                    pointSize : '0px'
                });

        }
        if(temp1 == 'Customer'){
            $( "#report-chart" ).removeClass( "hidden" );
            var arr = response.data;
            var area = new Morris.Area({
                    element: 'item-chart',
                    resize: true,
                    data: arr,
                    fillOpacity: 0.3,
                    xkey: 'date',
                    xLabelAngle: 60,
                    parseTime: false,
                    ykeys: ['total'],
                    labels: ['Customer'],
                    lineColors:[ '#428bca'],
                    resize: true,
                    pointStrokeColors:[ '#' + Math.random().toString(16).slice(2, 8).toUpperCase()],
                    hideHover: 'auto',
                    //xLabels: ["day","week","month","year"],
                    pointSize : '0px'
                });
        }
        if(temp1 == 'Void'){
           $( "#report-chart" ).removeClass( "hidden" );
            var arr = response.data;
            var area = new Morris.Area({
                    element: 'item-chart',
                    resize: true,
                    data: arr,
                    fillOpacity: 0.3,
                    xkey: 'date',
                    xLabelAngle: 60,
                    parseTime: false,
                    ykeys: ['total'],
                    labels: ['Void'],
                    lineColors:[ '#AF7AC5'],
                    resize: true,
                    pointStrokeColors:[ '#' + Math.random().toString(16).slice(2, 8).toUpperCase()],
                    hideHover: 'auto',
                    //xLabels: ["day","week","month","year"],
                    pointSize : '0px'
                });
        }
	
	});
});