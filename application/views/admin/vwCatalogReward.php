
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Recompensas de Lealtad
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaReward" class="viewTable CatalogReward">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-12 medium-6 large-6 columns">
                	<div class="small-12 medium-12 large-12 columns">
                		<input type="search" class="txtSearchComposed" id="txtSearchRewardPartner" placeholder="NOMBRE DEL COMERCIO" />
                	</div>
                    <div class="small-12 medium-12 large-12 columns">
                		<input type="search" class="txtSearchComposed" id="txtSearchRewardCampana" placeholder="NOMBRE DE CAMPAÑA" />
                	</div>
                    <div class="small-12 medium-12 large-12 columns">
                		<select class="radius" id="sctTypeReward">
							<option value="0">Tipo de Recompensa</option>
                           	<option value="1">Visitas</option>
                            <option value="2">Canjes</option>
                            <option value="3">Descargas</option>
						</select>
                	</div>
                </div>
                <div class="small-12 medium-6 large-6 columns">
                	<!--<div class="large-12 columns" style="float:left; height:107px;" id="separadorBoton">&nbsp;</div>-->
                	<div class="small-12 medium-2 large-12 columns" style="float:left;">
                		<button id="txtSearchReward" class="btnSearchCReward secondary" style="border-radius:5px;">Buscar</button>
                	</div>
              	</div>
            </div>
            <!--div alert-->
            <div class="row collapse">
            	<div class="large-12 columns divAlertWarning" id="divMenssageCReward" style="display:none">
					<div data-alert class="alert-box success" id="alertMessageCReward">
					</div>
				</div>
            	<div class="large-12 columns divAlertWarning" id="divMenssagewarningCReward" style="display:none; float:left;">
					<div data-alert class="alert-box warning" id="alertMessagewarningCReward">
						¿desea eliminar la campaña?
						<button class ="btnCancelC" id="btnCancelDeleteC">cancelar</button>
						<button class="btnAcceptC" id="btnAcceptDeleteC">aceptar</button>            
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tableReward" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="6" class="titleTabla">
                                	lista de Campañas
                                </td>
                           	</tr>
    						<tr>
                            	<th width="50">#</th>
                                <th>Recompensa</th>
                                <th>Requisitos</th>
                                <th>Campaña</th>
                                <th>Comercio</th>
                                <th>Estatus</th>
    						</tr>
  						</thead>
                        <tbody>
                        	
                        </tbody>
                    </table>
                    <?php $totalPaginador = 0; ?>
                    <!--- muestra la paginacion --->
                    <ul class="pagination" id="paginatorReward">
                    	<li id="btnPaginadorReward" value="0" class=btnPaginador "arrow primero unavailable">
							<a>&laquo;</a>
						</li>
						<?php 
						for($i = 1;$i<=($totalPaginador+1);$i++){
							if($i == 1){
							?>
								<li value="<?php echo $i ?>" id="btnPaginadorReward" class="btnPaginador current">
									<a><?php echo $i ?></a>
                                </li>
								<?php
							}
							else {
							?>
								<li value="<?php echo $i ?>" id="btnPaginadorReward" class="btnPaginador">
									<a><?php echo $i ?></a>
                              	</li>
								<?php	
							}
						}
							?>
						<li value="<?php echo ($totalPaginador+1) ?>" id="btnPaginadorReward" 
							class="btnPaginador arrow ultimo"><a>&raquo;</a></li>
					</ul>
                   	<!-- fin de la paginacion-->
                </div>
            </div>
        </div>
		<!-- fin de la tabla de campañas--->
		
		<!--------------------------------------------------------------------------->
		<!--------------------------------------------------------------------------->
		
    </div>
	<!----fin content--->