// JavaScript Document

////////////GLOBAL////////////////

var tipeEditReward = 1;
var addDealsReward = true;
var statusType = ["Borrador","Espera de autorizacion","Autorizado","Publicado"];
var idStatusAuthorization = 1;
var RewardRechazado = 1;
var flagStatus = 0;

/***********************************************************/
/*****************Nombre del encabezado*********************/
/***********************************************************/

$(document).on('click','.btnSubMenu',function(){ changeNameLealtad(this); });

function changeNameLealtad(selector){
	flagStatus = 0;
	//alert($(selector).attr('id'))
	if($(selector).attr('id') == "catalogCampana"){
		tipeEditReward = 1;
		$('.headerScreen').html('Campañas de Lealtad');
	}else if($(selector).attr('id') == "CatalogReward"){
		tipeEditReward = 2;
		$('.headerScreen').html('Recompensas de Lealtad');
		loadRewardLoyaltyTable();
	}else if($(selector).attr('id') == "AuthorizationsLoyalty"){
		tipeEditReward = 3;
		$('.headerScreen').html('Autorizaciones pendientes');
		loadPendingAuthorizations($('#sctTypeRewardAuthorization').val());
	}else if($(selector).attr('id') == "reportsLoyalty"){
		//$('.headerScreen').html('Campañas de Lealtad');
	}
}

/***********************************************************/
/************************CAMPAÑA****************************/
/***********************************************************/

////////////////////INDEX//////////////////////

//muestra el formulario
$('#btnAddCampana').click(function(){ showFormCampana(); });

//cancela formulario
$('#btnCancelCampana').click(function(){ hideFormCampana(); });

//agrega la campana
$('#btnRegisterCampana').click(function(){ addCampana(); });

//actualiza la campaña
$('#btnSaveCampana').click(function(){ editCampana(); });

//formulario para eliminar la campaña
$(document).on('click','#imageDelete',function(){ showFormDeleteCampana($(this).attr('value')); });

//autocompletar de partner
$("#txtPartnerCampana").keyup(function() { AutocompletePartnerCampana(); });

//obtiene el id para mostrar los datos de la campana
$(document).on('click','.showCampana',function(){ showFormEditCampana($(this).attr('value')); });

//elimina la campaña selecionado
$('#btnAcceptDeleteC').click(function(){ deleteCampana(); });

//esconde "eliminar campaña"
$('#btnCancelDeleteC').click(function(){ hideFormDeleteCampana(); });

//formulario para eliminar una recompensa
$(document).on('click','.imgDeleteReward', function(){ showFormDeleteReward($(this).attr('value')) });

//elimina la recompensa
$('#btnAcceptDeleteR').click(function(){ deleteRewardCampana(); });

//oculta el formulario de eliminar recompensa
$('#btnCancelDeleteR').click(function(){ hideFormDeleteReward(); });

//////////////////FUNCIONES////////////////////

//muestra el formulario de agregar campana
function showFormCampana(){
	cleanFieldCampana();
	hideAlertCampana();
	$('#btnSaveCampana').hide();
	$('#btnRegisterCampana').show();
	$('#tableRecompensa').hide();
	$('#ViewTablaCampanas').hide();
	$('#ViewFormCampanas').show();
	$('.headerScreen').html('Campañas de Lealtad > Campaña')
}

//muestra los datos de una campaña agregada
function showFormEditCampana(idCampana){
	cleanFieldCampana();
	hideAlertCampana();
	$('#btnSaveCampana').val(idCampana);
	$('#btnSaveCampana').show();
	$('#btnRegisterCampana').hide();
	$('#tableRecompensa').show();
	loadDataCampana(idCampana);
}

//esconde el formulario de campana
function hideFormCampana(){
	$('.headerScreen').html('Campañas de Lealtad')
	cleanFieldCampana();
	hideAlertCampana();
	$('#ViewFormCampanas').hide();
	$('#ViewTablaCampanas').show();		
}

//muestra el formulario para eliminar una campaña
function showFormDeleteCampana(id){
	$('#btnAcceptDeleteC').val(id);
	$('#divMenssagewarningCampana').hide();
	$('#divMenssage').hide();
	$('#divMenssagewarningCampana').show(1000);
}

//esconde el formulario para eliminar una campaña
function hideFormDeleteCampana(){
	$('#btnAcceptDeleteC').val("");
	$('#divMenssagewarningCampana').hide(500);
	$('#divMenssage').hide();
}

//agrega una campaña nueva
function addCampana(){
	var result = validateFormCampana();
	if(result){
		$('.bntSave').attr('disabled',true);
		$('.loading').html('<img src="assets/img/web/loading.gif" height="150px" width="150px" />');
		$('.loading').show();
		SaveCampana(0);	
	}
}

//edita los datos de la campaña
function editCampana(){
	var result = validateFormCampana();
	if(result){
		$('.bntSave').attr('disabled',true);
		$('.loading').html('<img src="assets/img/web/loading.gif" height="150px" width="150px" />');
		$('.loading').show();	
		SaveCampana($('#btnSaveCampana').val());	
	}
}

//elimina la campaña selecionado
function deleteCampana(){
	//alert($('#btnAcceptDeleteC').val())
	numPag = $('ul .current').val();
	$.ajax({
		type: "POST",
		url: "lealtad/deleteCampana",
		dataType:'json',
		data: {
			id:$('#btnAcceptDeleteC').val()
		},
		success: function(data){
			//verifica si se elimino la ultima fila de la tabla
			var aux = 0;
			$('#tableCampanaLealtad tbody tr').each(function(index) {
				aux++;
			});
			
			//si es uno regarga la tabla con un indice menos
			if(aux == 1){
				numPag = numPag-1;
			}
			ajaxMostrarTabla(column,order,"lealtad/getallSearchCampana",(numPag-1),"campana");
			$("#divMenssagewarningCampana").hide();
			$('#alertMessage').empty();
			$('#alertMessage').append(data);
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').hide(1000);
		},
		error: function(data){
			alert("error al eliminar una campaña. Por favor vuelva a intentarlo")	
		}
	});
}

