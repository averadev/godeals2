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
                    		INICIO LEALTAD
                        </div>    
                  	</li>
        			<li class="btnSubMenu TooltipsSubMenu" id="catalogCampana" title="Catalogo de campaña">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/catalogoCampanas.png" class="iconSubMenu" />
                        	</div>
                       		<div class="textSubMenu">
                        		CATÁLOGO DE CAMPAÑA
                        	</div>
                        </div>
                    </li>
            		<li class="btnSubMenu TooltipsSubMenu" id="CatalogReward" title="Catalogo de recompensa">
                    	<div class="contentSubMenu">
                    		<div class="imgSubMenu">
                        		<img src="assets/img/web/subMenu/CatalogoRecompensas.png" class="iconSubMenu" />
                        	</div>
                        	<div class="textSubMenu">
                    			CATÁLOGO DE RECOMPENSA
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
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwcatalogCampana">
    	<?php $this->load->view('admin/vwCampanaLealtad'); ?>
	</div>
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwCatalogReward">
    	<?php $this->load->view('admin/vwCatalogReward'); ?>
	</div>
    <div class="small-12 medium-12 large-10 columns divContentInfo" id="vwAuthorizationsLoyalty">
    	<?php $this->load->view('admin/vwAuthorizationsLoyalty'); ?>
	</div>
</div>

<!----sub menu movil despegable--->
<div class="opcionMenuLeftMovil">

	<div class="MenuIconMovil btnSubMenu" id="catalogCampana">
    	CATÁLOGO DE CAMPAÑA
   	</div>
    <div class="MenuIconMovil btnSubMenu" id="CatalogReward">
    	CATÁLOGO DE RECOMPENSA
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

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/lealtad.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/modal.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/cupones.js"></script>





