var ImgDealsA = new Array();
var arc = "";
var gallery = 0;
var DealsArray = new Array();
var dealsFilterArray = new Array();
var dialog, dialog2, form;
var typeModi = false;
var idDeals = 0;

//////////////////////////////////////////
///////////////////INDEX//////////////////
//////////////////////////////////////////

//elimina el deals selecionado
$(document).on('click','.deleteDealsReward',function(){ deleteDealsReward(this) });

//muestra la info del deals
$(document).on('click','.showDealsReward',function(){ showDealsReward($(this).attr('value')); });

//muestra la tabla de deals
$('#btnSearchGrantReward').click(function(){ showDealsTable(); });

//agrega un deals de la lista a la recompensa
$(document).on('mousedown','.checkDealsReward',function(){ addDealsOfTableToReward(this); });

//////////////////////////////////////////
///////////////////FUNCIONES//////////////////
//////////////////////////////////////////

$(function() {
	
	//ocultamos los campos de mas de deals
	$('#divCheckPubli').hide();
	$('#labelTotal').hide();
	$('#labelStock').hide();
	$('#labelPartner').hide();
	$('#labelIniDate').hide();
	$('#labelEndDate').hide();
	$('#txtTotal').val(0);
	$('#txtStock').val(0);
	$('#txtTotal').attr('total',0);
	$('#txtStock').attr('stock',0);
	
	dialog = $( "#dialog-form" ).dialog({
   		autoOpen: false,
      	height: "auto",
      	width: "80%",
      	modal: true,
      	buttons: {
        	"añadir deals":addDeals,
        	Cancel: function() {
        	  dialog.dialog( "close" );
        	}
      	},
      	close: function() {
      	}
   	});
	
	dialog2 = $( "#dialog-table" ).dialog({
   		autoOpen: false,
      	height: "auto",
      	width: "80%",
      	modal: true,
      	buttons: {
        	"Terminado": function() {
        		dialog2.dialog( "close" );
        	}
      	},
      	close: function() {
      	}
   	});
	
});

function addDealsReward() {
	var result;
	result = validationsRewardDeals();
	//result = true;
	if(result == true){
		typeModi = false;
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		
		cupones:uploadImage(0,2)
	}
}
	
function editDealsReward(){
	var result;
	result = validationsRewardDeals();
	//result = true;
	if(result == true){
		typeModi = true;
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		var nameImage = $('#imagenName').val();
		if(document.getElementById('fileImagen').value == ""){
			ajaxSaveCoupon(nameImage,idDeals,2);
		} else {
			uploadImage(idDeals,2);
		}
	}	
}

$( "#btnAddGrantReward" ).on( "click", function(){
	if(addDealsReward){
		typeModi = false;
		createModalReward();
		dialog.dialog( "open" );
		cleanFields();
		$('#txtPartner').val($('#txtPartnerCampana').val());
		$('#partnerList').html(
			"<option id='" + $('#txtPartnerCampana').attr('idP') + "' value='" +  $('#txtPartnerCampana').val() + "' />"
		);
		$('#viewEvent').hide();
		$('#FormEvent').show();
		$('#btnCancel').hide();
		$('#btnSaveCoupon').hide();
		$('#btnRegisterCoupon').hide();
	}
});
  
 ////muestra la info del deals para editar
function showDealsReward(id){
	typeModi = true;
	createModalReward();
	idDeals = id
	cleanFields();
	cupones:showCoupon(id);
	dialog.dialog( "open" );
	$('#txtPartner').val($('#txtPartnerCampana').val());
	$('#partnerList').html(
		"<option id='" + $('#txtPartnerCampana').attr('idP') + "' value='" +  $('#txtPartnerCampana').val() + "' />"
	);
	$('#viewEvent').hide();
	$('#FormEvent').show();
	$('#btnCancel').hide();
	$('#btnSaveCoupon').hide();
	$('#btnRegisterCoupon').hide();
	return false;
}
  
/*********************************************/
/*******************Deals*********************/
/*********************************************/

////////////elimina el deals selecionado
function deleteDealsReward(selector){
	var IDDeals = $(selector).attr('id');
	$('#TR' + IDDeals).remove();
	$('#tableGrantReward tbody tr').each(function(index, element) {
       	$(this).find('.tableId').html(index + 1);
    });
}

/**********muestra la recompensa en la tabla****/
function AddNewDealsRecompensa(idDeals){
	dialog.dialog( "close" );
	if(typeModi == false){
		var flagDealsNew = 0;
		$('#tableGrantReward tbody tr').each(function(index, element){
			flagDealsNew++;
		});
			
		$('#tableGrantReward tbody').append(
			'<tr class="newDeals" id="TRId' + idDeals + '">' +
				'<td class="tableId">' + (flagDealsNew + 1)  + '</td>' +
				'<td><a class="showDealsReward" value="' + idDeals + '">' + $('#txtName').val()  + '</a></td>' +
				'<td><a id="Id' + idDeals + '" class="deleteDealsReward"><img id="imgDelete" src="assets/img/web/delete.png"/></a>	</td>' +
			'</tr>'
		);
	}else{
		//drawnDealsReward();
		//$('#tableGrantReward tbody').find('#TRId' + idDeals).find('td').find('a').html($('#txtName').val());
		$("#tableGrantReward tbody #TRId" + idDeals).each(function (index){
            	$(this).children("td").each(function (index2){
                	switch (index2){
                    	case 1:
							$(this).html(
								'<a class="showDealsReward" value="' + idDeals + '">' + $('#txtName').val()  + '</a>'
							);
                      	break;
                }
            });
        });
	}
}

