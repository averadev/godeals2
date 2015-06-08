/**
 * GeekBucket 2014
 * Author: Alberto Vera Espitia
 * Define funcionalidad en el home del app
 *
 */
 
$('#alertLogin').hide();

$(function() {

    $("#login").click(function() {
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
                    window.location.href = URL_BASE + "home";
                }else{
                    showMsg(data.message);
                }
            }
        });
    }
}