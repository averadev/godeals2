// JavaScript Document

//botones que muestran los diferentes formularios
$('#btnAddPlace').click(function(){showFormAddPlace()});
$(document).on('click','#showPlace',function(){ ShowFormEditPlace(this); });
$(document).on('click','#imageDelete',function(){ ShowFormDeletePlace(this); });

//botones que registras,modifican o eliminan lugares 
$('#btnRegisterPlace').click(function() {addPlace()});
$('#btnSavePlace').click(function() {editPlace()});
$('#btnCancelFormPlace').click(function() {cancelPlace()});

//botones para el formulario de eliminar eventos
$('.btnAcceptP').click(function() {deletePlace()});
$('.btnCancelP').click(function() {cancelDeletePlace()});

//llama a la funcion de cambiar imagen
$("#imgImagenPlace").click(function() { changeImagePlace() });

//abre el explorador de archivos de la imagen
function changeImagePlace(){
	$('#fileImagenPlace').click();
}

//Llama a la funcion para validar la cantidad de letras que se ingresan
$(document).on('keydown','#txtPlaceName',function() {
	validateStringNamePlace();
});

//muestra el formulario para añadir lugares
function showFormAddPlace(){
	cleanFieldsPlace();
	hideAlertPlace();
	$('#btnSavePlace').hide();
	$('#btnRegisterPlace').show();
	$('#ViewTablaPlace').hide();
	$('#ViewFormPlace').show();	
}

//mujestra el formulario para editar lugares
function ShowFormEditPlace(id){
	cleanFieldsPlace();
	hideAlertPlace();
	id = $(id).find('input').val();
	$('#btnSavePlace').val(id);
	showsPlace(id);
	$('#btnRegisterPlace').hide();
	$('#btnSavePlace').show();
	$('#ViewTablaPlace').hide();
	$('#ViewFormPlace').show();
}

//muestra el formulario para eliminar un lugar
function ShowFormDeletePlace(id){
	id = $(id).attr('value');
	$('.btnAcceptE').val(id);
	$('#divMenssagewarningPlace').hide(500);
	$('#divMenssagePlace').hide();
	$('#divMenssagewarningPlace').show(1000);
}

// llama al formulario para agregar un lugar
function addPlace(){
	var result;
	result = validationsPlace();
	if(result){
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		uploadImagePlace(0);
	}
}

//llama a la funcion para editar un evento
function editPlace(){
	var result;
	result = validationsPlace();
	id = $('#btnSavePlace').val();
	if(result){
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		if(document.getElementById('fileImagenPlace').value == "" ){
			var nameImage = $('#imagenNamePlace').val();
			ajaxSavePlace(id,nameImage);
		} else {
			uploadImagePlace(id);
		}
			
	}
}

function cancelPlace(){
	cleanFieldsPlace();
	hideAlertPlace();
	$('#ViewFormPlace').hide();	
	$('#ViewTablaPlace').show();
}

//cancela el formulario de eliminar un lugar
function cancelDeletePlace(){
	$('#divMenssagewarningPlace').hide(1000);
}
	
//elimina el evento selecionado de la base de datos
function deletePlace(){
	id = $('.btnAcceptE').val();
	numPag = $('ul .current').val();
	$.ajax({
    	type: "POST",
       	url: "place/deletePlace",
       	dataType:'json',
		data: { 
			id:id
		},
      	success: function(data){
			var aux = 0;
			$('#tablePlace tbody tr').each(function(index) {
           		aux++;
           	});
					
			//si es uno regarga la tabla con un indice menos
			if(aux == 1){
				numPag = numPag-1;
			}
			ajaxMostrarTabla(column,order,"place/getallSearch",(numPag-1),"place");
			$('#divMenssagewarningPlace').hide(1000);
			$('#alertMessagePlace').html(data);
			$('#divMenssagePlace').show(1000).delay(1500);
			$('#divMenssagePlace').hide(1000);
      	},
		error: function(data){
			('#divMenssagewarningPlace').hide(1000);
			alert("Error al eliminar un lugar");
		}
	});
}

