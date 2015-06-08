// JavaScript Document

var contMenuDespegable;

//llama a la funcion para mostrar el menu derecho
$('#MenuOpctionMovil').click(function(){ showMenuRight(); });

//llama a la funcion para ocultar el menu
$('#bgMenuMovil').click(function(){ hideMenuRigth(); });

//llama a la funcion para mostrar el menu izquierdo
$('#SubMenuMovil').click(function(){ showMenuLeft(); });

//llama a la funcion para ocultar el menu izquierdo
$('#bgSubMenuMovil').click(function(){ hideMenuLeft(); });

//muestra el menujderechos
function showMenuRight(){
	$('#bgMenuMovil').show();
	$('#navmenuMovilDropdown').show();
	$('#menuMovilDropdown').animate({ "left": "30%" }, 500 );
	$('.container').animate({ "left": "-70%" }, 500 );
	$('.lowerMenuMovil').animate({ "left": "-70%" }, 500 );
	
}

//oculta el munu derecho
function hideMenuRigth(){
	$('#menuMovilDropdown').animate({ "left": "+=70%" }, 500 );
	$('.container').animate({ "left": "+=70%" }, 500 );
	$('.lowerMenuMovil').animate({ "left": "+=70%" }, 500 );
	$('#bgMenuMovil').hide();
	$('#navmenuMovilDropdown').delay(500).hide(0);
}

//muestra el menu izquierdo
function showMenuLeft(){
	$('#bgSubMenuMovil').show();
	$('.opcionMenuLeftMovil').show();
	$('.opcionMenuLeftMovil').animate({ "left": "0%" }, 500 );
}

//esconde el menu izquierdo
function hideMenuLeft(){
	$('.opcionMenuLeftMovil').animate({ "left": "-70%" }, 500 );
	$('#bgSubMenuMovil').hide();
}

//cargamos cuando este listo la pagina
$( document ).ready(function(){
	if(document.width>1024 || $('.menuHeader').width()>1024){
		var heightContainer = $('.container').height();
		$('.subMenuLeft').height(heightContainer);
	}
});

$('#imgOptionUser').click(function(e){
	$('#MenuOpctionUser').toggle();
	contMenuDespegable = 1;
	e.stopPropagation();
});

$('html').click(function() {
    /* Aqui se esconden los menus que esten visibles*/
	$('#MenuOpctionUser').hide();
});

$(window).resize(function() { 
	if(document.width>1024 || $('.menuHeader').width()>1024){
		var heightContainer = $('.container').height();
		$('.subMenuLeft').height(heightContainer);
	}else{
		$('.subMenuLeft').height('auto');
	}
});