<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

//require APPPATH.'/libraries/REST_Controller.php';


/**
 * The Saving coupon
 * Author: Alberto Vera Espitia
 * GeekBucket 2014
 *
 */
class Login extends CI_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('admin_user_db');
    }

	public function index(){
		if ($this->session->userdata('type') == 1) {
            redirect('home');
        }elseif($this->session->userdata('type') == 2){
			redirect('admin/dashboard');
		} else {
            $this->load->view('web/vwLogin');
        }
    }
	
	/*/
	 * verificamos usuario y contraseña
	 */
	public function checkLogin(){
        if($this->input->is_ajax_request()){
			$data = $this->admin_user_db->get(array('email' => $_POST['email'], 'password' => md5($_POST['password'])));
			$data2 = $this->admin_user_db->getAdmin(array('email' => $_POST['email'], 'password' => md5($_POST['password'])));
			
			if(count($data)>0){
				$this->session->set_userdata(array(
                    'id'	 	=> $data[0]->id,
                    'email' 	=> $data[0]->email,
					'username' 	=> $data[0]->name,
					'type' 		=> 1
                ));
				echo json_encode(array('success' => true, 'message' => 'Acceso satisfactorio.', 'type' => 1));
			}elseif (count($data2) > 0) {
				$this->session->set_userdata(array(
                    'id' => $data2[0]->id,
					'username' => $data2[0]->username,
                    'email' => $data2[0]->email,
					'type' 		=> 2
                ));
				echo json_encode(array('success' => true, 'message' => 'Acceso satisfactorio.', 'type' => 2));
			}else {
				echo json_encode(array('success' => false, 'message' => 'El usuario y/o password es incorrecto.'));
			}
					
        }
    }
	
	public function logout() {
        $this->session->unset_userdata('id');
		$this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
		$this->session->unset_userdata('type');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('home');
    }
	
	public function sendEmailContact(){
		if($this->input->is_ajax_request()){
			
			// título
        	$título = 'Contacto: Comercio de godeals';

        	// mensaje
        	$mensaje = '
        	<html>
            	<body>
                	<div style="width:100%; height:80px; background: #212121 url(http://godeals.mx/web/assets/img/web/logo.png) no-repeat center left; font-size:50px; color:#ffffff; padding: 20px 0 0 250px; ">
                    	Contacto
                	</div>
                	<div style="width:100%; height:5px; background: #5ec62b;"></div>

                	<div style="width:100%; margin: 20px 0;">
                    	<h3 style="padding-left:40px;"> '.$_POST['partner'].'</h3>

                    	<p style="font-family:Georgia; font-size:18px; padding-left:25px;">'.$_POST['observation'].'</p>

                	</div>

                	<div style="width:100%; height:5px; background: #5ec62b;"></div>
                	<div style="width:100%; height:60px; background: #212121; font-size:18px; font-weight: bold; color:#ffffff;">
                    	<div style="margin-left: 10px; display: inline-block; line-height: 60px; width:400px; background: url(http://godeals.mx/web/assets/img/web/logo.png) no-repeat center right;">DERECHOS RESERVADOS 2015</div>
                    		<div style="margin-left: 10px; display: inline-block; line-height: 60px;">CANCUN QUINTANA ROO MEXICO				</div>
                	</div>
            	</body>
        	</html>
        	';

        	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
        	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        	$cabeceras .= 'From: '.$_POST['partner'].' <'.$_POST['email'].'>';

        	// Enviarlo
       		if(mail('mzuniga@geekbucket.com.mx', $título, $mensaje, $cabeceras)){	
	   		//if(mail('conomia_alfredo@hotmail.com', $título, $mensaje, $cabeceras)){	
				echo json_encode(true);
			}else {
				echo json_encode(false);
			}
				
		}	
	}
	
	////cambia la contraseña del comercio
	public function changePassword(){
		if($this->input->is_ajax_request()){
			$user = $this->admin_user_db->chechMail($_POST['email']);
			if(count($user) > 0){
				$password = $this->getRandomCode();
				$update = array(
					'id' 			=> $user[0]->id,
					'password' 		=> md5($password)
				);
				$this->admin_user_db->updatePassword($update);
				$this->sendNewPassword($_POST['email'],$password);
				$message = "Contraseña actualizada, porfavor revise su correo.";
			}else{
				$message = "Contraseña actualizada, porfavor revise su correo.";
			}
			echo json_encode($message);
		}
	}
	
	//genera la nueva contraseña
	public function getRandomCode(){
        $an = "ABCDEFGHJKLMNPQRSTUVWXYZ123456789";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
				substr($an, rand(0, $su), 1) .
				substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);
    }
	
	//envia la nueva contraseña al correo del comercio
	public function sendNewPassword($mail, $password){
		
		// título
        	$título = 'Contacto: Cambio de contraseña de Go Deals';

        	// mensaje
        	$mensaje = '
        	<html>
            	<body>
                	<div style="width:100%; height:80px; background: #212121 url(http://godeals.mx/web/assets/img/web/logo.png) no-repeat center left; font-size:50px; color:#ffffff; padding: 20px 0 0 250px; ">
                    	Contacto
                	</div>
                	<div style="width:100%; height:5px; background: #5ec62b;"></div>

                	<div style="width:100%; margin: 20px 0;">
                    	<h3 style="padding-left:40px;">Go>Deals</h3>

                    	<p style="font-family:Georgia; font-size:18px; padding-left:25px;">se ha cambiado exitosamente su contraseña, su nueva contraseña es: ' . $password . '</p>

                	</div>

                	<div style="width:100%; height:5px; background: #5ec62b;"></div>
                	<div style="width:100%; height:60px; background: #212121; font-size:18px; font-weight: bold; color:#ffffff;">
                    	<div style="margin-left: 10px; display: inline-block; line-height: 60px; width:400px; background: url(http://godeals.mx/web/assets/img/web/logo.png) no-repeat center right;">DERECHOS RESERVADOS 2015</div>
                    		<div style="margin-left: 10px; display: inline-block; line-height: 60px;">CANCUN QUINTANA ROO MEXICO				</div>
                	</div>
            	</body>
        	</html>
        	';

        	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
        	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        	$cabeceras .= 'From: Go Deals <mzuniga@geekbucket.com.mx>';

        	// Enviarlo
       		// if(mail('mzuniga@geekbucket.com.mx', $título, $mensaje, $cabeceras)){	
	   		if(mail($mail, $título, $mensaje, $cabeceras)){	
				return true;
			}else {
				return false;
			}
		
	}
	
}