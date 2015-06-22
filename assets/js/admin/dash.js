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

var dialogDash, dialogDealsActive, dialogTotalUser, dialogNewUsers, dialogActiveUsers;

//creacion del modal
dialogDash = $( "#dialogDash-form" ).dialog({
   	autoOpen: false,
     height: "auto",
     width: "80%",
     modal: true,
	 dialogClass: 'dialogDash',
     /*buttons: {
        "Cerrar": function() {
          dialogDash.dialog( "close" );
        }
   	},*/
	buttons: [
        {
            text: "Cancelar",
            "class": 'dialogDashButtonCancel',
            click: function() {
                dialogDash.dialog( "close" );
            }
        }
    ],
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
    buttons: [
        {
            text: "Cancelar",
            "class": 'dialogDashButtonCancel',
            click: function() {
                dialogDash.dialog( "close" );
            }
        }
    ],
   	close: function() {
   	}
});

dialogTotalUser = $( "#dialogDashTotalUser" ).dialog({
   	autoOpen: false,
    height: "auto",
    width: "80%",
    modal: true,
	dialogClass: 'dialogDash',
    buttons: [
        {
            text: "Cancelar",
            "class": 'dialogDashButtonCancel',
            click: function() {
                dialogTotalUser.dialog( "close" );
            }
        }
    ],
   	close: function() {
   	}
});

dialogNewUsers = $( "#dialogDashNewUsers" ).dialog({
   	autoOpen: false,
    height: "auto",
    width: "80%",
    modal: true,
	dialogClass: 'dialogDash',
    buttons: [
        {
            text: "Cancelar",
            "class": 'dialogDashButtonCancel',
            click: function() {
                dialogNewUsers.dialog( "close" );
            }
        }
    ],
   	close: function() {
   	}
});

dialogActiveUsers = $( "#dialogDashActiveUsers" ).dialog({
   	autoOpen: false,
    height: "auto",
    width: "80%",
    modal: true,
	dialogClass: 'dialogDash',
    buttons: [
        {
            text: "Cancelar",
            "class": 'dialogDashButtonCancel',
            click: function() {
                dialogActiveUsers.dialog( "close" );
            }
        }
    ],
   	close: function() {
   	}
});

////////////////////index////////////////////////////

$(document).on('click','.btnShowDialogDash',function(){ showDialogDash($(this).attr('id')); });

$('#btnSearchTotalDeals').click(function(){ SearchTotalDeals($(this).attr('value')); });

$('#btnShowDealsActive').click(function(){ ShowDealsActive(); });

$('#btnShowTotalUser').click(function(){ showTotalUser(); });

$('#btnShowNewUsers').click(function(){ showNewUsers(); });

$('#btnShowActivesUsers').click(function(){ showActivesUsers(); });

////////////////////funciones////////////////////////

