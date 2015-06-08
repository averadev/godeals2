// JavaScript Document

//muestra los formularios
$('#checkPublicDeals').prop('checked', false);

$("#btnAddCoupon").click(function() { showFormAdd(); });
$(document).on('click','#showCoupon',function(){ ShowFormEdit(this); });
$(document).on('click','#imageDelete',function(){ ShowFormDelete(this); });

//botones para agregar, modificar o eliminar deals
$('#btnRegisterCoupon').click(function() { addDeals(); });
$('#btnSaveCoupon').click(function() { editDeals(); });
$("#btnCancel").click(function() {cancelForm()});

//botones para eliminar y cancelar el formulario de eliminar
$(".btnAcceptC").click(function() {eventDelete()});
$(".btnCancelC").click(function() {eventCancelDelete()});

//boton para selecionar imagen
$("#imgImagen").click(function() {changeImage()});

//activa el formulario de autocompletar
$("#txtPartner").keyup(function() { finderAutocomplete("partner"); });
$("#txtCity").keyup(function() { finderAutocomplete("city"); });

/***********valida la entrada de teclado*******************/
$(document).on('keydown','#txtTotal',function() {
	validarTotal();
});

//Llama a la funcion para validar la cantidad de letras que se ingresan
$(document).on('keydown','#txtName',function() {
	validateStringName();
});

$(document).on('keydown','#txtValidity',function() {
	validateStringValidez();
});

//llama a la funcion para cambiar el stock
$(document).on('keyup','#txtTotal',function(){
	changeStock();	
});

//llama a la funcion para cambiar el stock
$(document).on('change','#txtTotal',function(){
	changeStock();	
});

//muestra el formulario para agregar cupones
function showFormAdd(){
	cleanFields();
	$('#btnSaveCoupon').hide();
	$('#btnRegisterCoupon').show();
	$('#viewEvent').hide();
	$('#FormEvent').show();
	$('#imagenName').val(0);
}

//muestra el formulario para modificar datos
function ShowFormEdit(id){
	cleanFields();
	id = $(id).find('input').val();
	$('#btnSaveCoupon').val(id);
	showCoupon(id);
	$('#btnRegisterCoupon').hide();
	$('#btnSaveCoupon').show();
}
	
//muestra el formulario para eliminar cupones
function ShowFormDelete(idCoupon){
	$('.btnAcceptC').val($(idCoupon).attr("value"));
	$('#divMenssagewarning').hide(500);
	$('#divMenssage').hide();
	$('#divMenssagewarning').show(1000);
}

//llama a la funcion para registrar cupones
function addDeals(){
	var result;
	result = validations();
	if(result == true){
		$('.loading').show();
		$('.loading').html('<img src="../assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		uploadImage(0,1);
	}
}

//llama a la funcion para editar deals
function editDeals(){
	
	var result = validations()
	
	if(result == true){
		id = $('#btnSaveCoupon').val();
		var nameImage = $('#imagenName').val();
		$('.loading').show();
		$('.loading').html('<img src="../assets/img/web/loading.gif" height="40px" width="40px" />');
		$('.bntSave').attr('disabled',true);
		if(document.getElementById('fileImagen').value == ""){
			ajaxSaveCoupon(nameImage,id,1);
		} else {
			uploadImage(id,1);
		}
	}
	
}

//regresa a la tabla de cupones
function cancelForm(){
	cleanFields();
	$('#FormEvent').hide();	
	$('#viewEvent').show();
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
		url: "deals/deleteCoupon",
		dataType:'json',
		data: {
			id:$('.btnAcceptC').val()
		},
		success: function(data){
			//verifica si se elimino la ultima fila de la tabla
			var aux = 0;
			$('#tableCoupon tbody tr').each(function(index) {
				aux++;
			});
			
			//si es uno regarga la tabla con un indice menos
			if(aux == 1){
				numPag = numPag-1;
			}
			ajaxMostrarTabla(column,order,"deals/getallSearch",(numPag-1),"coupon");
			$("#divMenssagewarning").hide(1000);
			$('#alertMessage').empty();
			$('#alertMessage').append(data);
			$('#divMenssage').show(1000).delay(1500);
			$('#divMenssage').hide(1000);
		},
		error: function(data){
			alert("error al eliminar un deals. Por favor vuelva a intentarlo")	
		}
	});
}

////////////* sube la imagen al servidor *///////////////