/////sube la imagen al servidor
function uploadImagePlace(id){
		
	if(window.XMLHttpRequest) {
 		var Req = new XMLHttpRequest();
 	}else if(window.ActiveXObject) { 
 		var Req = new ActiveXObject("Microsoft.XMLHTTP");
 	}
		
	var data = new FormData();
		
	var ruta = new Array();
		
	if(document.getElementById('fileImagenPlace').value != ""){
		var archivos = document.getElementById("fileImagenPlace");//Damos el valor del input tipo file
 		var archivo = archivos.files;
		data.append('image',archivo[0]);
		ruta.push("assets/img/app/place/image/");
	}
		
	rutaJson = JSON.stringify(ruta);
	data.append('ruta',ruta);

	data.append('nameImage',$('#imagenNamePlace').val());
		
	//abrimos la conexion para subir una imagen
	Req.open("POST", "place/uploadImage", true);
	//verificamos si se executo correctamente el metodo
	Req.onload = function(Event) {
		//Validamos que el status http sea ok 
		if (Req.status == 200) {
 		//Recibimos la respuesta de php
			nameImage = Req.responseText;
			ajaxSavePlace(id,nameImage);
		} else { 
  			alert(Req.status); //Vemos que paso.
		} 		
	};
	//Enviamos la petición 
 	Req.send(data);			
}

/////guardamos o actualizamos los datos del lugar

function ajaxSavePlace(id,nameImage){
		
	var image = nameImage.split("pl_");
	var banner = image[1];
	banner = "plf_" + banner;
	
	numPag = $('ul .current').val();
	$.ajax({
  		type: "POST",
		url: "place/saveEvent",
       	dataType:'json',
       	data: { 
			id:id,
			name:$('#txtPlaceName').val(),
			image:nameImage,
			banner:banner,
			address:$('#txtPlaceAddress').val(),
			latitude:$('#txtPlaceLatitude').val(),
			longitude:$('#txtPlaceLongitude').val()
       	},
     	success: function(data){
			ajaxMostrarTabla(column,order,"place/getallSearch",(numPag-1),"place");
			$('#ViewFormPlace').hide();
			$('#ViewTablaPlace').show();
			$('#alertMessagePlace').html(data);
			$('#divMenssagePlace').show(1000).delay(1500);
			$('#divMenssagePlace').hide(1000);
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
 		},
		error: function(){
			ajaxMostrarTabla(column,order,"place/getallSearch",(numPag-1),"place");
			$('#ViewFormPlace').hide();
			$('#ViewTablaPlace').show();
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
			alert("error al insertar datos")
		}
  	});
}

//mostramos los datos de un lugar selecionado

function showsPlace(id){
	$.ajax({
		type: "POST",
      	url: "place/getID",
       	dataType:'json',
       	data: { 
			id:id
      	},
      	success: function(data){
			$('#txtPlaceName').val(data[0].name);
			$('#txtPlaceAddress').val(data[0].address);
			$('#txtPlaceLatitude').val(data[0].latitude);
			$('#txtPlaceLongitude').val(data[0].longitude);
			$('#imgImagenPlace').attr("src",URL_IMG + "app/place/image/" + data[0].image);
			$('#imagenNamePlace').val(data[0].image);
		}
	});	
}

///////validamos los campos ///////////////

function validationsPlace(){
	var result = true;
	
	hideAlertPlace();
		
	sizeImage = imgRealSizePlace($("#imgImagenPlace"));
		
	if($('#imagenNamePlace').val() == 0 && $('#fileImagenPlace').val().length == 0){
		$('#alertImagePlace').html("Campo vacio. Selecione una imagen");
		$('#alertImagePlace').show();
		$('#lblPlaceImage').addClass('error');
		result = false;
	} else if(sizeImage.width != 100 || sizeImage.height != 100){
		$('#alertImagePlace').html("El tamaño no corresponde: 100x100");
		$('#alertImagePlace').show();
		$('#lblPlaceImage').addClass('error');
		result = false;
	}
		
	if($('#txtPlaceLongitude').val().trim().length == 0){
		$('#alertLongitude').show();
		$('#lblPlaceLongitude').addClass('error');
		$('#txtPlaceLongitude').focus();
		result = false;
	}
		
	if($('#txtPlaceLatitude').val().trim().length == 0){
		$('#alertLatitude').show();
		$('#lblPlaceLatitude').addClass('error');
		$('#txtPlaceLatitude').focus();
		result = false;
	}
		
	if($('#txtPlaceAddress').val().trim().length == 0){
		$('#alertAddress').show();
		$('#lblPlaceAddress').addClass('error');
		$('#txtPlaceAddress').focus();
		result = false;
	}
		
	if($('#txtPlaceName').val().trim().length == 0){
		$('#alertName').html("Campo vacio. Por favor escriba el nombre del lugar.");
		$('#alertName').show();
		$('#lblPlaceName').addClass('error');
		$('#txtPlaceName').focus();
		result = false;
	}
	
	if($('#txtPlaceName').val().trim().length > 51){
		$('#alertName').html("Limite alcanzado. Por favor escriba menos de 50 palabras.");
		$('#alertName').show();
		$('#lblPlaceName').addClass('error');
		$('#txtPlaceName').focus();
		result = false;
	}
		
	return result;	
}