//valida los datos del formulario
function validateFormCampana(){
	var results = true;
	
	hideAlertCampana();
	
	//valida el campo descripcion
	if($('#txtDescriptionCampana').val().trim().length == 0){
		$('#txtDescriptionCampana').focus();
		$('#alertDescriptionCampana').show();
		$('#labelDescriptionCampana').addClass('error');
		results = false;
	}
	
	//valida que se haya selecionado un comercio
	valuePartner = $('#txtPartnerCampana').val().trim();
	idPartner = $('datalist option[value="' + valuePartner + '"]').attr('id');
	//valida que el partner selecionado no este vacio y que exista
	if(idPartner == undefined){
		$('#alertPartnerCampana').show();
		$('#labelPartnerCampana').addClass('error');
		$('#txtPartnerCampana').focus();
		results = false;
	}
	
	//valida el campo nombre
	if($('#txtNameCampana').val().trim().length == 0){
		$('#txtNameCampana').focus();
		$('#alertNameCampana').show();
		$('#labelNameCampana').addClass('error');
		results = false;	
	}
	
	return results	
}

//esconde los mensaje de alerta
function hideAlertCampana(){
	$('#alertNameCampana').hide();
	$('#alertPartnerCampana').hide();
	$('#alertDescriptionCampana').hide();
	
	$('#labelNameCampana').removeClass('error');
	$('#labelPartnerCampana').removeClass('error');
	$('#labelDescriptionCampana').removeClass('error');
	
	$('#divMenssagewarningReward').hide();
}

//limpia los registro de la campaña
function cleanFieldCampana(){
	$('#txtNameCampana').val("");
	$('#txtPartnerCampana').val("");
	$('#txtDescriptionCampana').val("");
	$('#partnerListCampana').empty();
	$('#tableRecompensa tbody').empty();
	$('#txtPartnerCampana').attr("idP",0);
}

//function de autocompletar input de partner
function AutocompletePartnerCampana(){
	
	$.ajax({
		type: "POST",
		url: "partners/getPartner",
		dataType:'json',
		data: {
			dato:$("#txtPartnerCampana").val()
		},
		success: function(data){
			$('#partnerListCampana').empty();
			for(var i = 0;i<data.length;i++){
				$('#partnerListCampana').append(
					"<option id='" + data[i].id + "' value='" +  data[i].name + "' />"
				);
			}
        }
	});
	
}

//guarda los datos de la campaña
function SaveCampana(id){
	
	var valuePartner = $('#txtPartnerCampana').val().trim();
	var idPartner = $('datalist option[value="' + valuePartner + '"]').attr('id')
	
	var status = 1
	if( $('.statusCampana').is(':checked') ) {
		status = 1
	}else{
		status = -1
	}
	
	numPag = $('ul .current').val();
	
	$.ajax({
		type: "POST",
		url: "lealtad/saveCampana",
		dataType:'json',
		data: {
			id:id,
			nombre:$('#txtNameCampana').val(),
			descripcion:$('#txtDescriptionCampana').val(),
			partnerId:idPartner,
			status:status
		},
		success: function(data){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"lealtad/getallSearchCampana",0,"campana");
			} else {
				ajaxMostrarTabla(column,order,"lealtad/getallSearchCampana",(numPag-1),"campana");
			}
			hideFormCampana();
			$('#alertMessage').empty();
			$('#alertMessage').html(data);
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').toggle(1000);
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
			$('.headerScreen').html('Campañas de Lealtad')
		},
		error: function(){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"lealtad/getallSearchCampana",0,"campana");
			} else {
				ajaxMostrarTabla(column,order,"lealtad/getallSearchCampana",(numPag-1),"campana");
			}
			hideFormCampana();
			$('#alertMessage').empty();
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
			alert("error al insertar datos");
		}
	});
	
}

//obtiene los datos de la campana
function loadDataCampana(idCampana){
	$.ajax({
		type: "POST",
		url: "lealtad/getId",
		dataType:'json',
		data: { 
			id:idCampana
		},
		success: function(data){
			$('#divMenssagewarningReward').hide();
			if(data.items.length >0){
				$('.headerScreen').html('Campañas de Lealtad > Campaña')
				var items = data.items[0];
				$('#txtNameCampana').val(items.nombre);
				$('#txtDescriptionCampana').val(items.descripcion);
				$('#txtPartnerCampana').val(items.partnerName);
				$('#txtPartnerCampana').attr('idP',items.partnerId);
				$('#partnerListCampana').append("<option id='" + items.partnerId + 
				"' value='" +  items.partnerName + "' />" );
				if(items.status == 1){
					$('.statusCampana').prop('checked', true);
				}else{
					$('.statusCampana').prop('checked', false);
				}
				$('#btnAddReward').val(items.id);
			}
			
			if(data.recompensa.length > 0){
				var items = data.recompensa;
				for(i=0;i<items.length;i++){
					
					//alert(items[i].lealtadStatusRecompensasId)
					
					var deleteR;
					var idR = 0;
					if(items[i].lealtadStatusRecompensasId == 4){
						deleteR = "";
						idR == 0;
					}else{
						deleteR = "<a class='imgDeleteReward' value='" + items[i].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a>";
						idR = items[i].id;
					}
					
					$('#tableRecompensa tbody').append(
						'<tr>' +
							'<td>' + i+1 + '</td>' +
							'<td><a class="showRewardCampana" id="' + items[i].id + '" value="' + idR + '">'+items[i].nombre + '</a></td>' +
							'<td></td>' +
							'<td>' +items[i].cantidadVigencia + ' ' + items[i].nombreVigencia + '</td>' +
							'<td>' +items[i].nombreStatus + '</td>' +
							"<td>" + deleteR + "</td>" +
						'</tr>'
					);
				}	
			}
			$('#ViewTablaCampanas').hide();
			$('#ViewFormCampanas').show();
			
		},
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});
}

////////muestra el formulario para eliminar una recompensa
function showFormDeleteReward(id){
	
	$('#btnAcceptDeleteR').val(id);
	$('#divMenssagewarningReward').hide();
	$('#divMenssagewarningReward').show(1000);
}

function deleteRewardCampana(){
	
	$.ajax({
		type: "POST",
		url: "lealtad/deleteRewardCampana",
		dataType:'json',
		data: {
			id:$('#btnAcceptDeleteR').val(),
			idCampana:$('#btnAddReward').val()
		},
		success: function(data){
			
			if(data.recompensa.length > 0){
				
				$('#tableRecompensa tbody').empty();
				
				var items = data.recompensa;
				for(i=0;i<items.length;i++){
					
					var deleteR;
					var idR = 0;
					if(items[i].lealtadStatusRecompensasId == 4){
						deleteR = "";
						idR == 0;
					}else{
						deleteR = "<a class='imgDeleteReward' value='" + items[i].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a>";
						idR = items[i].id;
					}
					
					$('#tableRecompensa tbody').append(
						'<tr>' +
							'<td>' + i+1 + '</td>' +
							'<td><a class="showRewardCampana" id="' + items[i].id + '" value="' + idR + '">'+items[i].nombre + '</a></td>' +
							'<td></td>' +
							'<td>' +items[i].cantidadVigencia + ' ' + items[i].nombreVigencia + '</td>' +
							'<td>' +items[i].nombreStatus + '</td>' +
							"<td>" + deleteR + "</td>" +
						'</tr>'
					);
				}	
			}
			
			$("#divMenssagewarningReward").hide();
			$('#alertMessageReward').html(data.mensagge);
			$('#divMenssageReward').hide();
			$('#divMenssageReward').show(1000).delay(1500);
			$('#divMenssageReward').hide(1000);
			
		},
		error: function(data){
			alert("error al eliminar la recompensa. Por favor vuelva a intentarlo")	
		}
	});
	
}

