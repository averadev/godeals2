
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Catalogo de Promociones
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaPromo" class="viewTable CatalogPromo">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-8 medium-8 large-8 columns">
                	<input type="search" class="txtSearch" id="txtSearchPromo" placeholder="Busqueda de campañas" />
                </div>
                <div class="small-4 medium-2 large-2 columns">
                	<button class="btnSearch secondary" id="txtSearchPromo"><img src="assets/img/web/iconSearch.png">Buscar</button>
                </div>
                <div class="small-12 medium-2 large-2 columns">
                	<button id="btnAddCoupon" class="btnAdd btnShowForm">Agregar</button>
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
                        ¿desea eliminar la promocion?
                        <button class ="btnCancelC" id="btnCancelC">cancelar</button>
                        <button class="btnAcceptC" id="btnAcceptC">aceptar</button>
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tableCoupon" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="6" class="titleTabla">
                                	lista de promociones
                                </td>
                           	</tr>
    						<tr>
                            	<th>#</th>
								<th>Descripcion</th>
								<th>Cliente</th>
								<th>Total</th>
								<th>Redimido</th>
								<th>Eliminar</th>
    						</tr>
  						</thead>
                        <tbody>
                            <?php 
                            $con = 0;
                            foreach ($coupon as $item):
                            $con++;
                            ?>
                                <tr>
                                    <td><?php echo $con;?></td>
                                    <td>
                                    <a  id="showCoupon"><?php echo $item->name;?><input type="hidden" id="idCoupon" value="<?php echo $item->id;?>" ></a>
                                    </td>
                                    <td><?php echo $item->partnerName;?></td>
                                    <td><?php echo $item->total;?></td>
                                    <td><?php 
										if ($item->status == 2){
											echo "Si";
										}else{
											echo "No";	
										}
									?></td>
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
						<li id="btnPaginadorPromo" value="0" class=btnPaginador "arrow primero unavailable">
							<a>&laquo;</a>
						</li>
						<?php 
						for($i = 1;$i<=($totalPaginador+1);$i++){
							if($i == 1){
								?>
								<li value="<?php echo $i ?>" id="btnPaginadorPromo" class="btnPaginador current">
									<a><?php echo $i ?></a>
								</li>
                                <?php
							}
							else {
                                ?>
                                <li value="<?php echo $i ?>" id="btnPaginadorPromo" class="btnPaginador">
                                <a><?php echo $i ?></a></li>
                                <?php	
							}
						}
						?>
						<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorPromo" 
							class="btnPaginador arrow ultimo"><a>&raquo;</a>
						</li>
					</ul>
                   	<!-- fin de la paginacion-->
                </div>
            </div>
        </div>
		<!-- fin de la tabla de campañas--->
		
		<!--div del formulario-->
        <div id="ViewFormPromo" class="viewForm">
        
        	<div class="row collapse contentForm">
				<!--Primera columna--->
            	<div class="small-12 medium-6 large-6 columns">
					
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelName"><strong>*Nombre</strong>
								<input type="text" id="txtName" class="radius"/>
							</label>
							<small id="alertName" class="error" style="display:none">
								Campo vacio. Por favor escriba el nombre del coupon
							</small>
						</div>
					</div>
							
					<div class="row">
						<div class="small-12 medium-5 large-5 columns">
							<label id="labelPartner"><strong>*Comercio</strong>
								<input type="text" id="txtPartner" list="partnerList" autocomplete="on" class="radius"> 
								<datalist id="partnerList"> </datalist>
							</label>
							<small id="alertPartner" class="error" style="display:none">
								Partner incorrecto. Por favor escriba un comercio existente
							</small>
						</div>
							
						<div class="small-12 medium-5 large-5 columns">
							<label id="labelCity"><strong>*Ciudad</strong>
								<input type="text" id="txtCity" list="cityList" autocomplete="on" class="radius"> 
								<datalist id="cityList"> </datalist>
							</label>
							<small id="alertCity" class="error" style="display:none">
								Ciudad incorrecto. Por favor escriba una ciudad existente
							</small>
						</div>
								
						<div class="medium-2 columns">&nbsp;</div>
					</div>
					
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelValidity"><strong>*Valides</strong>
								<input type="text" id="txtValidity" class="radius" />
							</label>
							<small id="alertValidity" class="error" style="display:none">
								Campo vacion. Por favor escriba la valides del deals.
							</small>
						</div>
					</div>
                            
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelDetail"><strong>*Descripcion de la promocion</strong>
								<textarea id="txtDetail" class="radius" rows="5"></textarea>
							</label>
							<small id="alertDetail" class="error" style="display:none">
								Campo vacion. Por favor escriba la decripcion.
							</small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelClauses"><strong>*Clausulas</strong>
								<textarea id="txtClauses" class="radius" rows="5"></textarea>
							</label>
							<small id="alertClauses" class="error" style="display:none">
								Campo vacion. Por favor escriba las clausulas.
							</small>
						</div>
					</div>
							
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelUser"><strong>Usuario</strong>
								<input type="text" id="txtUser" list="userList" autocomplete="on" class="radius"> 
								<datalist id="userList"> </datalist>
							</label>
							<small id="alertUser" class="error" style="display:none">
								Usuario incorrecto. Por favor escriba un usuario existente
							</small>
						</div>
					</div>
					
                </div>
				<!-- fin de la primera columna-->
				
				<!-- segunda columna -->
				<div class="small-12 medium-6 large-6 columns">
					
					<div class="row">
						<div class="small-12 medium-8 large-8 columns" id="imagen">
							<label id="labelImage"><strong>*Imagen</strong> </label>
							<a><img style="height:128px;width:128px;" id="imgImagen" 
								src="http://placehold.it/140x140&text=[140x140]" class="imgImagen"/>	
							</a>
							<input type="hidden" id="imagenName" value="0" />
							<input style="display:none" type="file" id="fileImagen" style="color:#003" 
								name="archivos[]" multiple />
							<small id="alertImage" class="error" style="display:none"></small>
						</div>
					</div>
                            
					<br/><br/>
					
					<div class="small-12 medium-10 large-10 columns">
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
					</div>
					
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelIniDate"><strong>*Fecha de Inicio</strong>
								<input type="date" id="txtIniDate" class="radius" />
							</label>
							<small id="alertIniDate" class="error" style="display:none"></small>
						</div>
					</div>
							
					<div class="row">
						<div class="small-12 medium-10 large-10 columns">
							<label id="labelEndDate"><strong>*Fecha Final</strong>
								<input type="date" id="txtEndDate" class="radius" />
							</label>
							<small id="alertEndDate" class="error" style="display:none"></small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-8 medium-9 large-6 columns">
							<button id="btnCancel" class="bntSave button small alert radius ">Cancelar</button>
							<button id="btnSaveCoupon" class="bntSave button small success radius ">Guardar</button>
							<button id="btnRegisterCoupon" class="bntSave button small success radius ">
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