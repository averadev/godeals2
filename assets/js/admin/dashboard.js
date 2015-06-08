// JavaScript Document

/**********variables**********/
var contDiv = 0;
var moth= ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
var idPartner = 0;
var partner = "";
var numPartner = 0;
var numPartner2 = 0;
var numPartnerDate = 0;

/********eventos*************/
$('#addNewDateAll').click(function(){ addDateAll(); });
$('#addNewPartner').click(function(){ addPartner(); });
$(document).on('click','.btnDatePartner',function(){ addDatePartner($(this).attr('id')); })

$(document).on('click','#btnCancelDate',function(){ cancelDate(); })
$('#btnAceptDate').click(function(){ aceptDate(); });
$('#btnAceptPartnerDate').click(function(){ aceptPartnerDate(); });

$('#btnAceptPartner').click(function(){ aceptPartner(); });

$(document).on('click','.imgDeleteDeals',function(){ deleteReportDeals($(this).attr('id')); });

$(document).on('click','.btnDeletePartner',function(){ DeletePartnerDeals($(this).attr('id')); });

$(document).on('click','.btnDeleteDealsByPartnerAndDate',function(){ deleteDealsByPartnerAndDate($(this).attr('id')); });

$('#btnReportDeals').click(function(){ 

	var AllDeals = new Array();
	var AllDealsByDate = new Array();
	var PartnerDeals = new Array();

	if( $('#check1').is(':checked') ) {
		$('.AllDeals').each(function(index, element) {
          //  console.log($(this).text().trim());
		  	AllDeals.push($(this).text().trim())
        });
		
		$('.AllDealsByDate').each(function(index, element) {
           	var dateD = $(this).find('#textHeaderDeals').text().trim();
			var downloadD = $(this).find('#DealsDownloads').text().trim();
			var redimirD = $(this).find('#DealsRedimir').text().trim();
			
			AllDealsByDate.push(dateD + "-" + downloadD + "-" + redimirD);
        });
	}
	
	if( $('#check2').is(':checked') ) {
		$('.contentDealsByPartner').each(function(index, element) {
			var PartnerName = $(this).find('.headerPartnerDeals').text().trim();
			var partnerD = $(this).find('#partnerDownload').text().trim();
           	var partnerR = $(this).find('#partnerRedimir').text().trim();
			var PartnerData = PartnerName + "-" + partnerD + "-" + partnerR;
			
			//PartnerDeals.push(PartnerName + "-" + partnerD + "-" + partnerR);
			
			$(this).find('.PartnerDealsDate').each(function(index, element) {
                var PartnerDate = $(this).find('#textHeaderDeals').text().trim();
				var partnerDD = $(this).find('#PartnerDateDownload').text().trim();
				var partnerDR = $(this).find('#PartnerDateRedimir').text().trim();
				//PartnerDeals = PartnerDeals + "-" + PartnerDate + "_" + partnerDD + "_" + partnerDR;
				 PartnerData = PartnerData + "*"  + PartnerDate + "_" + partnerDD + "_" + partnerDR;
            })
			
			PartnerDeals.push(PartnerData);
			
        });
	}
	
	$('#reportAllDeas').val(AllDeals);
	$('#reportAllDeasDate').val(AllDealsByDate);
	$('#reportPartnerDeas').val(PartnerDeals);
	
	$('#formReport').submit();
});

$('.checkOptionDeals').change(function(){ changeCheckBox(this); });

$("#txtPartner").keyup(function() { finderAutocomplete(); });

//muestra u oculta los busquedas
function changeCheckBox(selector){
	var id = $(selector).attr('id');
	if( $(selector).is(':checked') ) {
   		if(id == "check1"){
			$('#AllDeals').show();	
		}else{
			$('#DealsByPartner').show();
		}
	}else{
		if(id == "check1"){
			$('#AllDeals').hide();	
		}else{
			$('#DealsByPartner').hide();
		}
	}
}