//sube las imagen al directorio assets/img/app/coupon
function uploadImage(id,type){
	
	//alert(type)
	
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
		data.append('ImageMax',archivo[0]);
		ruta = "assets/img/app/deal/";
	}
	
	//rutaJson = JSON.stringify(ruta);
	data.append('ruta',ruta);
		
	data.append('nameImage',$('#imagenName').val());
		
	//cargamos los parametros para enviar la imagen
	Req.open("POST", "deals/subirImagen", true);
		
	//nos devuelve los resultados
	Req.onload = function(Event) {
			//Validamos que el status http sea ok 
	if (Req.status == 200) {
 	 	//Recibimos la respuesta de php
  		var nameImage = Req.responseText;
			ajaxSaveCoupon(nameImage,id,type);
		} else { 
  			alert(Req.status); //Vemos que paso.
		} 	
	};
		
	//Enviamos la petición 
 	Req.send(data);
}

/***********guardamos o actualizamos los datos de los deals ************/
function ajaxSaveCoupon(nameImage,id,type){	
		
	var valorPartner = $('#txtPartner').val().trim();
	var idPartner = $('datalist option[value="' + valorPartner + '"]').attr('id');
	
	var valorCity = $('#txtCity').val().trim();
	var idCity = $('datalist option[value="' + valorCity + '"]').attr('id');
	
	var idFilter = new Array();
	$('input[name=filter]:checked').each(function() {
		idFilter.push($(this).val());
	});
	
	var stoke = ""
	if($('#txtTotal').val() != $('#txtTotal').attr('total')){
		stoke = $("#txtStock").val().trim();
	}
	
	if(type == 1){
		var status = 1
		if($('#checkPublicDeals').is(':checked') ) {
			status = 1
		}else{
			status = -1
		}
	}else{
		var status = -2
	}
	
	var jsonIdFilter = JSON.stringify(idFilter);
	
	numPag = $('ul .current').val();
	
	$.ajax({
		type: "POST",
		url: "deals/saveCoupon",
		dataType:'json',
		data: {
			id:id,
			partnerId:idPartner,
			cityId:idCity,
			image:nameImage,
			name:$('#txtName').val().trim(),
			clauses:$('#txtClauses').val().trim(),
			validity:$('#txtValidity').val().trim(),
			detail:$('#txtDetail').val().trim(),
			total:$("#txtTotal").val().trim(),
			stock:stoke,
			iniDate:$("#txtIniDate").val().trim(),
			endDate:$("#txtEndDate").val().trim(),
			idFilter:jsonIdFilter,
			status:status
		},
		success: function(data){
			if(type == 1){
				if(numPag == undefined){
					ajaxMostrarTabla(column,order,"deals/getallSearch",0,"coupon");
				} else {
					ajaxMostrarTabla(column,order,"deals/getallSearch",(numPag-1),"coupon");
				}
				$('#FormEvent').hide();
				$('#viewEvent').show();
				$('#alertMessage').empty();
				$('#alertMessage').html(data.mensage);
				$('#divMenssage').show(1000).delay(1500);
				$('#divMenssage').toggle(1000);
				$('.loading').hide();
				$('.bntSave').attr('disabled',false);
			}else{
				$('.loading').hide();
				$('.bntSave').attr('disabled',false);
				modal:AddNewDealsRecompensa(data.idDeals);	
			}
		},
		error: function(){
			if(type == 1){
				if(numPag == undefined){
					ajaxMostrarTabla(column,order,"deals/getallSearch",0,"coupon");
				} else {
					ajaxMostrarTabla(column,order,"deals/getallSearch",(numPag-1),"coupon");
				}
				$('#FormEvent').hide();
				$('#viewEvent').show();
				$('#alertMessage').empty();
				$('.loading').hide();
				$('.bntSave').attr('disabled',false);
			}else{
				$('.loading').hide();
				$('.bntSave').attr('disabled',false);
				modal:AddNewDealsRecompensa();
			}
			alert("error al insertar datos");
			
		}
	});
}

/////////* muestra los datos de un deals *///////////////

