//JavaScript Document

numImage = 0;
idGalleryDelete = new Array();

//botones que muestran los diferentes formularios
$('#btnAddEvent').click(function(){showFormAdd()});
$(document).on('click','#showEvent',function(){ ShowFormEdit(this); });
$(document).on('click','#imageDelete',function(){ ShowFormDelete(this); });
$('#btnGaleria').click(function() {ShowFormGallery()});

//botones que registras,modifican o eliminan eventos 
$('#btnRegisterEvent').click(function() {eventAdd()});
$('#btnSaveEvent').click(function() {eventEdit()});
$('#btnCancel').click(function() {eventCancel()});

//botones para el formulario de eliminar eventos
$('.btnAcceptE').click(function() {eventDelete()});
$('.btnCancelE').click(function() {eventCancelDelete()});

//llama a la funcion cada vez que se quiere cambiar la imagen
$("#imgImagen").click(function() { $('#fileImagen').click(); });
$("#imgImagenF").click(function() { $('#fileImagenF').click(); });

//funcio que se llama cada vez que se teclea en el 'imput' place
$("#txtEventPlace").keyup(function() { autocomplete("place"); });
$("#txtEventCity").keyup(function() { autocomplete("city"); });

//Llama a la funcion para validar la cantidad de letras que se ingresan
$(document).on('keydown','#txtEventName',function() {
	validarCadena();
});

//llama a la funcion cada vez que se cambia un valor en los radiobutton
$("input:radio[name=RadioPlace]").change(function() { clearPlace(); });

///////////////////////////////////////////////////////////////////
//////////////////FUNCIONES///////////////////////////////////////
//////////////////////////////////////////////////////////////////

//muestra el formulario para agregar eventos
function showFormAdd(){
	cleanFields();
	hideAlert();
	$('#btnSaveEvent').hide();
	$('#btnRegisterEvent').show();
	$('#btnGaleria').hide();
	$('#ViewTablaEvent').hide();
	$('#ViewFormEvent').show();
}

//muestra el formulario para modificar eventos
function ShowFormEdit(id){
	cleanFields();
	hideAlert();
	id = $(id).find('input').val();
	$('#btnSaveEvent').val(id); 
	showsEvent(id);
	$('#btnRegisterEvent').hide();
	$('#btnSaveEvent').show();
	$('#btnGaleria').hide();
	$('#ViewTablaEvent').hide();
	$('#ViewFormEvent').show();
}
	
//muestra el formulario para eliminar eventos
function ShowFormDelete(id){
	id = $(id).attr('value');
	$('.btnAcceptE').val(id);
	$('#divMenssagewarning').hide(500);
	$('#divMenssage').hide();
	$
	('#divMenssagewarning').show(1000);
}

//llama a la funcion para agregar un evento
function eventAdd(){
	var result;
	result = validations();
	if(result){
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		uploadImage(0);
	}
}

//llama a la funcion de eliminar imagen y editar evento
function eventEdit(){
	var result;
	result = validations();
	id = $('#btnSaveEvent').val();
	if(result){
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
       	var nameImage = $('#imagenName').val();
		if(document.getElementById('fileImagen').value == ""
               && document.getElementById('fileImagenF').value == "" ){
				 
		 	var str = $('#imagenName').val();
			var res = str.split("e_");
			str = res[1];
			res = str.split(".jpg");
				  
			ajaxSaveEvent(res[0],id);
		} else {
			uploadImage(id);
		}
	}
}

//regresa a la tabla de eventos
function eventCancel(){
	cleanFields();
	hideAlert();
	$('#ViewFormEvent').hide();	
	$('#ViewTablaEvent').show();
}

/********oculta el formulario de eliminar *////////
function eventCancelDelete(){
	$('#divMenssagewarning').hide(1000);
}

