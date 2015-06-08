
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Catalogo de Ads
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaAds" class="viewTable CatalogAds">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-8 medium-8 large-8 columns">
                	<input type="search" class="txtSearch" id="txtSearchAds" placeholder="Busqueda de campañas" />
                </div>
                <div class="small-4 medium-2 large-2 columns">
                	<button class="btnSearch secondary" id="btnSearchAds"><img src="assets/img/web/iconSearch.png">Buscar</button>
                </div>
                <div class="small-12 medium-2 large-2 columns">
                	<button id="btnAddAds" class="btnAdd btnShowForm">Agregar</button>
                </div>
            </div>
            <!--div alert-->
            <div class="row collapse">
            	<div class="large-12 columns divAlertWarning" id="divMenssage" style="display:none">
					<div data-alert class="alert-box success" id="alertMessage">
					</div>
				</div>
            	<div class="large-12 columns divAlertWarning" id="divMenssagewarning" style="display:none; float:left;">
					<div data-alert class="alert-box warning" id="alertMessagewarning">
						¿desea eliminar el mensaje?
						<button class ="btnCancelC" id="btnCancelC">cancelar</button>
                       	<button class="btnAcceptC" id="btnAcceptC">aceptar</button>
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tableAds" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="6" class="titleTabla">
                                	lista de ADS
                                </td>
                           	</tr>
    						<tr>
                            	<th>#</th>
								<th >Mensaje</th>
								<th>Tipo</th>
								<th>Distancia Min</th>
								<th>Distancia Max</th>
								<th>Eliminar</th>
    						</tr>
  						</thead>
                        <tbody>
                            <?php 
                            $con = 0;
                            foreach ($ads as $item):
                            $con++;
								if($item->type == 1){
									$typeA = "Mensaje";
								}else{
									$typeA = "Publicidad";
								}
                            ?>
                                <tr>
                                    <td><?php echo $con;?></td>
                                    <td>
                                    <a  id="showAds"><?php echo $item->message;?><input type="hidden" id="idAds" value="<?php echo $item->id;?>" ></a>
                                    </td>
                                    <td><?php echo $typeA;?></td>
                                    <td><?php echo $item->distanceMin;?></td>
									<td><?php echo $item->distanceMax;?></td>
                                    <td><a id="imageDelete" value="<?php echo $item->id;?>"><img id="imgDelete" src="assets/img/web/delete.png"/></a></td>
                                </tr>

                            <?php endforeach;
                            $totalPaginador = intval($total/10);
                            if($total%10 == 0){
                                $totalPaginador = $totalPaginador - 1;		
                            }
                            ?>
                            </tbody>
                    </table>
                    <!--- muestra la paginacion --->
                    <ul class="pagination">
						<li id="btnPaginadorAds" value="0" class=btnPaginador "arrow primero unavailable">
							<a>&laquo;</a>
						</li>
						<?php 
						for($i = 1;$i<=($totalPaginador+1);$i++){
							if($i == 1){
							?>
								<li value="<?php echo $i ?>" id="btnPaginadorAds" class="btnPaginador current">
                                <a><?php echo $i ?></a></li>
                                <?php
                                }
                                else {
                                ?>
                                <li value="<?php echo $i ?>" id="btnPaginadorAds" class="btnPaginador">
                                <a><?php echo $i ?></a></li>
                                <?php	
							}
						}
                            ?>
						<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorAds" 
                            class="btnPaginador arrow ultimo"><a>&raquo;</a>
						</li>
					</ul>
                   	<!-- fin de la paginacion-->
                </div>
            </div>
        </div>
		<!-- fin de la tabla de campañas--->
		
		<!--div del formulario-->
        <div id="ViewFormAds" class="viewForm">
        
        	<div class="row collapse contentForm">
				<!--Primera columna--->
            	<div class="small-12 medium-6 large-6 columns">
                	
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelMensaje"><strong>*Mensaje</strong>
								<input type="text" id="txtMensaje" class="radius"/>
							</label>
							<small id="alertMensaje" class="error" style="display:none">
								Campo vacio. Por favor escriba el mensaje
							</small>
						</div>
					</div>
							
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelPartner"><strong>*Comercio</strong>
								<input type="text" id="txtPartner" list="partnerList" autocomplete="on" class="radius"> 
								<datalist id="partnerList"> </datalist>
							</label>
							<small id="alertPartner" class="error" style="display:none">
								Partner incorrecto. Por favor escriba un comercio existente
							</small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelBeacons"><strong>*Identificador de beacons</strong>
								<input type="number" id="txtBeacons" class="radius" min="0">
							</label>
							<small id="alertBeacons" class="error" style="display:none">
								Campo vacion. Por favor escriba un numero
							</small>
						</div>
					</div>
                            
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelType"><strong>*Tipo</strong>
								<select id="txtType">
									<option value="1">Mensaje de proximidad</option>
									<option value="2">Anuncio publicitario</option>
								</select>
							</label>
							<small id="alertType" class="error" style="display:none">
							</small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelDistMin"><strong>*Distancia Minima</strong>
								<input type="number" id="txtDistMin" class="radius" min="0">
							</label>
							<small id="alertDistMin" class="error" style="display:none">
								Campo vacion. Por favor escriba la distancia minima
							</small>
						</div>
					</div>
							
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelDistMax"><strong>*Distancia maxima</strong>
								<input type="number" id="txtDistMax" class="radius" min="0">
							</label>
							<small id="alertDistMax" class="error" style="display:none">
								Campo vacion. Por favor escriba la distancia maxima
							</small>
						</div>
					</div>
					
                </div>
				<!-- fin de la primera columna-->
				
				<!-- segunda columna -->
				<div class="small-12 medium-6 large-6 columns">
					
					<div class="row typeAd" style="display:none;" id="divImg">
						<div class="small-12 medium-8 large-8 columns" id="imagen">
							<label id="labelImage"><strong>*Imagen</strong> </label>
							<a><img style="height:150px;width:150px;" id="imgImagen" 
								src="http://placehold.it/150x150&text=[150x150]" class="imgImagen"/>
							</a>
							<input type="hidden" id="imagenName" value="" />
							<input style="display:none" type="file" id="fileImagen" style="color:#003" 
								name="archivos[]" multiple />
							<small id="alertImage" class="error" style="display:none"></small>
						</div>
					</div>
                            
					<br/><br/>
					
					<div class="row typeAd" style="display:none;">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblAddInfo" class="field"><strong>*Informacion</strong>
								<textarea id="txtAddInfo" class="radius"></textarea>
							</label>
							<small id="alertAddInfo" class="error" style="display:none">
								Campo vacio. Por favor escriba la informacion del anuncio
							</small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblLatitude" class="field"><strong>*Latitud</strong>
								<input type="text" id="txtLatitude" class="radius"/>
							</label>
							<small id="alertLatitude" class="error" style="display: none">
								Campo vacio. Escriba la latitud de la ubicación del comercio.
							</small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblLongitude" class="field"><strong>*Longitud</strong>
								<input type="text" id="txtLongitude" class="radius" />
							</label>
							<small id="alertLongitude" class="error" style="display: none">
								Campo vacio. Escriba la longitud de la ubicacion del comercio
							</small>
						</div>
					</div>
					<br/>
					
					<div class="row">
						<div class="small-8 medium-9 large-6 columns">
							<button id="btnCancel" class="bntSave button small alert radius ">Cancelar</button>
							<button id="btnSaveAds" class="bntSave button small success radius ">Guardar</button>
							<button id="btnRegisterAds" class="bntSave button small success radius ">
							Guardar</button>
						</div>
						<div class="loading small-2 medium-2 large-2 columns" id="load1"></div>
					</div>
					<div id="cargados"></div>
					
				</div>
				<!-- fin de la segundo columna-->
				
         	</div>
		</div>
		<!-- fin de la div formulario--->
		
    </div>
	<!----fin content--->