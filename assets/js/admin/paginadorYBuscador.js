// JavaScript Document
var dato = "";
var dato2 = "";
var dato3 = "";
var dato4 = "";
var order ="ASC";
var column = "id";
var idPartnerDeals = 0;

$(document).on('click','.btnPaginador',function(){ 
	paginador(this);
});

$('.arrowUp').click(function() { OrdenarPorFechas("ASC",this); });
$('.arrowDown').click(function() { OrdenarPorFechas("DESC",this); });

$('.btnSearch').click(function() { buscador(this); });

$('.txtSearch').keyup(function(e){
    if(e.keyCode ==13){
	buscador(this);	
    }
});


//funcion que cambia la paginacion
	function paginador(selecionado){
          
            var tipo = $(selecionado).attr('id').substring(12,selecionado.length).toLowerCase();
			
            var url = "";
                switch(tipo){
                    case "coupon":
                        url = "deals/paginadorArray";
						$('ul #btnPaginadorCoupon').removeClass('current');
                    break;
                    case "partner":
                        url = "partners/paginadorArray";
						$('ul #btnPaginadorPartner').removeClass('current');
                    break;
                    case "event":
                        url = "eventos/paginadorArray";
                        $('ul #btnPaginadorEvent').removeClass('current');
					break;
					case "sporttv":
						url = "sporttv/paginadorArray";
						$('ul #btnPaginadorSporttv').removeClass('current');
					break;
					case "publicity":
						url = "publicity/paginadorArray";
						$('ul #btnPaginadorPublicity').removeClass('current');
					break;
					case "place":
						url = "place/paginadorArray";
						$('ul #btnPaginadorPlace').removeClass('current');
					break;
					case "ads":
						url = "ads/paginadorArray";
						$('ul #btnPaginadorAds').removeClass('current');
					break;
					case "promo":
						url = "promociones/paginadorArray";
						$('ul #btnPaginadorAds').removeClass('current');
					break;
					case "campana":
						url = "lealtad/paginadorCampana";
						$('ul #btnPaginadorCampana').removeClass('current');
					break;
					case "authorizationsl":
						url = "lealtad/paginadorAuthoL";
						$('ul #btnPaginadorAuthorizationsL').removeClass('current');
					break;
					case "dealsreward":
						url = "deals/paginadorDealsByPartner";
						$('ul #btnPaginadorDealsReward').removeClass('current');
						idPartnerDeals = $('#txtPartnerCampana').attr('idP');
					break;
					case "reward":
						url = "lealtad/paginadorReward";
						$('ul #btnPaginadorReward').removeClass('current');
						idPartnerDeals = $('#txtPartnerCampana').attr('idP');
					break;
					case "dashdealsbydate":
						//alert('conectado')
						url = "dashboard/getDealsByDatePaginador";
						$('ul #btnPaginatorDashDealsByDate').removeClass('current');
					break;
					case "dashdealsactive":
						//alert('conectado')
						url = "dashboard/getInfoDealsActivos";
						$('ul #btnPaginatorDashDealsActive').removeClass('current');
					break;
					case "dashtotaluser":
						//alert('conectado')
						url = "dashboard/getInfoTotalUser";
						$('ul #btnPaginatorDashTotalUser').removeClass('current');
					break;
                }
                    
		$(selecionado).addClass('current');
		var cantidad = $(selecionado).val();
		//compureba si el primer numero del paginador
		if(cantidad == 0 || cantidad ==1){
			$('ul .primero').addClass('unavailable');
			cantidad = 1;
		} else {
			$('ul .primero').removeClass('unavailable');
		}
		//comprueba si el ultimo numero del paginador
		var total = $('ul .ultimo').val();
		if(total == cantidad){
			$('ul .ultimo').addClass('unavailable');
		} else {
			$('ul .ultimo').removeClass('unavailable');
		}
		//obtiene la siguiente lista del paginador
		cantidad = (cantidad-1) *10;
		
		if($(selecionado).attr('id') == "btnPaginadorReward" || $(selecionado).attr('id') == "btnPaginatorDashDealsByDate"
		|| $(selecionado).attr('id') == "btnPaginatorDashDealsActive" 
		|| $(selecionado).attr('id') == "btnPaginatorDashTotalUser"  ){
			muestraNuevaTablaCompuesta(url,cantidad,tipo);
		}else{    
			muestraNuevaTabla(url,cantidad,tipo);
		}
		
	}
	
	function muestraNuevaTabla(url,cantidad,tipo){
            $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: { 
                dato:dato,
                cantidad:cantidad,
				order:order,
				column:column,
				idPartner:idPartnerDeals
            },
            success: function(data){
                total = data.length;
                switch(tipo){
                    case "coupon":     
                        $('#tableCoupon tbody').empty();
                        for(var i = 0;i<total;i++){
                            num = parseInt(cantidad) + parseInt((i+1));
							var imgPubli = "";
							var idPublic = "";
							if(data[i].status == 1){
								imgPubli = "assets/img/web/tick.png";
								idPublic = "imgPubli1";
							}else{
								imgPubli = "assets/img/web/cancel.png";	
								idPublic = "imgPubli2";
							}
                            $('#tableCoupon tbody').append("<tr>" + 
                            "<td>"+ num +"</td>"+
                            "<td><a id='showCoupon'>"+data[i].name+"<input type='hidden' id='idCoupon' value='" + data[i].id + "' >" +
                            "</a></td>"+
                            "<td>"+data[i].partnerName+"</td>"+
                            "<td>"+data[i].total+"</td>"+
							"<td><img id='" + idPublic + "' src='" + imgPubli + "'/></td>"+
                            "<td><a id='imageDelete' value='" + data[i].id +"'><img id='imgDelete' "+
                            "src='assets/img/web/delete.png'/></a></td>" +
                            "</tr>");
                        }
                    break;
                                    
                    case "partner":
                       $('#tablePartners tbody').empty();
                        for(var i = 0;i<total;i++){
                            num = parseInt(cantidad) + parseInt((i+1));
                            $('#tablePartners tbody').append("<tr>" + 
                            "<td>"+ num +"</td>"+
                            "<td><a class='showPartner'>"+data[i].name+"<input type='hidden' id='idPartner' value='" + data[i].id + "' >" +
                            "</a></td>"+
                            "<td>"+data[i].phone+"</td>"+
                            "<td><a class='imageDelete' value='" + data[i].id +"'><img id='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
                        }
                    break;
                    
                     case "event":
					 
                       $('#tableEvents tbody').empty();
                        for(var i = 0;i<total;i++){
                            num = parseInt(cantidad) + parseInt((i+1));
                            $('#tableEvents tbody').append("<tr>" +
								"<td>"+ (num) +"</td>"+
								"<td><a id='showEvent'>"+data[i].name+"<input type='hidden' id='idEvent' value='" + 
								data[i].id + "' ></a></td>"+
								"<td>"+data[i].place+"</td>"+
								"<td>"+data[i].iniDate+"</td>"+
								"<td><a id='imageDelete' value='" + data[i].id +"'><img id='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
                        }
                    break;
					
					case "publicity":
					
                       $('#tablePublicity tbody').empty();
					   		for(var i = 0;i<total;i++){
								
							switch(data[i].category){
								case '1':
									category = "Banner";
									break;
								case '2':
									category = "Medio Banner";
									break;
								case '3':
									category = "Lateral";
									break;
								case '4':
									category = "Cintillo";
									break;
								case '5':
									category = "Movil";
									break;
							}
								
                            num = parseInt(cantidad) + parseInt((i+1));
                            $('#tablePublicity tbody').append("<tr>" +
								"<td>"+ (num) +"</td>"+
								"<td><a id='showPublicity'>"+data[i].namePartner+
								"<input type='hidden' id='idPublicity' value='" + data[i].id + "' ></a></td>"+
								"<td>"+category+"</td>"+
								"<td>"+data[i].iniDate+"</td>"+
								"<td>"+data[i].endDate+"</td>"+
								"<td><a id='imageDelete' value='" + data[i].id +"'><img class='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
                        }
						break;
						
						case "place":
                       	$('#tablePlace tbody').empty();
					   		for(var i = 0;i<total;i++){
                            num = parseInt(cantidad) + parseInt((i+1));
                            $('#tablePlace tbody').append("<tr>" +
								"<td>"+ (num) +"</td>"+
								"<td><a id='showPlace'>"+data[i].name+"<input type='hidden' id='idPlace' value='" + 
								data[i].id + "' ></a></td>"+
								"<td>"+data[i].address+"</td>"+
								"<td><a id='imageDelete' value='" + data[i].id +"'><img class='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
						}
						break;
						
						case "ads":
                       	$('#tableAds tbody').empty();
					   		for(var i = 0;i<total;i++){
                            num = parseInt(cantidad) + parseInt((i+1));
							
							var typeA = "";
							if(data[i].type == 1){
								typeA = "Mensaje";
							}else{
								typeA = "Publicidad";
							}
							
                            $('#tableAds tbody').append("<tr>" +
								"<td>"+ (num) +"</td>"+
								"<td><a id='showAds'>"+data[i].message+"<input type='hidden' id='idAds' value='" + 
								data[i].id + "' ></a></td>"+
								"<td>"+data[i].distanceMin+"</td>"+
								"<td>"+data[i].distanceMax+"</td>"+
								"<td><a id='imageDelete' value='" + data[i].id +"'><img class='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
						}
						break;
						
						case "promo":     
                        $('#tableCoupon tbody').empty();
                        for(var i = 0;i<total;i++){
							
							var redimir;
							if(data[i].name == 2){
								redimir = "Si";	
							}else{
								redimir = "No";
							}
							
                            num = parseInt(cantidad) + parseInt((i+1));
                            $('#tableCoupon tbody').append("<tr>" + 
                            "<td>"+ num +"</td>"+
                            "<td><a id='showCoupon'>"+data[i].name+"<input type='hidden' id='idCoupon' value='" + data[i].id + "' >" +
                            "</a></td>"+
                            "<td>"+data[i].partnerName+"</td>"+
                            "<td>"+data[i].total+"</td>"+
							"<td>"+redimir+"</td>"+
                            "<td><a id='imageDelete' value='" + data[i].id +"'><img id='imgDelete' "+
                            "src='assets/img/web/delete.png'/></a></td>" +
                            "</tr>");
                        }
                   		break;
						
						case "campana": 
						
                        $('#tableCampanaLealtad tbody').empty();
                        for(var i = 0;i<total;i++){
							
                            num = parseInt(cantidad) + parseInt((i+1));
							var publicado = "SI";
							if(data[i].status == -1){ publicado = "NO" }
							
                            $('#tableCampanaLealtad tbody').append("<tr>" + 
                            "<td>"+ num +"</td>"+
                            "<td><a class='showCampana' value='" + data[i].id + "'>"+ data[i].nombre + "</a></td>"+
                            "<td>"+ data[i].recompensa +"</td>"+
                            "<td>"+ data[i].partnerName +"</td>"+
							"<td>"+ publicado +"</td>"+
                            "<td><a id='imageDelete' value='" + data[i].id +"'><img id='imgDelete' "+
                            "src='assets/img/web/delete.png'/></a></td>" +
                            "</tr>");
                        }
                   		break;
						
						case "authorizationsl":
						
							$('#tableAuthorizationsLealtad tbody').empty();
							
							for(i=0;i<data.items.length;i++){
								
								num = parseInt(cantidad) + parseInt((i+1));
								var requerimientos = "";
								for(j=0;j<data.requirements[i].length;j++){
					
									for(k=0;k<data.requirements[i][j].length;k++){
										requerimientos = requerimientos +data.requirements[i][j][k].cantidadRequerida + " " + 
										data.requirements[i][j][k].nombre;
										if(k < data.requirements[i][j].length){requerimientos = requerimientos + '</br>'}
									}
								}
								
								//////////
								
								if(data.items[i].lealtadStatusRecompensasId == 4){
									var deleteReward = data.items[i].nameStatus;
									var idR = 0;
								}else{
									var deleteReward = "<a class='imgApproved' value='" + data.items[i].id +"' idStatus='" + data.items[i].lealtadStatusRecompensasId + "'>" + data.items[i].nameStatus + "</a>";	
									var idR = data.items[i].partnerId;
								}
				
								$('#tableAuthorizationsLealtad tbody').append(
									'<tr>' +
										'<td>' + num +'</td>' +
										'<td><a class="showRewardForAuthorization" id="' + data.items[i].id + '" value="' + idR + '">' + 
											data.items[i].nombre +'</td>' +
										'<td>' + requerimientos +'</td>' +
										'<td>Administrador</td>' +
										'<td>' + data.items[i].campanaNombre +'</td>' +
										'<td>' + data.items[i].namePartner +'</td>' +
										'<td>' + deleteReward + '</td>' +
									'</tr>'
								);
							}
						break;
						
						case "dealsreward":
						
                        	$('#tableCouponReward tbody').empty();
                        	for(var i = 0;i<total;i++){
							
                            	num = parseInt(cantidad) + parseInt((i+1));
								
								$('#tableCouponReward tbody').append(
									'<tr>'+
										'<td>' + (i+1) + '</td>' +
										'<td>' + data[i].name + '</td>' +
										'<td><input id="checkDR' + data[i].id + '" class="checkDealsReward" type="checkbox" idDeal="' + data[i].id + '" nameDeals="' + data[i].name + '"></td>' +
									'</tr>'
								);
				
								$('#tableGrantReward tbody tr').each(function(index, element) {
            						var trid = $(this).attr('id');
									var idD = trid.split("TRId");
									if( 'checkDR' + data[i].id  == 'checkDR' + idD[1]){
										$('#checkDR' + data[i].id).prop('checked', true);
									}	 
          						});
							
                            	/*$('#tableCampanaLealtad tbody').append("<tr>" + 
                            		"<td>"+ num +"</td>"+
                            		"<td><a class='showCampana' value='" + data[i].id + "'>"+ data[i].nombre + "</a></td>"+
                            		"<td>"+ data[i].recompensa +"</td>"+
                            		"<td>"+ data[i].partnerName +"</td>"+
									"<td>"+ publicado +"</td>"+
                            		"<td><a id='imageDelete' value='" + data[i].id +"'><img id='imgDelete' "+
                            		"src='assets/img/web/delete.png'/></a></td>" +
                            	"</tr>");*/
								
								
								
								
                        	}
                   		break;
						
                }            	
            }
        });	
    }
	
	var category;
	
	//funcion que muestra los resultados ordenados por fecha
	function OrdenarPorFechas(typeOrder,typeTable){
		tableOrder = $(typeTable).attr('id');
		column = tableOrder;
		order = typeOrder;
		typeTable = $(typeTable).attr('value');
		if(typeTable == "coupon"){
			
		}
		switch(typeTable){
			case "coupon":
			url = "deals/getallSearch";
			break;
			case "event":
			url = "eventos/getallSearch";
			break;
			case "sporttv":
			url = "sporttv/getallSearch";
            break;
			case "publicity":
			url = "publicity/getallSearch";
            break;
			case "promo":
			url = "publicity/getallSearch";
            break;
		}
		
		//llama a la funcion "ajax" que se encarga de mostrar los datos en la tabla
		ajaxMostrarTabla(tableOrder,typeOrder,url,0,typeTable);
	}
	
	//funcion que muestra los datos de deals en la tabla
	function ajaxMostrarTabla(tipo,order,url,cantidadEmpezar,tipoTabla){
		pagActual = cantidadEmpezar + 1;
		cantidadEmpezar = cantidadEmpezar *10;
		var btnPaginador;
		$.ajax({
            type: "POST",
            url:url,
            dataType:'json',
            data: { 
				dato:dato,
				column:tipo,
				order:order,
				cantidad:cantidadEmpezar
            },
            success: function(data){
				total = data.length;
				cantidad = total/10;
				cantidad = parseInt(cantidad) + 1;
				if(total%10 == 0){
					cantidad = cantidad -1;
				}
				//elimina el contenido de la tabla selecionada
				if(tipoTabla == "coupon"){
					$('#tableCoupon tbody').empty();
				} else if(tipoTabla == "event"){
					$('#tableEvents tbody').empty();
				}else if(tipoTabla == "partner"){
					$('#tablePartners tbody').empty();
				} else if(tipoTabla == "sporttv"){
					$('#tableSporttv tbody').empty();
				} else if(tipoTabla == "publicity"){
					$('#tablePublicity tbody').empty();
				} else if(tipoTabla == "place"){
					$('#tablePlace tbody').empty();
				}else if(tipoTabla == "ads"){
					$('#tableAds tbody').empty();
				}else if(tipoTabla == "promo"){
					$('#tableCoupon tbody').empty();
				}else if(tipoTabla == "campana"){
					$('#tableCampanaLealtad tbody').empty();
				}
                                
				$('.pagination').empty();
				for(var i = 0;i<10;i++){
					num = cantidadEmpezar + i;
					//rompe el ciclo si la cantidad de registros devueltos es menor a 10
					if(data[num] == undefined){
						break;	
					}
                                        
                    switch(tipoTabla)
					{
						case "coupon":
						var imgPubli = "";
							var idPublic = "";
							if(data[num].status == 1){
								imgPubli = "assets/img/web/tick.png";
								idPublic = "imgPubli1";
							}else{
								imgPubli = "assets/img/web/cancel.png";	
								idPublic = "imgPubli2";
							}
						$('#tableCoupon tbody').append("<tr>" + 
							"<td>"+(num+1)+"</td>"+
							"<td><a id='showCoupon'>"+data[num].name+"<input type='hidden' " + 
							"id='idCoupon' value='" + data[num].id + "' >" +
							"</a></td>"+
							"<td>"+data[num].partnerName+"</td>"+
							"<td>"+data[num].total+"</td>"+
							"<td><img id='" + idPublic + "' src='" + imgPubli + "'/></td>"+
							"<td><a id='imageDelete' value='" + data[num].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a></td>" +
							"</tr>");
						btnPaginador = "btnPaginadorCoupon";
                        break;
						
						case "partner":
							$('#tablePartners tbody').append("<tr>" + 
								"<td>"+(num+1)+"</td>"+
								"<td><a class='showPartner'>"+data[num].name+"<input type='hidden' " + 
								"id='idPartner' value='" + data[num].id + "' >" +
								"</a></td>"+
								"<td>"+data[num].phone+"</td>"+
								"<td><a class='imageDelete' value='" + data[num].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a></td>" +
							"</tr>");
                            btnPaginador = "btnPaginadorPartner"
							break;
                                        
                            case "event":
								
								$('#tableEvents tbody').append("<tr>" +
									"<td>"+ (num+1) +"</td>"+
									"<td><a id='showEvent'>"+data[num].name+"<input type='hidden' id='idEvent' value='" + 
									data[num].id + "' ></a></td>"+
									"<td>"+data[num].place+"</td>"+
									"<td>"+data[num].iniDate+"</td>"+
									"<td><a id='imageDelete' value='" + data[num].id +"'><img id='imgDelete' "+
									"src='assets/img/web/delete.png'/></a></td>" +
									"</tr>");
								btnPaginador = "btnPaginadorEvent";
								break;
								
							case "sporttv":
							$('#tableSporttv tbody').append("<tr>" +
								"<td>"+ (num+1) +"</td>"+
								"<td><a id='showSporttv'>"+data[num].name+"<input type='hidden'" +
								"id='idSporttv' value='" + 
								data[num].id + "' ></a></td>"+
								"<td>"+data[num].torneo+"</td>"+
								"<td>"+data[num].date+"</td>"+
								"<td><a id='imageDelete' value='" + data[num].id +"'><img class='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
							btnPaginador = "btnPaginadorSporttv";
							break;
							
							case "publicity":
							var category;
							switch(data[num].category){
								case '1':
									category = "Banner";
									break;
								case '2':
									category = "Medio Banner";
									break;
								case '3':
									category = "Lateral";
									break;
								case '4':
									category = "Cintillo";
									break;
								case '5':
									category = "Movil";
									break;
							}
							$('#tablePublicity tbody').append("<tr>" +
								"<td>"+ (num+1) +"</td>"+
								"<td><a id='showPublicity'>"+data[num].namePartner+"<input type='hidden'" +
								"id='idPublicity' value='" + data[num].id + "' ></a></td>"+
								"<td>"+category+"</td>"+
								"<td>"+data[num].iniDate+"</td>"+
								"<td>"+data[num].endDate+"</td>"+
								"<td><a id='imageDelete' value='" + data[num].id +"'><img class='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
							btnPaginador = "btnPaginadorPublicity";
							break;
							
							case "place":
							$('#tablePlace tbody').append("<tr>" +
								"<td>"+ (num+1) +"</td>"+
								"<td><a id='showPlace'>"+data[num].name+"<input type='hidden'" +
								"id='idPlace' value='" + 
								data[num].id + "' ></a></td>"+
								"<td>"+data[num].address+"</td>"+
								"<td><a id='imageDelete' value='" + data[num].id +"'><img class='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
							btnPaginador = "btnPaginadorPlace";
							break;
							
							case "ads":
							
							var typeA = "";
							if(data[num].type == 1){
								typeA = "Mensaje";
							}else{
								typeA = "Publicidad";
							}
							
                            $('#tableAds tbody').append("<tr>" +
								"<td>"+ (num+1) +"</td>"+
								"<td><a id='showAds'>"+data[num].message+"<input type='hidden' id='idAds' value='" + 
								data[num].id + "' ></a></td>"+
								"<td>"+typeA+"</td>"+
								"<td>"+data[num].distanceMin+"</td>"+
								"<td>"+data[num].distanceMax+"</td>"+
								"<td><a id='imageDelete' value='" + data[num].id +"'><img class='imgDelete' "+
								"src='assets/img/web/delete.png'/></a></td>" +
								"</tr>");
							break;
							
						case "promo":
						var redimir;
						if(data[num].status == 2){
							redimir = "Si";
						}else{
							redimir = "No"
						}
						$('#tableCoupon tbody').append("<tr>" + 
							"<td>"+(num+1)+"</td>"+
							"<td><a id='showCoupon'>"+data[num].name+"<input type='hidden' " + 
							"id='idCoupon' value='" + data[num].id + "' >" +
							"</a></td>"+
							"<td>"+data[num].partnerName+"</td>"+
							"<td>"+data[num].total+"</td>"+
							"<td>"+redimir+"</td>"+
							"<td><a id='imageDelete' value='" + data[num].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a></td>" +
							"</tr>");
						btnPaginador = "btnPaginadorPromo";
                        break;
						
						case "campana":
						
						var publicado = "SI";
						if(data[num].status == -1){ publicado = "NO" }
						
						$('#tableCampanaLealtad tbody').append("<tr>" + 
							"<td>"+(num+1)+"</td>"+
							"<td><a class='showCampana' value='" + data[num].id + "'>"+ data[num].nombre + "</a></td>"+
							"</a></td>"+
							"<td>"+data[num].recompensa+"</td>"+
							"<td>"+data[num].partnerName+"</td>"+
							"<td>"+publicado+"</td>"+
							"<td><a id='imageDelete' value='" + data[num].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a></td>" +
							"</tr>");
						btnPaginador = "btnPaginadorPromo";
                        break;
					}
                }
							
				$('.pagination').append(
					"<li value=" + cantidad + " id='" + btnPaginador + "' class='btnPaginador arrow primero'><a>&laquo;</a></li>"
				);
				
				for(var i = 1;i<=cantidad;i++){
							
					if(pagActual == i){
						$('.pagination').append(
							"<li value=" + i + " id='" + btnPaginador + "' class='btnPaginador current'><a>" + i + "</a></li>"
						);
					} else {
						$('.pagination').append(
							"<li value=" + i + " id='" + btnPaginador + "' class='btnPaginador'><a>" + i + "</a></li>"
						);
					}
				}
				$('.pagination').append(
					"<li value=" + cantidad + " id='" + btnPaginador + "' class='btnPaginador arrow ultimo'><a>&raquo;</a></li>"
				);
			}
		});	
	} 
	
	function buscador(typeTable){
       	var type = $(typeTable).attr('id').substring(9,typeTable.length).toLowerCase();
		var palabra;
		var url;
		//muestra los datos en deals
                switch(type){
                    case "coupon":
                        palabra = $('#txtSearchCoupon').val();
						url = "deals/getallSearch";
                    break;
                    case "event":
                        palabra = $('#txtSearchEvent').val();
						url = "eventos/getallSearch";
                    break;
                
                    case "partner":
                        palabra = $('#txtSearchPartner').val();
						url = "partners/getallSearch";
                    break;
					
					case "sporttv":
                        palabra = $('#txtSearchSporttv').val();
						url = "sporttv/getallSearch";
                    break;
					case "publicity":
                        palabra = $('#txtSearchPublicity').val();
						palabra2 = palabra.toLowerCase();
						switch(palabra2){
							case "banner":
								palabra = 1;
							break;
							case "medio banner":
								palabra = 2;
							break;
							case "lateral":
								palabra = 3;
							break;
							case "cintillo":
								palabra = 4;
							break;
							case "movil":
								palabra = 5;
							break;
						}
						url = "publicity/getallSearch";
                    break;
					
					case "place":
                        palabra = $('#txtSearchPlace').val();
						url = "place/getallSearch";
                    break;
					
					case "ads":
                        palabra = $('#txtSearchAds').val();
						url = "ads/getallSearch";
                    break;
					case "promo":
                        palabra = $('#txtSearchPromo').val();
						url = "promociones/getallSearch";
                    break;
					case "campana":
                        palabra = $('#txtSearchCampana').val();
						url = "lealtad/getallSearchCampana";
                    break;
                }
		
		column = "id";
		dato = palabra;
		//llama a la funcion "ajax" que se encarga de mostrar los datos en la tabla
		ajaxMostrarTabla(column,order,url,0,type);
	}

/***********************************************************/
/******************Busqueda compuesta***********************/
/***********************************************************/

$('.btnSearchCReward').click(function() { buscadorCompuesto(this); });

$('.txtSearchComposed').keyup(function(e){
    if(e.keyCode ==13){
		buscadorCompuesto(this);	
    }
});

function buscadorCompuesto(typeTable){
	var type = $(typeTable).attr('id').substring(9,typeTable.length).toLowerCase();
	var url;
	if(type == "reward" || type == "rewardpartner" || type == "rewardcampana"){
		dato2 = $('#txtSearchRewardPartner').val();
		dato3 = $('#txtSearchRewardCampana').val();
		dato4 = $('#sctTypeReward').val();
		url = "lealtad/getAllSearchReward";
		type = "reward"
	}
	column = "id";
	ajaxMostrarTablaCompuesta(column,order,url,0,type);
}

//muestra el resultado de la busqueda
function ajaxMostrarTablaCompuesta(tipo,order,url,cantidadEmpezar,tipoTabla){
	pagActual = cantidadEmpezar + 1;
	cantidadEmpezar = cantidadEmpezar *10;
	var btnPaginador;
	$.ajax({
       	type:"POST",
       	url:url,
        dataType:'json',
        data: {
			dato2:dato2,
			dato3:dato3,
			dato4:dato4,
			column:tipo,
			order:order,
			cantidad:cantidadEmpezar
 		},
       	success: function(data){
			total = data.items.length;
			cantidad = total/10;
			cantidad = parseInt(cantidad) + 1;
			if(total%10 == 0){
				cantidad = cantidad -1;
			}
			//elimina el contenido de la tabla selecionada
			if(tipoTabla == "reward"){
				$('#tableReward tbody').empty();
			}
                                
			$('.pagination').empty();
			for(var i = 0;i<10;i++){
				num = cantidadEmpezar + i;
				//rompe el ciclo si la cantidad de registros devueltos es menor a 10
				if(data.items[num] == undefined){
					break;	
				}
                                       
     	       switch(tipoTabla){
					case "reward":
					
						var requerimientos = "";
						for(j=0;j<data.requirements[i].length;j++){
							for(k=0;k<data.requirements[i][j].length;k++){
								requerimientos = requerimientos +data.requirements[i][j][k].cantidadRequerida + " " + 
								data.requirements[i][j][k].nombre;
								if(k < data.requirements[i][j].length){requerimientos = requerimientos + '</br>'}
							}
						}
						
						var idR = 0;
						if(data.items[i].lealtadStatusRecompensasId == 4){
							//deleteR = "";
							idR == 0;
						}else{
							/*deleteR = "<a class='imgDeleteReward' value='" + items[i].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a>";*/
							idR = data.items[i].partnerId;
						}
					
						$('#tableReward tbody').append(
							"<tr>" + 
								"<td>"+(num+1)+"</td>"+
								'<td><a class="showRewardForCatalog" id="' + data.items[i].id + '" value="' + idR + '">' + data.items[i].nombre +'</a></td>' +
								'<td>' + requerimientos +'</td>' +
								'<td>' + data.items[i].campanaNombre +'</td>' +
								'<td>' + data.items[i].namePartner +'</td>' +
								'<td>' + data.items[i].nameStatus + '</td>' +
							"</tr>");
						btnPaginador = "btnPaginadorReward";
                  	break;
				}
           	}
							
			$('.pagination').append(
				"<li value=" + cantidad + " id='" + btnPaginador + "' class='btnPaginador arrow primero'><a>&laquo;</a></li>"
			);
				
			for(var i = 1;i<=cantidad;i++){
							
				if(pagActual == i){
					$('.pagination').append(
						"<li value=" + i + " id='" + btnPaginador + "' class='btnPaginador current'><a>" + i + "</a></li>"
					);
				} else {
					$('.pagination').append(
						"<li value=" + i + " id='" + btnPaginador + "' class='btnPaginador'><a>" + i + "</a></li>"
					);
				}
			}
			$('.pagination').append(
				"<li value=" + cantidad + " id='" + btnPaginador + "' class='btnPaginador arrow ultimo'><a>&raquo;</a></li>"
			);
		}
	});
}

function muestraNuevaTablaCompuesta(url,cantidad,tipo){
	
	 $.ajax({
		type: "POST",
		url: url,
		dataType:'json',
		data: {
			dato2:dato2,
			dato3:dato3,
			dato4:dato4,
			cantidad:cantidad,
			order:order,
			column:column,
			idPartner:idPartnerDeals
		},
		success: function(data){
			console.log(data)
			total = data.items.length;
			switch(tipo){
				case "reward":     
					$('#tableReward tbody').empty();
					for(var i = 0;i<total;i++){
						 num = parseInt(cantidad) + parseInt((i+1));
						var requerimientos = "";
						for(j=0;j<data.requirements[i].length;j++){
							for(k=0;k<data.requirements[i][j].length;k++){
								requerimientos = requerimientos +data.requirements[i][j][k].cantidadRequerida + " " + 
								data.requirements[i][j][k].nombre;
								if(k < data.requirements[i][j].length){requerimientos = requerimientos + '</br>'}
							}
						}
						
						var idR = 0;
						if(data.items[i].lealtadStatusRecompensasId == 4){
							//deleteR = "";
							idR == 0;
						}else{
							/*deleteR = "<a class='imgDeleteReward' value='" + items[i].id +"'><img id='imgDelete' "+
							"src='assets/img/web/delete.png'/></a>";*/
							idR = data.items[i].partnerId;
						}
					
						$('#tableReward tbody').append(
							"<tr>" + 
								"<td>"+(num)+"</td>"+
								'<td><a class="showRewardForCatalog" id="' + data.items[i].id + '" value="' + idR + '">' + data.items[i].nombre +'</a></td>' +
								'<td>' + requerimientos +'</td>' +
								'<td>' + data.items[i].campanaNombre +'</td>' +
								'<td>' + data.items[i].namePartner +'</td>' +
								'<td>' + data.items[i].nameStatus + '</td>' +
							"</tr>"
						);
					}
				break;
				
				case "dashdealsbydate":
					
					items = data.items;
					$('#tableDashModal tbody').empty();
					for(i = 0;i<items.length;i++){
						num = parseInt(cantidad) + parseInt((i+1));
						$('#tableDashModal tbody').append(
						'<tr>' +
							'<td>' + num + '</td>' +
							'<td>' + items[i].descripcion + '</td>' +
							'<td>' + items[i].name + '</td>' +
							'<td>' + items[i].total + '</td>' +
						'</tr>'
						);
					}
					
              	break;
				
				case "dashdealsactive":
					
					items = data.items;
					$('#tableModalDealsActive tbody').empty();
					for(i = 0;i<items.length;i++){
						num = parseInt(cantidad) + parseInt((i+1));
						$('#tableModalDealsActive tbody').append(
							'<tr>' +
								'<td>' + num + '</td>' +
								'<td>' + items[i].name + '</td>' +
								'<td>' + items[i].partnerName + '</td>' +
								'<td>' + items[i].total + '</td>' +
								'<td>' + items[i].stock + '</td>' +
							'</tr>'
						);
					}
					
              	break;
				
				case "dashtotaluser":
					items = data.items;
					$('#tableModalTotalUser tbody').empty();
					for(i = 0;i<items.length;i++){
						num = parseInt(cantidad) + parseInt((i+1));
						$('#tableModalTotalUser tbody').append(
							'<tr>' +
								'<td>' + num + '</td>' +
								'<td>' + items[i].email + '</td>' +
								'<td>' + items[i].name + '</td>' +
							'</tr>'
						);
					}
              	break;
			}            	
		}
	});	
	
}