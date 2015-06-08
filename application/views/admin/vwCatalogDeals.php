<!--<div class="contentDiv" style="background:#303;">
    		<div id="divDeals">-->
    			<!--<div class="row">-->
            		<div class="small-12 medium-12 large-12 columns">
						<div class="headerScreen">
							Deals
						</div>        
					</div>
                    <!----content--->
                    <div class="small-12 medium-12 large-12 columns">
                    	
                        <div id="viewEvent" style="padding-left:0;" class="catalogDeals">
							<div class="row">
            
								<div class="large-12 columns" style="padding-left:0;">
									<!--- divicion que contiene el buscador --->
					
									<div class="large-12 large-centered columns" style="padding-left:0;">
										<div id="buscar" class="row collapse">
											<div class="small-8 medium-10 large-10 columns columns">
												<input class="txtSearch" id="txtSearchCoupon" type="text" 
												placeholder="Busqueda por descripcion, cliente, ubicacion" />

											</div>
											<div class="small-4 medium-2 large-2 columns">
												<button class="btnSearch" id="txtSearchCoupon"><img src="assets/img/web/iconSearch.png">Buscar</button>
											</div>
										</div>
									</div>
									<!--- fin de la divicion buscar --->
									<div class="small-12 large-11 large-centered columns" id="divMenssage" style="display:none">
										<div data-alert class="alert-box success" id="alertMessage">
										</div>
									</div>
									<div class="small-12 large-11" id="divMenssagewarning" style="display:none">
										<div data-alert class="alert-box warning" id="alertMessagewarning">
											¿desea eliminar el coupon?
											<button class ="btnCancelC" id="btnCancelC">cancelar</button>
											<button class="btnAcceptC" id="btnAcceptC">aceptar</button>
                        
										</div>
									</div>
									<!--- divicion "tabla" --->
									<!--- contiene la lista decupones --->
									<div id="tabla" class="large-12 large-centered columns" style="padding-left:0;">

										<table id="tableCoupon">
										<!--- encabezado de la tabla --->
											<thead>
												<tr>
													<td id="titulo" colspan="7">lista de Cupones
														<button id="btnAddCoupon" class="btnAdd">Agregar</button>
													</td>
												</tr>
												<tr>
													<th>#</th>
													<th>Descripcion</th>
													<th width="170px">Cliente</th>
													<th width="100px">Total</th>
													<th width="100px">Publicado</th>
													<th>Eliminar</th>
												</tr>
											</thead>
											<!--- muestra los datos sacados de la BD --->
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
														<?php 
														if($item->status == 1){
															?><td><img id="imgPubli1" src="assets/img/web/tick.png"/></td><?php
														}else{
															?><td><img id="imgPubli2" src="assets/img/web/cancel.png"/></td><?php
														}
														?>
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
											<li id="btnPaginadorCoupon" value="0" class=btnPaginador "arrow primero unavailable">
												<a>&laquo;</a>
											</li>
											<?php 
											for($i = 1;$i<=($totalPaginador+1);$i++){
												if($i == 1){
													?>
														<li value="<?php echo $i ?>" id="btnPaginadorCoupon" class="btnPaginador current">
														<a><?php echo $i ?></a></li>
													<?php
													}
												else {
													?>
													<li value="<?php echo $i ?>" id="btnPaginadorCoupon" class="btnPaginador">
													<a><?php echo $i ?></a></li>
													<?php	
												}
											}
											?>
											<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorCoupon" 
											class="btnPaginador arrow ultimo"><a>&raquo;</a></li>
										</ul>
									</div>
									<!--- fin divicion "tabla" --->
								</div>
							</div>
						</div>
						<!--- fin de la divicion "viewEvent" --->

						<!--- divicion "FormEvent" --->
						<!--- muestra el formulario para agregar y modificar cupones --->
						<div id="FormEvent" style="display:none;">
							<div class="row" style="margin:0; padding:0;">
								<div class="small-12 medium-12 large-12 columns" style="padding-left:0; padding-right:0;">
									<!-- primera columna -->
									<div class="small-12 medium-6 large-6 columns" style="padding-left:0; padding-right:0;">
						
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
											<div class="small-12 medium-10 large-5 columns">
												<label id="labelPartner"><strong>*Comercio</strong>
													<input type="text" id="txtPartner" list="partnerList" autocomplete="on" class="radius"> 
													<datalist id="partnerList"> </datalist>
												</label>
												<small id="alertPartner" class="error" style="display:none">
													Partner incorrecto. Por favor escriba un comercio existente
												</small>
											</div>
							
											<div class="small-12 medium-10 large-5 columns">
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
											<div class="small-12 medium-10 large-5 columns">
												<label id="labelTotal"><strong>*Total de Cupones</strong>
													<input type="number" id="txtTotal" class="radius" min="1" total="0" >
												</label>
												<small id="alertTotal" class="error" style="display:none">
													Campo vacio. Por favor escriba el total de cupones
												</small>
											</div>
                                
											<div class="small-12 medium-10 large-5 columns">
												<label id="labelStock"><strong>*Stock</strong>
													<input type="number" id="txtStock" class="radius" disabled="disabled" stock="0" >
												</label>
												<small id="alertStock" class="error" style="display:none">
													Campo vacio. Por favor escriba el total de cupones
												</small>
											</div>
                                
											<div class="medium-2 columns">&nbsp;</div>
                                
										</div>
										
										<div class="row">
											<div class="small-12 medium-10 large-10 columns">
												<label id="labelValidity"><strong>*Validez</strong>
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
												<label id="labelClauses"><strong>*Cláusulas</strong>
													<textarea id="txtClauses" class="radius" rows="5"></textarea>
												</label>
												<small id="alertClauses" class="error" style="display:none">
													Campo vacion. Por favor escriba las clausulas.
												</small>
											</div>
										</div>
							
										<div class="row" id="divCheckPubli">
											<div class="small-12 medium-10 large-10 columns">
												<label id="labelClauses"><strong>*Publicado</strong></label>
									
													<!--<input type="checkbox" name="publicar" value="1" id="publicar"><label id="txtPublicar">Si</label>-->
										
													<div class="onoffswitch" style="margin-bottom:15px;">
														<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="checkPublicDeals">
														<label class="onoffswitch-label" for="checkPublicDeals">
															<span class="onoffswitch-inner"></span>
															<span class="onoffswitch-switch"></span>
														</label>
													</div>
											</div> 
										</div>

									</div>
						
									<!-- fin primera columna -->


									<!-- segunda columna -->
									<div class="small-12 medium-6 large-6 columns">

										<div class="row">
											<div class="small-12 medium-8 large-8 columns" id="imagen">
												<label id="labelImage"><strong>*Imagen</strong> </label>
												<a><img style="height:128px;width:128px;" id="imgImagen" 
												src="http://placehold.it/140x140&text=[140x140]" class="imgImagen"/></a>
												<input type="hidden" id="imagenName" value="0" />
												<input style="display:none" type="file" id="fileImagen" isTrue="0" />
												<small id="alertImage" class="error" style="display:none"></small>
											</div>
										</div>
                            
										<br/><br/>
							
							
                            
										<!---$filter --->
							
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
																<input value="<?php echo $item->id ?>" type="checkbox" 
																	name="filter" class="chechFilterDeals" /> <?php echo $item->name ?>
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
												<small id="alertIniDate" class="error" style="display:none">
												</small>
											</div>
										</div>
							
										<div class="row">
											<div class="small-12 medium-10 large-10 columns">
												<label id="labelEndDate"><strong>*Fecha Final</strong>
													<input type="date" id="txtEndDate" class="radius" />
												</label>
												<small id="alertEndDate" class="error" style="display:none">
												</small>
											</div>
										</div>
							
										<div class="row" style="margin-right:0;">
											<div class="small-12 medium-10 large-7 columns">
												<button id="btnCancel" class="bntSave button small alert radius ">Cancelar</button>
												<button id="btnSaveCoupon" class="bntSave button small success radius ">Guardar</button>
												<button id="btnRegisterCoupon" class="bntSave button small success radius ">
													Guardar</button>
											</div>
											<div class="loading small-3 medium-2 large-2 columns" id="load1" style="float:left;"></div>
										</div>
										<div id="cargados"></div>
									</div>
								<!-- fin segunda columna -->
								</div>
							</div>
						</div>
						<!--- fin divicion "FormEvent" --->
                        
                    </div>
                    <!--- content -->
				<!--</div>-->
			<!--</div>
		</div>-->