function createModalReward(){
	
	if(typeModi == false){
		dialog = $( "#dialog-form" ).dialog({
   			autoOpen: false,
      		height: "auto",
      		width: "80%",
      		modal: true,
      		buttons: {
        		"añadir deals":addDealsReward,
        		Cancel: function() {
        		  dialog.dialog( "close" );
        		}
      		},
      		close: function() {
      		}
   		});
	}else{
	 	dialog = $( "#dialog-form" ).dialog({
   			autoOpen: false,
      		height: "auto",
      		width: "80%",
      		modal: true,
      		buttons: {
        		"editar deals":editDealsReward,
        		Cancel: function() {
        		  dialog.dialog( "close" );
        		}
      		},
      		close: function() {
      		}
   		});
	}
}


/////////////modal busqueda///////////////////

//muestra la tabla de los deals del comercio
function showDealsTable(){
	if(addDealsReward){
		dialog2.dialog( "open" );
		loadTableDealsReward();
	}
}

//cargamos los datos de la tabla de deals
function loadTableDealsReward(){	
	$.ajax({
		type: "POST",
		url: "deals/getDealsOfRewardByParner",
		dataType:'json',
		data: {
			partnerId:$('#txtPartnerCampana').attr('idP')
		},
		success: function(data){
			$('#tableCouponReward tbody').empty();
			for(i=0;i<data.length;i++){
				$('#tableCouponReward tbody').append(
					'<tr>'+
						'<td>' + (i+1) + '</td>' +
						'<td>' + data[i].name + '</td>' +
						'<td><input id="checkDR' + data[i].id + '" class="checkDealsReward" type="checkbox" idDeal="' + data[i].id + '" nameDeals="' + data[i].name + '"></td>' +
					'</tr>'
				);
				
				$('#tableGrantReward tbody tr').each(function(index, element) {
            		var trid = $(this).attr('id');
					var idD = trid.split("TRId");
					if( 'checkDR' + data[i].id  == 'checkDR' + idD[1]){
						$('#checkDR' + data[i].id).prop('checked', true);
					}	 
          		});
			}
			/////// paginador///////////
			
			var totalDeals = Math.ceil(data.length/10)
			if(data.length%10 == 0){
				totalDeals = totalDeals - 1;		
			}
			
			$('#tablePagi').html(
				'<ul class="pagination" id="pgtDealsRe">'+
					'<li id="btnPaginadorDealsReward" value="0" class="btnPaginador arrow primero unavailable">' +
						'<a>&laquo;</a>' +
					'</li>' +
					
				'</ul>'
			);
			
			for(i=1;i<=totalDeals;i++){
				if(i == 1){
					$('#pgtDealsRe').append(
						'<li id="btnPaginadorDealsReward" value="' + i + '" class="btnPaginador current">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
				else {
					
					$('#pgtDealsRe').append(
						'<li id="btnPaginadorDealsReward" value="' + i + '" class="btnPaginador">' +
							'<a>' + i + '</a>' +
						'</li>'
					);
				}
			}
			
			$('#pgtDealsRe').append(
				'<li id="btnPaginadorDealsReward" value="' + (totalDeals) + '" class="btnPaginador arrow ultimo">' +
					'<a>&raquo;</a>' +
				'</li>'
			);
		},
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});
}

////agrega un deals de la tabla a la recompensa
function addDealsOfTableToReward(selector){
	if($(selector).prop('checked')){
		
		var IDDeals = $(selector).attr('idDeal');
		$('#TRId' + IDDeals).remove();
		$('#tableGrantReward tbody tr').each(function(index, element) {
       		$(this).find('.tableId').html(index + 1);
    	});
		
	}else{
		var idDeals = $(selector).attr('idDeal');
		var nameDeals = $(selector).attr('nameDeals');
		
		var flagDealsNew = 0;
		$('#tableGrantReward tbody tr').each(function(index, element){
			flagDealsNew++;
		});
			
		$('#tableGrantReward tbody').append(
			'<tr class="newDeals" id="TRId' + idDeals + '">' +
				'<td class="tableId">' + (flagDealsNew + 1)  + '</td>' +
				'<td><a class="showDealsReward" value="' + idDeals + '">' + nameDeals  + '</a></td>' +
				'<td><a id="Id' + idDeals + '" class="deleteDealsReward"><img id="imgDelete" src="assets/img/web/delete.png"/></a>	</td>' +
			'</tr>'
		);
		
		
	}
	//console.log($(this).attr('checked'));
}