//elimina el evento selecionado
function eventDelete(){
	id = $('.btnAcceptE').val();
	numPag = $('ul .current').val();
	$.ajax({
		type: "POST",
    	url: "eventos/deleteEvent",
       	dataType:'json',
       	data: { 
			id:id
		},
       	success: function(data){
			var aux = 0;
			$('#tableEvents tbody tr').each(function(index) {
           		aux++;
           	});
			
			//si es uno regarga la tabla con un indice menos
			if(aux == 1){
				numPag = numPag-1;
			}
			ajaxMostrarTabla(column,order,"eventos/getallSearch",(numPag-1),"event");
			$('#divMenssagewarning').hide(1000);
			$('#alertMessage').empty();
			$('#alertMessage').append("se ha eliminado el evento");
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').hide(1000);
       	},
	   	error: function(data){
			alert("Error al eliminar un evento")
		   $('#divMenssagewarning').hide(1000);
		}
	});
}

////////***sube la imagen al servidor ***////////////////////

//sube las imagen al directorio assets/img/app/coupon
function uploadImage(id){
	
	//creamos la variable Request 
	if(window.XMLHttpRequest) {
		var Req = new XMLHttpRequest(); 
 	}else if(window.ActiveXObject) { 
 		var Req = new ActiveXObject("Microsoft.XMLHTTP"); 
 	}
	
	var data = new FormData(); 
	
	var ruta = new Array();
		
	if(document.getElementById('fileImagen').value != ""){
		var archivos = document.getElementById("fileImagen");//Damos el valor del input tipo file
 		var archivo = archivos.files; //obtenemos los valores de la imagen
		data.append('Image',archivo[0]);
		ruta.push("assets/img/app/event/");
	}
		
	if(document.getElementById('fileImagenF').value != ""){
		var archivos = document.getElementById("fileImagenF");//Damos el valor del input tipo file
 		var archivo = archivos.files; //obtenemos los valores de la imagen
		data.append('ImageF',archivo[0]);
		ruta.push("assets/img/app/event/full/");
	}
		
	rutaJson = JSON.stringify(ruta);
	data.append('ruta',ruta);
	
	if($('#imagenName').val() != 0){
		var str = $('#imagenName').val();
		var res = str.split("e_");
		str = res[1];
		res = str.split(".jpg");
		data.append('nameImage',res[0]);
	}else{
		data.append('nameImage',"");
	}
		
	//cargamos los parametros para enviar la imagen
	Req.open("POST", "eventos/subirImagen", true);
		
	//nos devuelve los resultados
	Req.onload = function(Event) {
		//Validamos que el status http sea ok 
		if (Req.status == 200) {
 	 		//Recibimos la respuesta de php
  			var nameImage = Req.responseText;
			ajaxSaveEvent(nameImage,id);
		} else { 
  			alert(Req.status); //Vemos que paso.
		} 	
	};
		
	//Enviamos la petición 
 	Req.send(data);
}

////////*** funcion que guarda o actualiza los datos del evento *////////

//agrega o modifica los datos del evento
function ajaxSaveEvent(nameImage,id){
	
	var imageN = "e_" + nameImage + ".jpg";
	var imageF = "ef_" + nameImage + ".jpg";
		
	//regresa la id del lugar
	var valuePlace = $('#txtEventPlace').val();
	var idPlace = $('#placeList option[value="' + valuePlace + '"]').attr('id');
	
	var valueCity = $('#txtEventCity').val();
	var idCity = $('#cityList option[value="' + valueCity + '"]').attr('id');
	
	var typePlace = $('input:radio[name=RadioPlace]:checked').val();
	
	var idFilter = new Array();
	$('input[name=filter]:checked').each(function() {
		idFilter.push($(this).val());
	});
	
	var jsonIdFilter = JSON.stringify(idFilter);
	
	numPag = $('ul .current').val();
	$.ajax({
   		type: "POST",
       	url: "eventos/saveEvent",
		dataType:'json',
		data: { 
			id:id,
			name:$('#txtEventName').val(),
			idPlace:idPlace,
			cityId:idCity,
			typePlace:typePlace,
			detail:$('#txtEventDetail').val(),
			date:$('#dtEventDate').val(),
			endDate:$('#dtEventEndDate').val(),
			image:imageN,
			imageFull:imageF,
			idFilter:jsonIdFilter
		},
		success: function(data){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"eventos/getallSearch",0,"event");
			} else {
				ajaxMostrarTabla(column,order,"eventos/getallSearch",(numPag-1),"event");
			}
			$('#ViewFormEvent').hide();
			$('#ViewTablaEvent').show();
			$('#alertMessage').empty();
			$('#alertMessage').html(data);
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').hide(1000);
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
		},
		error: function(){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"eventos/getallSearch",0,"event");
			} else {
				ajaxMostrarTabla(column,order,"eventos/getallSearch",(numPag-1),"event");
			}
			$('#ViewFormEvent').hide();
			$('#ViewTablaEvent').show();
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
			alert("error al insertar datos")
		}
	});
}

