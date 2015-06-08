
<?php
	$this->load->view('web/vwHeader');
?>
<style>
	.alert-box{
		display: none;
	}
</style>
    
    <body>
        
		<hr>
		
		<div class="row" style="margin-top:80px;">
			<div class="small-2 large-2 columns">&nbsp;</div>
			<div class="small-8 large-6 columns">
				<div class="panel">
					<h4>Redime el código!</h4>
					<div data-alert class="alert-box alert bg-danger"></div>
					<div data-alert class="alert-box info bg-info"></div>
					
						<div class="row">
							<div class="large-8 columns">
								<input id="txtCodigo" type="text" placeholder="Ingresa el código del Deal." />
							</div>
							<div class="large-4 columns"><a id="btnSearch" class="radius button right">Canjear</a></div>
						</div>
					
				</div>
			</div>
			<div class="small-2 large-4 columns">&nbsp;</div>
		</div>
		
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url().FOUND; ?>js/foundation.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url().JS; ?>partner/redencion.js"></script></script>
        
    </body>
</html>