function hideFormDeleteReward(){
	$('#btnAcceptDeleteR').val(0);
	$('#divMenssagewarningReward').hide(1000);
}


/***********************************************************/
/***********************RECOMPENSA CAMPAÑA**************************/
/***********************************************************/

////////////////////Variables//////////////////////

var contRequestReward = 1;
var contUserNivelReward = 1;

////////////////////INDEX//////////////////////

//muestra el frmulario para agregar recompensa
$('#btnAddReward').click(function(){ showFormRecompensa(); });

//cambio en el checkbox de nivel de usuario
$('#checkUserLevel').click(function(){ changeUserLevel(); });

//añade requerimientos a la tabla
$('#imgAddRuleRedward').click(function(){ addRequestRequest() });

//elimina un celda de requerimiento
$(document).on('click','.imgDeleteRequest',function(){ deleteRequestReward($(this).attr('value')); });

//añade tipo de usuario
$('#imgAddTypeUserRedward').click(function(){ addUserLevelReward() });

//elimina un celda de requerimiento
$(document).on('click','.imgDeleteUserLevel',function(){ deleteUserLevelReward($(this).attr('value')); });

//agrega la recompensa
$('#btnRegisterRewardCampana').click(function(){ addRewardCampana(); });

//cancela el formulario de recompensa de campañas
$('#btnCancelRewardCampana').click(function(){ CancelRewardCampana(); });

//muestra la recompensa selecionada
$(document).on('click','.showRewardCampana',function(){ loadDataRewardCampana($(this).attr('id'), $(this).attr('value')); });

//actualiza los datos de la recompensa
$('#btnSaveRewardCampana').click(function(){ editRewardCampana(); });

function showFormRecompensa(){
	flagStatus = 1;
	//alert($('#btnAddReward').val())
	cleanFieldRecompensaCampana();
	addDealsReward = true;
	$('.btnGrantreward').css('background-color','rgb(153,153,153)');
	$('.headerScreen').html('Campañas de Lealtad > Campaña > Recompensa')
	$('#btnSaveRewardCampana').hide();
	$('#btnRegisterRewardCampana').show();
	$('#ViewTablaCampanas').hide();
	$('#ViewFormCampanas').hide();
	$('#ViewFormRecompensa').show();
}

//muestra u oculta la tabla de nivel de usuario
function changeUserLevel(){
	if( $('#checkUserLevel').is(':checked') ) {
		$('.groupUserLevel').show();
	}else{
		$('.groupUserLevel').hide();
	}	
}

//añade requerimientos a la tabla 
function addRequestRequest(){
	
	$('#divAlertRequestReward').hide();
	
	if($('#txtNameRequestReward').val().trim().length > 0 && $('#txtAmountRequestReward').val().trim().length > 0 && 
	$('#sctTypeRuleRedward').val() != null){
		var flagResquet = 0
		$('#tableRequestReward tbody tr').each(function(index, element) {
       		if($(this).attr('id') == "request" + $('#sctTypeRuleRedward option:selected').val()){
				flagResquet++;
			}
   		});
		if(flagResquet == 0){
		
			var totalTR = $('#tableRequestReward tbody').find('tr').length + 1
		
			$('#tableRequestReward tbody').append(
				'<tr id="request' + $('#sctTypeRuleRedward option:selected').val() +'">' +
					'<td class="tableId">' + totalTR + '</td>' +
					'<td>' + $('#txtNameRequestReward').val().trim() + '</td>' +
					'<td amou="' + $('#txtAmountRequestReward').val().trim() + '" rule="' 
						+ $('#sctTypeRuleRedward option:selected').val() +'">' + 
					$('#txtAmountRequestReward').val().trim() + ' ' + $('#sctTypeRuleRedward option:selected').text() + 
					'</td>' +
					"<td><a class='imgDeleteRequest' value='" + $('#sctTypeRuleRedward option:selected').val() 
						+"'><img id='imgDelete' "+
					"src='assets/img/web/delete.png'/></a></td>" +
				'</tr>'
			);
			contRequestReward++;
			$('#txtNameRequestReward').val("");
			$('#txtAmountRequestReward').val("");
			$("#sctTypeRuleRedward option[value='']").attr("selected",true);
		}else{
			$('#alertRequestReward').html("Regla repetida. No se puede agregar 2 veces la misma regla");
			$('#divAlertRequestReward').show();
		}
	}else{
		if($('#txtNameRequestReward').val().trim().length == 0){
			$('#alertRequestReward').html("Campo vacio. Por favor escriba el nombre del requerimineto");
			$('#divAlertRequestReward').show();
		}else if($('#txtAmountRequestReward').val().trim().length == 0){
			$('#alertRequestReward').html("Campo vacio. Por favor escriba la cantidad de requerimiento");
			$('#divAlertRequestReward').show();
		}else if($('#sctTypeRuleRedward').val() == null){
			$('#alertRequestReward').html("Campo vacio. Por favor selecione una regla");
			$('#divAlertRequestReward').show();
		}
	}
}

//elimina la celda selecionado de la tabla requerimiento 
function deleteRequestReward(id){
	$('#request' + id).remove();
	
	$('#tableRequestReward tbody tr').each(function(index, element) {
       	$(this).find('.tableId').html(index + 1);
    });
}