//////*muestra los datos de evento selecionado *///////////////

//muestra los datos del evento a modificar
function showsEvent(id){
	$.ajax({
		type: "POST",
      	url: "eventos/getID",
      	dataType:'json',
      	data: { 
			id:id
      	},
       	success: function(data){
			$('#txtEventName').val(data.items[0].name);
			$('#txtEventPlace').val(data.items[0].place);
			if(data.items[0].partnerId == null){
				$("#radioPlace").prop('checked', true);
				$('#placeList').append("<option id='" + data.items[0].placeId + "' value='" +  data.items[0].place + "' />");
			}else{
				$("#radioPartner").prop('checked', true);
				$('#placeList').append("<option id='" + data.items[0].partnerId + "' value='" +  data.items[0].place + "' />");
			}
			
			$('#txtEventCity').val(data.items[0].cityName);
			$('#cityList').append("<option id='" + data.items[0].cityId + "' value='" +  
				data.items[0].cityName + "' />");
			
			$('#txtEventDetail').val(data.items[0].detail);
			var dateTime = data.items[0].iniDate;
			var replaced = dateTime.replace(" ",'T');
			$('#dtEventDate').val(replaced);
			var dateTime = data.items[0].endDate;
			var replaced = dateTime.replace(" ",'T');
			$('#dtEventEndDate').val(replaced);
          	$('#imgImagen').attr("src",URL_IMG + "app/event/" + data.items[0].Image + "?version=" + (new Date().getTime()))
            $('#imgImagenF').attr("src",URL_IMG + "app/event/full/" + data.items[0].ImageFull + "?version=" + (new Date().getTime()))
			$('#imagenName').val(data.items[0].Image);
           //	$('#imgImagen').attr("hidden",data.items[0].image);
			
			//mostramos los filtros
			
			$('input[name=filter]').each(function(index, element) {
				for(var i=0;i<data.filters.length;i++){
					if($(this).val() == data.filters[i].idFilter){
						$(this).prop('checked', true);
					}
				}
			});
			
      	}
 	});
}

