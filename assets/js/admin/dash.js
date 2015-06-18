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

var dialogDash, dialogDealsActive, dialogTotalUser;

//creacion del modal
dialogDash = $( "#dialogDash-form" ).dialog({
   	autoOpen: false,
     height: "auto",
     width: "80%",
     modal: true,
	 dialogClass: 'dialogDash',
     buttons: {
        "Terminado": function() {
          dialogDash.dialog( "close" );
        }
   	},
   	close: function() {
   	}
});

//$(".ui-dialog-titlebar").hide();

dialogDealsActive = $( "#dialogDashDealsActive" ).dialog({
   	autoOpen: false,
    height: "auto",
    width: "80%",
    modal: true,
	dialogClass: 'dialogDash',
    buttons: {
        "Terminado": function() {
          dialogDealsActive.dialog( "close" );
        }
   	},
   	close: function() {
   	}
});

dialogTotalUser = $( "#dialogDashTotalUser" ).dialog({
   	autoOpen: false,
    height: "auto",
    width: "80%",
    modal: true,
	dialogClass: 'dialogDash',
    buttons: {
        "Terminado": function() {
          dialogTotalUser.dialog( "close" );
        }
   	},
   	close: function() {
   	}
});

////////////////////index////////////////////////////

$(document).on('click','.btnShowDialogDash',function(){ showDialogDash($(this).attr('id')); });

$('#btnSearchTotalDeals').click(function(){ SearchTotalDeals($(this).attr('value')); });

$('#btnShowDealsActive').click(function(){ ShowDealsActive(); });

$('#btnShowTotalUser').click(function(){ showTotalUser(); });

////////////////////funciones////////////////////////

function showDialogDash(idBtn){
	//alert(idBtn)
	
	cleanFieldDealsByDate();
	
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
		dato4 = 1
	}else{
		url	= "dashboard/getDealsRedimidosDate";
		dato4 = 2
	}
	getDealsByDate($('#txtDashIniDate').val(),$('#txtDashEndDate').val(),1,url);
}

function getDealsByDate(iniDate,endDate,type,url){
	
	dato2 = iniDate;
	dato3 = endDate;
	
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
			items = data.items;
			$('#tableDashModal tbody').empty();
			for(i = 0;i<items.length;i++){
				$('#tableDashModal tbody').append(
					'<tr>' +
						'<td>' + (i+1) + '</td>' +
						'<td>' + items[i].descripcion + '</td>' +
						'<td>' + items[i].name + '</td>' +
						'<td>' + items[i].total + '</td>' +
					'</tr>'
				);
			}
			
			//paginatorDealsByDate
			
			totalItems = Math.ceil(data.total/10)
			
			if(data.total%10 == 0){
				totalItems = totalItems + 1;		
			}
			
			$('#paginatorDashDealsByDate').html(
				'<li id="btnPaginatorDashDealsByDate" value="0" class="btnPaginador arrow primero unavailable">' +
					'<a>&laquo;</a>' +
				'</li>'
			);
			
			for(i=1;i<=totalItems;i++){
				if(i == 1){
					$('#paginatorDashDealsByDate').append(
						'<li id="btnPaginatorDashDealsByDate" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#paginatorDashDealsByDate').append(
						'<li id="btnPaginatorDashDealsByDate" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#paginatorDashDealsByDate').append(
				'<li id="btnPaginatorDashDealsByDate" value="' + (totalItems) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
			
        },
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});	
}

function cleanFieldDealsByDate(){
	dato2 = "";
	dato3 = "";	
	dato4 = "";
	$('#txtDashIniDate').val("");
	$('#txtDashEndDate').val("");
}

//muestra los deals activos

function ShowDealsActive(){
	dialogDealsActive.dialog( "open" );
	
	$.ajax({
		type: "POST",
		url: "dashboard/getInfoDealsActivos",
		dataType:'json',
		data:{
			cantidad:0
		},
		success: function(data){
			items = data.items;
			$('#tableModalDealsActive tbody').empty();
			for(i = 0;i<items.length;i++){
				$('#tableModalDealsActive tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td>' + items[i].name + '</td>' +
						'<td>' + items[i].partnerName + '</td>' +
						'<td>' + items[i].total + '</td>' +
						'<td>' + items[i].stock + '</td>' +
					'</tr>'
				);
			}
			
			//paginatorDealsByDate
			
			totalItems = Math.ceil(data.total/10)
			
			if(data.total%10 == 0){
				totalItems = totalItems + 1;		
			}
			
			$('#paginatorDashDealsActive').html(
				'<li id="btnPaginatorDashDealsActive" value="0" class="btnPaginador arrow primero unavailable">' +
					'<a>&laquo;</a>' +
				'</li>'
			);
			
			for(i=1;i<=totalItems;i++){
				if(i == 1){
					$('#paginatorDashDealsActive').append(
						'<li id="btnPaginatorDashDealsActive" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#paginatorDashDealsActive').append(
						'<li id="btnPaginatorDashDealsActive" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#paginatorDashDealsActive').append(
				'<li id="btnPaginatorDashDealsActive" value="' + (totalItems) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
			
        },
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});	
}

//muestra una lista con el total de usuarios en la app
function showTotalUser(){
	dialogTotalUser.dialog( "open" );
	
	$.ajax({
		type: "POST",
		url: "dashboard/getInfoTotalUser",
		dataType:'json',
		data:{
			cantidad:0
		},
		success: function(data){
			items = data.items;
			$('#tableModalTotalUser tbody').empty();
			for(i = 0;i<items.length;i++){
				$('#tableModalTotalUser tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td>' + items[i].email + '</td>' +
						'<td>' + items[i].name + '</td>' +
					'</tr>'
				);
			}
			
			totalItems = Math.ceil(data.total/10)
			
			if(data.total%10 == 0){
				totalItems = totalItems + 1;		
			}
			
			$('#paginatorDashTotalUser').html(
				'<li id="btnPaginatorDashTotalUser" value="0" class="btnPaginador arrow primero unavailable">' +
					'<a>&laquo;</a>' +
				'</li>'
			);
			
			for(i=1;i<=totalItems;i++){
				if(i == 1){
					$('#paginatorDashTotalUser').append(
						'<li id="btnPaginatorDashTotalUser" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#paginatorDashTotalUser').append(
						'<li id="btnPaginatorDashTotalUser" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#paginatorDashTotalUser').append(
				'<li id="btnPaginatorDashTotalUser" value="' + (totalItems) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
			
        },
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});	
}