//se agrega un nivel de usuario a la tabla
function addUserLevelReward(){
	$('#divAlertUserLevelReward').hide();
	
	if($('#sctTypeTypeUserReward').val() != null){
		
		var flagUserLevel = 0
		$('#tableUserLevel tbody tr').each(function(index, element) {
       		if($(this).attr('id') == "levelUser" +  $('#sctTypeTypeUserReward option:selected').val()){
				flagUserLevel++;
			}
   		});
		
		if(flagUserLevel == 0){
		
			var totalTR = $('#tableUserLevel tbody').find('tr').length + 1
			$('#tableUserLevel tbody').append(
				'<tr id="levelUser' +  $('#sctTypeTypeUserReward option:selected').val() +'">' +
					'<td class="tableId">' + totalTR + '</td>' +
					'<td id="' + $('#sctTypeTypeUserReward option:selected').val() +'">' 
					+ $('#sctTypeTypeUserReward option:selected').text() + '</td>' + 
					"<td><a class='imgDeleteUserLevel' value='" +  $('#sctTypeTypeUserReward option:selected').val() 
					+"'><img id='imgDelete' "+ "src='assets/img/web/delete.png'/></a></td>" +
				'</tr>'
			);
			contUserNivelReward++;
			$("#sctTypeTypeUserReward option[value='']").attr("selected",true);
		}else{
			$('#alertUserLevelReward').html('Usuario repetido. No se puede reperit 2 veces el mismo nivel de usuario');
			$('#divAlertUserLevelReward').show();
		}
	}else{
		$('#alertUserLevelReward').html('Campo vacio. Selecion un tipo de usuario');
		$('#divAlertUserLevelReward').show();
	}
}

//elimina la fila selecionada
function deleteUserLevelReward(id){
	$('#levelUser' + id).remove();
	
	$('#tableUserLevel tbody tr').each(function(index, element) {
       	$(this).find('.tableId').html(index + 1);
    });
}

//agrega una nueva recompensa de la campaña
function addRewardCampana(){
	
	hideAlertRewardCampana();
	
	var result = validateRewardCampana();
	if(result){
		$('.bntSave').attr('disabled',true);
		$('.loading').html('<img src="assets/img/web/loading.gif" height="150px" width="150px" />');
		$('.loading').show();
		saveRewardCampana(0);
	}	
	
	//saveRewardCampana(0);
}

//actualiza los datos de la recompensa de la campaña
function editRewardCampana(){
	//alert($('#btnSaveRewardCampana').val());
	hideAlertRewardCampana();
	
	var result = validateRewardCampana();
	if(result){
		$('.bntSave').attr('disabled',true);
		$('.loading').html('<img src="assets/img/web/loading.gif" height="150px" width="150px" />');
		$('.loading').show();
		saveRewardCampana($('#btnSaveRewardCampana').val());
	}
}

//cancela el formulario para agregar recompensas a la campaña
function CancelRewardCampana(){
	flagStatus = 0;
	if(tipeEditReward == 1){
		$('.headerScreen').html('Campañas de Lealtad > Campaña')
		$('#divMenssagewarningReward').hide();
		$('#ViewFormRecompensa').hide();
		$('#ViewFormCampanas').show();
		cleanFieldRecompensaCampana();
	}else if(tipeEditReward == 2){
		$('.headerScreen').html('Recompensas de Lealtad');
		$('#vwcatalogCampana').hide();
		$('#ViewFormRecompensa').hide();
		$('#vwCatalogReward').show();
	}else if(tipeEditReward == 3){
		$('.headerScreen').html('Autorizaciones pendientes');
		$('#vwcatalogCampana').hide();
		$('#ViewFormRecompensa').hide();
		$('#vwAuthorizationsLoyalty').show();
	}	
}

//valida que los campos de recompensa sean correctos
function validateRewardCampana(){
	var result = true;
	
	var hoy = new Date();
	var dd = hoy.getDate();
	var mm = hoy.getMonth()+1; //hoy es 0!
	var yyyy = hoy.getFullYear();

	if(dd<10) {
		dd='0'+dd
	} 

	if(mm<10) {
		mm='0'+mm
	} 

	hoy = yyyy+'-'+mm+'-'+dd;
	
	if( $('#checkUserLevel').is(':checked') ) {
		if($('#tableUserLevel tbody').find('tr').length == 0){
			$('#alertTableUserLevelReward').html("Se necesita por lo menos un nivel de usuario");
			$('#alertTableUserLevelReward').show();
			result = false;
		}
	}
	
	if($('#tableRequestReward tbody').find('tr').length == 0){
		$('#alertTableResquedReward').html("Se necesita por lo menos una regla para la recompensa");
		$('#alertTableResquedReward').show();
		result = false;
	}
	
	if($('#tableGrantReward tbody').find('tr').length == 0){
		$('#alertTableGrantReward').html("Se necesita por lo menos un deals para la recompensa");
		$('#alertTableGrantReward').show();
		result = false;
	}
	
	if($('#txtAmountValidityReward').val().trim().length == 0 || $('#sctTypeValidityReward').val() == null){
		$('#labelValidityReward').addClass('error');
		$('#alertValidityReward').html("Los campos cantidad y tipo de vigencia son requeridos");
		$('#divAlertValidityReward').show();
		result = false;
	}
	
	if($('#txtEndDateReward').val() < $('#txtIniDateReward').val()){
		$('#alertEndDateReward').html("Fecha incorrecta. selecione una fecha mayor o igual a la inicial.");
		$('#alertEndDateReward').show();
		$('#labelEndDateReward').addClass('error');
		$('#txtIniDateReward').focus();
		result = false;
	}
	
	if($('#txtEndDateReward').val().trim().length == 0){
		$('#labelEndDateReward').addClass('error');
		$('#alertEndDateReward').html('Campo vacio. Selecione una fecha');
		$('#alertEndDateReward').show();
		$('#txtEndDateReward').focus();
		result = false;
	}
	
	if($('#txtIniDateReward').val() < hoy){
		$('#alertIniDateReward').html("Fecha incorrecta. Seleciones una fecha igual o mayor a la de hoy");
		$('#alertIniDateReward').show();
		$('#labelIniDateReward').addClass('error');
		$('#txtIniDateReward').focus();
		result = false;
	}
	
	if($('#txtIniDateReward').val().trim().length == 0){
		$('#labelIniDateReward').addClass('error');
		$('#alertIniDateReward').html('Campo vacio. Selecione una fecha');
		$('#alertIniDateReward').show();
		$('#txtIniDateReward').focus();
		result = false;
	}
	
	if($('#txtNameReward').val().trim().length == 0){
		$('#labelNameReward').addClass('error');
		$('#alertNameReward').show();
		$('#txtNameReward').focus();
		result = false;
	}
	
	return result;	
}

function hideAlertRewardCampana(){
	$('.labelRewardCampana').removeClass('error');
	$('.alertRewardCamapana').hide();
}