//muestra el modal para escoger la fecha
function addDateAll(){
	$('#btnAceptPartnerDate').hide();
	$('#btnAceptDate').show();
	$('#contentModalPartner').hide();
	$('#contentModalDate').show();
	$('#modalDate').show();
}

function addPartner(){
	$('#contentModalDate').hide();
	$('#contentModalPartner').show();
	$('#modalDate').show();
}

function addDatePartner(idPartner){
	numPartner = idPartner;
	$('#btnAceptDate').hide();
	$('#btnAceptPartnerDate').show();
	$('#contentModalPartner').hide();
	$('#contentModalDate').show();
	$('#modalDate').show();
}

//esconde el modal para escoger fecha
function cancelDate(){
	$('#modalDate').hide();
}

//realiza la consulta por fecha
function aceptDate(){
	
	$('loandingDate').show();
	
	result = validateDate();
	
	if(result){
		
		$.ajax({
			type: "POST",
			url: "dashboard/getDownloadByDate",
			dataType:'json',
			data: { 
				iniDate:$('#dtIniDate').val(),
				endDate:$('#dtEndDate').val()
			},
			success: function(data){
				$('#modalDate').hide();
				createDealsByDate($('#dtIniDate').val(),$('#dtEndDate').val(),data);
				cleanFieldDate();
				$('loandingDate').hide();
			
			},
			error: function(data){
				alert("Error al mostrar la informacion. Por Favor Vuelva a intentarlo")	
				$('loandingDate').hide();
			}
		});
		
		
			
	}
}

//pinta el reporte de deals
function createDealsByDate(iniDate,endDate,items){
	
	var str = iniDate;
	var res = str.split("-");
	iniDate = res[2] + " " + moth[parseInt(res[1])] + " " + res[0];
	
	var str = endDate;
	var res = str.split("-");
	endDate = res[2] + " " + moth[parseInt(res[1])] + " " + res[0];
	
	$('#newDateAll').append(
	'<div style="float:left;" class="small-11 medium-6 large-6 columns AllDealsByDate" id="Deals' + contDiv +'">' +
		'<div class="small-11 medium-6 large-12 columns headerDealsAll">' + 
		'<div id="textHeaderDeals">Deals de ' + iniDate + ' a ' + endDate + '</div>' +
			'<div class="imgNewDateDeals" id="removeNewDateAll">' +
				'<img src="assets/img/web/delete_icon&48.png" class="imgDeleteDeals" id="' + contDiv + '" />' +
			'</div>' +
		'</div>' +
		'<div class="small-11 medium-12 large-12 columns">' + 
			'<div class="small-12 medium-6 large-6 columns divContentDeals">' + 
				'<div class="textContentDeals">Deals descargados</div>' + 
				'<div class="contentDeals" id="DealsDownloads">' + items.downloads.length +' Deals</div>' + 
			'</div>' + 
			'<div class="small-12 medium-6 large-6 columns divContentDeals" style="float:left;">' + 
				'<div class="textContentDeals">Deals redimidos</div>' + 
				'<div class="contentDeals" id="DealsRedimir">' + items.redimir.length +' Deals</div>' + 
			'</div>' +
		'</div>' +
	'</div>'
	);
	
	contDiv++;
}

//elimina el reporte de deals selecionado
function deleteReportDeals(num){
	$('#Deals' + num).remove();
}

//valida los campos de fecha
function validateDate(){
	
	var result = true;
	
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();

	if(dd<10) {
   		dd='0'+dd
	} 

	if(mm<10) {
    	mm='0'+mm
	} 

	today = yyyy+'-'+mm+'-'+dd;
	
	hideAlert();
	
	if($('#dtEndDate').val().trim().length == 0){
		$('#alertEndDate').html("Campo Vacio.");
		$('#alertEndDate').show();
		$('#labelEndDate').addClass('error');
		$('#dtEndDate').focus();
		result = false;	
	}else if($('#dtEndDate').val() < $('#dtIniDate').val()){
		$('#alertEndDate').html("Fecha menor a la inicial.");
		$('#alertEndDate').show();
		$('#labelEndDate').addClass('error');
		$('#dtEndDate').focus();
		result = false;
	}
	
	if($('#dtIniDate').val().trim().length == 0){
		$('#alertIniDate').html("Campo Vacio.");
		$('#alertIniDate').show();
		$('#labelIniDate').addClass('error');
		$('#dtIniDate').focus();
		result = false;	
	}
	
	return result;
	
}

