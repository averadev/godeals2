<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Go Deals</title>
    <link href='http://fonts.googleapis.com/css?family=Chivo' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
    <script type="text/javascript" src="<?php echo base_url().FOUND; ?>js/vendor/modernizr.js"></script>

  </head>
<body>
    <?php
    $pg = isset($page) && $page != '' ?  $page :'home'  ;
    ?>
    
    <div class="row">
			<div class="small-8 large-4 columns">
				<h1><img src="<?php echo base_url().IMG; ?>web/logo.png"></h1>
			</div>
			<div class="small-4 large-8 columns"></div>
		</div>
    
    <nav class="top-bar" data-topbar>
        
        <ul class="title-area">
            <li class="name"><h1><a href="#"> Go Deals</a></h1></li>
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            <ul class="left">
                <li class="divider"></li>
                <li <?php echo  $pg =='home' ? 'class="active"' : '' ?>><a href="<?php echo base_url(); ?>home">home</a></li>
                <li class="divider"></li>
                <li <?php echo  $pg =='codigo' ? 'class="active"' : '' ?>><a href="<?php echo base_url(); ?>codigo">Codigo</a></li>
                <li class="divider"></li>
            </ul>
            <ul class="right">
                <li class="divider"></li>
                <li><a  href="<?php echo base_url(); ?>login/logout">Salir</a></li>
            </ul>
        </section>
        
    </nav>
    