function cleanFieldRecompensaCampana(){
	$('#txtNameReward').val("");
	$('#txtIniDateReward').val("");
	$('#txtEndDateReward').val("");
	$('#txtAmountValidityReward').val("");
	$("#sctTypeValidityReward option[value='']").attr("selected",true);
	$('#txtNameRequestReward').val("");
	$('#txtAmountRequestReward').val("");
	$("#sctTypeRuleRedward option[value='']").attr("selected",true);
	$("#sctTypeTypeUserReward option[value='']").attr("selected",true);
	$('#tableGrantReward tbody').empty();
	$('#tableRequestReward tbody').empty();
	$('#tableUserLevel tbody').empty();
	$('#checkUserLevel').prop('checked', false);
	$('#checkPublishedReward').prop('checked', true);
	$('.groupUserLevel').hide();
	RewardRechazado = 1;
	
	$('#tittleStatus').html(statusType[0]);
					
	//$('#leftStatus').show();
	$('#rightStatus').html(
		'<a class="shiftStatus" id="' + 1 + '" type="1">' + 
			statusType[1] +
			'<img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>&nbsp;&nbsp;' + 
		'</a>'
	);
					
	$('#leftStatus').html('&nbsp;');
	
	idStatusAuthorization = 1;
}

function saveRewardCampana(id){
	
	var status = 2;
	/*if( $('#checkPublishedReward').is(':checked')) {
		status = 2;
	}else{
		status = 1;
	}*/
	
	status = idStatusAuthorization
	
	var rulesArray = new Array();
	var userLevelArray = new Array();
	
	$('#tableRequestReward tbody tr').each(function(index, element) {
		var campo1, campo2, campo3;
        $(this).children("td").each(function (index2){
			switch (index2){
               	case 1:
					campo1 = $(this).text();
                break;
               	case 2:
					campo2 = $(this).attr('amou');
					campo3 = $(this).attr('rule');
                break;
           	}
		});
		rulesArray.push({"nombre":campo1,"cantidadRequerida":campo2,"lealtadReglasID":campo3})
    });
	
	var rules = JSON.stringify(rulesArray);
	
	var userLevel = 0;
	
	if( $('#checkUserLevel').is(':checked') ) {
		
		$('#tableUserLevel tbody tr').each(function(index, element) {
			var campo1;
        	$(this).children("td").each(function (index2){
				switch (index2){
               		case 1:
						campo1 = $(this).attr('id');
                	break;
           		}
			});
			userLevelArray.push({"catNivelUsuarioId":campo1})
    	});
	
	var userLevel = JSON.stringify(userLevelArray);
		
	}else{
		userLevel = 0;
	}
	
	var dealsRewardArray = new Array();
	
	$('#tableGrantReward tbody tr').each(function(index, element) {
		var DealsR = $(this).attr('id');
		var idDeals =  DealsR.split("TRId");		
		dealsRewardArray.push(idDeals[1])
    });
	
	var dealsReward = JSON.stringify(dealsRewardArray);
	$.ajax({
		type: "POST",
		url: "lealtad/saveRewardCampana",
		dataType:'json',
		data: {
			id:id,
			nombre:$('#txtNameReward').val(),
			lealtadCampanaId:$('#btnAddReward').val(),
			cantidadVigencia:$('#txtAmountValidityReward').val(),
			lealtadTiposVigenciaId:$('#sctTypeValidityReward').val(),
			fechaInicio:$('#txtIniDateReward').val(),
			fechaTermino:$('#txtEndDateReward').val(),
			lealtadStatusRecompensasId:status,
			status:$('#checkPublishedReward').attr('value'),
			rules:rules,
			userLevel:userLevel,
			dealsReward:dealsReward
		},
		success: function(data){
			
			$('#tableRecompensa tbody').empty();
			
			if(data.recompensa.length > 0){
				var items = data.recompensa;
				for(i=0;i<items.length;i++){
					
					var deleteR;
					var idR = 0;
					if(items[i].lealtadStatusRecompensasId == 4){
						deleteR = "";
						idR == 0;
					}else{
						deleteR = "<a class='imgDeleteReward' value='" + items[i].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a>";
						idR = items[i].id;
					}
					
					$('#tableRecompensa tbody').append(
						'<tr>' +
							'<td>' + i+1 + '</td>' +
							'<td><a class="showRewardCampana" id="' + items[i].id + '" value="' + idR + '">'+items[i].nombre + '</a></td>' +
							'<td></td>' +
							'<td>' +items[i].cantidadVigencia + ' ' + items[i].nombreVigencia + '</td>' +
							'<td>' +items[i].nombreStatus + '</td>' +
							'<td>' + deleteR + '</td>' +
						'</tr>'
					);
				}	
			}
			
			if(tipeEditReward == 1){
				$('.headerScreen').html('Campañas de Lealtad > Campaña');
				$('#ViewFormRecompensa').hide();
				$('#ViewFormCampanas').show();
				$('#alertMessageReward').empty();
				$('#alertMessageReward').html(data.mensagge);
				$('#divMenssageReward').show(1000).delay(1500);
				$('#divMenssageReward').toggle(1000);
			}else if(tipeEditReward == 2){
				$('.headerScreen').html('Recompensas de Lealtad');
				$('#ViewFormRecompensa').hide();
				$('#vwcatalogCampana').hide();
				$('#vwCatalogReward').show();
				$('#alertMessageCReward').empty();
				$('#alertMessageCReward').html(data.mensagge);
				$('#divMenssageCReward').show(1000).delay(1500);
				$('#divMenssageCReward').toggle(1000);
			}else if(tipeEditReward == 3){
				$('.headerScreen').html('Autorizaciones pendientes');
				$('#ViewFormRecompensa').hide();
				$('#vwcatalogCampana').hide();
				$('#vwAuthorizationsLoyalty').show();
				$('#alertMessageAuthorization').empty();
				$('#alertMessageAuthorization').html(data.mensagge);
				$('#divMenssageAuthorization').show(1000).delay(1500);
				$('#divMenssageAuthorization').toggle(1000);
				loadPendingAuthorizations($('#sctTypeRewardAuthorization').val());
			}
			
			window.scrollTo(10, 0);
			
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
		},
		error: function(){
			alert("error al guardar los datos de la recompensa");
			$('#ViewFormRecompensa').hide();
			$('#ViewFormCampanas').show();
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
		}
	});
}

