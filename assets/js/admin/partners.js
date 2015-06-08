// JavaScript Document

numImage = 0;
idGalleryDelete = new Array();

/*muestra la tabla o formularios */
$(document).on('click','.showPartner',function(){ showEditForm(this);});
$('#btnAddPartner').click(function(){showAddForm();});
$(document).on('click','.imageDelete',function(){ showDeleteForm(this);});
$('#btnGaleria').click(function() {ShowFormGallery()});

/******botones para agregar,editar o eliminar comercios*******/
$('#btnRegisterPartner').click(function() {addPartner();});
$('#btnSavePartner').click(function() {editPartner();});
$("#btnCancel").click(function() {CancelarForm();});

//botones para el formulario de eliminar partners --barra dinamica que aparece cuando se pulsa el boton de eliminar
$('#btnAcceptC').click(function() {deletePartner();});
$('#btnCancelC').click(function() {cancelDeletePartner();});

/************btn para abrir la imagen***********************/
$("#imgImagen").click(function() {changeImage();});
$("#imgBanner").click(function() {changeBanner();});

/***********valida la entrada de teclado*******************/
$(document).on('keydown','#txtPartnerPhone',function() {
	validarPhone();
});

$(document).on('keydown','#txtPartnerLatitude, #alertPartnerLatitude',function() {
		validarCoordenada();
});

//Llama a la funcion para validar la cantidad de letras que se ingresan
$(document).on('keydown','#txtPartnerName',function() {
	validateStringName();
});

//mostramos el formulario de partner
function showAddForm(){
	cleanFields();
	hideAlerts();
	$('#btnSavePartner').hide();
	$('#btnRegisterPartner').show();
	$('#btnGaleria').hide();
	$('#ViewTablaPartner').hide();
	$('#ViewFormPartner').show();
}

//mostramos el formulario con los datos del partner
function showEditForm(partner){
    cleanFields();
	hideAlerts();
    id = $(partner).find('input').val();//obtiene la id del partner
    $('#btnSavePartner').val(id);
    showPartner(id);
	$('#btnRegisterPartner').hide();
    $('#btnSavePartner').show();
	$('#btnGaleria').show();
    $('#ViewTablaPartner').hide();
    $('#ViewFormPartner').show();   
}

//mostramos el formulario para eliminar comercios

function showDeleteForm(id){
    id = $(id).attr('value');
    $('#btnAcceptC').val(id);
    $('#divMenssagewarning').hide(500);
    $('#divMenssage').hide();
    $('#divMenssagewarning').show(1000);
}

