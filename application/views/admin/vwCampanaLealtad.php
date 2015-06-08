
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Campañas de Lealtad
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaCampanas" class="viewTable catalogCampana">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-8 medium-8 large-8 columns">
                	<input type="search" class="txtSearch" id="txtSearchCampana" placeholder="Busqueda de campañas" />
                </div>
                <div class="small-4 medium-2 large-2 columns">
                	<button class="btnSearch secondary" id="btnSearchCampana"><img src="assets/img/web/iconSearch.png">Buscar</button>
                </div>
                <div class="small-12 medium-2 large-2 columns">
                	<button id="btnAddCampana" class="btnAdd btnShowForm">Agregar</button>
                </div>
            </div>
            <!--div alert-->
            <div class="row collapse">
            	<div class="large-12 columns divAlertWarning" id="divMenssage" style="display:none">
					<div data-alert class="alert-box success" id="alertMessage">
					</div>
				</div>
            	<div class="large-12 columns divAlertWarning" id="divMenssagewarningCampana" style="display:none; float:left;">
					<div data-alert class="alert-box warning" id="alertMessagewarningCampana">
						¿desea eliminar la campaña?
						<button class ="btnCancelC" id="btnCancelDeleteC">cancelar</button>
						<button class="btnAcceptC" id="btnAcceptDeleteC">aceptar</button>            
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tableCampanaLealtad">
                    	<thead>
                        	<tr>
                            	<td colspan="6" class="titleTabla">
                                	lista de Campañas
                                </td>
                           	</tr>
    						<tr>
                            	<th width="50">#</th>
      							<th width="400">Campaña</th>
      							<th width="150"># Recompensa</th>
      							<th width="250">Comercio</th>
      							<th width="50">Publicado</th>
                                <th width="50">Eliminar</th>
    						</tr>
  						</thead>
                        <tbody>
                        	<?php
							$numTotal = 1;
							foreach ($campana as $item):
							?>
                            	<tr>
                                	<td><?php echo $numTotal; ?></td>
                                    <td>
                                    	<a  class="showCampana" value="<?php echo $item->id;?>">
											<?php echo $item->nombre;?>
                                            <!--<input type="hidden" id="idCampana" value="<?php echo $item->id;?>" >-->
                                        </a>
                                    </td>
                                    <td><?php echo $item->recompensa; ?></td>
                                    <td><?php echo $item->partnerName; ?></td>
                                    <td><?php if($item->status == 1){echo 'SI';}else{echo "NO";} ?></td>
                                    <td><a id="imageDelete" value="<?php echo $item->id;?>"><img id="imgDelete" src="assets/img/web/delete.png"/></a></td>
                                </tr>
							<?php	
							$numTotal++;
							endforeach;
							$totalPaginador = intval($totalC/10);
							if($totalC%10 == 0){
								$totalPaginador = $totalPaginador - 1;		
							}
							?>
                        </tbody>
                    </table>
                    <!--- muestra la paginacion --->
                    <ul class="pagination">
                    	<li id="btnPaginadorCampana" value="0" class="btnPaginador arrow primero unavailable">
							<a>&laquo;</a>
						</li>
						<?php 
						for($i = 1;$i<=($totalPaginador+1);$i++){
							if($i == 1){
							?>
								<li value="<?php echo $i ?>" id="btnPaginadorCampana" class="btnPaginador current">
									<a><?php echo $i ?></a>
                                </li>
								<?php
							}
							else {
							?>
								<li value="<?php echo $i ?>" id="btnPaginadorCampana" class="btnPaginador">
									<a><?php echo $i ?></a>
                              	</li>
								<?php	
							}
						}
							?>
						<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorCampana" 
							class="btnPaginador arrow ultimo"><a>&raquo;</a></li>
					</ul>
                   	<!-- fin de la paginacion-->
                </div>
            </div>
        </div>
		<!-- fin de la tabla de campañas--->
		
		<!--div del formulario-->
        <div id="ViewFormCampanas" class="viewForm">
        
        	<div class="row collapse contentForm">
            <!--Primera columna--->
            	<div class="small-12 medium-6 large-6 columns">
                	<!--input nombre campana-->
                	<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelNameCampana"><strong>*Nombre</strong>
								<input type="text" id="txtNameCampana" class="radius"/>
							</label>
							<small id="alertNameCampana" class="error" style="display:none">
								Campo vacio. Por favor escriba el nombre de la campaña
							</small>
						</div>
					</div>
                    <!-- input partner--->
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelPartnerCampana"><strong>*Comercio</strong>
								<input type="text" id="txtPartnerCampana" list="partnerListCampana" autocomplete="on" class="radius"> 
								<datalist id="partnerListCampana"> </datalist>
							</label>
							<small id="alertPartnerCampana" class="error" style="display:none">
								Partner incorrecto. Por favor escriba un comercio existente
							</small>
						</div>
					</div>
					<!-- input Descripcion--->
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelDescriptionCampana"><strong>*Descripción</strong>
								<textarea id="txtDescriptionCampana" class="radius" rows="5"></textarea>
							</label>
							<small id="alertDescriptionCampana" class="error" style="display:none">
								Campo vacion. Por favor escriba la descripción de la campaña.
							</small>
						</div>
					</div>
					
                </div>
				<!-- fin de la primera columna-->
				
				<!-- segunda columna -->
				<div class="small-12 medium-6 large-6 columns">
					<!-- input Descripcion--->
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelPublishedReward"><strong>*Publicado</strong></label>
							<div class="onoffswitch" style="margin-bottom:15px;">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox statusCampana" id="chechPublishedCampana" checked>
								<label class="onoffswitch-label" for="chechPublishedCampana">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					
				</div>
				<!-- fin de la segundo columna-->
                <!---alert---->
               	<div class="row collapse">
                <div class="small-12 medium-12 large-12 columns" style="height:1px;">&nbsp;</div>
            		<div class="small-12 medium-12 large-12 columns divAlertWarning" id="divMenssageReward" style="margin-bottom:25px; display:none;">
						<div data-alert class="alert-box success" id="alertMessageReward">
						</div>
					</div>
            		<div class="small-12 medium-12 large-12 columns divAlertWarning" id="divMenssagewarningReward" style="display:none; float:left; margin-bottom:25px;">
						<div data-alert class="alert-box warning" id="alertMessagewarningReward">
							¿desea eliminar la campaña?
							<button class ="btnCancelC" id="btnCancelDeleteR">cancelar</button>
							<button class="btnAcceptC" id="btnAcceptDeleteR">aceptar</button>            
						</div>
					</div>
            	</div>
            	<!------------------------<
				
				<!-- Columna de la tabla de recompensa -->
				<div class="small-12 medium-12 large-12 columns" id="tableRecompensa">
					<div class="row">
						<table id="tableRecompensa" width="100%">
                        	<thead>
                        		<tr>
                            		<td colspan="6" class="titleTabla">
                            			Recompensas
                                        <button id="btnAddReward" class="btnAdd btnReward">Agregar</button>
                            		</td>
                            	</tr>
                            	<tr>
                            		<td>#</td>
                                	<td>Nombre</td>
                                	<td>Cantidad Requerida</td>
                                	<td>Vigencia</td>
                                	<td>Estatus</td>
                                	<td>Eliminar</td>
                            	</tr>
                            </thead>
                            <tbody>
                            	
                            </tbody>
                        </table>
					</div>
				</div>
				<!-- fin de la columna tabla -->
                
                <!-- botones-->
                <div class="small-12 medium-12 large-12 columns">
                	<div class="btnForm">	
                    	<button id="btnCancelCampana" class="bntSave button small alert radius ">Cancelar</button>
						<button id="btnSaveCampana" class="bntSave button small success radius ">Guardar</button>
						<button id="btnRegisterCampana" class="bntSave button small success radius ">Guardar</button>
                        <div class="loading small-3 medium-2 large-2 columns" id="load1" style="float:right; display:none;">				 
                        </div>
					</div>
                </div>
                <!---- fin botones--->
				
         	</div>
		</div>
		<!-- fin de la div formulario--->
		
		<!--------------------------------------------------------------------------->
		<!--------------------------------------------------------------------------->
		<!--------------------------------------------------------------------------->
		
		<!-----div de recompensa-------->
		<div id="ViewFormRecompensa" class="viewForm">
        
			<div class="row collapse contentForm">
            
            	<div class="large-12 columns divAlertWarning" id="divMenssagewarningShiftStatus" style="display:none; float:left; margin-bottom:0px;">
					<div data-alert class="alert-box warning" id="alertMessagewarningShiftStatus" style="min-height:45px;">
						<div id="textMensageShiftStatus" style="float:left;">¿Deseas cambiar el estatus de la recompensa?</div>
						<button class ="btnCancelC" id="btnCancelShiftStatus">cancelar</button>
						<button class="btnAcceptC" id="btnAcceptShiftStatus">aceptar</button>            
					</div>
				</div>
                
                <div class="small-12 medium-12 large-12 columns">&nbsp;</div>
            
            	<!--cambio de status--->
            	<div class="small-12 medium-12 large-12 columns">
                	<div class="row" id="BarStatusReward">
                    	<div class="small-12 medium-10 large-12 columns" id="statusReward">
                        	<div id="leftStatus">
                            	<img src="assets/img/web/arrowBackS.png" height="50px" width="40px"/>
                            	
                            </div>
                        	<div id="tittleStatus">
                            	Recompensa
                            </div>
                            <div id="rightStatus">
                            	
                                <img src="assets/img/web/arrowNextS.png" height="50px" width="40px"/>
                            </div>
                        	<!--<img src="assets/img/web/arrowNextS.png" height="50px" width="50px"/>-->
                        </div>
                    </div>
                </div>
                <!-- fin --->
            
				<!--Primera columna--->
            	<div class="small-12 medium-6 large-6 columns">
					<!--input nombre recompensa-->
                	<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label class="labelRewardCampana" id="labelNameReward"><strong>*Nombre</strong>
								<input type="text" id="txtNameReward" class="radius"/>
							</label>
							<small id="alertNameReward" class="error alertRewardCamapana" style="display:none">
								Campo vacio. Por favor escriba el nombre de la recompensa
							</small>
						</div>
					</div>
                    <!--input fecha inicio recompensa-->
                	<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label class="labelRewardCampana" id="labelIniDateReward"><strong>*Fecha de inicio</strong>
								<input type="date" id="txtIniDateReward" class="radius"/>
							</label>
							<small id="alertIniDateReward" class="error alertRewardCamapana" style="display:none">
								Campo vacio. Por favor escriba la fecha de inicio
							</small>
						</div>
					</div>
                    
                    <!------------------>
				</div>
                <!--fin primera columna--->
				
				<!--segunda columna--->
                
            	<div class="small-12 medium-6 large-6 columns">
					<!--input nombre recompensa-->
                	<div class="row" id="toggleStatusReward" style="display:none;">
						<div class="small-12 medium-10 large-10 columns">
							<label class="labelRewardCampana" id="labelPublishedReward"><strong>*status</strong></label>
							<div class="onoffswitch" style="margin-bottom:15px;">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox statusReward" id="checkPublishedReward" checked value="">
								<label class="onoffswitch-label" for="checkPublishedReward">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
                    <!--input fecha inicio recompensa-->
                	<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label class="labelRewardCampana" id="labelEndDateReward"><strong>*Fecha de terminacion</strong>
								<input type="date" id="txtEndDateReward" class="radius"/>
							</label>
							<small id="alertEndDateReward" class="error alertRewardCamapana" style="display:none">
								Campo vacio. Por favor escriba la fecha de terminacion
							</small>
						</div>
					</div>
                    <!------------------>
				</div>
                <!--fin segunda columna--->
				
				<!-- recompensa a otorgar---->
				<div class="small-12 medium-12 large-12 columns" id="divGrantReward">
                	<div class="row headerSubReward">
                    	RECOMPENSA A OTORGAR
                    </div>
					
					<div class="row" style="margin-top:20px;">
						<!--vigencia-->
						<div class="small-12 medium-12 large-12 columns">
							<div class="small-12 medium-10 large-4 columns">
								<a class="button btnGrantreward" id="btnAddGrantReward">
									<img class="imgBtnIconGR" src="assets/img/web/add.png" />
									Añadir recompensa
								</a>
							</div>
							<div class="small-12 medium-10 large-4 columns">
								<a class="button btnGrantreward" id="btnSearchGrantReward">
									<img class="imgBtnIconGR" src="assets/img/web/search.png" />
									Buscar recompensa
								</a>
							</div>
							<div class="small-12 medium-10 large-6 columns">
								&nbsp;
							</div>
                            
						</div>
						<!------------------------>
					</div>
				</div>
				<!-- fin recompensa a otorgar---->
				
				<!--- tabla requerimiento----->
				<div class="small-12 medium-12 large-12 columns" id="divGrantTable">
					<div class="row">
						<table id="tableGrantReward" width="100%">
                        	<thead>
                        		<tr>
                            		<td colspan="4" class="titleTabla">
                            			Recopensas añadidos
                            		</td>
                            	</tr>
                            	<tr>
                            		<td width="100">#</td>
                                	<td>Nombre</td>
                                	<td width="100">eliminar</td>
                            	</tr>
                            </thead>
                            <tbody>
                            	
                            </tbody>
                        </table>
					</div>
                    <small id="alertTableGrantReward" class="error alertRewardCamapana" style="display:none;"></small>
				</div>
				<!----fin tabla requerimiento--->
				<!-------------------------------------------------------------------------->
				
				<!-----requerimientos recompensa---->
				<div class="small-12 medium-12 large-12 columns" id="divRequest">
                	<div class="row headerSubReward">
                    	REQUERIMIENTOS
                    </div>
					
					<div class="row" style="margin-top:20px;">
						<!--vigencia-->
						<div class="small-12 medium-12 large-12 columns">
							<label class="labelRewardCampana" id="labelValidityReward" style="margin-bottom:10px; margin-left:15px;"><strong>Vigencia</strong></label>
							<div class="small-12 medium-10 large-2 columns">
								<input type="number" id="txtAmountValidityReward" min="1" class="radius" placeholder="Cantidad"/>
							</div>
							<div class="small-12 medium-10 large-3 columns">
                            	<select class="radius" id="sctTypeValidityReward">
									<option value="" disabled selected>Tipo de vigencia</option>
                                    <option value="1">Dias</option>
                                    <option value="2">Semanas</option>
                                    <option value="3">Mes</option>
                                    <option value="4">Años</option>
								</select>
							</div>
							<div class="small-12 medium-10 large-7 columns">
								&nbsp;
							</div>
                            <div class="small-12 medium-10 large-12 columns alertRewardCamapana" id="divAlertValidityReward" style="display:none;">
								<small id="alertValidityReward" class="error"></small>
							</div>
						</div>
						
						<!-- requerimientos-->
						
						<div class="small-12 medium-12 large-12 columns">
							<label id="labelRequestReward" style="margin-bottom:10px; margin-left:15px;"><strong>Añadir Requerimientos</strong></label>
							<div class="small-12 medium-10 large-4 columns">
								<input type="text" id="txtNameRequestReward" class="radius" placeholder="Nombre"/>
							</div>
							<div class="small-12 medium-10 large-2 columns">
								<input type="number" id="txtAmountRequestReward" class="radius" placeholder="Cantidad"/>
							</div>
							<div class="small-12 medium-10 large-3 columns">
                            	<select class="radius" id="sctTypeRuleRedward">
									<option value="" disabled selected>Tipo de Regla</option>
                                    <option value="1">Visitas</option>
                                    <option value="2">Canjes</option>
                                    <option value="3">Descargas</option>
								</select>
							</div>
							<div class="small-12 medium-10 large-1 columns">
								<img id="imgAddRuleRedward" class="imgAddReward" src="assets/img/web/add.png" />
							</div>
							<div class="small-12 medium-10 large-1 columns">
								&nbsp;
							</div>
                            <div class="small-12 medium-10 large-12 columns" id="divAlertRequestReward" style="display:none;">
								<small id="alertRequestReward" class="error"></small>
							</div>
                            
						</div>
						
						<!------------------------>
						
					</div>
				</div>
				<!-- fin requerimientos recompensa---->
				
				<!--- tabla requerimiento----->
				<div class="small-12 medium-12 large-12 columns" id="divRequestTable">
					<div class="row">
						<table id="tableRequestReward" width="100%">
                        	<thead>
                        		<tr>
                            		<td colspan="4" class="titleTabla">
                            			Requerimientos añadidos
                            		</td>
                            	</tr>
                            	<tr>
                            		<td>#</td>
                                	<td>Nombre</td>
                                	<td>Cantidad Requerida</td>
                                	<td>eliminar</td>
                            	</tr>
                            </thead>
                            <tbody>
                            	
                            </tbody>
                        </table>
					</div>
                    <small id="alertTableResquedReward" class="error alertRewardCamapana" style="display:none;"></small>
				</div>
				<!----fin tabla requerimiento--->
				
				<!-----nivel de usuario---->
				<div class="small-12 medium-12 large-12 columns" id="divUserLevel">
                	<div class="row headerSubReward">
                    	NIVEL DE USUARIO
                    </div>
					
					<div class="row" style="margin-top:20px;">
						<!--vigencia-->
						<div class="small-12 medium-12 large-12 columns">
							<label id="labelUserLevelReward" style="margin-bottom:10px; margin-left:15px;"><strong>Niveles de usuario a agregar</strong></label>
							<div class="small-12 medium-10 large-4 columns">
								<input id="checkUserLevel" type="checkbox"><label for="checkUserLevel">Restringir por nivel de usuario</label>
							</div>
							<div class="small-12 medium-10 large-3 columns groupUserLevel">
                            	<select class="radius" id="sctTypeTypeUserReward">
									<option value="" disabled selected>Tipo de usuario</option>
                                    <option value="1">Normal</option>
                                    <option value="2">V.I.P</option>
								</select>
							</div>
							<div class="small-12 medium-10 large-1 columns groupUserLevel">
								<img id="imgAddTypeUserRedward" class="imgAddReward" src="assets/img/web/add.png" />
							</div>
							<div class="small-12 medium-10 large-4 columns">
								&nbsp;
							</div>
                            <div class="small-12 medium-12 large-12 columns" id="divAlertUserLevelReward" style="display:none;">
								<small id="alertUserLevelReward" class="error"></small>
							</div>
						</div>
						<!------------------------>
					</div>
				</div>
				<!-- fin nivel usuario---->
				
				<!--- tabla nivel de usuario----->
				<div class="small-12 medium-12 large-12 columns groupUserLevel" id="divUserLevelTable">
					<div class="row">
						<table id="tableUserLevel" width="100%">
                        	<thead>
                        		<tr>
                            		<td colspan="4" class="titleTabla">
                            			Usuarios añadidos
                            		</td>
                            	</tr>
                            	<tr>
                            		<td>#</td>
                                	<td>Tipo de usuario</td>
                                	<td>eliminar</td>
                            	</tr>
                            </thead>
                            <tbody>
                            	
                            </tbody>
                        </table>
					</div>
                    <small id="alertTableUserLevelReward" class="error alertRewardCamapana" style="display:none;"></small>
				</div>
				<!----fin tabla nivel de usuario--->
                
                <!--- botones ----->
                
                <div class="small-12 medium-12 large-12 columns">
                	<div class="btnForm">	
                    	<button id="btnCancelRewardCampana" class="bntSave button small alert radius ">Cancelar</button>
						<button id="btnSaveRewardCampana" class="bntSave button small success radius ">Guardar</button>
						<button id="btnRegisterRewardCampana" class="bntSave button small success radius ">Guardar</button>
                        <div class="loading small-3 medium-2 large-2 columns" id="loadRC" style="float:right; display:none;">				 
                        </div>
					</div>
                </div>
                
                <!---fin de los botones--->
				
			</div>
		</div>
        <!---fin de div recompensa--------------------->
		
						
		<!-------------form deals---------------->
				
					<div id="dialog-form" title="Crear nuevo deals">
						<?php $this->load->view('admin/vwCatalogDeals'); ?>	
					</div>
                    <div id="dialog-table" title="Deals del comercio">
                    	<table id="tableCouponReward" width="100%">
							<!--- encabezado de la tabla --->
							<thead>
								<tr>
									<td id="titulo" colspan="3">lista de Cupones
									</td>
								</tr>
								<tr>
									<th width="100">#</th>
									<th>Descripcion</th>
                                    <th width="150">Agregar</th>
								</tr>
							</thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                        <div id="tablePagi">
                        	
                        </div>
                        
                    </div>
				
				<!--------------------------------------------->
		
		<!--------------------------------------------------------------------------->
		<!--------------------------------------------------------------------------->
		
    </div>
	<!----fin content--->