
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Catalogo de Comercios
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaPartner" class="viewTable CatalogPartner">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-8 medium-8 large-8 columns">
                	<input type="search" class="txtSearch" id="txtSearchPartner" placeholder="Busqueda por nombre del comercio, categoria" />
                </div>
                <div class="small-4 medium-2 large-2 columns">
                	<button class="btnSearch secondary" id="btnSearchPartner"><img src="assets/img/web/iconSearch.png">Buscar</button>
                </div>
                <div class="small-12 medium-2 large-2 columns">
                	<button id="btnAddPartner" class="btnAdd btnShowForm">Agregar</button>
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
						¿Desea eliminar el comercio?
						<button id="btnCancelC" class="btnCancelarE">Cancelar</button>
						<button id="btnAcceptC" class="btnAceptarE">Aceptar</button>           
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tablePartners" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="5" class="titleTabla">
                                	lista de comercios
                                </td>
                           	</tr>
    						<tr>
                            	<th>#</th>
                                <th width="300px">Nombre</th>
								<th width="200px">Telefono</th>
                                <th>Eliminar</th>
    						</tr>
  						</thead>
                        <tbody>
							<?php 
							$con = 0;
							foreach ($partner as $item):
                                $con++;
                                ?>
								<tr>
                                    <td><?php echo $con;?></td>
                                    <td>
										<a  class="showPartner"><?php echo $item->name;?><input type="hidden" id="idPartner" value="<?php echo $item->id;?>" ></a>
                                    </td>
									<td><?php echo $item->phone;?></td>
									<td><a class="imageDelete" value="<?php echo $item->id;?>"><img class="imgDelete" src="assets/img/web/delete.png"/></a></td>
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
						<li id="btnPaginadorPartner" value="0" class="btnPaginador arrow primero unavailable"><a>&laquo;</a></li>
                        <?php 
                        for($i = 1;$i<=($totalPaginador+1);$i++){
                            if($i == 1){
								?>
								<li value="<?php echo $i ?>" id="btnPaginadorPartner" class="btnPaginador current"><a><?php echo $i ?></a></li>
								<?php
							}else {
								?>
								<li value="<?php echo $i ?>" class="btnPaginador" id="btnPaginadorPartner"><a><?php echo $i ?></a></li>
								<?php	
							}
						}
						?>
						<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorPartner" class="btnPaginador arrow ultimo"><a>&raquo;</a></li>
					</ul>
                   	<!-- fin de la paginacion-->
                </div>
            </div>
        </div>
		<!-- fin de la tabla de campañas--->
		
		<!--div del formulario-->
        <div id="ViewFormPartner" class="viewForm">
        
        	<div class="row collapse contentForm">
				<!--Primera columna--->
            	<div class="small-12 medium-6 large-6 columns">
					<!--- input nombre del comercio ---->
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblPartnerName" class="field"><strong>*Nombre</strong>
								<input type="text" id="txtPartnerName" class="radius"/>
							</label>
							<small id="alertPartnerName" class="error" style="display:none">
								Campo vacio. Por favor escriba el nombre del comercio
							</small>
						</div>
					</div>
					
					<!--- input direccion del comercio ---->
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblPartnerAddress" class="field"><strong>*Direccion</strong>
								<textarea id="txtPartnerAddress" class="radius"></textarea>
							</label>
							<small id="alertPartnerAddress" class="error" style="display:none">
								Campo vacio. Por favor escriba la direccion del comercio
							</small>
						</div>
					</div>
					
					<!--- input telefono del comercio ---->
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblPartnerPhone" class="field"><strong>Telefono</strong>
								<input type="tel" id="txtPartnerPhone" class="radius" />
							</label>
							<small id="alertPartnerPhone" class="error" style="display: none">
								Campo vacio. Por favor escriba el telefono del comercio
							</small>
						</div>
					</div>
					
					
					<div class="row">
						<!--- input correo del comercio ---->
						<div class="small-12 medium-11 large-5 columns">
							<label id="lblPartnerMail" class="field"><strong>Correo</strong>
								<input type="email" id="txtPartnerMail" class="radius" placeholder="ejemplo@email.com" />
							</label>
							<small id="alertPartnerMail" class="error" style="display: none">
							</small>
						</div>
						<!--- input contraseña del comercio ---->
						<div class="small-12 medium-11 large-5 columns">
							<label id="lblPartnerPassword" class="field"><strong>Contraseña</strong>
								<input type="text" id="txtPartnerPassword" class="radius" />
							</label>
							<small id="alertPartnerPassword" class="error" style="display: none">
								Campo Vacio. Escriba una contraseña.
							</small>
						</div>
						<div class="small-12 medium-11 large-2 columns">&nbsp;</div>
					</div>
                            
					<div class="row">
						<!--- input twitter del comercio ---->
						<div class="small-12 medium-11 large-5 columns">
							<label id="lblPartnerTwitter" class="field"><strong>Twitter</strong>
								<input type="text" id="txtPartnerTwitter" class="radius" />
							</label>
							<small id="alertPartnerTwitter" class="error" style="display: none">
								Campo vacio. Por favor escriba la cuenta de Twitter del comercio
							</small>
						</div>
						<!--- input facebook del comercio ---->
						<div class="small-12 medium-11 large-5 columns">
							<label id="lblPartnerFacebook" class="field"><strong>Facebook</strong>
								<input type="text" id="txtPartnerFacebook" class="radius" />
							</label>
							<small id="alertPartnerFacebook" class="error" style="display: none">
								Campo vacio. Por favor escriba la cuenta de Facebook del comercio
							</small>
						</div>
						<div class="small-12 medium-11 large-2 columns">&nbsp;</div>
					</div>
					
					<!--- input informacion del comercio ---->
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblPartnerInfo" class="field"><strong>*Informacion</strong>
								<textarea id="txtPartnerInfo" class="radius"></textarea>
							</label>
							<small id="alertPartnerInfo" class="error" style="display:none">
								Campo vacio. Por favor escriba la informacion del comercio
							</small>
						</div>
					</div>
					
					<!--- input informacion del comercio ---->
					<!--<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblWelcomeIntro" class="field"><strong>*Mensaje de bienvenida</strong>
								<textarea id="txtWelcomeIntro" class="radius"></textarea>
							</label>
							<small id="alertWelcomeIntro" class="error" style="display:none">
								Campo vacio. Por favor escriba el mensaje de bienvenida
							</small>
						</div>
					</div>
                            
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblWelcomeFooter" class="field"><strong>*Mensaje de despedida</strong>
								<textarea id="txtWelcomeFooter" class="radius"></textarea>
							</label>
							<small id="alertWelcomeFooter" class="error" style="display:none">
								Campo vacio. Por favor escriba el mensaje de despedida
							</small>
						</div>
					</div>-->
                            
					<!--- boton galeria del comercio ---->
					<div class="row">
						<div class="small-12 medium-12 large-12 columns">
							<button  id="btnGaleria" class="bntSave button small success radius ">Galeria</button>
						</div>
					</div>
					
                </div>
				<!-- fin de la primera columna-->
				
				<!-- segunda columna -->
				<div class="small-12 medium-6 large-6 columns">
					
					<div class="row">
						<div class="small-12 medium-11 large-10 columns" id="imagen">
							<label id="lblPartnerImage" class="field"><strong>*Imagen</strong></label>
							<a><img id="imgImagen" style="width:140px;height:140px;border:solid 1px #a5a5a5;" src="http://placehold.it/140x140&text=[140x140]" class="imgImagen" /></a>
							<input type="hidden" id="imagenName" value="0" />
							<input type="file" style="display:none;" id="fileImagen" style="color:#003" name="archivos[]" multiple />
							<small id="alertImage" class="error" style="display:none"></small>
						</div>
					</div>
					<br/>
					
					<div class="row">
						<div class="small-12 medium-11 large-10 columns" id="banner">
							<label id="lblPartnerBanner" class="field"><strong>*Banner</strong></label>
								<a><img id="imgBanner" style="width:480px;height:165px;border:solid 1px #a5a5a5;" src="http://placehold.it/480x165&text=[480x165]" class="imgImagen" /></a>
								<input type="hidden" id="bannerName" value="0" />
								<input type="file" id="fileBanner" style="color:#003" name="archivos[]" multiple style="display:none;" />
								<small id="alertBanner" class="error" style="display:none"></small>
						</div>
					</div>
					<br/><br/>
					
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblPartnerLatitude" class="field"><strong>Latitud</strong>
								<input type="text" id="txtPartnerLatitude" class="radius"/>
							</label>
							<small id="alertPartnerLatitude" class="error" style="display: none">
								Campo vacio. Latitud de la ubicación del comercio.
							</small>
						</div>
					</div>
                           
					<div class="row">
						<div class="small-12 medium-11 large-10 columns">
							<label id="lblPartnerLongitude" class="field"><strong>Longitud</strong>
								<input type="text" id="txtPartnerLongitude" class="radius" />
							</label>
							<small id="alertPartnerLongitude" class="error" style="display: none">
								Campo vacio. Longitud de la ubicacion del comercio
							</small>
						</div>
					</div>
					<br/>
					
					<div class="row">
						<div class="small-7 medium-9 large-6 columns">
							<button id="btnCancel" class="bntSave button small alert radius ">
								Cancelar</button>
							<button id="btnSavePartner" class="bntSave button small success radius ">
								Guardar</button>
							<button id="btnRegisterPartner" class="bntSave button small success radius ">
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
		
		<!----- div Galeria-------->
		<div id="galleryPartner" class="viewForm">
        	<div class="row collapse contentForm">
				
				<!--- formulario de galeria --->
				<div class="row">
					<h3  class="text-center">Galeria</h3>
					<!-- primera columna -->
					<div class="small-12 medium-12 large-12 columns">
						<div class="small-12 medium-4 large-6 columns">
                            
							<div class="row">
                                <div class="small-12 medium-11 large-10 columns">
                                	<label id="lblImageGallery"><strong>*galeria</strong></label>
                                    <a><img id="imgImageGallery" src="http://placehold.it/480x165&text=[480x165]" style="width:480px; height:165px;" /></a>
                                    <input type="file" id="fileImageGallery" style="display:none;" />
                                    <small id="alertImageGallery" class="error" style="display:none"></small>
                                </div>
                            </div>
                            </br><br />
                            
                            <div class="row">
                                <div class="medium-10 columns">
                                <button id="btnAddGallery" class="button tiny success radius ">agregar</button>
                                </div>
                            </div>
                        </div>
                        <!-- fin primera columna -->    
                        
                        <!-- segunda columna -->
                    	<div class="small-12 medium-8 large-6 columns">
                            
                            <div class="row">
                            	<div id="gridImages" class="small-12 medium-12 large-12 columns">
                                </div>
                            </div>
                            <br/><br/>
                            
							<div class="row">
                                <div class="small-10 medium-6 large-6 columns">
                                    <button id="btnCancelGallery" class="button small alert radius bntSave">
                                    Regresar</button>
                                    <button id="btnSaveGallery" class="btnS2 button small success radius bntSave">
                                    Guardar</button>
                                </div>
                                <div class="loading small-2 medium-2 large-2 columns" id="load2">
                                </div>
                            </div>
                            
                        </div>   
                        
					</div>
					<!--- fin del formulario de galleria --->
				</div>
				
			</div>	
		</div>
		
		<!-------------------------->
		
		<!--------------------------------------------------------------------------->
		<!--------------------------------------------------------------------------->
		
    </div>
	<!----fin content--->