//llama a la funcion de agregar un comercio
function addPartner(){
	var result = null;
	result = validations(1);
	
	if(result){
		$('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		uploadImage(0);	
	}
	
}

function editPartner(){
	 var result;
    result = validations(2);
    var id = $('#btnSavePartner').val();
    if(result){
        $('.loading').show();
		$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
        if(document.getElementById('fileImagen').value == "" && document.getElementById('fileBanner').value == ""){
			var str = $('#imagenName').val();
			var res = str.split("p_");
			str = res[1];
			res = str.split(".jpg");
            var nameImage = $('#imagenName').val();
            ajaxSavePartner(res[0],id);
        } else  {
            uploadImage(id);
        }
    }
}

//regresa a la tabla de partner
function CancelarForm(){
   /* limpiarCampos();
	ocultarAlertas();*/
    $('#ViewFormPartner').hide();	
    $('#ViewTablaPartner').show();
}

//cancela el formulario de eliminar partner
function cancelDeletePartner(){
    $('#divMenssagewarning').hide(1000);
}

//marca como 0 el estatus de un comercio (elimina el comercio)
function deletePartner(){
    id = $('#btnAcceptC').val();

    numPag = $('ul .current').val();
    
    $.ajax({
    type: "POST",
    url: "partners/deletePartner",
    dataType:'json',
        data: { 
            id:id
        },
        success: function(data){
            var aux = 0;
            $('#tablePartners tbody tr').each(function(index) {
                aux++;
            });

            //si es uno regarga la tabla con un indice menos
            if(aux == 1){
                numPag = numPag-1;
            }
            ajaxMostrarTabla(column,order,"partners/getAllSearch",(numPag-1),"partner");
            $('#divMenssagewarning').hide(1000);
            $('#alertMessage').empty();
            $('#alertMessage').append("se ha eliminado el socio");
            $('#divMenssage').show(1000).delay(1500);
            $('#divMenssage').hide(1000);
        }
    });
}

///////////////subimos la imagen al servidor///////////////////////////////

function uploadImage(id){
	
		if(window.XMLHttpRequest) {
                var Req = new XMLHttpRequest();
        }else if(window.ActiveXObject) { 
                var Req = new ActiveXObject("Microsoft.XMLHTTP");
        }
		
		var data = new FormData();
		var ruta = new Array();
		var nombreI = new Array();
		
		if(document.getElementById('fileImagen').value != ""){
        	var archivosImage = document.getElementById("fileImagen");//Damos el valor del input tipo file
        	var archivoImage = archivosImage.files;
			data.append('image',archivoImage[0]);
			ruta.push("assets/img/app/partner/image/");
			nombreI.push("p_");
		}
		
		if(document.getElementById('fileBanner').value != ""){
			var archivosBanner = document.getElementById("fileBanner");//Damos el valor del input tipo file
        	var archivoBanner = archivosBanner.files;
			data.append('banner',archivoBanner[0]);
			ruta.push("assets/img/app/partner/banner/");
			nombreI.push("pf_");
		}
		
		if($('#imagenName').val() != 0){
			var str = $('#imagenName').val();
			var res = str.split("p_");
			str = res[1];
			res = str.split(".jpg");
			data.append('nameImage',res[0]);
		}else{
			data.append('nameImage',"");
		}
		
		data.append('ruta',ruta);
		data.append('nombreI',nombreI);

        //abrimos la conexion para subir una imagen
        Req.open("POST", "partners/uploadImage", true);
        //verificamos si se executo correctamente el metodo
        Req.onload = function(Event) {
            //Validamos que el status http sea ok 
            if (Req.status == 200) {
                    //Recibimos la respuesta de php
                    nameImage = Req.responseText;
                    ajaxSavePartner(nameImage,id);
            } else { 
                    alert(Req.status); //Vemos que paso.
            } 		
        };
        //Enviamos la petición 
        Req.send(data);			
}

//agregamos o modificamos los datos del comercio//

function ajaxSavePartner(nameImage,id){

    var imageP = "p_" + nameImage + ".jpg";
    var bannerP = "pf_" + nameImage + ".jpg";
	
    numPag = $('ul .current').val();
    $.ajax({
        type: "POST",
        url: "partners/savePartner",
        dataType:'json',
        data: { 
            id:id,
            name:$('#txtPartnerName').val().trim(),
			info:$('#txtPartnerInfo').val().trim(),
			image:imageP,
			banner:bannerP,
            address:$('#txtPartnerAddress').val().trim(),
            phone:$('#txtPartnerPhone').val().trim(),
            latitude:$('#txtPartnerLatitude').val().trim(),
            longitude:$('#txtPartnerLongitude').val().trim(),
            facebook:$('#txtPartnerFacebook').val().trim(),
            twitter:$('#txtPartnerTwitter').val().trim(),
			email:$('#txtPartnerMail').val().trim(),
			password:$('#txtPartnerPassword').val().trim(),
        },
        success: function(data){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"partners/getAllSearch",0,"partner");
			} else {
            	ajaxMostrarTabla(column,order,"partners/getAllSearch",(numPag-1),"partner");
			}
            $('#ViewFormPartner').hide();
            $('#ViewTablaPartner').show();
            $('#alertMessage').html(data);
            $('#divMenssage').show(1000).delay(1500);
            $('#divMenssage').hide(1000);
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
        },
        error: function(data){
			if(numPag == undefined){
				ajaxMostrarTabla(column,order,"partners/getAllSearch",0,"partner");
			} else {
            	ajaxMostrarTabla(column,order,"partners/getAllSearch",(numPag-1),"partner");
			}
            $('#ViewFormPartner').hide();
            $('#ViewTablaPartner').show();
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
            alert("error al insertar datos");  
        }
    });
}

