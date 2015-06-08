//JavaScript Documents

//muestra los formularios
$("#btnAddAds").click(function() { showFormAdd(); });
$(document).on('click','#showAds',function(){ ShowFormEdit(this); });
$(document).on('click','#imageDelete',function(){ ShowFormDelete(this); });

//botones para agregar, modificar o eliminar ads
$('#btnRegisterAds').click(function() { addAds(); });
$('#btnSaveAds').click(function() { editAds(); });
$("#btnCancel").click(function() {cancelForm()});

//botones para eliminar y cancelar el formulario de eliminar
$(".btnAcceptC").click(function() {eventDelete()});
$(".btnCancelC").click(function() {eventCancelDelete()});

//activa el formulario de autocompletar
$("#txtPartner").keyup(function() { finderAutocomplete(); });

//llama a la funcion para cambiar la imagen
$("#imgImagen").click(function() {changeImage()});

//llama a la funcion cuando se cambia el dropdown
$("#txtType").change(function() { changeDropDown(this); });

//Llama a la funcion para validar que no sea punto decimal
$(document).on('keydown','#txtBeacons',function() {
	validateFloat();
});

//llama a la funcion para validar los campos de latitude y longitude
$(document).on('keydown','#txtLatitude, #txtLongitude',function() {
	validarCoordenada();
});

///////////////////////////////////////////////////
/////////////////Funciones/////////////////////////
///////////////////////////////////////////////////

//muestra el formulario para agregar mensajes
function showFormAdd(){
	cleanFields();
	$('#btnSaveAds').hide();
	$('#btnRegisterAds').show();
	$('#ViewTablaAds').hide();
	$('#ViewFormAds').show();
}

//muestra el formulario para modificar datos
function ShowFormEdit(id){
	cleanFields();
	id = $(id).find('input').val();
	$('#btnSaveAds').val(id);
	showAds(id);
	$('#btnRegisterAds').hide();
	$('#btnSaveAds').show();
}

//muestra el formulario para eliminar cupones
function ShowFormDelete(idAds){
	$('.btnAcceptC').val($(idAds).attr("value"));
	$('#divMenssagewarning').hide(500);
	$('#divMenssage').hide();
	$('#divMenssagewarning').show(1000);
}

//llama a la funcion para registrar cupones
function addAds(){
	var result;
	result = validations();
	if(result == true){
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		if($("#txtType").val() == 1){
			ajaxSaveAds("",0)
		}else{
			uploadImage(0)
		}
	}
}

//llama a la funcion para editar deals
function editAds(){
	
	var result = validations()
	
	if(result == true){
		id = $('#btnSaveAds').val();
		var nameImage = $('#imagenName').val();
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		if($("#txtType").val() == 1){
			ajaxSaveAds("",id)
		}else{
			if(document.getElementById('fileImagen').value == ""){
				ajaxSaveAds(nameImage,id);
			} else {
				uploadImage(id);
			}
		}
	}	
}

//regresa a la tabla de cupones
function cancelForm(){
	cleanFields();
	$('#ViewFormAds').hide();	
	$('#ViewTablaAds').show();
	hideAlerts();
}

//oculta la opcion de eliminar
function eventCancelDelete(){
	$('#divMenssagewarning').hide(1000);
}

/////////*elimina el deals selecionado*//////

function eventDelete(idCoupon){
	numPag = $('ul .current').val();
	$.ajax({
		type: "POST",
		url: "ads/deleteAds",
		dataType:'json',
		data: {
			id:$('.btnAcceptC').val()
		},
		success: function(data){
			//verifica si se elimino la ultima fila de la tabla
			var aux = 0;
			$('#tableAds tbody tr').each(function(index) {
				aux++;
			});
			
			//si es uno regarga la tabla con un indice menos
			if(aux == 1){
				numPag = numPag-1;
			}
			ajaxMostrarTabla(column,order,"ads/getallSearch",(numPag-1),"ads");
			$("#divMenssagewarning").hide(1000);
			$('#alertMessage').empty();
			$('#alertMessage').append("Se han eliminado el mensaje");
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').hide(1000);
		},
		error: function(data){
			alert("error al eliminar un mensaje. Por favor vuelva a intentarlo")	
		}
	});
}