//////////////////////valida que los campos sean correctos/////////////////////
function validations(){
	var result = true;	
	
	hideAlert();
	
	var date = new Date();
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();
	if(day<10){
		day = "0" + day;	
	}
	if(month < 10){
		month = "0" + month;	
	}
	var currentDate =(year + "-" + month + "-" + day);
	
	//validamos que se haya selecionado los filtros
	
	var checkboxFilter = 0;
	$('input[name=filter]:checked').each(function() {
		checkboxFilter++;
   	});
	
	if(checkboxFilter == 0){
		$('#alertFilter').show();
		$('#labelFilter').addClass('error');
        result = false;
	}
	
	// Obtenemos dimensiones
	sizeImage = imgRealSize($("#imgImagen"));
  	sizeImageFull = imgRealSize($("#imgImagenF"));
        
	// Valida que se haya selecionado una imagen
	if($('#imagenName').val() == 0 && $('#fileImagen').val().length == 0){
		$('#alertImage').html("Campo vacio. Selecione una imagen");
		$('#alertImage').show();
		$('#labelImage').addClass('error');
		result = false;
	}else if(sizeImage.width != 100 || sizeImage.height != 100){
  	    $('#alertImage').html("El tamaño no corresponde: 128x128");
		$('#alertImage').show();
		$('#labelImage').addClass('error');
		result = false;
	  }
		
	if($('#imagenName').val() == 0 && $('#fileImagenF').val().length == 0){
		$('#alertImageF').html("Campo vacio. Selecione una imagen");
		$('#alertImageF').show();
		$('#labelImageF').addClass('error');
		result = false;
	}else if(sizeImageFull.width != 440){
      	$('#alertImageF').html("El ancho no corresponde: 440");
		$('#alertImageF').show();
		$('#labelImageF').addClass('error');
		result = false;
  	}
	
	// dtEventEndDate
	if($('#dtEventEndDate').val() < currentDate){
		$('#alertEndDate').html("Fecha Incorrecta. Ingrese una fecha actual");
		$('#alertEndDate').show();
		$('#lblEventEndDate').addClass('error');
		$('#dtEventDate').focus();
		result = false;
	}
		
	if($('#dtEventEndDate').val().trim().length == 0){
		$('#alertEndDate').html("Campo vacio. Ingrese una fecha");
		$('#alertEndDate').show();
		$('#lblEventEndDate').addClass('error');
		$('#dtEventDate').focus();
		result = false;
	} 
	
	if($('#dtEventEndDate').val() < $('#dtEventDate').val()){
		$('#alertEndDate').html("Fecha incorrecta. Ingrese una fecha mayor a la fecha inicio");
		$('#alertEndDate').show();
		$('#lblEventEndDate').addClass('error');
		$('#dtEventDate').focus();
		result = false;
	}
		
	// dtEventDate
	if($('#dtEventDate').val() < currentDate){
		$('#alertEventDate').empty();
		$('#alertEventDate').append("Fecha Incorrecta. Ingrese una fecha actual");
		$('#alertEventDate').show();
		$('#lblEventDate').addClass('error');
		$('#dtEventDate').focus();
		result = false;
	}
		
	if($('#dtEventDate').val().trim().length == 0){
		$('#alertEventDate').empty();
		$('#alertEventDate').append("Campo vacio. Ingrese una fecha");
		$('#alertEventDate').show();
		$('#lblEventDate').addClass('error');
		$('#dtEventDate').focus();
		result = false;
	}
	
	if($('#txtEventDetail').val().trim().length == 0){
		$('#alertDetail').show();
		$('#lblEventDetail').addClass('error');
		$('#txtEventDetail').focus();
		result = false;
	}
	
	valueCity = $('#txtEventCity').val();
	idCity = $('#cityList option[value="' + valueCity + '"]').attr('id');
 	if(idCity == undefined){
		$('#alertCity').show();
		$('#lblEventCity').addClass('error');
		$('#txtEventCity').focus();
		result = false;
	}
		
	valuePlace = $('#txtEventPlace').val();
	idPlace = $('#placeList option[value="' + valuePlace + '"]').attr('id');
 	if(idPlace == undefined){
		$('#alertPlace').show();
		$('#lblEventPlace').addClass('error');
		$('#txtEventPlace').focus();
		result = false;
	}
		
	if($('#txtEventName').val().trim().length == 0){
		$('#alertName').html("Campo vacio. Por favor escriba un nombre");
		$('#alertName').show();
		$('#lblEventName').addClass('error');
		$('#txtEventName').focus();
		result = false;
	}
	
	if($('#txtEventName').val().length > 51){
		$('#alertName').html("Limite alcanzado. Por favor escriba maximo 50 palabras");
		$('#alertName').show();
		$('#lblEventName').addClass('error');
		$('#txtEventName').focus();
		result = false;
	}		
		
	return result;
}

    function imgRealSize(img) {
        var image = new Image();
        image.src = $(img).attr("src");
        return { 'width': image.naturalWidth, 'height': image.naturalHeight }
    }
	
	//oculta las alertas de error
	function hideAlert(){
		$('#alertName').hide();
		$('#alertDetail').hide();
		$('#alertPlace').hide();
		$('#alertCity').hide();
		$('#alertImage').hide();
        $('#alertImageF').hide();
		$('#alertEventDate').hide();
		$('#alertEndDate').hide();
		$('#alertFilter').hide();
		
		$('#lblEventName').removeClass('error');
		$('#lblEventDetail').removeClass('error');
		$('#lblEventPlace').removeClass('error');
		$('#lblEventCity').removeClass('error');
		$('#lblEventDate').removeClass('error');
		$('#lblEventEndDate').removeClass('error');
        $('#labelImage').removeClass('error');
        $('#labelImageF').removeClass('error');
		$('#labelFilter').removeClass('error');
	}
	
	//limpia los campos del formulario
	function cleanFields(){
		$('#txtEventName').val("");
		$('#txtEventPlace').val("");
		$('#placeList').empty();
		$('#txtEventCity').val("");
		$('#cityList').empty();
		$('#txtEventDetail').val("");
		$('#dtEventDate').val("");
		$('#dtEventEndDate').val("");
		
		$('#imgImagen').attr("src","http://placehold.it/100x100&text=[100x100]");
		document.getElementById('fileImagen').value ='';
		$('#imgImagenF').attr("src","http://placehold.it/220x300&text=[440x_]");
		document.getElementById('fileImagenF').value ='';
        
		$('#imagenName').val(0);
		$('#imagenNameF').val(0);
		
		$('#divMenssage').hide();
		$('#divMenssagewarning').hide();	
	}
	
	////////////////////visualizacion de la imagen /////////////////////////////////
	
