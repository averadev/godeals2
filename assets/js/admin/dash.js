// JavaScript Document

$(function() {
    
    getNewUsuariosAll();
    getActivesAll();
    getDownloadAll();
    getRedimidosAll();
});

// funcion que crea una grafica estadistica
function getNewUsuariosAll(){
	$.ajax({
		type: "POST",
		url: "dashboard/getNewUsuariosAll",
		dataType:'json',
		success: function(data){
			var ctxNewUsers = {
                    labels: data.label,
                    datasets: [
                        {
                            label: "My Second dataset",
                            fillColor: "rgba(151,187,205,0.2)",
                            strokeColor: "rgba(151,187,205,1)",
                            pointColor: "rgba(151,187,205,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(151,187,205,1)",
                            data: data.total
                        }
                    ]
                };	
                var ctx = document.getElementById("ctxNewUsers").getContext("2d");
                var myLineChart = new Chart(ctx).Line(ctxNewUsers, { bezierCurve: false });
        }
	});
}

// funcion que crea una grafica estadistica
function getActivesAll(){
	$.ajax({
		type: "POST",
		url: "dashboard/getActivesAll",
		dataType:'json',
		success: function(data){
			var ctxActives = {
                labels: data.label,
                datasets: [
                    {
                        label: "My Second dataset",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: data.total
                    }
                ]
            };	
            var ctx = document.getElementById("ctxActives").getContext("2d");
            var myLineChart = new Chart(ctx).Line(ctxActives, { bezierCurve: false });
        }
	});
}

// funcion que crea una grafica estadistica
function getDownloadAll(){
	$.ajax({
		type: "POST",
		url: "dashboard/getDownloadAll",
		dataType:'json',
		success: function(data){
			var ctxDealDownloaded = {
                labels: data.label,
                datasets: [
                    {
                        label: "My Second dataset",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: data.total
                    }
                ]
            };	
            var ctx = document.getElementById("ctxDealDownloaded").getContext("2d");
            var myLineChart = new Chart(ctx).Line(ctxDealDownloaded, { bezierCurve: false });
        }
	});
}

// funcion que crea una grafica estadistica
function getRedimidosAll(){
	$.ajax({
		type: "POST",
		url: "dashboard/getRedimidosAll",
		dataType:'json',
		success: function(data){
			var ctxDealDReden = {
                labels: data.label,
                datasets: [
                    {
                        label: "My Second dataset",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: data.total
                    }
                ]
            };	
            var ctx = document.getElementById("ctxDealDReden").getContext("2d");
            var myLineChart = new Chart(ctx).Line(ctxDealDReden, { bezierCurve: false });
        }
	});
}


/////////////////////////////////////////////////////
/////////////////////MODAL///////////////////////////
/////////////////////////////////////////////////////

var dialogDash;

//creacion del modal
dialogDash = $( "#dialogDash-form" ).dialog({
   	autoOpen: false,
     height: "auto",
     width: "80%",
     modal: true,
     buttons: {
        Cancel: function() {
          dialogDash.dialog( "close" );
        }
   	},
   	close: function() {
   	}
});

////////////////////index////////////////////////////

$(document).on('click','.btnShowDialogDash',function(){ showDialogDash($(this).attr('id')); });

$('#btnSearchTotalDeals').click(function(){ SearchTotalDeals($(this).attr('value')); });

////////////////////funciones////////////////////////

function showDialogDash(idBtn){
	//alert(idBtn)
	$('#txtDashIniDate').val("");
	$('#txtDashEndDate').val("");
	$('#btnSearchTotalDeals').attr('value',idBtn)
	var url;
	if(idBtn == "dealsDescargado"){
		url	= "dashboard/getDealsDescargadosDate";
	}else{
		url	= "dashboard/getDealsRedimidosDate";
	}
	getDealsByDate(1,1,0,url);
	
}

function SearchTotalDeals(idBtn){
	var url;
	if(idBtn == "dealsDescargado"){
		url	= "dashboard/getDealsDescargadosDate";
	}else{
		url	= "dashboard/getDealsRedimidosDate";
	}
	getDealsByDate($('#txtDashIniDate').val(),$('#txtDashEndDate').val(),1,url);
}

function getDealsByDate(iniDate,endDate,type,url){
	dialogDash.dialog( "open" );
	$.ajax({
		type: "POST",
		url: url,
		dataType:'json',
		data:{
			iniDate:iniDate,
			endDate:endDate,
			type:type
		},
		success: function(data){
			$('#tableDashModal tbody').empty();
			for(i = 0;i<data.length;i++){
				$('#tableDashModal tbody').append(
					'<tr>' +
						'<td>' + data[i].name + '</td>' +
						'<td>' + data[i].total + '</td>' +
					'</tr>'
				);
			}
        }
	});	
}