function hideAlert(){
	$('#labelEndDate').removeClass('error');
	$('#labelIniDate').removeClass('error');
	$('#labelPartner').removeClass('error');
	
	$('#alertEndDate').hide();
	$('#alertIniDate').hide();
	$('#alertPartner').hide();
}

function cleanFieldDate(){
	$('#dtIniDate').val("");
	$('#dtEndDate').val("");
	$('#txtPartner').val("");
}

//realiza la consulta por comercio
function aceptPartner(){
	result = validatePartner();
	
	if(result){
		var valorPartner = $('#txtPartner').val();
		var idPartner = $('datalist option[value="' + valorPartner + '"]').attr('id');
		
		$.ajax({
			type: "POST",
			url: "dashboard/getDealsByPartner",
			dataType:'json',
			data: { 
				idPartner:idPartner
			},
			success: function(data){
				
				$('#modalDate').hide();
				createDealsPartner(valorPartner,idPartner,data)
				cleanFieldDate();
			
			},
			error: function(data){
				alert("Error al mostrar la informacion. Por Favor Vuelva a intentarlo")	
				$('loandingDate').hide();
			}
		});
		
	}
}

//crea el comercio selecionado
function createDealsPartner(partner,idPartner,items){
	
	$('#contenDealsPartner').append(
		'<div class="small-11 medium-12 large-12 columns contentDealsByPartner" id="partner' + numPartner2 +'">' +
			'<div class="small-12 medium-12 large-12 columns">&nbsp;</div>' +
			'<div class="small-11 medium-12 large-8 columns headerPartnerDeals" style="float:left;">' +
				'' + partner + '' +
				'<div class="imgNewDateDeals" id="removeNewPartner">' +
					'<img src="assets/img/web/delete_icon&48.png" height="100%" width="100%" id="' + numPartner2 + '" class="btnDeletePartner"/>' +
				'</div>' +
				'<div class="imgNewDateDeals2" id="addNewDatePartner">' +
					'<img src="assets/img/web/calendar_2_icon&48.png" height="100%" width="100%" id="' + numPartner2 + '" class="btnDatePartner"/>' +
				'</div>' +
			'</div>' +
			'<div class="small-11 medium-12 large-12 columns">' +
				'<div class="small-12 medium-6 large-3 columns divContentDeals">' +
					'<div class="textContentDeals">Deals descargados</div>' +
					'<div class="contentDeals" id="partnerDownload">' + items.downloads.length + ' Deals</div>' +
				'</div>' +
				'<div class="small-12 medium-6 large-3 columns divContentDeals" style="float:left;">' +
					'<div class="textContentDeals">Deals redimidos</div>' +
					'<div class="contentDeals" id="partnerRedimir">' + items.redimir.length + ' Deals</div>' +
				'</div>' +
			'</div>' +
			'<div class="small-12 medium-12 large-12 columns">&nbsp;</div>' +
			'<div class="DealsReport" id="partnerD' + numPartner2 + '"></div>' +
		'</div>'
	);
	
	numPartner2++;
}

function validatePartner(){
	result = true;
	
	hideAlert();
	
	//valida que se haya selecionado un comercio
	valorPartner = $('#txtPartner').val().trim();
	idPartner = $('datalist option[value="' + valorPartner + '"]').attr('id');
	//valida que el partner selecionado no este vacio y que exista
	if(idPartner == undefined){
		$('#alertPartner').show();
		$('#labelPartner').addClass('error');
		$('#txtPartner').focus();
		result = false;
	}
	
	return result;	
}

//elimina el cuadro de partner selecionado
function DeletePartnerDeals(idPartner){
	$('#partner' + idPartner).remove();
}

