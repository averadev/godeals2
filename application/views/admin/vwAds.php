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
                    		INICIO ADS
                        </div>    
                  	</li>
        			<li class="btnSubMenu TooltipsSubMenu" id="CatalogAds" title="Catalogo de ads">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/catalogoCampanas.png" class="iconSubMenu" />
                        	</div>
                       		<div class="textSubMenu">
                        		CATÁLOGO DE ADS
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
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwCatalogAds">
    	<?php $this->load->view('admin/vwCatalogAds'); ?>
	</div>
</div>

<!----sub menu movil despegable--->
<div class="opcionMenuLeftMovil">
	<div class="MenuIconMovil btnSubMenu" id="CatalogAds">
    	CATÁLOGO DE ADS
   	</div>
    <div class="MenuIconMovil btnSubMenu" id="reportsLoyalty">
    	REPORTES
  	</div>
</div>

<div id="bgSubMenuMovil"></div>

<?php
$this->load->view('admin/vwFooter');
?>

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/ads.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>