//muestra los datos de la recompensa selecionada
function loadDataRewardCampana(id,active){
	//alert(tipeEditReward)
	flagStatus = 0;
	cleanFieldRecompensaCampana();
	$.ajax({
		type: "POST",
		url: "lealtad/getRewardCampanaById",
		dataType:'json',
		data: { 
			id:id
		},
		success: function(data){
			if(data.items.length >0){
				var items = data.items[0];
				if(tipeEditReward == 1){
					$('.headerScreen').html('Campañas de Lealtad > Campaña > Recompensa');
				}else if(tipeEditReward == 2){
					$('.headerScreen').html('Recompensas de Lealtad > Recompensa');
					$('#txtPartnerCampana').attr('idP',active);
					$('#btnAddReward').val(items.lealtadCampanaId)
				}else if(tipeEditReward == 3){
					$('.headerScreen').html('Autorizaciones pendientes > Recompensa');
					$('#txtPartnerCampana').attr('idP',active);
					$('#btnAddReward').val(items.lealtadCampanaId)
				}
				
				$('#txtNameReward').val(items.nombre);
				var dateTime = items.fechaInicio;
				//var replaced = dateTime.replace(" ",'T');*/
				var replaced = dateTime.split(" ");
				$('#txtIniDateReward').val(replaced[0]);
				
				$('#checkPublishedReward').val(items.lealtadStatusRecompensasId);
				
				if(items.lealtadStatusRecompensasId == 1){
					$('#checkPublishedReward').prop('checked', false);
				}else{
					$('#checkPublishedReward').prop('checked', true);
				}
				
				//if(tipeEditReward == 3){
					$('#tittleStatus').html(statusType[items.lealtadStatusRecompensasId - 1]);
					
					if(items.lealtadStatusRecompensasId == 1){
						$('#leftStatus').html('&nbsp;');
					}else{
						$('#leftStatus').show();
						$('#leftStatus').html(
							'<a class="shiftStatus" id="' + items.lealtadStatusRecompensasId + '" type="0">' + 
							'<img src="assets/img/web/arrowBackS.png" height="50px" width="40px"/>&nbsp;&nbsp;' + 
							statusType[items.lealtadStatusRecompensasId - 2] + 
							'</a>'
						);
					}
					
					if(tipeEditReward == 3){
					
						if(items.lealtadStatusRecompensasId == 4){
							$('#leftStatus').html('&nbsp;');
							$('#rightStatus').html('&nbsp;');
						}else{
							$('#rightStatus').show();
							$('#rightStatus').html(
								'<a class="shiftStatus" id="' + items.lealtadStatusRecompensasId + '" type="1">' + 
								statusType[items.lealtadStatusRecompensasId] +
								'&nbsp;&nbsp;<img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>' +
								'</a>'
							);
						}
					}else{
						if(items.lealtadStatusRecompensasId == 3 || items.lealtadStatusRecompensasId == 4){
							$('#leftStatus').html('&nbsp;');
							$('#rightStatus').html('&nbsp;');
						}else if(items.lealtadStatusRecompensasId == 1){
							
							$('#rightStatus').show();
							$('#rightStatus').html(
								'<a class="shiftStatus" id="' + items.lealtadStatusRecompensasId + '" type="1">' + 
								statusType[items.lealtadStatusRecompensasId] +
								'&nbsp;&nbsp;<img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>' +
								'</a>'
							);
						}
					}
				//}
				
				var dateTime = items.fechaTermino;
				//var replaced = dateTime.replace(" ",'T');
				var replaced = dateTime.split(" ");
				$('#txtEndDateReward').val(replaced[0]);
				$('#txtAmountValidityReward').val(items.cantidadVigencia);
				$('#sctTypeValidityReward option[value="'+ items.lealtadTiposVigenciaId +'"]').attr('selected', 'selected');
				$('#btnSaveRewardCampana').val(items.id);
				
			}
			if(data.rule.length > 0){
				var items = data.rule;
				for(i=0;i<items.length;i++){
					$('#tableRequestReward tbody').append(
						'<tr id="request' + items[i].lealtadReglasId +'">' +
							'<td class="tableId">' + (i + 1) + '</td>' +
							'<td>' + items[i].nameRule + '</td>' +
							'<td amou="' + items[i].cantidadRequerida + '" rule="' + 
								items[i].lealtadReglasId +'">' + 
								items[i].cantidadRequerida + ' ' + 
								items[i].nombre + 
							'</td>' +
							"<td><a class='imgDeleteRequest' value='" + items[i].lealtadReglasId +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a></td>" +
						'</tr>'
					);
				}
			}
			
			if(data.user.length > 0){
				var items = data.user;
				for(i=0;i<items.length;i++){
					$('#tableUserLevel tbody').append(
						'<tr id="levelUser' + items[i].catNivelUsuariosId +'">' +
						'<td class="tableId">' + (i+1) + '</td>' +
						'<td id="' + items[i].catNivelUsuariosId +'">' + 
						items[i].nombre + '</td>' +
						"<td><a class='imgDeleteUserLevel' value='" + items[i].catNivelUsuariosId +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a></td>" +
						'</tr>'
					);
				}
				$('#checkUserLevel').prop('checked', true);
				$('.groupUserLevel').show();
			}
			
			if(data.deals.length > 0){
				var items = data.deals;
				for(i=0;i<items.length;i++){
					$('#tableGrantReward tbody').append(
						'<tr class="newDeals" id="TRId' + items[i].id + '">' +
							'<td class="tableId">' + (i + 1)  + '</td>' +
							'<td><a class="showDealsReward" value="' + items[i].id + '">' + items[i].name  + '</td>' +
							'<td><a id="Id' + items[i].id + '" class="deleteDealsReward"><img id="imgDelete" src="assets/img/web/delete.png"/></a></td>' +
						'</tr>'
					);
				}
			}
			
			$('#btnRegisterRewardCampana').hide();
			$('#btnSaveRewardCampana').show();
			
			if(tipeEditReward == 1){
				$('#ViewTablaCampanas').hide();
				$('#ViewFormCampanas').hide();
				$('#ViewFormRecompensa').show();
			}else if(tipeEditReward == 2){
				$('#vwCatalogReward').hide();
				$('#ViewFormRecompensa').show();
				$('#vwcatalogCampana').show();
			}else if(tipeEditReward == 3){
				$('#vwAuthorizationsLoyalty').hide();
				$('#ViewFormRecompensa').show();
				$('#vwcatalogCampana').show();
			}
			
			
			if(active == 0){
				addDealsReward = false;
				$('#btnSaveRewardCampana').val("");
				$('#btnSaveRewardCampana').hide();
				$('.btnGrantreward').css('background-color','rgba(153,153,153,.40)');
			}else{
				addDealsReward = true;
				$('#btnSaveRewardCampana').show();
				$('.btnGrantreward').css('background-color','rgb(153,153,153)');
			}
			
		},
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});	
}


/***********************************************************/
/***************AUTORIZACIONES PENDIENTES*******************/
/***********************************************************/

////////////////////////INDEX////////////////////////////////
//carga las autorizaciones pendientes
//$('#AuthorizationsLoyalty').click(function(){  });