function showDialogDash(idBtn){
	//alert(idBtn)
	
	cleanFieldDealsByDate();
	
	$('#btnSearchTotalDeals').attr('value',idBtn)
	var url;
	if(idBtn == "dealsDescargado"){
		url	= "dashboard/getDealsDescargadosDate";
		//$('#dialogDash-form').attr('title','Deals descargados');
		$('#ui-id-1').html('Deals descargados');
		$('#typeNumberDeals').html('# Descargados');
	}else{
		url	= "dashboard/getDealsRedimidosDate";
		//$('#dialogDash-form').attr('title','Deals Redimidos');
		$('#ui-id-1').html('Deals Redimidos');
		$('#typeNumberDeals').html('# Redimidos');
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
						'<td>' + items[i].stock + '</td>' +
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
	
	//obtenemos la gecha de hoy
	var fecha = new Date();
	//var currentDate = (fecha.getFullYear() + "-" + (fecha.getMonth() +1) + "-" + fecha.getDate());
	var day = fecha.getDate();
	var month = (fecha.getMonth() +1);
	var year = fecha.getFullYear();
	if(day < 10){
		day = "0" + day;	
	}
	if(month < 10){
		month = "0" + month;
	}
	var currentDate = ( year + "-" + month + "-" + day);
	$('#txtDashEndDate').val(currentDate);
	//obtenemos la fecha de la semana pasada
	var lastWeek=new Date(fecha.getTime() - (24*60*60*1000)*7);
	
	var day = lastWeek.getDate();
	var month = (lastWeek.getMonth() +1);
	var year = lastWeek.getFullYear();
	if(day < 10){
		day = "0" + day;	
	}
	if(month < 10){
		month = "0" + month;
	}
	var lastWeekDate = ( year + "-" + month + "-" + day);
	
	$('#txtDashIniDate').val(lastWeekDate);
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
						'<td>' + items[i].stock + '</td>' +
						'<td>' + items[i].total + '</td>' +
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
	$('#txtSearchTypeUser').val('');
	
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
				var nameUser = "Sin nombre de usuario"
				if(items[i].name != null){
					nameUser = items[i].name;	
				}
				var lastDatesUser = "Sin ultima conexion"
				if(items[i].lastDate != null){
					lastDatesUser = items[i].lastDate;	
				}
				
				$('#tableModalTotalUser tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td>' + items[i].email + '</td>' +
						'<td>' + nameUser + '</td>' +
						'<td>' + lastDatesUser + '</td>' +
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

function showNewUsers(){
	dialogNewUsers.dialog( "open" );
	
	$.ajax({
		type: "POST",
		url: "dashboard/getInfoNewUser",
		dataType:'json',
		data:{
			cantidad:0
		},
		success: function(data){
			items = data.items;
			$('#tableModalNewUsers tbody').empty();
			for(i = 0;i<items.length;i++){
				var nameUser = "Sin nombre de usuario"
				if(items[i].name != null){
					nameUser = items[i].name;	
				}
				var lastDatesUser = "Sin ultima conexion"
				if(items[i].lastDate != null){
					lastDatesUser = items[i].lastDate;	
				}
				
				$('#tableModalNewUsers tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td>' + items[i].email + '</td>' +
						'<td>' + nameUser + '</td>' +
						'<td>' + lastDatesUser + '</td>' +
					'</tr>'
				);
			}
			
			totalItems = Math.ceil(data.total/10)
			
			if(data.total%10 == 0){
				totalItems = totalItems + 1;		
			}
			
			$('#paginatorDashNewUsers').html(
				'<li id="btnPaginatorDashNewUsers" value="0" class="btnPaginador arrow primero unavailable">' +
					'<a>&laquo;</a>' +
				'</li>'
			);
			
			for(i=1;i<=totalItems;i++){
				if(i == 1){
					$('#paginatorDashNewUsers').append(
						'<li id="btnPaginatorDashNewUsers" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#paginatorDashNewUsers').append(
						'<li id="btnPaginatorDashNewUsers" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#paginatorDashNewUsers').append(
				'<li id="btnPaginatorDashNewUsers" value="' + (totalItems) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
			
        },
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});	
}

//muestra la informacion de los usuarios activos
function showActivesUsers(){
	dialogActiveUsers.dialog( "open" );
	
	$.ajax({
		type: "POST",
		url: "dashboard/getInfoActiveUser",
		dataType:'json',
		data:{
			cantidad:0
		},
		success: function(data){
			items = data.items;
			$('#tableModalActiveUsers tbody').empty();
			for(i = 0;i<items.length;i++){
				var nameUser = "Sin nombre de usuario"
				if(items[i].name != null){
					nameUser = items[i].name;	
				}
				var lastDatesUser = "Sin ultima conexion"
				if(items[i].lastDate != null){
					lastDatesUser = items[i].lastDate;	
				}
				
				$('#tableModalActiveUsers tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td>' + items[i].email + '</td>' +
						'<td>' + nameUser + '</td>' +
						'<td>' + lastDatesUser + '</td>' +
					'</tr>'
				);
			}
			
			totalItems = Math.ceil(data.total/10)
			
			if(data.total%10 == 0){
				totalItems = totalItems + 1;		
			}
			
			$('#paginatorDashActiveUsers').html(
				'<li id="btnPaginatorDashActiveUsers" value="0" class="btnPaginador arrow primero unavailable">' +
					'<a>&laquo;</a>' +
				'</li>'
			);
			
			for(i=1;i<=totalItems;i++){
				if(i == 1){
					$('#paginatorDashActiveUsers').append(
						'<li id="btnPaginatorDashActiveUsers" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#paginatorDashActiveUsers').append(
						'<li id="btnPaginatorDashActiveUsers" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#paginatorDashActiveUsers').append(
				'<li id="btnPaginatorDashActiveUsers" value="' + (totalItems) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
			
        },
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});
}