
$(function() {
	
	//  Eventos de Botones
	$("#btnSearch").click(function() {
		setCode();
	});
	$("#txtCodigo").keypress(function(e) {
	    if(e.which == 13) { setCode(); }
	});
	

});


/**
 * Redime el cupon
 */
function setCode(pagina){
	
    if ($("#txtCodigo").val() == ''){
            sendMsg("Ingrese el codigo a redimir.", false);
    }else{
		var today = new Date();
		var currentDay = today.getFullYear() +'-'+ (today.getMonth()+1) +'-'+ today.getDate();
		
        $.ajax({
            type: "POST",
            url: "redemption/setCode",
            dataType:'json',
            data: { 
                code: $("#txtCodigo").val(),
				redemptionDate: currentDay,
                status: 2
            },
            success: function(data){
                sendMsg(data.message, (data.success == 1));
            }
        });
    }
}

function sendMsg(text, isSuccess){
    text += '<a href="#" class="close">&times;</a>';
    $(".bg-danger").hide();
    $(".bg-info").hide();
		console.log(text);
    if (isSuccess){
        $(".bg-info").html(text);
        $(".bg-info").show("slow");
    }else{
        $(".bg-danger").html(text);
        $(".bg-danger").show("slow");
    }
    
    // On close
    $(".close").click(function() {
		$(this).parent().hide();
	});close
}