//autoriza la publicacion de la recompensa
//$(document).on('click','.imgApproved',function(){ approvedReward($(this).attr('value'),$(this).attr('idStatus')); });

//muestra formulario para aprovar la recompensa
$(document).on('click','.imgApproved',function(){ showFormAprovedReward(this); });

//cancel ael formulario para aprovar la recompensa
$('#btnCancelDeleteAuthoReward').click(function(){ hideFormAprovedReward(); });

//aprueva la recompensa al siguiente status
$('#btnAcceptDeleteAuthoReward').click(function(){ approvedReward(); });

//muestra los datos de la recompensa
$(document).on('click','.showRewardForAuthorization',function(){ loadDataRewardCampana($(this).attr('id'), $(this).attr('value')); });

//cambia la tabla de autorizaciones
$('#sctTypeRewardAuthorization').change(function(){ loadPendingAuthorizations($(this).val()); });

//cambia el estado de la recompensa
$(document).on('click','.shiftStatus',function(){ shiftStatusReward($(this).attr('id'),$(this).attr('type')) });

//cancela el cambio de estatus
$('#btnCancelShiftStatus').click(function(){ cancelShiftStatusReward(); });

//actualiza el estatus de la recompensa
$('#btnAcceptShiftStatus').click(function(){ updateStatusReward(); });

/////////////////////////fUNCIONES///////////////////////////

