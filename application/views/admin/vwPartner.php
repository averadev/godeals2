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
                    		INICIO COMERCIO
                        </div>    
                  	</li>
        			<li class="btnSubMenu TooltipsSubMenu" id="CatalogPartner" title="Catalogo de Comercio">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/catalogoCampanas.png" class="iconSubMenu" />
                        	</div>
                       		<div class="textSubMenu">
                        		CATÁLOGO DEL COMERCIO
                        	</div>
                        </div>
                    </li>
            		<li class="btnSubMenu TooltipsSubMenu" id="CatalogPub" title="Catalogo de publicidad">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/CatalogoRecompensas.png" class="iconSubMenu" />
                        	</div>
                        	<div class="textSubMenu">
                    			CATÁLOGO DE PUBLICIDAD
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
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwCatalogPartner">
    	<?php $this->load->view('admin/vwCatalogPartner'); ?>
	</div>
</div>

<!----sub menu movil despegable--->
<div class="opcionMenuLeftMovil">
	<div class="MenuIconMovil btnSubMenu" id="CatalogPartner">
    	CATÁLOGO DEL COMERCIO
   	</div>
    <div class="MenuIconMovil btnSubMenu" id="CatalogPub">
    	CATÁLOGO DE PUBLICIDAD
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

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/partners.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>





