
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <title>Go Deals</title>
        <link href='http://fonts.googleapis.com/css?family=Chivo' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css" />
		
    </head>
    <body>
    
  		<div class="small-12 medium-12 large-12 columns" id="headerLogin"></div> 
        
        
        <div class="row">
  			<div class="small-12 medium-12 large-12 columns" id="separadorL">
            	<br><br><br><br><br><br><br><br>
            </div>
		</div>
        
        <div class="row">
  			<div class="small-1 medium-3 large-3 columns">&nbsp;</div>
            <div class="small-10 medium-6 large-6 columns">
            	<img src="assets/img/web/logo.png" />
            </div>
  			<div class="small-10 medium-6 large-6 columns">
            	<div id="bgLogin" >
                	<br><br>
                    
                    <div class="row">
                    	<div class="small-12 medium-12 large-12 columns">
                        
                        
                        
                        	<div class="row">
                            	admin
                        		<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                        			<div class="small-10 medium-10 large-10 columns">
                            			<small id="alertLogin" class="alert-box alert">
                                        
                                		</small>
                           			</div>
                            	<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                       		</div>
                        
                        	<div class="row">
                        		<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                        			<div class="small-10 medium-10 large-10 columns">
                            			<label class="field" id="lblUSer">*Usuario
                                			
                                		</label>
                                        <input type="text" id="txtUser" class="radius"/>
                                		
                           			</div>
                            	<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                       		</div>
                            
                            <div class="row">
                        		<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                        			<div class="small-10 medium-10 large-10 columns">
                            			<label class="field" id="lblPassword">*Password
                                			
                                		</label>
                                        <input type="password" id="txtPassword" class="radius"/>
                                		
                           			</div>
                            	<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                       		</div>
                            
                            <div class="row">
                        		<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                        			<div class="small-10 medium-10 large-10 columns">
                            			<a id="login" class="button round">Ingresar</a>
                           			</div>
                            	<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                       		</div>
                        
                        </div>
                    </div>

                </div>
         
            </div>
  			<div class="small-1 medium-3 large-3 columns">&nbsp;</div>
		</div>
		
		<div class="row">
  			<div class="small-12 medium-12 large-12 columns" id="separadorL">
            	<br><br><br><br><br><br><br><br>
            </div>
		</div>
		
		
	</body>
		
        <script>
        	var URL_BASE = '<?php echo base_url(); ?>';
    	</script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url().FOUND; ?>js/foundation.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/admin/login.js"></script>
</html>