///////muestra los datos del comercio selecionado /////////

function showPartner(id){
   
    $.ajax({
        type: "POST",
        url: "partners/getId",
        dataType:'json',
        data: { 
            id:id
        },
        success: function(data){
            $('#txtPartnerName').val(data[0].name);
            $('#txtPartnerAddress').val(data[0].address);
            $('#txtPartnerPhone').val(data[0].phone);
            $('#txtPartnerMail').val(data[0].email);
            $('#txtPartnerTwitter').val(data[0].twitter);
            $('#txtPartnerFacebook').val(data[0].facebook);
			$('#txtPartnerInfo').val(data[0].info);
            $('#imgImagen').attr("src",URL_IMG + "app/partner/image/" + data[0].image + "?version=" + (new Date().getTime()))
            $('#imagenName').val(data[0].image);
            $('#imgImagen').attr("hidden",data[0].image)
			$('#imgBanner').attr("src",URL_IMG + "app/partner/banner/" + data[0].banner + "?version=" + (new Date().getTime()))
            $('#bannerName').val(data[0].banner);
            $('#imgBanner').attr("hidden",data[0].banner)
            $('#txtPartnerLatitude').val(data[0].latitude);
            $('#txtPartnerLongitude').val(data[0].longitude);
            $('#ViewTablaPartner').hide();
            $('#ViewFormPartner').show();                
        }
    });   
}