////////////* sube la imagen al servidor *///////////////

//sube las imagen al directorio assets/img/app/coupon
function uploadImage(id){
	
	//creamos la variable Request 
	if(window.XMLHttpRequest) {
 		var Req = new XMLHttpRequest(); 
 	}else if(window.ActiveXObject) { 
 		var Req = new ActiveXObject("Microsoft.XMLHTTP"); 
 	}	
	
	var data = new FormData(); 
		
	//var ruta = new Array();
		
	if(document.getElementById('fileImagen').value != ""){
		var archivos = document.getElementById("fileImagen");//Damos el valor del input tipo file
 		var archivo = archivos.files; //obtenemos los valores de la imagen
		data.append('image',archivo[0]);
		ruta = "assets/img/app/message/";
	}
	
	//rutaJson = JSON.stringify(ruta);
	data.append('ruta',ruta);
		
	data.append('nameImage',$('#imagenName').val());
		
	//cargamos los parametros para enviar la imagen
	Req.open("POST", "ads/uploadImage", true);
		
	//nos devuelve los resultados
	Req.onload = function(Event) {
			//Validamos que el status http sea ok 
	if (Req.status == 200) {
 	 	//Recibimos la respuesta de php
  		var nameImage = Req.responseText;
			ajaxSaveAds(nameImage,id);
		} else { 
  			alert(Req.status); //Vemos que paso.
		} 	
	};
		
	//Enviamos la petición 
 	Req.send(data);
}

function ajaxSaveAds(nameImage,id){
	
	var valuePartner = $('#txtPartner').val().trim();
	var idPartner = $('datalist option[value="' + valuePartner + '"]').attr('id');
	
	var typeA = $('#txtType').val();
	
	numPag = $('ul .current').val();
	
	$.ajax({
		type: "POST",
		url: "ads/saveAds",
		dataType:'json',
		data: {
			id:id,
			major:$("#txtBeacons").val(),
			typeA:typeA,
			partnerId:idPartner,
			message:$("#txtMensaje").val(),
			image:nameImage,
			distanceMin:$("#txtDistMin").val(),
			distanceMax:$("#txtDistMax").val(),
			latitude:$("#txtLatitude").val(),
			longitude:$("#txtLongitude").val(),
			displayInfo:$('#txtAddInfo').val()
		},
		success: function(data){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"ads/getallSearch",0,"ads");
			} else {
				ajaxMostrarTabla(column,order,"ads/getallSearch",(numPag-1),"ads");
			}
			$('#ViewFormAds').hide();
			$('#ViewTablaAds').show();
			$('#alertMessage').empty();
			$('#alertMessage').html(data);
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').toggle(1000);
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
		},
		error: function(){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"ads/getallSearch",0,"ads");
			} else {
				ajaxMostrarTabla(column,order,"ads/getallSearch",(numPag-1),"ads");
			}
			$('#ViewFormAds').hide();
			$('#ViewTablaAds').show();
			$('#alertMessage').empty();
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
			alert("error al insertar datos");
		}
	});
}

//muestra los datos de un cupon
function showAds(id){
	
	$.ajax({
		type: "POST",
		url: "ads/getId",
		dataType:'json',
		data: { 
			id:id
		},
		success: function(data){
			$('#txtMensaje').val(data[0].message);
			$('#txtPartner').val(data[0].partnerName);
			$('#txtBeacons').val(data[0].major);
			$('#txtDistMin').val(data[0].distanceMin);
			$('#txtDistMax').val(data[0].distanceMax);
			$('#txtLatitude').val(data[0].latitude);
			$('#txtLongitude').val(data[0].longitude);
			$('#partnerList').append("<option id='" + data[0].partnerId + 
			"' value='" +  data[0].partnerName + "' />" );
			if(data[0].type == 1){
				$("#txtType option[value=1]").attr("selected",true);
				if(data[0].image != null){
					$('#imagenName').val(data[0].image);
				}
			}else{
				$("#txtType option[value=2]").attr("selected",true);
				$('#imgImagen').attr("src",URL_IMG + "app/message/" + data[0].image 
				+ "?version=" + (new Date().getTime()));
				$('#imagenName').val(data[0].image);
				$('#imgImagen').attr("hidden",data[0].image);
				$('#txtAddInfo').val(data[0].displayInfo);
				$(".typeAd").show();
			}
			$('#ViewTablaAds').hide();
			$('#ViewFormAds').show();
			
		},
		error: function(data){
			alert("Error al mostrar los datos del mensaje. Por Favor Vuelva a intentarlo")	
		}
	});
}