function aceptPartnerDate(){
	
	$('loandingDate').show();
	
	result = validateDate();
	
	if(result){
		
		$.ajax({
			type: "POST",
			url: "dashboard/getDealsByPartnerAndDate",
			dataType:'json',
			data: { 
				idPartner:idPartner,
				iniDate:$('#dtIniDate').val(),
				endDate:$('#dtEndDate').val()
			},
			success: function(data){
				console.log(data)
				
				$('#modalDate').hide();
				createDealsByPartnerAndDate($('#dtIniDate').val(),$('#dtEndDate').val(),data)
				cleanFieldDate();
			
			},
			error: function(data){
				alert("Error al mostrar la informacion. Por Favor Vuelva a intentarlo")	
				$('loandingDate').hide();
			}
		});
		
		
		/*$('#modalDate').hide();
		createDealsByPartnerAndDate()
		cleanFieldDate();*/
	}
	
}

function createDealsByPartnerAndDate(iniDate,endDate,items){
	
	var str = iniDate;
	var res = str.split("-");
	iniDate = res[2] + " " + moth[parseInt(res[1])] + " " + res[0];
	
	var str = endDate;
	var res = str.split("-");
	endDate = res[2] + " " + moth[parseInt(res[1])] + " " + res[0];
	
	$('#partnerD' + numPartner).append(
		'<div class="small-12 medium-6 large-6 columns PartnerDealsDate" id="datePartner' + numPartnerDate + '" style="float:left">	' +
			'<div class="small-12 medium-6 large-12 columns headerPartnerDateDeals">' +
				'<div id="textHeaderDeals">Deals de ' + iniDate + ' a ' + endDate + '</div>' +
				'<div class="imgNewDatePartnerDeals" id="removeNewDateAll">' +
					'<img src="assets/img/web/delete_icon&48.png" class="btnDeleteDealsByPartnerAndDate" id="' + numPartnerDate + '"  height="100%" width="100%"/>' +
				'</div>' +
			'</div>' +
			'<div class="small-12 medium-12 large-12 columns">' +
				'<div class="small-12 medium-6 large-6 columns divContentDeals">' +
					'<div class="textContentDeals txtdatePartner">Deals descargados</div>' +
						'<div class="contentDeals" id="PartnerDateDownload">' + items.downloads.length + ' Deals</div>' +
					'</div>' +
				'	<div class="small-12 medium-6 large-6 columns divContentDeals" style="float:left;">' +
						'<div class="textContentDeals txtdatePartner">Deals redimidos</div>' +
						'<div class="contentDeals" id="PartnerDateRedimir">' + items.redimir.length +' Deals</div>' +
					'</div>' +
				'</div>' +
			'</div>' + 
		'</div>' 
	);
	
	numPartnerDate++;
	
}

//elimina el cuadro delecionado
function deleteDealsByPartnerAndDate(id){
	$('#datePartner' + id).remove();
}

//autocompletar de comercio
function finderAutocomplete(){
	$.ajax({
		type: "POST",
		url: "partners/getPartner",
		dataType:'json',
		data: {
			dato:$("#txtPartner").val()
		},
		success: function(data){
				$('#partnerList').empty();
				for(var i = 0;i<data.length;i++){
					$('#partnerList').append(
						"<option id='" + data[i].id + "' value='" +  data[i].name + "' />"
					);
				}
        }
	});	
}

/***********genera los reportes*****************/
function generateReportDeals(){
	
	$.ajax({
			type: "POST",
			url: "dashboard/createReportDeals",
			dataType:'json',
			data: { 
				datos:""
			},
			success: function(data){
				alert("hola")
				window.open('http://http://localhost:8080/4beta/dashboard','_blank' );
			},
			error: function(data){
				//alert("Error al mostrar la informacion. Por Favor Vuelva a intentarlo")
				window.open('http://http://localhost:8080/4beta/dashboard/createReportDeals','_blank' );
			}
		});
	
}