//obtiene las autorizaciones pendientes a publicar
function loadPendingAuthorizations(status){
	
	dato = status
	
	$.ajax({
		type: "POST",
		url: "lealtad/pendingAuthorizations",
		dataType:'json',
		data: {
			status:status
		},
		success: function(data){
			//console.log(data.requirements[0][0][0])
			$('#tableAuthorizationsLealtad tbody').empty();
			
			var totalRewardTable = 10;
			
			if(data.items.length < 10){
				totalRewardTable = data.items.length;
			}
			
			for(i=0;i<totalRewardTable;i++){
				var requerimientos = "";
				for(j=0;j<data.requirements[i].length;j++){
					
					for(k=0;k<data.requirements[i][j].length;k++){
						requerimientos = requerimientos +data.requirements[i][j][k].cantidadRequerida + " " + 
						data.requirements[i][j][k].nombre;
						if(k < data.requirements[i][j].length){requerimientos = requerimientos + '</br>'}
					}
				}
				
				if(data.items[i].lealtadStatusRecompensasId == 4){
					var deleteReward = data.items[i].nameStatus;
					var idR = 0;
				}else{
					var deleteReward = "<a class='imgApproved' value='" + data.items[i].id +"' idStatus='" + data.items[i].lealtadStatusRecompensasId + "'>" + data.items[i].nameStatus + "</a>";	
					var idR = data.items[i].partnerId;
				}
				
				$('#tableAuthorizationsLealtad tbody').append(
					'<tr>' +
					'<td>' + (i+1) +'</td>' +
					'<td><a class="showRewardForAuthorization" id="' + data.items[i].id + '" value="' + idR + '">' + 
					data.items[i].nombre +'</td>' +
					'<td>' + requerimientos +'</td>' +
					'<td>Administrador</td>' +
					'<td>' + data.items[i].campanaNombre +'</td>' +
					'<td>' + data.items[i].namePartner +'</td>' +
					'<td>' + deleteReward + '</td>' +
					'</tr>'
				);
					
			}
			
			/////////////////////////////////////	
				
			var totalReward = Math.ceil(data.items.length/10)
			
			//if(totalReward == 0){ totalReward++; }
				
			if(data.items.length%10 == 0){
				totalReward = totalReward + 1;		
			}
			
			$('#paginatorAuthorizationsL').html(
				'<li id="btnPaginadorAuthorizationsL" value="0" class="btnPaginador arrow primero unavailable">' +
					'<a>&laquo;</a>' +
				'</li>'
			);
			
			for(i=1;i<=totalReward;i++){
				if(i == 1){
					$('#paginatorAuthorizationsL').append(
						'<li id="btnPaginadorAuthorizationsL" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#paginatorAuthorizationsL').append(
						'<li id="btnPaginadorAuthorizationsL" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#paginatorAuthorizationsL').append(
				'<li id="btnPaginadorAuthorizationsL" value="' + (totalReward) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
				
			////////////////////// btnPaginadorAuthorizationsL
			
		},
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});
}

//muestra el formulario  para aprovar una recompensa
function showFormAprovedReward(selector){
	$('#btnAcceptDeleteAuthoReward').attr('value',$(selector).attr('value'));
	$('#btnAcceptDeleteAuthoReward').attr('idStatus',$(selector).attr('idStatus'));
	$('#divMenssagewarningAuthorization').hide(500);
	$('#divMenssageAuthorization').hide();
	$('#divMenssagewarningAuthorization').show(1000);
}

//esconde el formulario para aprovar deals
function hideFormAprovedReward(){
	$('#divMenssagewarningAuthorization').hide(1000);
}

//aprueba la recompensa de la campaña
function approvedReward(){
	var id = $('#btnAcceptDeleteAuthoReward').attr('value');
	var idStatus = $('#btnAcceptDeleteAuthoReward').attr('idStatus');
	var status = parseInt(idStatus) + 1
	$.ajax({
		type: "POST",
		url: "lealtad/approvedReward",
		dataType:'json',
		data: {
			id:id,
			status:status
		},
		success: function(data){
			$('#divMenssagewarningAuthorization').hide(1000);
			loadPendingAuthorizations(idStatus);
		},
		error: function(data){
			alert("Error al mostrar los datos de la recompensa. Por Favor Vuelva a intentarlo")	
			$('#divMenssagewarningAuthorization').hide(1000);
		}
	});
}

//cambia el status de la recompensa
//aprueba o rechaza dependiendo
function shiftStatusReward(idStatus,type){
	
	if(type == 0){
		idStatusAuthorization = parseInt(idStatus) - 1;	
	}else{
		idStatusAuthorization = parseInt(idStatus) + 1;	
	}
	RewardRechazado = type;
	
	if(flagStatus == 1){
	
		$('#tittleStatus').html(statusType[idStatusAuthorization - 1]);
					
		if(idStatusAuthorization == 1){
			$('#leftStatus').html('&nbsp;');
		}else{
			$('#leftStatus').show();
			$('#leftStatus').html(
				'<a class="shiftStatus" id="' + idStatusAuthorization + '" type="0">' + 
					'<img src="assets/img/web/arrowBackS.png" height="50px" width="40px"/>&nbsp;&nbsp;' + 
					statusType[idStatusAuthorization - 2] + 
				'</a>'
			);
		}
					
		if(idStatusAuthorization == 4){
			$('#rightStatus').html('&nbsp;');
		}else{
			$('#rightStatus').show();
			$('#rightStatus').html(
				'<a class="shiftStatus" id="' + idStatusAuthorization + '" type="1">' + 
					statusType[idStatusAuthorization] +
					'&nbsp;&nbsp;<img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>' +
				'</a>'
			);
		}
	
		if(tipeEditReward == 1 || tipeEditReward == 2){
			if(idStatusAuthorization == 2){
				$('#rightStatus').html('&nbsp;');
			}else{
				$('#rightStatus').show();
				$('#rightStatus').html(
					'<a class="shiftStatus" id="' + idStatusAuthorization + '" type="1">' + 
						statusType[idStatusAuthorization] +
						'&nbsp;&nbsp;<img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>' +
					'</a>'
				);
			}
		}
	}else{
		$('#divMenssagewarningShiftStatus').hide();
		$('#textMensageShiftStatus').html("¿Deasea actualizar es el estatus a " + statusType[idStatusAuthorization - 1]);
		$('#divMenssagewarningShiftStatus').show(1000);
	}
}

//cancel el cambio de estatus de la recompensa
function cancelShiftStatusReward(){
	$('#divMenssagewarningShiftStatus').hide(1000);
	idStatusAuthorization = $('#checkPublishedReward').attr('value');
}

//actualiza el estatus de la recompensa sin actualizar todos los datos
function updateStatusReward(){
	
	$.ajax({
		type:"POST",
		url:"lealtad/shiftStatusReward",
		dataType:"json",
		data:{
			id:$('#btnSaveRewardCampana').val(),
			idStatus:idStatusAuthorization,
			status:$('#checkPublishedReward').attr('value')
		},
		success: function(data){
			
			$('#checkPublishedReward').attr('value',idStatusAuthorization);
			
			$('#divMenssagewarningShiftStatus').hide(1000);
			
			$('#tittleStatus').html(statusType[idStatusAuthorization - 1]);
					
			if(idStatusAuthorization == 1){
				$('#leftStatus').html('&nbsp;');
			}else{
				$('#leftStatus').show();
				$('#leftStatus').html(
					'<a class="shiftStatus" id="' + idStatusAuthorization + '" type="0">' + 
						'<img src="assets/img/web/arrowBackS.png" height="50px" width="40px"/>&nbsp;&nbsp;' + 
						statusType[idStatusAuthorization - 2] + 
					'</a>'
				);
			}
					
			if(tipeEditReward == 3){		
				if(idStatusAuthorization == 4){
					$('#rightStatus').html('&nbsp;');
					$('#leftStatus').html('&nbsp;');
				}else{
					$('#rightStatus').show();
					$('#rightStatus').html(
						'<a class="shiftStatus" id="' + idStatusAuthorization + '" type="1">' + 
							statusType[idStatusAuthorization] +
							'&nbsp;&nbsp;<img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>' +
						'</a>'
					);
				}
			}
	
			if(tipeEditReward == 1 || tipeEditReward == 2){
				if(idStatusAuthorization == 2){
					$('#rightStatus').html('&nbsp;');
				}else{
					$('#rightStatus').show();
					$('#rightStatus').html(
						'<a class="shiftStatus" id="' + idStatusAuthorization + '" type="1">' + 
							statusType[idStatusAuthorization] +
							'&nbsp;&nbsp;<img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>' +
						'</a>'
					);
				}
			}
			
		},
		error: function(data){
			alert("Error al actualizar el status. Intentelo mas tarde")
			$('#divMenssagewarningShiftStatus').hide(1000);
		}
	});
	
}

/***********************************************************/
/**********************RECOMPENSA***************************/
/**********************LISTA********************************/
/***********************************************************/

/////////////////////INDEX/////////////////////////

//$(document).on('click','.showRewardForCatalog',function(){ showRewardCatalog($(this).attr('id')); });

//muestra los datos de la recompensa
$(document).on('click','.showRewardForCatalog',function(){ loadDataRewardCampana($(this).attr('id'), $(this).attr('value')); });



/////////////////////FUNCIONES/////////////////////

function loadRewardLoyaltyTable(){
	$.ajax({
		type: "POST",
		url: "lealtad/getRewardCatalog",
		dataType:'json',
		data: {
		},
		success: function(data){
			//console.log(data)
			$('#tableReward tbody').empty();
			
			var totalRewardTable = 10;
			
			if(data.items.length < 10){
				totalRewardTable = data.items.length;
			}
			
			for(i=0;i<totalRewardTable;i++){
				var requerimientos = "";
				for(j=0;j<data.requirements[i].length;j++){
					for(k=0;k<data.requirements[i][j].length;k++){
						requerimientos = requerimientos +data.requirements[i][j][k].cantidadRequerida + " " + 
						data.requirements[i][j][k].nombre;
						if(k < data.requirements[i][j].length){requerimientos = requerimientos + '</br>'}
					}
				}
				
				var idR = 0;
				if(data.items[i].lealtadStatusRecompensasId == 4){
					//deleteR = "";
					idR == 0;
				}else{
					/*deleteR = "<a class='imgDeleteReward' value='" + items[i].id +"'><img id='imgDelete' "+
						"src='assets/img/web/delete.png'/></a>";*/
					idR = data.items[i].partnerId;
				}
				
				$('#tableReward tbody').append(
					'<tr>' +
						'<td>' + (i+1) +'</td>' +
						'<td><a class="showRewardForCatalog" id="' + data.items[i].id + '" value="' + idR + '">' + data.items[i].nombre +'</a></td>' +
						'<td>' + requerimientos +'</td>' +
						'<td>' + data.items[i].campanaNombre +'</td>' +
						'<td>' + data.items[i].namePartner +'</td>' +
						'<td>' + data.items[i].nameStatus + '</td>' +
					'</tr>'
				);	
			}
			
			var totalReward = Math.ceil(data.items.length/10)
			if(data.length%10 == 0){
				totalReward = totalReward - 1;		
			}
			
			$('#paginatorReward').html(
				'<li id="btnPaginadorReward" value="0" class="btnPaginador arrow primero unavailable">' +
					'<a>&laquo;</a>' +
				'</li>'
			);
			
			for(i=1;i<=totalReward;i++){
				if(i == 1){
					$('#paginatorReward').append(
						'<li id="btnPaginadorReward" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#paginatorReward').append(
						'<li id="btnPaginadorReward" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#paginatorReward').append(
				'<li id="btnPaginadorReward" value="' + (totalReward) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
			
		},
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});
}