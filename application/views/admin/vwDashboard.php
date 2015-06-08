<?php
$this->load->view('admin/vwHeader');
?>

<div class="container" style="height:400px;">

	<div class="small-12 medium-12 large-2 columns" style="margin-right:0;">
    	&nbsp;
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

<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/cupones.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>





