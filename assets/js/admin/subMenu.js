// JavaScript Document

$('.btnSubMenu').click(function(){ pageSubMenu($(this).attr('id')); });

function pageSubMenu(idSubMenu){
	
	$('.btnSubMenu').removeClass('active');
	$('.divContentInfo').hide();
	
	$('#' + idSubMenu).addClass('active');
	
	$('#vw' + idSubMenu).show();
	
	$('.subMenuLeft').height('auto');
	
	$('.divAlertWarning').hide();
	
	$('.viewTable').hide();
	$('.viewForm').hide();
	$('.' + idSubMenu).show();
	
	$('.subMenuLeft').height(600);
	
	if(document.width>1024 || $('.menuHeader').width()>1024){
		if($('.container').height() > 600){
			var heightContainer = $('.container').height();
			$('.subMenuLeft').height(heightContainer);
		}
	}else{
		$('.opcionMenuLeftMovil').animate({ "left": "-70%" }, 500 );
		$('#bgSubMenuMovil').hide();	
	}
	
}

$(document).click(function(){
	
	$('.subMenuLeft').height(600);
	
	if(document.width>1024 || $('.menuHeader').width()>1024){
		if($('.container').height() > 600){
			var heightContainer = $('.container').height();
			$('.subMenuLeft').height(heightContainer);
		}
	}else{
		$('.opcionMenuLeftMovil').animate({ "left": "-70%" }, 500 );
		$('#bgSubMenuMovil').hide();	
	}
});