//obtiene las proporciones de la imagen
function imgRealSizePlace(img) {
	var image = new Image();
   	image.src = $(img).attr("src");
  	return { 'width': image.naturalWidth, 'height': image.naturalHeight }
}

//oculta las alertas del formulario
function hideAlertPlace(){
	$('#alertImagePlace').hide();
	$('#alertLongitude').hide();
	$('#alertLatitude').hide();
	$('#alertAddress').hide();
	$('#alertName').hide();
		
	$('#lblPlaceImage').removeClass('error');
	$('#lblPlaceLongitude').removeClass('error');
	$('#lblPlaceLatitude').removeClass('error');
	$('#lblPlaceAddress').removeClass('error');
	$('#lblPlaceName').removeClass('error');
}
	
//limpia los campos del formulario
function cleanFieldsPlace(){
	$('#txtPlaceName').val("");
	$('#txtPlaceAddress').val("");
	$('#imgImagenPlace').attr("src","http://placehold.it/100x100&text=[100x100]");
	document.getElementById('fileImagenPlace').value ='';
	$('#imagenNamePlace').val(0);
	$('#txtPlaceLatitude').val("");
	$('#txtPlaceLongitude').val("");
}

////////////funcion para visualizar la imagen selecionada //////////////////////////

$(window).load(function(){
 	$(function() {
		//detecta cada vez que hay un cambio en el formulario de imagen
 		$('#fileImagenPlace').change(function(e) {
		$('#lblPlaceImage').removeClass('error');
	  	$('#alertImagePlace').hide();
		$('#imgImagenPlace').attr("src","http://placehold.it/100x100&text=[100x100]");
	  	if($('#imagenNamePlace').val() != 0){
			$('#imgImagenPlace').attr("src",URL_IMG + "app/place/image/" + $('#imagenNamePlace').val())
	  	}
		if(e.target.files[0] != undefined){
			addImagePlace(e); 
		}
	});

	//muestra la nueva imagen
   	function addImagePlace(e){ 
   		var file = e.target.files[0],
      	imageType = /image.*/;
	
      	if (!file.type.match(imageType)){
		  	$('#imgImagenPlace').attr("src","http://placehold.it/100x100&text=[100x100]");
		 	document.getElementById('fileImagenPlace').value ='';
		  	if($('#imagenNamePlace').val() != 0){
			  	$('#imgImagenPlace').attr("src",URL_IMG + "app/place/image/" + $('#imagenNamePlace').val())
		  	} else {
				$('#lblPlaceImage').addClass('error');
			  	$('#alertImagePlace').empty();
			  	$('#alertImagePlace').append("Selecione una imagen");
			  	$('#alertImagePlace').show();
		  	}
       	return;
	  	}
  		//carga la imagen
     	var reader = new FileReader();
      		reader.onload = fileOnloadPlace;
      		reader.readAsDataURL(file);
     	}
	 
  		//muestra el resultado
    	function fileOnloadPlace(e) {
      		var result=e.target.result;
      		$('#imgImagenPlace').attr("src",result);
     	}
	});
});

//valida el total de letras que se ingresan en el input name
function validateStringNamePlace(){
	if($('#txtPlaceName').val().length > 50 && event.keyCode != 8 && event.keyCode != 9 
		&& event.keyCode != 37 && event.keyCode != 39){
		event.preventDefault();
	}	
}