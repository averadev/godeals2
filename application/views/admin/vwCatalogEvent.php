
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Catalogo de eventos
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaEvent" class="viewTable CatalogEvent">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-8 medium-8 large-8 columns">
                	<input type="search" class="txtSearch" id="txtSearchEvent" placeholder="Busqueda de eventos" />
                </div>
                <div class="small-4 medium-2 large-2 columns">
                	<button class="btnSearch secondary" id="btnSearchEvent"><img src="assets/img/web/iconSearch.png">Buscar</button>
                </div>
                <div class="small-12 medium-2 large-2 columns">
                	<button id="btnAddEvent" class="btnAdd btnShowForm">Agregar</button>
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
						¿desea eliminar el evento?
						<button id="btnCancelC" class="btnCancelE">Cancelar</button>
						<button id="btnCancelC" class="btnAcceptE">Aceptar</button>           
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tableEvents" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="5" class="titleTabla">
                                	lista de Eventos
                                </td>
                           	</tr>
    						<tr>
                            	<th>#</th>
      							<th>Nombre</th>
      							<th >Lugar</th>
      							<th >Fecha&nbsp;&nbsp;&nbsp;&nbsp;
                                        	<a class="arrowUp" id="iniDate" value="event">
                                        	<img src="assets/img/web/arrowGreen2.png"></a>
                                        	<a class="arrowDown" id="iniDate" value="event">
                                        	<img src="assets/img/web/arrowGreen.png"></a>
                                </th>
                                <th>Eliminar</th>
    						</tr>
  						</thead>
                        <tbody>
							<?php 
								$con = 0;
								foreach ($event as $item):
									$con++;
									?>                                       
									<tr>
										<td><?php echo $con;?></td>
										<td>
											<a  id="showEvent"><?php echo $item->name;?><input type="hidden" id="idEvento" value="<?php echo $item->id;?>" ></a>
										</td>
										<td><?php echo $item->place;?></td>
										<!--<td><?php echo $item->city;?></td>-->
										<td><?php echo $item->iniDate;?></td>
										<td><a id="imageDelete" value="<?php echo $item->id;?>"><img class="imgDelete" src="assets/img/web/delete.png"/></a></td>
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
  						<li id="btnPaginadorEvent" value="0" class="btnPaginador arrow primero unavailable"><a>&laquo;</a></li>
						<?php 
						for($i = 1;$i<=($totalPaginador+1);$i++){
							if($i == 1){
							?>
								<li value="<?php echo $i ?>" id="btnPaginadorEvent" class="btnPaginador current"><a><?php echo $i ?></a></li>
                                <?php
							}
							else {
								?>
								<li value="<?php echo $i ?>" id="btnPaginadorEvent" class="btnPaginador"><a><?php echo $i ?></a></li>
								<?php	
							}
						}
						?>
  						<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorEvent" class="btnPaginador arrow ultimo"><a>&raquo;</a></li>
					</ul>
                   	<!-- fin de la paginacion-->
                </div>
            </div>
        </div>
		<!-- fin de la tabla de campañas--->
		
		<!--div del formulario-->
        <div id="ViewFormEvent" class="viewForm">
        
        	<div class="row collapse contentForm">
				<!--Primera columna--->
            	<div class="small-12 medium-6 large-6 columns">
                	<!--input nombre campana-->
                	<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label class="field" id="lblEventName">*Nombre
								<input type="text" id="txtEventName" class="radius"/>
							</label>
							<small id="alertName" class="error" style="display:none">
								Campo vacio. Por favor escriba un nombre
							</small>
						</div>
					</div>
                    <!-- input partner--->
					<div class="row">
    					<div class="large-6 columns">
      						<label>Selecione el lugar del evento</label>
      							<input type="radio" name="RadioPlace" value="partner" id="radioPartner" checked="true" />
							<label for="partner">Partner</label>
      							<input type="radio" name="RadioPlace" value="place" id="radioPlace" />
							<label for="place">Place</label>
    					</div>
                    </div>
                                
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblEventPlace" class="field">*Lugar
								<input type="text" id="txtEventPlace" list="placeList" autocomplete="on" class="radius" />
                                <datalist id="placeList"> </datalist>
							</label>
							<small id="alertPlace" class="error" style="display:none">
								Campo Vacio. Escriba el lugar del evento
							</small>
						</div>
					</div>
								
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblEventCity" class="field">*Ciudad
								<input type="text" id="txtEventCity" list="cityList" autocomplete="on" class="radius" />
                                <datalist id="cityList"> </datalist>
							</label>
							<small id="alertCity" class="error" style="display:none">
								Campo Vacio. Escriba la ciudad del evento
							</small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label class="field" id="lblEventDetail">*Descripcion
								<textarea type="text" id="txtEventDetail" class="radius" rows="5"></textarea>
							</label>
							<small id="alertDetail" class="error" style="display:none">
								Campo vacio. Por favor escriba la descripcion del evento
							</small>
						</div>
					</div>
								
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblEventDate" class="field">*Fecha Inicio
								<input type="date" id="dtEventDate" class="radius" />
							</label>
							<small id="alertEventDate" class="error" style="display:none"></small>     
						</div>
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblEventEndDate" class="field">fecha final
								<input type="date" id="dtEventEndDate" class="radius"></textarea>
							</label>
							<small id="alertEndDate" class="error" style="display:none"></small>
						</div>
						<div class="medium-2 columns">&nbsp;</div>
					</div>
								
					<div class="row">
						<div class="small-12 medium-12 large-12 columns">
							<button  id="btnGaleria" class="bntSave button small success radius">Galeria</button>
						</div>
					</div>
					
                </div>
				<!-- fin de la primera columna-->
				
				<!-- segunda columna -->
				<div class="small-12 medium-6 large-6 columns">
				
					<div class="row">
						<div class="small-12 medium-5 large-5 columns" id="imagen">
							<label id="labelImage"><strong>*Image</strong> </label>
							<a><img id="imgImagen" src="http://placehold.it/100x100&text=[100x100]" 
                            style="height:100px; width:100px;" class="imgImagen" /></a>
							<input type="hidden" id="imagenName" value="0" />
							<input style="display:none" type="file" id="fileImagen" style="color:#003" 
								name="archivos[]" multiple />
							<small id="alertImage" class="error" style="display:none"></small>
						</div>
                                    
						<div class="small-12 medium-6 large-6 columns" id="imagen">
							<label id="labelImage"><strong>*Image Full HD</strong> </label>
							<a><img id="imgImagenF" src="http://placehold.it/220x300&text=[440x_]" 
                            style="width:220px;" class="imgImagen" /></a>
							<input type="hidden" id="imagenNameF" value="0" />
							<input style="display:none" type="file" id="fileImagenF" style="color:#003" 
								name="archivos[]" multiple />
							<small id="alertImageF" class="error" style="display:none"></small>
						</div>
                                    
                        <div class="small-12 medium-1 large-1 columns" id="imagen"></div>
                                    
					</div>
					
					</br>
					
					<div class="row">
						<label id="labelFilter"><strong>Filtros</strong> </label>
						<div class="medium-12 columns">
							<table id="tableFilter">
								<?php
								$i = 0;
								foreach ($filter as $item):
									if($i == 0){
									?><tr><?php
									}
									?>
										<td> 
											<input value="<?php echo $item->id ?>" type="checkbox" name="filter" /> <?php echo $item->name ?>
										</td>
									<?php 
									$i++;
									if($i == 2){
										?> </tr> <?php
										$i = 0;		
									}		
								endforeach; 
								?>
							</table>     
                            <small id="alertFilter" class="error" style="display:none">
								Selecione al menos una opcion.
                            </small>   
						</div>
					</div>
					
					<br/><br/>
                            
					<div class="row">
						<div class="small-8 medium-9 large-6 columns">
							<button id="btnCancel" class="bntSave button small alert radius ">Cancelar</button>
							<button id="btnSaveEvent" class="bntSave button small success radius ">Guardar</button>
							<button  id="btnRegisterEvent" class="bntSave button small success radius ">Guardar</button>
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