//////////////////verificamos que los campos sean correctos ////////////////
function validations(type){
	var result = true;
	
	hideAlerts();
	
	if($('#txtPartnerLongitude').val().trim().length == 0){
		$('#alertPartnerLongitude').show();
        $('#lblPartnerLongitude').addClass('error');
        $('#txtPartnerLongitude').focus();
        result = false;	
	}
	
	if($('#txtPartnerLatitude').val().trim().length == 0){
        $('#alertPartnerLatitude').show();
        $('#lblPartnerLatitude').addClass('error');
        $('#txtPartnerLatitude').focus();
        result = false;
    }
	
	if($('#txtPartnerInfo').val().trim().length == 0){
        $('#alertPartnerInfo').show();
        $('#lblPartnerInfo').addClass('error');
        $('#txtPartnerInfo').focus();
        result = false;
    }
	
	if($('#txtPartnerPassword').val().trim().length == 0 && type == 1){
        $('#alertPartnerPassword').show();
        $('#lblPartnerPassword').addClass('error');
        $('#txtPartnerPassword').focus();
        result = false;
    }
	
	//valida que se haya selecionado una imagen
    sizeImage = imgRealSize($("#imgImagen"));
    if($('#imagenName').val() == 0 && $('#fileImagen').val().length == 0){
        $('#alertImage').empty();
        $('#alertImage').append("Campo vacio. Selecione una imagen");
        $('#alertImage').show();
		$('#lblPartnerImage').addClass('error');
        result = false;
	//valida el tamaño de la imagen
	}else if(sizeImage.width != 140 || sizeImage.height != 140){
        $('#alertImage').html("El tamaño no corresponde: 140x140");
        $('#alertImage').show();
        $('#labelImage').addClass('error');
        result = false;
    }
	
	//valida que se haya selecionado la imagen del banner
    sizeImage = imgRealSize($("#imgBanner"));
    if($('#bannerName').val() == 0 && $('#fileBanner').val().length == 0){
        $('#alertBanner').empty();
        $('#alertBanner').append("Campo vacio. Selecione una imagen");
        $('#alertBanner').show();
		$('#lblPartnerBanner').addClass('error');
        result = false;
	//valida el tamaño de la imagen del banner
	}else if(sizeImage.width != 480 || sizeImage.height != 165){
        $('#alertBanner').html("El tamaño no corresponde: 480x165");
        $('#alertBanner').show();
        $('#labelBanner').addClass('error');
        result = false;
    }
	
	if( $('#alertPartnerMail').text() == "correo existente. Porfavor Selecione otro"){
		$('#alertPartnerMail').html("correo existente. Porfavor Selecione otro");
		$('#alertPartnerMail').show();
		$('#lblPartnerMail').addClass('error');
        $('#txtPartnerMail').focus();
        result = false;
	}
	
	var emailExpr = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
	
	if($('#txtPartnerMail').val().trim().length > 0){
		var email = $('#txtPartnerMail').val().trim();
		if( !emailExpr.test(email) ){
			$('#alertPartnerMail').html("Email incorrecto. Porfavor escriba un email correcto" + 
			"<br /> ejem: ejemplo@email.com");
			$('#alertPartnerMail').show();
        	$('#lblPartnerMail').addClass('error');
        	$('#txtPartnerMail').focus();
        	result = false;
		}
	} else {
		$('#alertPartnerMail').html("Campo Vacio. Porfavor escriba un correo del comercio" + 
		"<br /> ejem: ejemplo@email.com");
		$('#alertPartnerMail').show();
        $('#lblPartnerMail').addClass('error');
        $('#txtPartnerMail').focus();
        result = false;
	}
		
	if($('#txtPartnerPhone').val().trim().length == 0){
        $('#alertPartnerPhone').show();
        $('#lblPartnerPhone').addClass('error');
        $('#txtPartnerPhone').focus();
        result = false;
    }	
		
    if($('#txtPartnerAddress').val().trim().length == 0){
        $('#alertPartnerAddress').show();
        $('#lblPartnerAddress').addClass('error');
        $('#txtPartnerAddress').focus();
        result = false;
    }
	
	if($('#txtPartnerName').val().trim().length == 0){
		$('#alertPartnerName').html("Campo vacio. Por favor escriba el nombre del comercio");
        $('#alertPartnerName').show();
        $('#lblPartnerName').addClass('error');
        $('#txtPartnerName').focus();
        result = false;
    }
	
	if($('#txtPartnerName').val().trim().length > 51){
		$('#alertPartnerName').html("Limite alcanzado. Por favor escriba maximo 50 palabras.");
        $('#alertPartnerName').show();
        $('#lblPartnerName').addClass('error');
        $('#txtPartnerName').focus();
        result = false;
    }
    
    return result;
		
}

//ocultamos los mensajes de alerta
function hideAlerts(){
    $('#alertPartnerName').hide()
    $('#alertPartnerAddress').hide();
    $('#alertPartnerPhone').hide();
    $('#alertPartnerMail').hide();
	$('#alertPartnerPassword').hide();
    $('#alertPartnerLatitude').hide();
    $('#alertPartnerLongitude').hide();
	$('#alertImage').hide();
	$('#alertBanner').hide();
	$('#alertPartnerInfo').hide();

    $('#lblPartnerName').removeClass('error');
    $('#lblPartnerAddress').removeClass('error');
    $('#lblPartnerPhone').removeClass('error');
    $('#lblPartnerMail').removeClass('error');
	$('#lblPartnerPassword').removeClass('error');
    $('#lblPartnerLatitude').removeClass('error');
    $('#lblPartnerLongitude').removeClass('error');
	$('#lblPartnerImage').removeClass('error');
	$('#lblPartnerBanner').removeClass('error');
	$('#lblPartnerInfo').removeClass('error');
}