//muestra los datos de un cupon
function showCoupon(id){
	$.ajax({
		type: "POST",
		url: "deals/getId",
		dataType:'json',
		data: { 
			id:id
		},
		success: function(data){
			$('#txtName').val(data.items[0].name);
			$('#txtPartner').val(data.items[0].partnerName);
			$('#txtCity').val(data.items[0].cityName);
			$('#txtTotal').val(data.items[0].total);
			$('#txtStock').val(data.items[0].stock);
			$('#txtTotal').attr('total',data.items[0].total);
			$('#txtStock').attr('stock',data.items[0].stock);
			$('#partnerList').append("<option id='" + data.items[0].partnerId + 
			"' value='" +  data.items[0].partnerName + "' />" );
			$('#cityList').append("<option id='" + data.items[0].cityId + 
			"' value='" +  data.items[0].cityName + "' />" );
			$('#txtValidity').val(data.items[0].validity);
			$('#txtClauses').val(data.items[0].clauses);
			$('#txtDetail').val(data.items[0].detail);
			$('#txtIniDate').val(data.items[0].iniDate);
			$('#txtEndDate').val(data.items[0].endDate);
			$('input[name=filter]').each(function(index, element) {
				for(var i=0;i<data.filters.length;i++){
					if($(this).val() == data.filters[i].idFilter){
						$(this).prop('checked', true);
					}
				}
			});
			if(data.items[0].status == 1){
				$('#checkPublicDeals').prop('checked', true);
			}else{
				$('#checkPublicDeals').prop('checked', false);
			}
			$('#imgImagen').attr("src",URL_IMG + "app/deal/" + data.items[0].image 
			+ "?version=" + (new Date().getTime()));
			$('#imagenName').val(data.items[0].image);
			$('#imgImagen').attr("hidden",data.items[0].image);
			$('#viewEvent').hide();
			$('#FormEvent').show();
			
		},
		error: function(data){
			alert("Error al mostrar los datos del deals. Por Favor Vuelva a intentarlo")	
		}
	});
}

