<?php
$this->load->view('admin/vwHeader');
?>

<div class="container">

	<div class="small-12 medium-12 large-12 columns" style="margin-right:0;">
    	
        <div class="row" style="border-radius: 4px; border: 2px solid #a3a3a3; padding: 0 20px; margin-top: 20px;">
            <h4>Bienvenido <?php echo $nameUser;?></h4>
            <p style="font-size:10px; margin-top: -10px;">Ultima conexión: 15-Mayo-2015</p>
        </div>
        
        <form>
            <div class="row" style="margin-top: 20px;">
                <div class="medium-3 columns" style="border-radius: 3px; border: 2px solid #a3a3a3; background-color: #f8f8f8; min-height: 637px;">
                    
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="row collapse" style="margin-top: 20px;">
                                <div class="small-10 columns">
                                    <input type="text" value="Total de usuarios: <?php echo $TotalUser;?>" readonly>
                                </div>
                                <div class="small-2 columns">
                                    <a href="#" class="button postfix" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="row collapse" style="margin-top: 10px;">
                                <div class="small-10 columns">
                                    <input type="text" value="Nuevos usuarios: 8" readonly>
                                </div>
                                <div class="small-2 columns">
                                    <a href="#" class="button postfix" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;</a>
                                </div>
                                <canvas id="ctxNewUsers" height="300" style="width: 100%; margin-top: -20px; background-color: #ffffff;"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="large-12 columns"  style="margin-top: 12px;">
                            <div class="row collapse" style="margin-top: 10px;">
                                <div class="small-10 columns">
                                    <input type="text" value="Usuarios activos: 59%" readonly>
                                </div>
                                <div class="small-2 columns">
                                    <a href="#" class="button postfix" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;</a>
                                </div>
                                <canvas id="ctxActives" height="300" style="width: 100%; margin-top: -20px; background-color: #ffffff;"></canvas>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="medium-9 columns">
                    <div class="row" style="border-radius: 3px; border: 2px solid #a3a3a3; background-color: #f8f8f8;">
                        <div class="medium-4 columns">
                            <div class="row collapse" style="margin-top: 20px;">
                                <div class="small-10 columns">
                                    <input type="text" value="Deals Activos: <?php echo $DealsActivos;?>" readonly>
                                </div>
                                <div class="small-2 columns">
                                    <a href="#" class="button postfix" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;</a>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="large-12 columns">
                                    <div class="row collapse" style="margin-top: 10px;">
                                        <div class="small-10 columns">
                                            <input type="text" value="Deals descargados: 123" readonly>
                                        </div>
                                        <div class="small-2 columns">
                                            <a  id="dealsDescargado" class="button postfix btnShowDialogDash" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;a</a>
                                        </div>
                                        <canvas id="ctxDealDownloaded" height="300" style="width: 100%; margin-top: -20px; background-color: #ffffff;"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-12 columns">
                                    <div class="row collapse" style="margin-top: 10px;">
                                        <div class="small-10 columns">
                                            <input type="text" value="Deals redimidos: 86" readonly>
                                        </div>
                                        <div class="small-2 columns">
                                            <a id="dealsRedimidos" class="button postfix btnShowDialogDash" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;b</a>
                                        </div>
                                        <canvas id="ctxDealDReden" height="300" style="width: 100%; margin-top: -20px; background-color: #ffffff;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-4 columns">
							<table id="tableEvents" style="margin-top: 10px;">
								<thead>
									<tr>
										<td class="titulo" colspan="7">Deals Descargados</td>
									</tr>
									<tr>
										<th>Comercio</th>
										<th># Deals</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($DealsD as $item):?>
                                        <tr>
                                            <th width="250px" style="font-weight: normal;"><?php echo $item->name;?></th>
                                            <th width="210px" style="font-weight: normal;"><?php echo $item->total;?></th>
                                        </tr>
                                    <?php endforeach;?>
								</tbody>
							</table>
                        </div>
                        
                        <div class="medium-4 columns">
							<table id="tableEvents" style="margin-top: 10px;">
								<thead>
									<tr>
										<td class="titulo" colspan="7">Deals Redimidos</td>
									</tr>
									<tr>
										<th>Comercio</th>
										<th># Deals</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($DealsR as $item):?>
                                        <tr>
                                            <th width="250px" style="font-weight: normal;"><?php echo $item->name;?></th>
                                            <th width="210px" style="font-weight: normal;"><?php echo $item->total;?></th>
                                        </tr>
                                    <?php endforeach;?>
								</tbody>
							</table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
        
        <div id="dialogDash-form" title="Reportes deals">
        	
            <div class="row">
              	<div class="large-8 large-centered columns">
					<!----Campos de fecha----->
             		<div class="row" style="margin-top:20px;">
                    	<!------->
                    	<div class="small-6 medium-6 large-5 columns">
							<label id="labelDashIniDate"><strong>*Fecha de inicio</strong>
								<input type="date" id="txtDashIniDate" class="radius"/>
							</label>
							<small id="alertDashIniDate" class="error" style="display:none">
								Campo vacio. Por favor escriba la fecha de inicio.
							</small>
						</div>
                        <!----->
                       	<div class="small-6 medium-6 large-5 columns">
							<label id="labelDashEndDate"><strong>*Fecha fin</strong>
								<input type="date" id="txtDashEndDate" class="radius"/>
							</label>
							<small id="alertDashEndDate" class="error" style="display:none">
								Campo vacio. Por favor escriba la fecha final.
							</small>
						</div>
                        <!-------->
                        <div class="small-2 medium-2 large-2 columns">
                        	</br>
                            <a id="btnSearchTotalDeals" class="button small radius" style="color:#FFF; font-size:16px;">
                            	Buscar
                          	</a>
                        </div>
                        <!-------->
                    </div>
					<!----fin campos fecha----->
					<!----tabla del modal------>
					<div class="row" style="margin-top:20px;">
                    	<div class="small-6 medium-6 large-12 columns">
							<table id="tableDashModal" style="margin-top: 10px;">
								<thead>
									<tr>
										<td class="titulo" id="titleTableDashModal" colspan="2">Deals</td>
									</tr>
									<tr>
										<th>Comercio</th>
										<th># Deals</th>
									</tr>
								</thead>
								<tbody>
                                	
								</tbody>
							</table>
                        </div>
                    </div>
					<!-----fin tabla modal------->
				</div>
			</div>
            
        </div>
        
        
    </div>
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwCatalogDeals">
    	<div class="small-12 medium-12 large-12 columns">
			<div class="headerScreen">
				
			</div>        
		</div>
	</div>
	
</div>

<!----sub menu movil despegable--->
<div class="opcionMenuLeftMovil">

	<div class="MenuIconMovil btnSubMenu" id="catalogDeals">
    	Catalogo de deals
   	</div>
    <div class="MenuIconMovil btnSubMenu" id="pendingAuthorizations">
    	Autorizaciones pendientes
  	</div>
   	<div class="MenuIconMovil btnSubMenu" id="reportsDeals">
    	Reportes
   	</div>
</div>

<div id="bgSubMenuMovil"></div>

<?php
$this->load->view('admin/vwFooter');
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/dash.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>
<script type="text/javascript" src="<?php echo base_url().URL; ?>api/chart/Chart.min.js"></script>





