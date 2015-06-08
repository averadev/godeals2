
	<div class="small-12 medium-12 large-12 columns">
		<div class="headerScreen">
			Autorizaciones pendientes
		</div>        
	</div>
    <!----content--->
    <div class="small-12 medium-12 large-12 columns"> 
	
        <!--tabla de campañas --->
		<div id="ViewTablaReward" class="viewTable AuthorizationsLoyalty">
        	<!-- div busqueda -->
        	<div class="row collapse bgSerach">
            	<div class="small-12 medium-6 large-6 columns">
                    <div class="small-12 medium-12 large-12 columns">
                		<select class="radius" id="sctTypeRewardAuthorization">
							<option value="1">Borrador</option>
                            <option value="2" selected="selected">Esperando autorizacion</option>
                            <option value="3">Autorizado</option>
                            <option value="4">Publicado</option>
						</select>
                	</div>
                </div>
                <div class="small-12 medium-6 large-6 columns">
                	<!--<div class="large-12 columns" style="float:left; height:107px;" id="separadorBoton">&nbsp;</div>-->
                	<div class="small-12 medium-2 large-12 columns" style="float:left;">
                		<button id="txtSearchReward" class="btnSearch secondary" style="border-radius:5px;">Buscar</button>
                	</div>
				</div>
            </div>
            <!--div alert-->
            <div class="row collapse">
            	<div class="large-12 columns divAlertWarning" id="divMenssageAuthorization" style="display:none">
					<div data-alert class="alert-box success" id="alertMessageAuthorization">
					</div>
				</div>
            	<div class="large-12 columns divAlertWarning" id="divMenssagewarningAuthorization" style="display:none; float:left;">
					<div data-alert class="alert-box warning" id="alertMessagewarningAuthorization">
						¿desea aprobar la recompensa?
						<button class ="btnCancelC" id="btnCancelDeleteAuthoReward">Cancelar</button>
						<button class="btnAcceptC" id="btnAcceptDeleteAuthoReward">Aceptar</button>            
					</div>
				</div>
            </div>
            <!--div tabla--->
            <div class="row collapse contentTabla">
            	<div class="small-12 medium-12 large-12 columns">
                	<table id="tableAuthorizationsLealtad" width="100%;">
                    	<thead>
                        	<tr>
                            	<td colspan="7" class="titleTabla">
                                	lista de Campañas
                                </td>
                           	</tr>
    						<tr>
                            	<th>#</th>
      							<th>Recompensa</th>
      							<th>Requesitos</th>
      							<th>Registro</th>
      							<th>Campaña</th>
                                <th>Comercio</th>
                                <th>status</th>
    						</tr>
  						</thead>
                        <tbody>
                        	
                        </tbody>
                    </table>
                    <!--- muestra la paginacion --->
                    <ul class="pagination" id="paginatorAuthorizationsL">
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