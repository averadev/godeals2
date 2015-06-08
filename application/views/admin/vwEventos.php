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
                    		INICIO EVENTOS
                        </div>    
                  	</li>
        			<li class="btnSubMenu TooltipsSubMenu" id="CatalogEvent" title="Catalogo de eventos">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/catalogoCampanas.png" class="iconSubMenu" />
                        	</div>
                       		<div class="textSubMenu">
                        		CATÁLOGO DE EVENTOS
                        	</div>
                        </div>
                    </li>
            		<li class="btnSubMenu TooltipsSubMenu" id="CatalogLocations" title="Catalogo de locaciones">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/catalogoCampanas.png" class="iconSubMenu" />
                        	</div>
                        	<div class="textSubMenu">
                    			CATÁLOGO DE lOCACIONES
                     	   </div>
                        </div>
                  	</li>
                    <li class="btnSubMenu TooltipsSubMenu" id="AuthorizationsLoyalty" title="Autorizaciones pendientes">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/Autorizaciones.png" class="iconSubMenu" />
                        	</div>
                        	<div class="textSubMenu">
                    			AUTORIZACIONES PENDIENTES
                     	   </div>
                        </div>
                  	</li>
            		<li class="btnSubMenu TooltipsSubMenu" id="reportsLoyalty" title="Reportes">
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
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwCatalogEvent">
    	<?php $this->load->view('admin/vwCatalogEvent'); ?>
	</div>
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwCatalogLocations">
    	<?php $this->load->view('admin/vwCatalogLocations'); ?>
	</div>
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwAuthorizationsLoyalty">
	</div>
</div>

<!----sub menu movil despegable--->
<div class="opcionMenuLeftMovil">

	<div class="MenuIconMovil btnSubMenu" id="CatalogEvent">
    	CATÁLOGO DE EVENTOS
   	</div>
    <div class="MenuIconMovil btnSubMenu" id="CatalogLocations">
    	CATÁLOGO DE lOCACIONES
  	</div>
   	<div class="MenuIconMovil btnSubMenu" id="AuthorizationsLoyalty">
    	AUTORIZACIONES PENDIENTES
   	</div>
     <div class="MenuIconMovil btnSubMenu" id="reportsLoyalty">
    	REPORTES
  	</div>
</div>

<div id="bgSubMenuMovil"></div>

<?php
$this->load->view('admin/vwFooter');
?>

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/eventos.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/place.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>





