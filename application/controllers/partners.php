<?php
/**
 * GeekBucket 2014
 * Author: Polanco Alan
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Partners extends CI_Controller {
 
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database('default');
        $this->load->model('partner_db');
       // $this->load->model('map_category_db');
        if ($this->session->userdata('type') == 1 || !$this->session->userdata('type')) {
            redirect('login');
        }
    }
    
	public function index($offset = 0){
		$data['nameUser'] = $this->session->userdata('username');  
        $data['page'] = 'partners';  
        $data['partner'] = $this->sortSliceArray($this->partner_db->getAllActive(),10);
        $data['total'] = $this->totalArray($this->partner_db->getAllActive());//numero total de partners
	
        $this->load->view('admin/vwPartner',$data);
            
	}
    
    public function totalArray($array){
        $array = count($array);
        return $array;
    }
	
	/**
	*	regresa 10 partner 
	*/
    public function paginadorArray(){
        if($this->input->is_ajax_request()){
            $data = $this->partner_db->getAllSearch($_POST['dato'],$_POST['column'],$_POST['order']);
            $array = array_slice($data, $_POST['cantidad'], 10);
            echo json_encode($array);
        }
    }
    
	/**
	* regresa todos los partner 
	*/
    public function getAllSearch(){   
        if($this->input->is_ajax_request()){
            $data = $this->partner_db->getAllSearch($_POST['dato'],$_POST['column'],$_POST['order']);
            echo json_encode($data);
        }
    }
    
    public function sortSliceArray($array, $count){
        if (count($array) > $count){
            $array = array_slice($array, 0, $count);
        }
        return $array;
    }
    
	/**
	* obtiene partner por id
	*/
    public function getId(){
        if($this->input->is_ajax_request()){
            $data = $this->partner_db->getId($_POST['id']);
            echo json_encode($data);
        }    
    }
	
	/**
	*	regresa los partner por nombre
	*/
	public function getPartner(){
        if($this->input->is_ajax_request()){
            $data = $this->partner_db->getNameSearch($_POST['dato']);
            echo json_encode($data);
        }
    }
	
	/**
	*	valida que el amail no exista en la base de datos
	*/
	public function getEmail(){
		if($this->input->is_ajax_request()){
            $data = $this->partner_db->getEmail($_POST['email']);
            echo json_encode($data);
        }
	}
	
	/**
	 * obtiene las galerias del comercio
 	 */
	public function getAllGalleryById(){
		if($this->input->is_ajax_request()){
            $data = $this->partner_db->getAllGalleryById($_POST['partnerId']);
            echo json_encode($data);
        }
	}
	
	/**
	* inserta o actualiza los datos del partner
	*/
    public function savePartner(){
         if($this->input->is_ajax_request()){
             if($_POST['id']==0){
                $data = $this->partner_db->insertPartner(array(
                    'name'      		=> $_POST['name'],
                    'info'      		=> $_POST['info'],
                    'image'  			=> $_POST['image'],
                    'banner'   			=> $_POST['banner'],
                    'address'   		=> $_POST['address'],
                    'phone'     		=> $_POST['phone'],
                    'latitude'  		=> $_POST['latitude'],
                    'longitude' 		=> $_POST['longitude'],
                    'facebook'   		=> $_POST['facebook'],
                    'twitter' 			=> $_POST['twitter'],
					'status' 			=> 1,
                    'email'    			=> $_POST['email'],
					'password'   		=> md5($_POST['password'])
                    )
                ); 
				$data = "Se han agregado un nuevo comercio";
               // echo json_encode($data);
            }
            else {
				
				$data = array(
                    'id'        		=> $_POST['id'],
                    'name'      		=> $_POST['name'],
                    'info'      		=> $_POST['info'],
                    'image'  			=> $_POST['image'],
                    'banner'   			=> $_POST['banner'],
                    'address'   		=> $_POST['address'],
                    'phone'     		=> $_POST['phone'],
                    'latitude'  		=> $_POST['latitude'],
                    'longitude' 		=> $_POST['longitude'],
                    'facebook'   		=> $_POST['facebook'],
                    'twitter' 			=> $_POST['twitter'],
					'status' 			=> 1,
                    'email'    			=> $_POST['email']
               	);
				
				if($_POST['password'] != ""){
					$data['password'] = md5($_POST['password']);
				}
				
				$data = $this->partner_db->updatePartner($data);
				
				$data = "Se han editado los datos del comercio " . $_POST['name'];
            }
            echo json_encode($data);
        }
    }
    
	/**
	* actualiza el status a 0
	*/
    public function deletePartner(){
        if($this->input->is_ajax_request()){
            $data = $this->partner_db->deletePartner($_POST['id']);
            echo json_encode($data);
        }
    }
	
	/**
	 * guarda o actualiza los datos de la galeria
	 */  
	 public function saveGallery(){
		if($this->input->is_ajax_request()){
			if($_POST['add'] == 1){
				$insert = array();
				foreach(json_decode(stripslashes($_POST['image'])) as $image){
					array_push($insert, array(
						'idPartner' 	=> $_POST['idPartner'],
   						'image' 	=> $image
					));
				}
				$data = $this->partner_db->insertGallery($insert);
				$data = "Se han actualizado la galeria";
			} 
			if($_POST['save'] == 1){
				$delete = array();
					
				foreach(json_decode(stripslashes($_POST['idImage'])) as $id){
					$delete[] = $id;
				}	
				$data = $this->partner_db->deleteGallery($delete);
				
				//$data = $a[0]->image;
				
				$data = "Se han actualizado la galeria";
			}
            
            echo json_encode($data);
        }
	}
    
    /*------------------Imagen*-----------------*/
      
     
    public function uploadImage(){
		
		$ruta = explode(",",$_POST['ruta']);
		$nombreI = explode(",",$_POST['nombreI']);
		//$nombre = $_POST['nombre'];
		
		if($_POST['nameImage'] == ""){
			$fecha = new DateTime();
			$fechaActual = $fecha->getTimestamp();
		} else {
			$fechaActual = 	$_POST['nameImage'];
		}
		
		$i = 0;
		
        foreach ($_FILES as $key) {
            if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
                $nombre = $key['name'];//Obtenemos el nombre del archivo
                $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
                $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
                $tipo = $key['type']; //obtenemos el tipo de imagen
				
				$nombreTimeStamp = $nombreI[$i] . $fechaActual . ".jpg";
				
				move_uploaded_file($temporal, $ruta[$i] . $nombreTimeStamp);
				
				//echo $nombre[$i];
				
				$i++;
                
            }
        }
		
		echo $fechaActual;	
    }
     
    public function deleteImage(){
        if($this->input->is_ajax_request()){
            $rutaMax="assets/img/app/logo/";
            unlink($rutaMax . $_POST['deleteImage']);
        }   
    }
	
	public function uploadImageGallery(){
		
		$con = 0;
  		foreach ($_FILES as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$nombre = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos la dirrecion del archivo
      			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				$fecha = new DateTime();
				$nombreTimeStamp = $fecha->getTimestamp();
				
				$ruta="assets/img/app/partner/gallery/";
				
				$nameGallery = "gallery_" . $nombreTimeStamp . $con . ".jpg";
				
				//subimos la imagen de galleria	
				move_uploaded_file($temporal, $ruta . $nameGallery);
					
					echo $nameGallery . "*_*";
					
					$con++;
				
    		}else{
				
    		}
		}
		
	}
  
}
