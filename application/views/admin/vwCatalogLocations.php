
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Catalogo de locaciones
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaPlace" class="viewTable CatalogLocations">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-8 medium-8 large-8 columns">
                	<input type="search" class="txtSearch" id="txtSearchPlace" placeholder="Busqueda por nombre, ciudad o clave" />
                </div>
                <div class="small-4 medium-2 large-2 columns">
                	<button class="btnSearch secondary" id="btnSearchPlace"><img src="assets/img/web/iconSearch.png">Buscar</button>
                </div>
                <div class="small-12 medium-2 large-2 columns">
                	<button id="btnAddPlace" class="btnAdd btnShowForm">Agregar</button>
                </div>
            </div>
            <!--div alert-->
            <div class="row collapse">
            	<div class="large-12 columns divAlertWarning" id="divMenssagePlace" style="display:none">
					<div data-alert class="alert-box success" id="alertMessagePlace">
					</div>
				</div>
            	<div class="large-12 columns divAlertWarning" id="divMenssagewarningPlace" style="display:none; float:left;">
					<div data-alert class="alert-box warning" id="alertMessagewarningPlace">
						¿desea eliminar el lugar?
						<button id="btnCancelC" class="btnCancelP">Cancelar</button>
						<button id="btnCancelC" class="btnAcceptP">Aceptar</button>           
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tablePlace" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="4" class="titleTabla">
                                	lista de Lugares
                                </td>
                           	</tr>
    						<tr>
                            	<th>#</th>
								<th>Nombre</th>
								<th>dirección</th>
								<th>Eliminar</th>
    						</tr>
  						</thead>
                        <tbody>
							<?php 
								$con = 0;
								foreach ($place as $item):
									$con++;
									?>                                       
									<tr>
										<td><?php echo $con; ?></td>
                                        <td>
											<a id="showPlace"><?php echo $item->name;?>
											<input type="hidden" id="idplace" value="<?php echo $item->id;?>" >
											</a>
										</td>
										<td><?php echo $item->address;?></td>
										<td>
											<a id="imageDelete" value="<?php echo $item->id;?>">
												<img class="imgDelete" src="assets/img/web/delete.png"/>
											</a>
										</td>
									</tr>
							<?php endforeach;
								$totalPaginador = intval($totalP/10);
								if($totalP%10 == 0){
									$totalPaginador = $totalPaginador - 1;		
								}
							?>
						</tbody>
                    </table>
                    <!--- muestra la paginacion --->
                    <ul class="pagination">
  						<li id="btnPaginadorPlace" value="0" class="btnPaginador arrow primero unavailable">
							<a>&laquo;</a></li>
                            <?php 
							for($i = 1;$i<=($totalPaginador+1);$i++){
								if($i == 1){
									?>
                                    <li value="<?php echo $i ?>" id="btnPaginadorPlace" class="btnPaginador current">
                                    <a><?php echo $i ?></a></li>
                                    <?php
									}
									else {
									?>
                                    <li value="<?php echo $i ?>" id="btnPaginadorPlace" class="btnPaginador">
                                    <a><?php echo $i ?></a></li>
                                    <?php	
								}
							}
							?>
  						<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorPlace" 
                                class="btnPaginador arrow ultimo"><a>&raquo;</a></li>
					</ul>
                   	<!-- fin de la paginacion-->
                </div>
            </div>
        </div>
		<!-- fin de la tabla de campañas--->
		
		<!--div del formulario-->
        <div id="ViewFormPlace" class="viewForm">
        
        	<div class="row collapse contentForm">
				<!--Primera columna--->
            	<div class="small-12 medium-6 large-6 columns">
                	
					<!--input nombre  del lugar-->
					<div class="row">
                        <div class="small-12 medium-11 large-10 columns">
                            <label class="field" id="lblPlaceName">*Nombre
                                <input type="text" id="txtPlaceName" class="radius"/>
							</label>
							<small id="alertName" class="error" style="display:none">
								Campo vacio. Por favor escriba el nombre del lugar
							</small>
						</div>
					</div>
                        	
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label class="field" id="lblPlaceAddress">*Direccion
                                <input type="text" id="txtPlaceAddress" class="radius"/>
							</label>
                            <small id="alertAddress" class="error" style="display:none">
                                Campo vacio. Por favor escriba la dirrecion del lugar
                            </small>
						</div>
					</div>
                            
                    <div class="row">
                        <div class="small-12 medium-11 large-10 columns">
                            <label class="field" id="lblPlaceLatitude">*latitud
                                <input type="text" id="txtPlaceLatitude" class="radius"/>
							</label>
                            <small id="alertLatitude" class="error" style="display:none">
                                Campo vacio. Por favor escriba la latitud del lugar
							</small>
						</div>
					</div>
                            
					<div class="row">
                        <div class="small-12 medium-11 large-10 columns">
                            <label class="field" id="lblPlaceLongitude">*longitud
                                <input type="text" id="txtPlaceLongitude" class="radius"/>
							</label>
							<small id="alertLongitude" class="error" style="display:none">
								Campo vacio. Por favor escriba la longitud del lugar
							</small>
						</div>
					</div>
					
                </div>
				<!-- fin de la primera columna-->
				
				<!-- segunda columna -->
				<div class="small-12 medium-6 large-6 columns">
					
					<div class="row">
						<div class="small-12 medium-11 large-10 columns" id="imagen">
							<label id="lblPlaceImage" class="field">Imagen</label>
							<a><img id="imgImagenPlace" src="http://placehold.it/100x100&text=[100x100]"/ 
								style="height:100px; width:100px;" class="imgImagen"></a>
                            <input type="hidden" id="imagenNamePlace" value="0" />
                            <input style="display:none" type="file" id="fileImagenPlace" style="color:#003" name="archivos[]" multiple />
                            <small id="alertImagePlace" class="error small-9 medium-11 large-10 columns" style="display:none"></small>
						</div>
					</div>
                    
					<br/><br/>
                            
					<div class="row">
						<div class="small-8 medium-9 large-6 columns">
                            <button id="btnCancelFormPlace" class="bntSave button small alert radius ">Cancelar</button>
      						<button id="btnSavePlace" class="bntSave button small success radius ">
								Guardar</button>
      						<button  id="btnRegisterPlace" class="bntSave button small success radius ">
      							Guardar</button>
						</div>
						<div class="loading small-2 medium-2 large-2 columns" id="load1"></div>
					</div>
					
				</div>
				<!-- fin de la segundo columna-->
				
         	</div>
		</div>
		<!-- fin de la div formulario--->
		
		<!--------------------------------------------------------------------------->
		<!--------------------------------------------------------------------------->
		
    </div>
	<!----fin content--->