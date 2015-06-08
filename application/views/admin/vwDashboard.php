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
                                            <a href="#" class="button postfix" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;</a>
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
                                            <a href="#" class="button postfix" style=" background-repeat:no-repeat; background-position: center; background-image: url('<?php echo base_url().IMG; ?>web/btnSearch.png')">&nbsp;</a>
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

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/dash.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>
<script type="text/javascript" src="<?php echo base_url().URL; ?>api/chart/Chart.min.js"></script>