//validamos los campos del formulario
function validations(){
	var result = true;
	
	hideAlerts();
	
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
	
	//valida que el campo iniDate no este vacio
	if($('#txtIniDate').val().trim().length == 0){
		$('#alertIniDate').html("Campo vacio. Por favor selecione una fecha inicial");
		$('#alertIniDate').show();
		$('#labelIniDate').addClass('error');
		$('#txtIniDate').focus();
		result = false;
	}else if($('#txtIniDate').val() < hoy){
		$('#alertIniDate').html("Fecha incorrecta. Seleciones una fecha igual o mayor a la de hoy");
		$('#alertIniDate').show();
		$('#labelIniDate').addClass('error');
		$('#txtIniDate').focus();
		result = false;
	}
	
	//valida que el campo endDate no esta vacio
	if($('#txtEndDate').val().trim().length == 0){
		$('#alertEndDate').html("Campo vacio. Por favor selecione una fecha final");
		$('#alertEndDate').show();
		$('#labelEndDate').addClass('error');
		$('#txtEndDate').focus();
		result = false;
	}else if($('#txtEndDate').val() < $('#txtIniDate').val()){
		$('#alertEndDate').html("Fecha incorrecta. selecione una fecha mayor o igual a la inicial.");
		$('#alertEndDate').show();
		$('#labelEndDate').addClass('error');
		$('#txtEndDate').focus();
		result = false;
	}
	
	var checkboxFilter = 0;
	$('input[name=filter]:checked').each(function() {
		checkboxFilter++;
   	});
	
	if(checkboxFilter == 0){
		$('#alertFilter').show();
		$('#labelFilter').addClass('error');
        result = false;
	}
		
	//valida que se haya selecionado una imagen
    sizeImage = imgRealSize($("#imgImagen"));
    if($('#imagenName').val() == 0 && $('#fileImagen').attr('isTrue') != 1){
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
	
	//valida que el campo clausula no este vacio
	if($('#txtClauses').val().trim().length == 0){
		$('#alertClauses').show();
		$('#labelClauses').addClass('error');
		$('#txtClauses').focus();
		result = false;
	}
	
	// valida que el campo detail este lleno
	if($('#txtDetail').val().trim().length == 0){
		$('#alertDetail').show();
		$('#labelDetail').addClass('error');
		$('#txtDetail').focus();
		result = false;
	}
		
	//valida que el campo valides no este vacio
	if($('#txtValidity').val().trim().length == 0){
		$('#alertValidity').html("Campo vacion. Por favor escriba la valides del deals");
		$('#alertValidity').show();
		$('#labelValidity').addClass('error');
		$('#txtValidity').focus();
		result = false;
	}
	
	//valida la longitud de texto del campo validez
	if($('#txtValidity').val().length > 56){
		$('#alertValidity').html("Limite alcanzado. Por favor escriba menos de 55 palabras");
		$('#alertValidity').show();
		$('#labelValidity').addClass('error');
		$('#txtValidity').focus();
		result = false;
	}
	
	//valida que el stock sea mayor a 0
	if($('#txtStock').val().trim() < 0){
		$('#alertStock').html('Valor incorrecto. El stock tiene que ser mayor a 0.');
		$('#alertStock').show();
		$('#labelStock').addClass('error');
		$('#txtStock').focus();
		result = false;
	}
	
	//valida que el campo total no este vacio
	if($('#txtTotal').val().trim().length == 0){
		$('#alertTotal').html('Campo vacio. Por favor escriba el total de cupones.');
		$('#alertTotal').show();
		$('#labelTotal').addClass('error');
		$('#txtTotal').focus();
		result = false;
	}
	
	//valida que el total sea mayor a 0
	if($('#txtTotal').val().trim() < 1 ){
		$('#alertTotal').html('Valor incorrecto. Por favor escriba un numero mayor a 0.');
		$('#alertTotal').show();
		$('#labelTotal').addClass('error');
		$('#txtTotal').focus();
		result = false;
	}
	
	//valida que se haya selecionado una ciudad
	valorCity = $('#txtCity').val().trim();
	idCity = $('datalist option[value="' + valorCity + '"]').attr('id');
	//valida que el partner selecionado no este vacio y que exista
	if(idCity == undefined){
		$('#alertCity').show();
		$('#labelCity').addClass('error');
		$('#txtCity').focus();
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
	
	//valida que el campo nombre no este vacio
	if($('#txtName').val().trim().length == 0){
		$('#alertName').html("Campo vacio. Por favor escriba el nombre del deal");
		$('#alertName').show();
		$('#labelName').addClass('error');
		$('#txtName').focus();
		result = false;
	}
	
	//valida la longitud de texto del campo
	if($('#txtName').val().length > 41){
		$('#alertName').html("Limite alcanzado. Por favor escriba maximo de 40 palabras");
		$('#alertName').show();
		$('#labelName').addClass('error');
		$('#txtName').focus();
		result = false;
	}
		
	return result;	
}

//obtiene las proporciones de la imagen
function imgRealSize(img) {
    var image = new Image();
    image.src = $(img).attr("src");
    return { 'width': image.naturalWidth, 'height': image.naturalHeight }
}

//escondemos los mensajes de alerta
function hideAlerts(){
	$('#alertName').hide()
	$('#alertPartner').hide();
	$('#alertCity').hide();
	$('#alertTotal').hide();
	$('#alertStock').hide();
	$('#alertValidity').hide();
	$('#alertClauses').hide();
	$('#alertDetail').hide();
	$('#alertImage').hide();
	$('#alertFilter').hide();
	$('#alertIniDate').hide();
	$('#alertEndDate').hide();
		
	$('#labelName').removeClass('error');
	$('#labelPartner').removeClass('error');
	$('#labelCity').removeClass('error');
	$('#labelTotal').removeClass('error');
	$('#labelStock').removeClass('error');
	$('#labelValidity').removeClass('error');
	$('#labelClauses').removeClass('error');
	$('#labelDetail').removeClass('error');
	$('#labelImage').removeClass('error');
	$('#labelFilter').removeClass('error');
	$('#labelIniDate').removeClass('error');
	$('#labelEndDate').removeClass('error');
}
	
function cleanFields(){
	$('#txtName').val("");
	$('#txtPartner').val("");
	$('#txtCity').val("");
	$('#txtTotal').val(0);
	$('#txtStock').val(0);
	$('#txtTotal').attr('total',0);
	$('#txtStock').attr('stock',0);
	$('#txtValidity').val("");
	$('#txtClauses').val("");
	$('#txtDetail').val("");
	$('#txtIniDate').val("");
	$('#txtEndDate').val("");
	$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
	//document.getElementById('fileImagen').value ='';
	$('#fileImagen').attr('isTrue','0');
	/*$('input[type=checkbox]:checked').each(function() {
		$(this).prop('checked', false);
	});*/
	$('.chechFilterDeals').prop('checked', false);
	$('#partnerList').empty();
	$('#cityList').empty();
	$('#divMenssage').hide();
	$('#divMenssagewarning').hide();
	$('#imagenName').val(0);
	$('#checkPublicDeals').prop('checked', false);
}

////////* visualizacion de la imagen *//////////////

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
			$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
			if($('#imagenName').val() != 0){
				$('#imgImagen').attr("src",URL_IMG + "app/deal/" + $('#imagenName').val())
			}
			if(e.target.files[0] != undefined){
				addImage(e); 
				$('#fileImagen').attr('isTrue','1');
			}else{
				$('#fileImagen').attr('isTrue','0');
			}
		});

		function addImage(e){
			var file = e.target.files[0],
			imageType = /image.*/;
    
			if (!file.type.match(imageType)){
				$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
				document.getElementById('fileImagen').value ='';
				if($('#imagenName').val() != 0){
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

/********** funcion de autocompletar *********////

function finderAutocomplete(campo){
	
	if(campo == "partner"){
		var url = "partners/getPartner";
		var dato = 	$("#txtPartner").val();
	} else {
		var url = "city/getCities";
		var dato = 	$("#txtCity").val();
	}
	
	$.ajax({
		type: "POST",
		url: url,
		dataType:'json',
		data: {
			dato:dato
		},
		success: function(data){
			if(campo == "partner"){
				$('#partnerList').empty();
				for(var i = 0;i<data.length;i++){
					$('#partnerList').append(
						"<option id='" + data[i].id + "' value='" +  data[i].name + "' />"
					);
				}
			}else {
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
	
//////////////valida que solo entren numeros /////////////

function validarTotal(){
	
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
			if (event.keyCode < 96 || event.keyCode > 105) {
				event.preventDefault();
			}
		}
	}	
}

//valida el total de letras que se ingresan en el input name
function validateStringName(){
	if($('#txtName').val().length > 41 && event.keyCode != 8 && event.keyCode != 9 
		&& event.keyCode != 37 && event.keyCode != 39){
		event.preventDefault();
	}	
}

//valida el total de letras que se ingresan en el input validez
function validateStringValidez(){
	
	if($('#txtValidity').val().length > 55 && event.keyCode != 8 && event.keyCode != 9 
		&& event.keyCode != 37 && event.keyCode != 39){
		event.preventDefault();
	}	
}

//cambia el total de stock
function changeStock(){
	var vStock = $('#txtStock').val();
	var vTotal = $('#txtTotal').val();
	var tStock = $('#txtStock').attr('stock');
	var tTotal = $('#txtTotal').attr('total');
	
	if( vTotal > tTotal){
		var cTotal = vTotal - tTotal;
		cTotal = parseInt(tStock) + parseInt(cTotal);	
	}else{
		var cTotal = tTotal - vTotal
		cTotal = parseInt(tStock) - parseInt(cTotal);
	}
	$('#txtStock').val(cTotal);
}

///////////////////////////////////////////////
////////////////Lealtad recompensa/////////////
///////////////////////////////////////////////

//validamos los campos del formulario de deals por recompensa
function validationsRewardDeals(){
	var result = true;
	
	hideAlerts();
	
	var checkboxFilter = 0;
	$('input[name=filter]:checked').each(function() {
		checkboxFilter++;
   	});
	
	if(checkboxFilter == 0){
		$('#alertFilter').show();
		$('#labelFilter').addClass('error');
        result = false;
	}
		
	//valida que se haya selecionado una imagen
    sizeImage = imgRealSize($("#imgImagen"));
    if($('#imagenName').val() == 0 && $('#fileImagen').attr('isTrue') != 1){
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
	
	//valida que el campo clausula no este vacio
	if($('#txtClauses').val().trim().length == 0){
		$('#alertClauses').show();
		$('#labelClauses').addClass('error');
		$('#txtClauses').focus();
		result = false;
	}
	
	// valida que el campo detail este lleno
	if($('#txtDetail').val().trim().length == 0){
		$('#alertDetail').show();
		$('#labelDetail').addClass('error');
		$('#txtDetail').focus();
		result = false;
	}
		
	//valida que el campo valides no este vacio
	if($('#txtValidity').val().trim().length == 0){
		$('#alertValidity').html("Campo vacion. Por favor escriba la valides del deals");
		$('#alertValidity').show();
		$('#labelValidity').addClass('error');
		$('#txtValidity').focus();
		result = false;
	}
	
	//valida la longitud de texto del campo validez
	if($('#txtValidity').val().length > 56){
		$('#alertValidity').html("Limite alcanzado. Por favor escriba menos de 55 palabras");
		$('#alertValidity').show();
		$('#labelValidity').addClass('error');
		$('#txtValidity').focus();
		result = false;
	}
	
	//valida que se haya selecionado una ciudad
	valorCity = $('#txtCity').val().trim();
	idCity = $('datalist option[value="' + valorCity + '"]').attr('id');
	//valida que el partner selecionado no este vacio y que exista
	if(idCity == undefined){
		$('#alertCity').show();
		$('#labelCity').addClass('error');
		$('#txtCity').focus();
		result = false;
	}
	
	//valida que el campo nombre no este vacio
	if($('#txtName').val().trim().length == 0){
		$('#alertName').html("Campo vacio. Por favor escriba el nombre del deal");
		$('#alertName').show();
		$('#labelName').addClass('error');
		$('#txtName').focus();
		result = false;
	}
	
	//valida la longitud de texto del campo
	if($('#txtName').val().length > 41){
		$('#alertName').html("Limite alcanzado. Por favor escriba maximo de 40 palabras");
		$('#alertName').show();
		$('#labelName').addClass('error');
		$('#txtName').focus();
		result = false;
	}
		
	return result;	
}