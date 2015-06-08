<?php
$this->load->view('admin/vwHeader');
?>

<div class="container">



	<div class="small-12 medium-12 large-2 columns" style="margin-right:0;">
    	<div class="subMenuLeft">
    		<div class="opcionMenuLeft">
        		<ul>
                	<li class="btnSubMenuTitle">
                    	<div class="imgSubMenuTitle">
                        	<img src="assets/img/web/subMenu/Inicio.png" class="iconSubMenu" />
                        </div>
                        <div class="textSubMenuTitel">
                    		INICIO DEALS
                        </div>    
                  	</li>
        			<li class="btnSubMenu TooltipsSubMenu" id="catalogDeals" title="Consulta o agrega nuevos deals">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                       			<img src="assets/img/web/subMenu/CatalogoDeals.png" class="iconSubMenu" />
                       		</div>
                     		<div class="textSubMenu">
                        		CATÁLOGO DE DEALS
                        	</div>
                        </div>
                    </li>
            		<li class="btnSubMenu TooltipsSubMenu" id="pendingAuthorizations" 
                    	title="Consulta los deals en espera de autorizacion">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/Autorizaciones.png" class="iconSubMenu" />
                        	</div>
                        	<div class="textSubMenu">
                    			AUTORIZACIONES PENDIENTES
                     	   </div>
                        </div>
                  	</li>
            		<li class="btnSubMenu TooltipsSubMenu" id="reportsDeals" 
                    	title="Consulta los reportes de descarga y redencion de deals">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/Reportes.png" class="iconSubMenu" />
                        	</div>
                        	<div class="textSubMenu">
                    			REPORTES
                        	</div>
                        </div>
                 	</li>
        		</ul>
    		</div>
            
    	</div>
    </div>
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwcatalogDeals">
    	<?php $this->load->view('admin/vwCatalogDeals'); ?>
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

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/cupones.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>