//valida el formulario de agregar o editar
function validations(){
	var result = true;
	
	hideAlerts();
	
	if($('#txtLongitude').val().trim().length == 0){
        $('#alertLongitude').show();
		$('#lblLongitude').addClass('error');
		$('#txtLongitude').focus();
		result = false;
	}
	
	if($('#txtLatitude').val().trim().length == 0){
        $('#alertLatitude').show();
		$('#lblLatitude').addClass('error');
		$('#txtLatitude').focus();
		result = false;
	}
	
	if($('#txtAddInfo').val().trim().length == 0 && $("#txtType").val() == 2){
        $('#alertAddInfo').show();
		$('#lblAddInfo').addClass('error');
		$('#txtAddInfo').focus();
        result = false;
	}
	
	if($('#imagenName').val() == "" && $('#fileImagen').val().length == 0 && $("#txtType").val() == 2){
        $('#alertImage').empty();
        $('#alertImage').append("Campo vacio. Selecione una imagen");
        $('#alertImage').show();
		$('#lblPartnerImage').addClass('error');
        result = false;
	}
	
	if($('#txtDistMax').val().trim().length == 0){
        $('#alertDistMax').show();
		$('#labelDistMax').addClass('error');
		$('#txtDistMax').focus();
		result = false;
	}
	
	if($('#txtDistMin').val().trim().length == 0){
        $('#alertDistMin').show();
		$('#labelDistMin').addClass('error');
		$('#txtDistMin').focus();
		result = false;
	}
	
	if($('#txtBeacons').val().trim().length == 0){
        $('#alertBeacons').show();
		$('#labelBeacons').addClass('error');
		$('#txtBeacons').focus();
		result = false;
	}
	
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
	
	if($('#txtMensaje').val().trim().length == 0){
        $('#alertMensaje').show();
		$('#labelMensaje').addClass('error');
		$('#txtMensaje').focus();
		result = false;
	}
	
	return result;
}

//escondemos los mensajes de alerta
function hideAlerts(){
	$('#alertMensaje').hide()
	$('#alertPartner').hide();
	$('#alertBeacons').hide();
	$('#alertDistMin').hide();
	$('#alertDistMax').hide();
	$('#alertLatitude').hide();
	$('#alertLongitude').hide();
	$('#alertImage').hide();
	$('#alertAddInfo').hide();
		
	$('#labelMensaje').removeClass('error');
	$('#labelPartner').removeClass('error');
	$('#labelBeacons').removeClass('error');
	$('#labelDistMin').removeClass('error');
	$('#labelDistMax').removeClass('error');
	$('#lblLatitude').removeClass('error');
	$('#lblLongitude').removeClass('error');
	$('#labelImage').removeClass('error');
	$('#lblAddInfo').removeClass('error');
}

//limpia los campos
function cleanFields(){
	$('#txtMensaje').val("");
	$('#txtPartner').val("");
	$('#txtBeacons').val("");
	$('#txtDistMin').val("");
	$('#txtDistMax').val("");
	$('#txtLatitude').val("");
	$('#txtLongitude').val("");
	$('#txtAddInfo').val("");
	$('#imgImagen').attr("src","http://placehold.it/150x150&text=[150x150]");
	document.getElementById('fileImagen').value ='';
	$("#txtType option[value=1]").attr("selected",true);
	$(".typeAd").hide();
	$('#partnerList').empty();
	$('#divMenssage').hide();
	$('#divMenssagewarning').hide();
	$('#imagenName').val("");
}

/********detecta cuando se cambia el dropdown********/
function changeDropDown(selector){
	valueType = $(selector).val();
	if(valueType == 2){
		$('.typeAd').toggle(1000);
	}else{
		$('.typeAd').toggle(1000);
	}
}