function cleanFields(){
    $('#txtPartnerName').val("");
    $('#txtPartnerAddress').val("");
    $('#txtPartnerPhone').val("");
    $('#txtPartnerMail').val("");
	$('#txtPartnerPassword').val("");
    $('#txtPartnerTwitter').val("");
    $('#txtPartnerFacebook').val("");
	$('#txtPartnerInfo').val("");
	$('#txtWelcomeIntro').val("");
	$('#txtWelcomeFooter').val("");
    $('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
    document.getElementById('fileImagen').value ='';
	$('#imgBanner').attr("src","http://placehold.it/480x165&text=[480x165]");
    document.getElementById('fileBanner').value ='';
    $('#txtPartnerLatitude').val("");
    $('#txtPartnerLongitude').val("");
	$('#imagenName').val(0);
}

//obtiene las proporciones de la imagen
function imgRealSize(img) {
    var image = new Image();
    image.src = $(img).attr("src");
    return { 'width': image.naturalWidth, 'height': image.naturalHeight }
}

////////////////////imagen//////////////////////////

//abrimos la imagen
function changeImage(){
    $('#fileImagen').click();
}

function changeBanner(){
    $('#fileBanner').click();
}

//visualizar imagen
$(window).load(function(){
	
	//imagen logo
 	$(function() {
  		$('#fileImagen').change(function(e) {
	  	$('#alertImage').hide();
	  	$('#lblPartnerImage').removeClass('error');
	  	$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
	  	if($('#imagenName').val() != 0){
		 	$('#imgImagen').attr("src",URL_IMG + "app/partner/image/" + $('#imagenName').val())
	  	}
      	addImage(e);
	});
	
	function addImage(e){
		var file = e.target.files[0],
		imageType = /image.*/;
		
		if (!file.type.match(imageType)){
			$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
			document.getElementById('fileImagen').value ='';
			if($('#imagenName').val() != 0){
				$('#imgImagen').attr("src",URL_IMG + "app/partner/image/" + $('#imagenName').val());
			} else {
			  	$('#alertImage').empty();
			  	$('#alertImage').append("Selecione una imagen");
			  	$('#alertImage').show();
			  	$('#lblPartnerImage').addClass('error');
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
	
	//imagen banner
 	$(function() {
  		$('#fileBanner').change(function(e) {
	  	$('#alertBanner').hide();
	  	$('#lblPartnerBanner').removeClass('error');
	  	$('#imgBanner').attr("src","http://placehold.it/480x165&text=[480x165]");
	  	if($('#bannerName').val() != 0){
		 	$('#imgBanner').attr("src",URL_IMG + "app/partner/banner/" + $('#bannerName').val())
	  	}
      	addBanner(e);
	});
	
	function addBanner(e){
		var file = e.target.files[0],
		imageType = /image.*/;
		
		if (!file.type.match(imageType)){
			$('#imgBanner').attr("src","http://placehold.it/480x165&text=[480x165]");
			document.getElementById('fileBanner').value ='';
			if($('#bannerName').val() != 0){
				$('#imgBanner').attr("src",URL_IMG + "app/partner/banner/" + $('#bannerName').val());
			} else {
			  	$('#alertBanner').empty();
			  	$('#alertBanner').append("Selecione una imagen");
			  	$('#alertBanner').show();
			  	$('#lblPartnerBanner').addClass('error');
		  	}		  
      	 return;
	  	}
  
     	var reader = new FileReader();
      		reader.onload = fileOnloadBanner;
      		reader.readAsDataURL(file);
     	}
  
     	function fileOnloadBanner(e) {
     		var result=e.target.result;
      		$('#imgBanner').attr("src",result);
     	}
	});
	
});
// fin visualizar imagen

////////////validamos la entrada del teclado en el telefono /////////////

function validarPhone(){
	
	if(event.shiftKey){
		event.preventDefault();
   	}
 
 	if (event.keyCode == 46 || event.keyCode == 8){
   		
	}
   	else {
	   	if (event.keyCode < 95) {
		   	if (event.keyCode < 48 && event.keyCode != 9 && event.keyCode != 16 &&  event.keyCode != 32 && event.keyCode != 37 
			&& event.keyCode != 39 || event.keyCode > 57) {
			   	event.preventDefault();
			}
		}else {
			if (event.keyCode < 96 || event.keyCode > 105 && event.keyCode != 107  && event.keyCode 
			!= 109 && event.keyCode != 189 ) {
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

////////////validaciones de letras//////////////////

//valida el total de letras que se ingresan en el input name
function validateStringName(){
	if($('#txtPartnerName').val().length > 50 && event.keyCode != 8 && event.keyCode != 9 
		&& event.keyCode != 37 && event.keyCode != 39){
		event.preventDefault();
	}	
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
	$('#ViewFormPartner').hide();
	$('#galleryPartner').show();
}

function addGallery(){
	result = validateGallery();
	//result = true;
	if(result){
			
		var gallery = "gallery" + numImage;
		$('#gridImages').append(
			"<div id='imgPlacegallery' class='small-6 medium-6 large-6 columns "+ gallery + "'>"+
            		"<a id='imgDeleteBlack' value='"+ gallery + "'><img src='assets/img/web/deleteBlack.png' /></a>"+
					"<img id='imgImageMiniGallery' src='" + $('#imgImageGallery').attr('src')+ "' />"+
					"<input type='file' id='"+ gallery +"' class='fileGallery' style='display:none;'/>" +
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
	$('.loading').html('<img src="assets/img/web/loading.gif" height="40px" width="40px" />');
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
		ajaxMostrarTabla(column,order,"partners/getallSearch",(numPag-1),"partner");
		$('.loading').hide();
		$('.bntSave').attr('disabled',false);
		$('#galleryPartner').hide();
		$('#ViewTablaPartner').show();
		$('#alertMessage').html("Se han actualizado la galeria");
		$('#divMenssage').show(1000).delay(1500);
		$('#divMenssage').hide(1000);
		$('.loading').hide();
		$('.bntSave').attr('disabled',false);	
	}
}

//cancela la galeria
function CancelGallery(){
	
	/*var input = $("#fileImageGallery");
	input.replaceWith(input.val('').clone(true));*/
	
	//document.getElementById("fileImageGallery").value = "";
	cleanGallery();
	$('#galleryPartner').hide();
	$('#ViewFormPartner').show();
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
	Req.open("POST", "partners/uploadImageGallery", true);
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
        url: "partners/saveGallery",
        dataType:'json',
      	data: { 
			add:add,
			save:save,
			idPartner:$('#btnSavePartner').val(),
			image:nameImageGallery,
			idImage:idImage
      	},
    	success: function(data){
			ajaxMostrarTabla(column,order,"partners/getallSearch",(numPag-1),"partner");
			$('#galleryPartner').hide();
			$('#ViewTablaPartner').show();
			$('#alertMessage').html(data);
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').hide(1000);
			$('.loading').hide();
			$('.bntSave').attr('disabled',false);
       	},
		error: function(){
			ajaxMostrarTabla(column,order,"partners/getallSearch",(numPag-1),"partner");
			$('#galleryPartner').hide();
			$('#ViewTablaPartner').show()
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
    	url: "partners/getAllGalleryById",
      	dataType:'json',
      	data: {
			partnerId:$('#btnSavePartner').val()
       	},
     	success: function(data){
				for(var i = 0;i<data.length;i++){
					$('#gridImages').append(
					"<div id='imgPlacegallery' class='small-6 medium-6 large-6 columns "+ data[i].id + "'>"+
            		"<a id='imgDeleteBlack' value='"+ data[i].id + "'><img src='assets/img/web/deleteBlack.png' /></a>"+
					"<img id='imgImageMiniGallery' src='assets/img/app/partner/gallery/" + data[i].image+ "' />"+
					"<div id='imgPlacegallery' class='small-12 medium-12 large-12 columns' style='height:25px;'>" +
                	"</div>"
				);
			}
      	},
		error: function(){
			ajaxMostrarTabla(column,order,"partners/getallSearch",(numPag-1),"partner");
			$('#galleryPartner').hide();
			$('#ViewTablaPartner').show()
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