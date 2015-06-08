
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <title>Go Deals</title>
        <link href='http://fonts.googleapis.com/css?family=Chivo' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
        <script type="text/javascript" src="<?php echo base_url() . FOUND; ?>js/vendor/modernizr.js"></script>
    </head>
    <body>
        
        <div class="row">
            <div class="large-12 columns">
                <h1>Go Deals <small>Pantalla de Pre-Registro.</small></h1>  
                <hr>
            </div>
        </div>
        
        <form>
            <div class="row" style="margin-top:10%;">
                
                <div class="large-3 medium-2 small-1 columns">&nbsp;</div>
                <div class="large-6 medium-8 small-10 columns">
                    
                    <div class="row" style="margin: 0 0 20px 0;">
                        <label>Activaci&oacute;n:
                            <select id="selActivation">
                                <?php foreach ($activations as $item):?>
                                    <option value="<?php echo $item->id;?>"><?php echo $item->name;?></option>
                                <?php endforeach;?>
                            </select>
                        </label>
                    </div>
                    
                    <div class="row collapse">
                        <div class="small-10 columns">
                            <input id="txtEmail" type="text" placeholder="E-mail">
                        </div>
                        <div class="small-2 columns">
                            <a href="#" id="btnGo" class="button postfix">Go</a>
                        </div>
                    </div>
                    
                </div>
                <div class="large-3 medium-2 small-1 columns">&nbsp;</div>
            </div>
        </form>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . FOUND; ?>js/foundation.min.js"></script>
        <script>
            $(function() {
                $("#btnGo").click(function() {
                    
                    if (! ($("#txtEmail").val() == '') ){
                        // Current date
                        var currentdate = new Date(); 
                        // Send info
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>preregistro/save",
                            dataType: 'json',
                            data: {
                                email: $("#txtEmail").val(),
                                idActivation: $( "#selActivation" ).val(),
                                date: currentdate.getFullYear() + "-" + (currentdate.getMonth()+1) + "-" + currentdate.getDate()
                            },
                            success: function(data) {
                                // Clear field
                                $("#txtEmail").val("");
                            }
                        });
                    }
                    
                });
            });
        </script>
    </body>
</html>