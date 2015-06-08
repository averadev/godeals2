/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * login de godeals
 *
 */
 
//llama a la funcion para mostrar el registro
$('#btnRegisterPartner').click(function(){ showFormRegister(); });
$('#btnCancelRegister').click(function(){ hideFormRegister(); });

//llama a la funcion para mostrar el formulario de olvide mi contraseña
$('#labelRememberPassword').click(function(){ showFormRemenber(); });
$('#btnCancelRemenber').click(function(){ hideFormRemenber(); });

//llama a la funcion para enviar el registro
$('#btnSendEmail').click(function(){ sendEmailContact(); });

//llama a la funcion para recordar mi contraseña
$('#btnRemenberPassword').click(function(){ remenberPassword(); });

$(function() {

    $("#btnSignIn").click(function() {
		verifyUser();
	});
    
    $("#txtUser,#txtPassword").keypress(function(e) {
	    if(e.which == 13) { verifyUser(); }
	});
});



/**
 * Actualizamos el mensaje de alerta
 */
function showMsg(mensaje){
    $('#alertLogin').hide();
    $('#alertLogin').html(mensaje);
    $('#alertLogin').show('slow');
}


/**
 * Ejemplo de una consulta al backend
 */
function verifyUser(){
	
    if ($('#txtUser').val().trim().length == 0
       || $('#txtPassword').val().trim().length == 0){
		   
        showMsg('El usuario y password son requeridos.');
    }else{
        $.ajax({
            type: "POST",
            url: "login/checkLogin",
            dataType:'json',
            data: { 
                email: $('#txtUser').val(),
                password: $('#txtPassword').val()
            },
            success: function(data){
                if (data.success){
					if(data.type == 1){
						window.location.href = URL_BASE + "home";
					}else{
						window.location.href = URL_BASE + "dashboard";
					}
                }else{
                    showMsg(data.message);
                }
            }
        });
    }
}

//muestra el formulario de registro(contacto)
function showFormRegister(){
	clearField();
	$('#alertLogin').hide();
	$('#alertRegister').hide();
	$('#formLogin').hide('slow');
	$('#formRemenberPassword').hide('slow');
	$('#registrerForm').hide();
	$('#formRegister').show('slow');
}

//esconde el formulario de registro(contacto)
function hideFormRegister(){
	clearField();
	$('#alertLogin').hide();
	$('#alertRegister').hide();
	$('#formRegister').hide('slow');
	$('#formRemenberPassword').hide('slow');
	$('#formLogin').show('slow');
	$('#registrerForm').show();
}

//muestra el formulario de recordar contraseña
function showFormRemenber(){
	clearField();
	$('#alertLogin').hide();
	$('#alertRegister').hide();
	$('#formLogin').hide('slow');
	$('#formRegister').hide('slow');
	$('#formRemenberPassword').show('slow');
	//$('#bgLogin').show('slow');
}

//esconde el formulario de recordar contraseña
function hideFormRemenber(){
	clearField();
	$('#alertLogin').hide();
	$('#alertRegister').hide();
	$('#formRegister').hide('slow');
	$('#formRemenberPassword').hide('slow');
	$('#formLogin').show('slow');
}

////////////////////////////////

//envia el email del contacto
function sendEmailContact(){
	var result = true;
	result = verifyContact();
	if(result){
		$.ajax({
            type: "POST",
            url: "login/sendEmailContact",
            dataType:'json',
            data: { 
                email: $('#txtEmail').val(),
                partner: $('#txtPartner').val(),
				observation: $('#txtObservation').val()
            },
            success: function(data){
				hideFormRegister();
               	alert("mensaje enviado");
            },
			error: function(data){
				alert("mensaje no enviado");
			}
        });
	}
}

//verifica que los campos este correctos
function verifyContact(){
	var result = true;
	
	$('#alertRegister').hide();
	
	if($('#txtPartner').val().trim().length == 0){
		result = false;
	}
	
	if($('#txtObservation').val().trim().length == 0){
		result = false;
	}
	
	/*if($('#txtEmail').val().trim().length == 0){
		result = false;
	}*/
	
	var emailExpr = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
	var email = $('#txtEmail').val().trim();
	if( !emailExpr.test(email) ){
        result = false;
	}
	
	if(result == false){
		$('#alertRegister').html('los campos son requeridos');
		$('#alertRegister').show('slow');
	}
	
	return result;	
}

//cambia la contraseña del comercio
function remenberPassword(){
	
	$('#alertRemeber').hide();
	
	var emailExpr = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
	var email = $('#txtRemenberEmail').val().trim();
	if( !emailExpr.test(email) ){ 
    	$('#alertRemeber').html("Correo invalido");
   		$('#alertRemeber').show('slow');
    }else{
  		$.ajax({
            type: "POST",
            url: "login/changePassword",
            dataType:'json',
            data: { 
                email: $('#txtRemenberEmail').val()
            },
            success: function(data){
               // alert("Contraseña cambiada por favor revise su correo");
			   hideFormRemenber();
			   alert(data);
            },
			error: function(data){
				alert('Error al cambiar la contraseña');	
			}
        });
    }
	
}

function clearField(){
	
	$('#txtUser').val("");
	$('#txtPassword').val("");
	
	$('#txtEmail').val("");
	$('#txtPartner').val("");
	$('#txtObservation').val("");	
	
	$('#txtRemenberEmail').val("");
}