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