/////////////////////////////////////////////////////

/********** funcion de autocompletar *********/
function finderAutocomplete(){
	$.ajax({
		type: "POST",
		url: "partners/getPartner",
		dataType:'json',
		data: {
			dato:$("#txtPartner").val()
		},
		success: function(data){
			console.log(data);
			$('#partnerList').empty();
			for(var i = 0;i<data.length;i++){
				$('#partnerList').append(
					"<option id='" + data[i].id + "' value='" +  data[i].name + "' lat='" + data[i].latitude + "' log='" + data[i].longitude + "' />"
				);
			}
        }
	});
}

$("#txtPartner").change(function() {
	var idPartner;
	var valorPartner = $('#txtPartner').val().trim();
	idPartner = $('datalist option[value="' + valorPartner + '"]').attr('id');
	if(idPartner != undefined){
		$("#txtLatitude").val($("#" + idPartner).attr("lat"));
		$("#txtLongitude").val($("#" + idPartner).attr("log"));
	}
	
});

////////////////////////////////////////////////////
////////* visualizacion de la imagen *//////////////
////////////////////////////////////////////////////

//abre el explorador de archivos cuando le das click a la imagen de cupones
function changeImage(){
	$('#fileImagen').click();
}

//muestra la imagen en la pagina
$(window).load(function(){
	$(function() {
		$('#fileImagen').change(function(e) {
			$('#labelImage').removeClass('error');
			$('#alertImage').hide();
			$('#imgImagen').attr("src","http://placehold.it/150x150&text=[150x150]");
			if($('#imagenName').val() != ""){
				$('#imgImagen').attr("src",URL_IMG + "app/deal/" + $('#imagenName').val())
			}
			if(e.target.files[0] != undefined){
				addImage(e); 
			}
		});

		function addImage(e){
			var file = e.target.files[0],
			imageType = /image.*/;
    
			if (!file.type.match(imageType)){
				$('#imgImagen').attr("src","http://placehold.it/150x150&text=[150x150]");
				document.getElementById('fileImagen').value ='';
				if($('#imagenName').val() != ""){
					$('#imgImagen').attr("src",URL_IMG + "app/deals/" + $('#imagenName').val())
				} else {
				$('#labelImage').addClass('error');
				$('#alertImage').empty();
				$('#alertImage').append("Selecione una imagen");
				$('#alertImage').show();
			}
			return;
		}
  
		var reader = new FileReader();
			reader.onload = fileOnload;
			reader.readAsDataURL(file);
		}
  
		function fileOnload(e) {
			var result=e.target.result;
			$('#imgImagen').attr("src",result);
		}
	});
});

/////////////////////////////////////////////////////

//valida que no se ingresen numeros enteros

function validateFloat(){
	if(event.shiftKey){
		event.preventDefault();
		console.log("hola")
   	}
 
   	if (event.keyCode == 46 || event.keyCode == 8)    {  		
   	}
   	else {
		if (event.keyCode < 95) {
		   	if (event.keyCode < 48 && event.keyCode != 9 && event.keyCode != 37 && event.keyCode != 39 
			|| event.keyCode > 57) {
			   	event.preventDefault();
			}
		} else {
			if (event.keyCode < 96 || event.keyCode > 105) {
				event.preventDefault();
			}
		}
	}	
}

/************valida las entreda de teclado de coordenadas **************/
function validarCoordenada(){
	if(event.shiftKey){
		event.preventDefault();
   	}
 
   	if (event.keyCode == 46 || event.keyCode == 8)    {  		
   	}
   	else {
		if (event.keyCode < 95) {
		   	if (event.keyCode < 48 && event.keyCode != 9 && event.keyCode != 37 && event.keyCode != 39 
			|| event.keyCode > 57) {
			   	event.preventDefault();
			}
		} else {
			if (event.keyCode < 96 || event.keyCode > 105 && event.keyCode != 109 && event.keyCode != 189 
			&& event.keyCode != 110 && event.keyCode != 190) {
				event.preventDefault();
			}
		}
	}
}

///////////////////////////////////////////////////////////