$(window).load(function(){
	$(function() {
		// Imagen App
		$('#fileImagen').change(function(e) {
			$('#labelImage').removeClass('error');
			$('#alertImage').hide();
			$('#imgImagen').attr("src","http://placehold.it/128x128&text=[128x128]");
			if($('#imagenName').val() != 0){
				$('#imgImagen').attr("src",URL_IMG + "app/event/" + $('#imagenName').val());
			}
			if(e.target.files[0] != undefined){
				addImage(e); 
			}
		});
		
		function addImage(e){
			var file = e.target.files[0],
			imageType = /image.*/;
			if (!file.type.match(imageType)){
				$('#imgImagenApp').attr("src","http://placehold.it/100x100&text=[100x100]");
				document.getElementById('fileImagen').value ='';
				if($('#imagenName').val() != 0){
					$('#imgImagen').attr("src",URL_IMG + "app/event/" + $('#imagenName').val())
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
            
        // Imagen Full
		$('#fileImagenF').change(function(e) {
			$('#labelImageF').removeClass('error');
			$('#alertImageF').hide();
			$('#imgImagenF').attr("src","http://placehold.it/440x600&text=[440x_]");
			if($('#imagenName').val() != 0){
				$('#imgImagenF').attr("src",URL_IMG + "app/event/full/" + $('#imagenName').val())
			}
			if(e.target.files[0] != undefined){
				addImageF(e); 
			}
		});
            
		function addImageF(e){
			var file = e.target.files[0],
			imageType = /image.*/;
			if (!file.type.match(imageType)){
				$('#imgImagenF').attr("src","http://placehold.it/440x600&text=[440x_]");
				document.getElementById('fileImagenF').value ='';
				if($('#imagenNameF').val() != 0){
					$('#imgImagenF').attr("src",URL_IMG + "app/event/full/" + $('#imagenName').val())
				} else {
					$('#labelImageF').addClass('error');
					$('#alertImageF').empty();
					$('#alertImageF').append("Selecione una imagen");
					$('#alertImageF').show();
				}
				return;
			}
			var reader = new FileReader();
			reader.onload = fileOnloadF;
			reader.readAsDataURL(file);
		}
		function fileOnloadF(e) {
			var result=e.target.result;
			$('#imgImagenF').attr("src",result);
		}
	});
});

// fin visualizar imagen

///////////*funcion del autocompletar de lugar *//////////////

function autocomplete(campo){
	
	if(campo == "place"){
		var url = "eventos/getNamePlace";
		var dato = $('#txtEventPlace').val();
	} else {
		var url = "city/getCities";
		var dato = 	$("#txtEventCity").val();
	}
	
	$.ajax({
		type: "POST",
		url:url,
		dataType:'json',
		data: {
			dato:dato,
			tabla:$('input:radio[name=RadioPlace]:checked').val()
		},
		success: function(data){
			if(campo == "place"){
				$('#placeList').empty();
				for(var i = 0;i<data.length;i++){
					$('#placeList').append(
						"<option id='" + data[i].id + "' value='" +  data[i].name + "' />"
					);
				}
			} else {
				$('#cityList').empty();
				for(var i = 0;i<data.length;i++){
					$('#cityList').append(
						"<option id='" + data[i].idCity + "' value='" +  data[i].name + "' />"
					);
				}
			}
		}
	});
}

////////validamos el total de letras de un input

function validarCadena(){
	if($('#txtEventName').val().length > 50 && event.keyCode != 8 && event.keyCode != 9
		&& event.keyCode != 37 && event.keyCode != 39){
		event.preventDefault();
	}
}

///////////////*limpiamos el txt de place ***********/////

function clearPlace(){
	$('#txtEventPlace').val("");    
	$('#placeList').empty();	
}


////////////////////////////////////////////////////////////
//////////////////////GALERIA///////////////////////////////
////////////////////////////////////////////////////////////

//cambia la imagen de la galeria
$("#imgImageGallery").click(function() {changeImageGallery();});

//agrega una umagen a la galeria
$("#btnAddGallery").click(function() {addGallery()});

//botones para guardar o cancelar la galeria
$('#btnSaveGallery').click(function() {eventAddGallery()});
$('#btnCancelGallery').click(function() {CancelGallery()});

//elimina una imagen de la galeria
$(document).on('click','#imgDeleteBlack',function(){ deleteGallery(this); });

//muestra la galeria del comercio
function ShowFormGallery(){
	cleanGallery();
	showGallery();
	$('#ViewFormEvent').hide();
	$('#galleryEvent').show();
}

function addGallery(){
	result = validateGallery();
	//result = true;
	if(result){
			
		var gallery = "gallery" + numImage;
		$('#gridImages').append(
			"<div id='imgPlacegallery' class='small-6 medium-6 large-4 columns "+ gallery + "'>"+
            		"<a id='imgDeleteBlack' value='"+ gallery + "'><img src='../assets/img/web/deleteBlack.png' /></a>"+
					"<img id='imgImageMiniGallery' src='" + $('#imgImageGallery').attr('src')+ "' />"+
					"<input type='file' id='"+ gallery +"' class='fileGallery'/>" +
					"<div id='imgPlacegallery' class='small-12 medium-12 large-12 columns' style='height:25px;'>" +
           "</div>"
		);
		
		//style='display:none'
			
		var archivos2 = document.getElementById("fileImageGallery");
		var archivo2 = archivos2.files;
		document.getElementById(gallery).files = archivo2;
		
		numImage++;
		$('#imgImageGallery').attr("src","http://placehold.it/480x165&text=[480x165]");
	}
}

///elimina una imagen de la galeria
function deleteGallery(selector){
	type = $(selector).attr('value').substring(0,7).toLowerCase();
	valueImage = $(selector).attr('value');
	if(type != "gallery"){
		idGalleryDelete.push(valueImage);
	}
	$('.' + valueImage).remove();
}

//valida la galeria
function validateGallery(){
	result = true;
		
	sizeImageGallery = imgRealSize($("#imgImageGallery"));
		
	if($('#imgImageGallery').attr("src") == "http://placehold.it/480x165&text=[480x165]"){
		$('#alertImageGallery').html("Campo vacio. Selecione una imagen");
		$('#alertImageGallery').show();
		$('#lblImageGallery').addClass('error');
		result = false;
	} else if(sizeImageGallery.width != 480 || sizeImageGallery.height != 165){
      	$('#alertImageGallery').html("El tamaño no corresponde: 480x165");
		$('#alertImageGallery').show();
		$('#lblImageGallery').addClass('error');
		result = false;
 	}
	return result;	
}

//escondemos la galeria
function hideAlertGallery(){
	$('#alertImageGallery').hide();
	$('#alertImageThumb').hide();
		
	$('#lblImageGallery').removeClass('error');
	$('#lblImageThumb').removeClass('error');
}

//limpiamos la galleria	
function cleanGallery(){
	document.getElementById('fileImageGallery').value ='';
	$('#imgImageGallery').attr("src","http://placehold.it/480x165&text=[480x165]");
	$('#gridImages').empty();
	idGalleryDelete.length = 0;
}

//guardamos o actualizamos la galeria
function eventAddGallery(){
	$('.loading').show();
	$('.loading').html('<img src="../assets/img/web/loading.gif" height="40px" width="40px" />');
	$('.bntSave').attr('disabled',true);
	var conTotal = 0;
	$('.fileGallery').each(function() {
		conTotal++;
	});	
	if(conTotal > 0 && idGalleryDelete.length > 0){
		uploadGallery(1,1);
	} else if (conTotal > 0 && idGalleryDelete.length == 0){
		uploadGallery(1,0);
	} else if (conTotal == 0 && idGalleryDelete.length > 0){
		ajaxSaveGallery("",0,1);
	} else {
		ajaxMostrarTabla(column,order,"../admin/event/getallSearch",(numPag-1),"partner");
		$('.loading').hide();
		$('.bntSave').attr('disabled',false);
		$('#galleryEvent').hide();
		$('#ViewTablaEvent').show();
		$('#alertMessage').html("Se han actualizado la galeria");
		$('#divMenssage').show(1000).delay(1500);
		$('#divMenssage').hide(1000);
		$('.loading').hide();
		$('.bntSave').attr('disabled',false);	
	}
}

//cancela la galeria
function CancelGallery(){
	cleanGallery();
	$('#galleryEvent').hide();
	$('#ViewFormEvent').show();
}

////////subimos la galeria al servidor /////////////
function uploadGallery(add,save){
		
	if(window.XMLHttpRequest) {
 		var Req = new XMLHttpRequest();
 	}else if(window.ActiveXObject) { 
 		var Req = new ActiveXObject("Microsoft.XMLHTTP");
 	}
		
	var data = new FormData();
		
	conImage = 0;
		
	$('.fileGallery').each(function() {
		var archivos = document.getElementById($(this).attr('id'));
		var archivo = archivos.files;
		data.append($(this).attr('id'),archivo[0]);
		//conImage++;
   	});
	
	//data.append('total',conImage);
		
	//abrimos la conexion para subir una imagen
	Req.open("POST", "../admin/event/uploadImageGallery", true);
	//verificamos si se executo correctamente el metodo
	Req.onload = function(Event) {
		//Validamos que el status http sea ok 
		if (Req.status == 200) {
 	 		//Recibimos la respuesta de php
			nameImage = Req.responseText;
			ajaxSaveGallery(nameImage,add,save);
		} else { 
  			alert(Req.status); //Vemos que paso.
		} 		
	};
		//Enviamos la petición 
	Req.send(data);
}

//guardamos los datos de la galeria

function ajaxSaveGallery(nameImage,add,save){
		
	numPag = $('ul .current').val();
	if(add == 1){
		nameImageGallery = nameImage.split('*_*');
		nameImageGallery.pop();
		nameImageGallery = JSON.stringify(nameImageGallery);
	} else {
		nameImageGallery = 0;	
	}
		
	if(save == 1){
		idImage = JSON.stringify(idGalleryDelete);
	} else {
		idImage = 0;	
	}
		
	$.ajax({
        type: "POST",
        url: "../admin/event/saveGallery",
        dataType:'json',
      	data: { 
			add:add,
			save:save,
			idPartner:$('#btnSavePartner').val(),
			image:nameImageGallery,
			idImage:idImage
      	},
    	success: function(data){
			ajaxMostrarTabla(column,order,"../admin/event/getallSearch",(numPag-1),"partner");
			$('#galleryEvent').hide();
			$('#ViewTablaEvent').show();
			$('#alertMessage').html(data);
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').hide(1000);
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
       	},
		error: function(){
			ajaxMostrarTabla(column,order,"../admin/event/getallSearch",(numPag-1),"partner");
			$('#galleryEvent').hide();
			$('#ViewTablaEvent').show()
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
			alert("error al actualizar la galleria")
		}
	});
}

//muestra las galerias del comercio
function showGallery(){
		
	numPag = $('ul .current').val();
		
	$.ajax({
      	type: "POST",
    	url: "eventos/getAllGalleryById",
      	dataType:'json',
      	data: {
			eventId:$('#btnSaveEvent').val()
       	},
     	success: function(data){
				for(var i = 0;i<data.length;i++){
					$('#gridImages').append(
					"<div id='imgPlacegallery' class='small-6 medium-6 large-4 columns "+ data[i].id + "'>"+
            		"<a id='imgDeleteBlack' value='"+ data[i].id + "'><img src='../assets/img/web/deleteBlack.png' /></a>"+
					"<img id='imgImageMiniGallery' src='../assets/img/app/partner/gallery/" + data[i].image+ "' />"+
					"<div id='imgPlacegallery' class='small-12 medium-12 large-12 columns' style='height:25px;'>" +
                	"</div>"
				);
			}
      	},
		error: function(){
			ajaxMostrarTabla(column,order,"../admin/event/getallSearch",(numPag-1),"partner");
			$('#galleryEvent').hide();
			$('#ViewTablaEvent').show()
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
			alert("error al mostrar la galleria")
		}
	});	
}

//////////visualizar la imagen de la galeria ///////

//abre el explorador de archivos cuando le das click a la imagen de cupones

function changeImageGallery(){
	$('#fileImageGallery').click();
}

$(window).load(function(){
 	$(function() {
		//detecta cada vez que hay un cambio en el formulario de imagen
 		$('#fileImageGallery').change(function(e) {
		$('#lblImageGallery').removeClass('error');
	  	$('#alertImageGallery').hide();
		$('#imgImageGallery').attr("src","http://placehold.it/480x165&text=[480x165]");
		if(e.target.files[0] != undefined){
			addImageGallery(e); 
		}
 	});

	//muestra la nueva imagen
     function addImageGallery(e){
		 
     	var file = e.target.files[0],
      	imageType = /image.*/;
	
      	if (!file.type.match(imageType)){
		  	$('#imgImageGallery').attr("src","http://placehold.it/480x165&text=[480x165]");
		 	 document.getElementById('fileImagenGallery').value ='';
				$('#lblImageGallery').addClass('error');
			  	$('#alertImageGallery').html("Selecione una imagen");
			  	$('#alertImageGallery').show();
       		return;
	  	}
  		//carga la imagen
      	var reader = new FileReader();
      		reader.onload = fileOnloadGallery;
      		reader.readAsDataURL(file);
     	}
	 
  		//muestra el resultado
     	function fileOnloadGallery(e) {
     	 	var result=e.target.result;
      		$('#imgImageGallery').attr("src",result);
     	}
	 
 	});
})
