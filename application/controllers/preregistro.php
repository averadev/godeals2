<?php
/**
 * GeekBucket 2014
 * Author: Gengis Cetina
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class preregistro extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database('default');
        $this->load->model('preregistro_db');
    }

    /**
     * Despliega la pantalla 
     */
    public function index(){  
        
        // Get View
        $arr['activations'] = $this->preregistro_db->getActivations();
        $this->load->view('web/vwPreRegistro', $arr);
    }
    
    /**
     * Guarda la info recibida
     */
    public function save(){  
        
        // Get View
        $this->preregistro_db->insertPreregistro($_POST);
        $this->registro($_POST["email"]);
        echo json_encode(array("done" => 1));    
    }
    
    function registro($email){
    	
        // mensaje
        $mensaje = '
        <html>
            <body style="background-color: #F5F5F5;">
                <div style="width:100%; height:80px; background: #212121 url(http://godeals.mx/assets/img/prox/logoGo.png) no-repeat center left; font-size:50px; color:#ffffff; padding: 20px 0 0 250px; "></div>
                <div style="width:100%; height:5px; background: #5ec62b;"></div>

                <div style="width:100%; margin: 20px 0 40px 0;">
                    <h2>&iexcl;Felicidades! &iexcl;Est&aacute;s a un paso de ser miembro de la comunidad Go Deals!</h2>
                    
                    <p style="font-family:Georgia; font-size:18px;">
                        Go Deals es una agenda social que te dar&aacute; acceso a regalos y promociones exclusivas en comercios participantes de Cancun y Riviera Maya, 
                        adem&aacute;s de informarte de los eventos pr&oacute;ximos en tu ciudad.
                    </p>
                    
                    <p style="font-family:Georgia; font-size:18px;">
                        Al realizar tu pre-registro, entras automáticamente a sorteos de distintas recompensas, las cuales en caso de resultar ganador, 
                        llegar&aacute;n a tu bandeja de notificaciones dentro de la aplicaci&oacute;n, por lo que solo necesitas descargarla en tu tel&eacute;fono Android o Iphone:
                    </p>
                    
                    <center>
                        <a href="https://itunes.apple.com/es/app/go-deals/id932481336" ><img src="http://godeals.mx/assets/img/web/btnApp1.png"></a>
                        <a href="https://play.google.com/store/apps/details?id=mx.godeals" ><img src="http://godeals.mx/assets/img/web/btnApp2.png"></a>
                    </center>
                    
                    <p style="font-family:Georgia; font-size:18px;">
                        &iexcl;No te pierdas las promociones especiales que te ofrecen los mejores lugares de tu ciudad!.
                    </p>
                    
                    <p style="font-family:Georgia; font-size:18px;">
                        &iquest;Tienes alguna pregunta? Com&eacute;ntanos en nuestras redes sociales: 
                        <a style="margin: 0 10px;" href="https://www.facebook.com/godealsmx" ><img src="http://godeals.mx/assets/img/web/btnRecomSocial1.png"></a>
                        <a href="https://twitter.com/godealsmx" ><img src="http://godeals.mx/assets/img/web/btnRecomSocial2.png"></a>
                    </p>

                </div>
                

            </body>
        </html>
        ';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: Go Deals <contacto@godeals.mx>';

        // Enviarlo
        mail($email, "Pre-Registro Go Deals", $mensaje, $cabeceras);
    }
    
    
}