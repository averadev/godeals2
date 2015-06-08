<?php
$this->load->view('admin/vwHeader');
?>

<div class="container">

	<div class="small-12 medium-12 large-2 columns" style="margin-right:0;">
    	<div class="subMenuLeft">
    		<div class="opcionMenuLeft">
        		<ul>
                    <li class="btnSubMenuTitle" style="height:50px;">
                    	<div class="imgSubMenuTitle" style="margin-top:10px;">
                        	<img src="assets/img/web/subMenu/Inicio.png" class="iconSubMenu" />
                        </div>
                        <div class="textSubMenuTitel">
                    		INICIO </br> PROMOCIONES
                        </div>    
                  	</li>
        			<li class="btnSubMenu TooltipsSubMenu" id="CatalogPromo" title="Catalogo de ads">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/catalogoCampanas.png" class="iconSubMenu" />
                        	</div>
                       		<div class="textSubMenu">
                        		CATÁLOGO DE PROMOCIONES
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
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwCatalogPromo">
    	<?php $this->load->view('admin/vwCatalogPromo'); ?>
	</div>
</div>

<!----sub menu movil despegable--->
<div class="opcionMenuLeftMovil">

	<div class="MenuIconMovil btnSubMenu" id="CatalogPromo">
    	CATÁLOGO DE PROMOCIONES
   	</div>
    <div class="MenuIconMovil btnSubMenu" id="reportsLoyalty">
    	REPORTES
  	</div>
</div>

<div id="bgSubMenuMovil"></div>

<?php
$this->load->view('admin/vwFooter');
?>

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/promociones.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>





