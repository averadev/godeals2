<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<meta http-equiv="Last-Modified" content="0" />
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Deals</title>
    <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
    <link rel="stylesheet" href="<?php echo base_url().CSS; ?>header.css" />
    <link rel="stylesheet" href="<?php echo base_url().CSS; ?>common.css" />
    <link rel="stylesheet" href="<?php echo base_url().CSS; ?>tooltipster.css" />
    <link rel="stylesheet" href="<?php echo base_url().CSS; ?>themes/tooltipster-shadow.css" />

  </head>
<body>
    <?php
    $pg = isset($page) && $page != '' ?  $page :'dashboard'  ;
    ?>
    
    <!--<nav class="top-bar" data-topbar>
        
        <ul class="title-area">
            <li class="name"><h1><a href="#"> Go Deals</a></h1></li>
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            
        </section>
        
    </nav>-->
    
    <nav class="menuHeader">
    	<div class="top-menu">
        	<div id="imgLogoH">
            	<a href="<?php echo base_url(); ?>dashboard"><img src="assets/img/web/logoGo.png" /></a>
            </div>
            <div id="boxUserData">
            	<div id="imgIconUser">
                	<img src="assets/img/web/iconoUsuario2.png" id="imgLogoUser" />
                    <div id="nameUser">
                    	<?php echo $nameUser; ?>
                    </div>
                </div>
                <div id="imgOptionUser">
                	<img src="assets/img/web/br_down_icon&16.png" />
                </div>
                <div id="MenuOpctionUser">
                	<ul>
                    	<li>
                        	<div class="imgOptionUser">
                        		<img src="assets/img/web/subMenu/settings-icon.png" class="imgOption2Re" />
                            </div>
                            <div class="textOptionUser">
                            	CONFIGURACION DEL SISTEMA
                            </div>
                        </li>
                        
                        <a  href="<?php echo base_url(); ?>login/logout">
                        	<li style="margin-bottom:5px;">
                        			<div class="imgOptionUser">
                        				<img src="assets/img/web/subMenu/Users-Exit-icon.png" />
                            		</div>
                            		<div class="textOptionUser">
                    					SALIR
                            		</div>
                        	</li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="lower-menu">
        	<div class="menuIconParent" id="menuTop">
            	<a href="<?php echo base_url(); ?>deals">
            		<div class="menuIconChildren">
               			<div class="imgIconMenu">
                    		<img src="assets/img/web/iconoDeals.png" />
                   	 	</div>
                    	<div class="textIconMenu">
                    		DEALS
                    	</div>
                	</div>
                </a>
                <a href="<?php echo base_url(); ?>lealtad">
                	<div class="menuIconChildren">
               			<div class="imgIconMenu">
                    		<img src="assets/img/web/iconoLealtad.png" />
                    	</div>
                    	<div class="textIconMenu">
                    		LEALTAD
                    	</div>
                	</div>
                </a>
                <a href="<?php echo base_url(); ?>eventos">
                	<div class="menuIconChildren">
               			<div class="imgIconMenu">
                    		<img src="assets/img/web/iconoEventos.png" />
                    	</div>
                    	<div class="textIconMenu">
                    		EVENTOS
                    	</div>
                	</div>
                </a>
                <a href="<?php echo base_url(); ?>partners">
					<div class="menuIconChildren">
						<div class="imgIconMenu">
							<img src="assets/img/web/iconoLocaciones.png" />
						</div>
						<div class="textIconMenu">
							COMERCIOS
						</div>
					</div>
				</a>
				<a href="<?php echo base_url(); ?>ads">
					<div class="menuIconChildren">
						<div class="imgIconMenu">
							<img src="assets/img/web/iconoPublicidad.png" />
						</div>
						<div class="textIconMenu">
							ADS
						</div>
					</div>
				</a>
				<a href="<?php echo base_url(); ?>promociones">
					<div class="menuIconChildren">
						<div class="imgIconMenu">
							<img src="assets/img/web/iconoPublicidad.png" />
						</div>
						<div class="textIconMenu">
							PROMOCIONES
						</div>
					</div>
				</a>
            </div>
            <!--lower-menu-Movil--->
            <div class="lowerMenuMovil" id="menuMovil">
            	<div id="SubMenuMovil">
                	<img src="assets/img/web/menuMovil.png" />
                </div>
            
            	<div id="textMenuMovil">
                	Menu
                </div>
                <div id="MenuOpctionMovil">
                	<img src="assets/img/web/menuMovil.png" />
                </div>
            </div>
            
            <!---fin ---->
        </div>
    </nav>
    
    <nav id="navmenuMovilDropdown">
    	<div id="menuMovilDropdown">
        	<div id="nameUserMovil">
            	<?php echo $nameUser; ?>
            </div>
            <div class="MenuIconMovil">
            	DEALS
            </div>
            <div class="MenuIconMovil">
            	LEALTAD
            </div>
            <div class="MenuIconMovil">
            	EVENTOS
            </div>
            <div class="MenuIconMovil">
            	LOCACIONES
            </div>
            <div class="MenuIconMovil">
            	PUBLICIDAD
            </div>
            <div class="MenuIconMovil">
            	SALIR
            </div>
        </div>
    </nav>
    
    <div id="bgMenuMovil">
    
    </div>
    

