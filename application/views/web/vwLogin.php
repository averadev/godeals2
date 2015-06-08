
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Go Deals</title>
        <link href='http://fonts.googleapis.com/css?family=Chivo' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css" />
		
    </head>
    <body>
    
    	<div class="small-3 medium-9 large-10 columns">&nbsp;</div>
        <div class="small-9 medium-3 large-2 columns" id="bgBtnRegister">
        	<div id="registrerForm">
        		<p id="labelRegister">¿Aun no esta registrado?</p>
      			<input type="button" value="REGISTRATE" id="btnRegisterPartner" />
            </div>
        </div>
         
  			<div id="separadorL">
            	&nbsp;
            </div>
        
        <div class="row">
            <div class="small-1 medium-3 large-3 columns">&nbsp;</div>
            <div class="small-12 medium-6 large-6 columns" style="text-align:center; margin-left:0; margin-bottom:20px; padding-right:50px;">
            	<img src="assets/img/web/logoGo2.png" width="70%" />
            </div>
            <div class="small-1 medium-3 large-3 columns">&nbsp;</div>
		</div>
        
        <div class="row">
            <div class="small-1 medium-3 large-3 columns">&nbsp;</div>
            <div class="small-12 medium-6 large-6 columns">
            	<div class="bgLogin" id="formLogin">
                	<div id="divAlertLogin">
                		<small id="alertLogin" class="alert-box alert" style="display:none; width:100%;"></small>
            		</div>
                	<input type="email" class="inputLoginaaa" id="txtUser" placeholder="EMAIL" />
                    <input type="password" class="inputLoginaaa" id="txtPassword" placeholder="CONTRASEÑA" />
                    <input type="button" value="INGRESAR" id="btnSignIn" class="btnLogin" />
                    <p id="labelRememberPassword">Se me olvido mi contraseña</p>
                </div>
                
                <div class="bgLogin" id="formRegister">
                	<div id="divAlertLogin">
                		<small id="alertRegister" class="alert-box alert" style="display:none; width:100%;"></small>
            		</div>
                	<input type="email" class="inputLoginaaa" id="txtEmail" placeholder="EMAIL" />
                    <input type="text" class="inputLoginaaa" id="txtPartner" placeholder="COMERCIO" />
                    <textarea rows="4" placeholder="OBSERVACION" id="txtObservation"></textarea>
                    <input type="button" value="ENVIAR" id="btnSendEmail" class="btnRegister" />
                    <input type="button" value="CANCELAR" id="btnCancelRegister" class="btnRegister" />
                </div>
                
                <div class="bgLogin" id="formRemenberPassword">
                	<div id="divAlertLogin">
                		<small id="alertRemeber" class="alert-box alert" style="display:none; width:100%;"></small>
            		</div>
                    <input type="text" class="inputLoginaaa" id="txtRemenberEmail" placeholder="EMAIL" />
                	<input type="button" value="ENVIAR" id="btnRemenberPassword" class="btnRegister" />
                    <input type="button" value="CANCELAR" id="btnCancelRemenber" class="btnRegister" />
                </div>
            </div>
            <div class="small-1 medium-3 large-3 columns">&nbsp;</div>
		</div>
        
   	<div id="divFooter" class="small-12 medium-12 large-12 columns">
    	<img src="assets/img/web/logo-geek.png" width="150px" />
    </div>
		
		
	</body>
		
        <script>
        	var URL_BASE = '<?php echo base_url(); ?>';
    	</script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url().FOUND; ?>js/foundation.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/admin/login.js"></script>
</html>