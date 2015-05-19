<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';


/**
 * The Saving coupon
 * Author: Alberto Vera Espitia
 * GeekBucket 2014
 *
 */
class Api extends REST_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->model('api_db');
    }

	public function index_get(){
        $this->load->view('web/vwApi');
    }
    
	/**
	 * Registrar Usuarios
	 */
	 
	 public function createUser_get() { 
        // Verificamos parametros y acceso
        $message = null;
        if ($message == null) {
            // Obtener cupones
            if ($this->get('fbId') == ''){
                $data = $this->api_db->verifyEmail($this->get('email'));
                if (count($data) > 0){
                    $message = array('success' => false, 'message' => 'El email ya fue registrado anteriormente.');
                }else{
                    $idApp = $this->api_db->insert(array('email' => $this->get('email'), 'password' => $this->get('password')));
                    $message = array('success' => true, 'idApp' => $idApp, 'message' => 'El usuario fue registrado exitosamente');
                }
            }else{
                // Usuario de FaceBook
                $data = $this->api_db->verifyEmail($this->get('email'));
					if($this->get('birthday')){
						$birthday = $this->formatDate($this->get('birthday'));
					} else {
						$birthday = "0000-00-00";
					}
                if (count($data) > 0){
                    $this->api_db->update(array('email' => $this->get('email'), 'name' => $this->get('name'), 'fbId' => $this->get('fbId'), 'birthday' => $birthday));
                    $message = array('success' => true, 'idApp' => $data[0]->id, 'message' => 'El usuario fue registrado exitosamente');
                }else{
                    $idApp = $this->api_db->insert(array('email' => $this->get('email'), 'name' => $this->get('name'), 'fbId' => $this->get('fbId'), 'birthday' => $birthday));
                    $message = array('success' => true, 'idApp' => $idApp, 'message' => 'El usuario fue registrado exitosamente');
                }
            }
        }
        $this->response($message, 200);
    }
	
	/**
     * Crear Usuario
     */
    public function validateUser_get() { 
        // Verificamos parametros y acceso
        $message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
            // Obtener cupones
            $data = $this->api_db->verifyEmailPass($this->get('email'), $this->get('password'));
            if (count($data) > 0){
                $message = array('success' => true, 'message' => 'Usuario correcto', 'items' => $data);
            }else{
                $message = array('success' => false, 'message' => 'El usuario o password es incorrecto.');
            }
        }
        $this->response($message, 200);
    }
	
	/**
	 * Descuenta un cupon de la lista
	 */
	 public function discountCoupon_get(){
		//verificamos que existan cupones disponibles
		$message = $this->verifyIsSet(array('idApp'));
		if($message == null){
			$data = $this->api_db->verifyStockCoupon($this->get('idCoupon'));
			if( count($data) > 0 && $data[0]->stock > 0){
				
				$stock = $data[0]->stock - 1;
				
				$update = array(
					'id' 	=> $this->get('idCoupon'),
   					'stock' 	=> $stock,
				);
				
				$message = $this->api_db->updateStock($update);
				
				$code = $this->get('idApp') . $this->getRandomCode() . $this->get('idCoupon');
				
				$hoy = getdate();
				$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];
				
				$insert = array(
					'idCliente' => $this->get('idApp'),
					'idCupon'	=> $this->get('idCoupon'),
					'idEvent'	=> "",
					'code'		=> $code,
					'date' 		=> $strHoy,
					'status'	=> 1
				);
				
				$message = $this->api_db->insertClienteCoupon($insert);
				
				$message = array('success' => true, 'message' => 'Cupon añadido');
				
			}else{
				$message = array('success' => false, 'message' => 'Coupon no disponible o agotado');
			}
		}
		$this->response($message, 200);
	 }
    
    /**
     * Obtiene todos los deals del dia por  usuario
     */
    public function getRecommended_get(){
        $deals = $this->sortSliceArray($this->api_db->getTodayDeal($this->get('idApp'),$this->get('city')), 3);  
        foreach ($deals as $item): 
            $item->rowType = 'deal';
            $item->path = 'assets/img/app/deal/';
			if( $item->idCliente == ""){
				$item->assigned = 0;
			}else{
				$item->assigned = 1;
			}
		endforeach;
        
        $events = $this->sortSliceArray($this->api_db->getAllEvent($this->get('city')), 3);  
		foreach ($events as $item):
            $item->rowType = 'event';
            $item->path = 'assets/img/app/event/';
			if($item->partnerId != null){
				$item->type = "partner";
			} else {
				$item->type = "place";
			}
        endforeach;
        
        // Merge items
        $items = array_merge($events, $deals);
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }
	
    /**
     * Obtiene todos los eventos del dia por  usuario
     */
    public function getTodayEvent_get(){
        $items = $this->sortSliceArray($this->api_db->getAllEvent($this->get('city')), 3);  
		foreach ($items as $item):
			if($item->partnerId != null){
				$item->type = "partner";
			} else {
				$item->type = "place";
			}
        endforeach;
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }
    
    /**
     * Obtiene todos los deals del dia por  usuario
     */
    public function getTodayDeal_get(){
        $items = $this->sortSliceArray($this->api_db->getTodayDeal($this->get('idApp')), 3);  
        foreach ($items as $item): 
			if( $item->idCliente == ""){
				$item->assigned = 0;
			}else{
				$item->assigned = 1;
			} 
		endforeach;
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }

    /**
     * Obtiene todos los eventos disponibles
     */
    public function getAllEvent_get(){
        $items = $this->api_db->getAllEvent($this->get('city'));
		foreach ($items as $item):
            $item->path = 'assets/img/app/event/';
			if($item->partnerId != null){
				$item->type = "partner";
			} else {
				$item->type = "place";
			}
        endforeach;
		$filter = $this->api_db->getFilterActiveEvent();
        $message = array('success' => true, 'items' => $items, 'filter' => $filter);
        $this->response($message, 200);
    }
    
    /**
     * Obtiene todos los deals disponibles
     */
    public function getAllDeal_get(){
        $items = $this->api_db->getAllDeal($this->get('idApp'),$this->get('city'));
        foreach ($items as $item): 
            $item->path = 'assets/img/app/deal/';
			if( $item->idCliente == ""){
				$item->assigned = 0;
			}else{
				$item->assigned = 1;
			} 
		endforeach;
		$filter = $this->api_db->getFilterActiveDeals();
        $message = array('success' => true, 'items' => $items, 'filter' => $filter);
        $this->response($message, 200);
    }
    
    /**
     * Obtiene el comercio por id
     */
    public function redemptionDeal_get(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];
        $items = $this->api_db->redemptionDeal(array('code' => $this->get('code'), 'redemptionDate' => $strHoy, 'status' => 2));
        $message = array('success' => true, 'date'=>$strHoy);
        $this->response($message, 200);
    }
    
    /**
     * Obtiene el comercio por id
     */
    public function getPartnertById_get(){
        $items = $this->api_db->getPartnertById($this->get('idPartner'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }
    
    /**
     * Obtiene el comercio por id
     */
    public function getAdPartner_get(){
        $items = $this->api_db->getAdPartner($this->get('idAd'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }
    
    /**
     * Obtiene todos los deals del dia por  usuario
     */
    public function getMyDeals_get(){
        $items = $this->api_db->getMyDeals($this->get('idApp'),$this->get('city'));
        foreach ($items as $item): $item->assigned = 1; endforeach;
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }
	
	/**
	 * Obtiene los deals por el comercio
	 */
	 public function getDealsByPartner_get(){
		$items = $this->api_db->getDealsByPartner($this->get('idPartner'),$this->get('city'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	 }
	 
	 /**
	 * Obtiene la galeria del comercio
	 */
    
	public function getGallery_get(){
		$items = $this->api_db->getGallery($this->get('idPartner'),$this->get('type'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * Obtiene un cupon por medio del id
	 */
	
	public function getCouponById_get(){
		$items = $this->api_db->getCouponById($this->get('idCoupon'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
     * Obtiene las notificaciones del usuario
     */
	
	public function getNotifications_get(){
		$items = $this->api_db->getNotifications($this->get('idApp'));
		$items2 = array();
		
		foreach($items as $item):
			if( $item->tipo ==  1){
				$item->path = "assets/img/app/event/";
				$event = $this->api_db->getEventbyId($item->idRelacional);
				foreach($event as $eventItem):
					$item->id 			= $eventItem->id;
					$item->name 		= $eventItem->name;
					$item->partnerId 	= $eventItem->partnerId;
					$item->detail 		= $eventItem->detail;
					$item->iniDate		= $eventItem->iniDate;
					$item->image 		= $eventItem->image;
					$item->imageFull 	= $eventItem->imageFull;
					$item->place 		= $eventItem->place;
					$item->address 		= $eventItem->address;
					$item->latitude 	= $eventItem->latitude;
					$item->longitude 	= $eventItem->longitude;
					$item->placeImage 	= $eventItem->placeImage;
					$item->placeBanner 	= $eventItem->placeBanner;
					$item->typeId 		= $eventItem->typeId;
					$item->typeId 		= $eventItem->typeId;
					if($eventItem->partnerId != null){
						$item->type = "partner";
					} else {
						$item->type = "place";
					}
				endforeach;
			}else{
				$item->path = "assets/img/app/deal/";
				
				$deals = $this->api_db->getCouponById($item->idRelacional);
				foreach($deals as $dealsItem):
					$item->id 			= $dealsItem->id;
					$item->name 		= $dealsItem->name;
					$item->detail 		= $dealsItem->detail;
					$item->image 		= $dealsItem->image;
					$item->total 		= $dealsItem->total;
					$item->stock 		= $dealsItem->stock;
					$item->clauses 		= $dealsItem->clauses;
					$item->validity 	= $dealsItem->validity;
					$item->partnerId 	= $dealsItem->partnerId;
					$item->partner 		= $dealsItem->partner;
					$item->address 		= $dealsItem->address;
					$item->assigned 	= 0;
				endforeach;
				
			}
		endforeach;
		
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * Obtiene las notificaciones no leidas
	 */
	public function getNotificationsUnRead_get(){
		$items = $this->api_db->getNotificationsUnRead($this->get('idApp'));
		$items = count($items);
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * marca la notificacion como leido
	 */
	public function notificationRead_get(){
		$update = array(
			'id' 	=> $this->get('idNotification'),
			'leido'	=> 0
		);
		$message = $this->api_db->notificationRead($update);
	}
	
	/**
	 * Obtiene las busquedas del eventos
	 */
	public function getSearchEvent_get(){
		$items = $this->api_db->getSearchEvent($this->get('texto'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	 
	public function getSearchCoupon_get(){
		$items = $this->api_db->getSearchCoupon($this->get('texto'),$this->get('idApp'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * obtiene si el cupon ha sido descargado
	 */
	 
	public function getCouponDownload_get(){
		$items = $this->api_db->getCouponDownload($this->get('idApp'),$this->get('idCoupon'));
		$message = array('success' => true, 'items' => $items, );
		$this->response($message, 200);
	}
	
	/**
	 * obtiene las ciudades participantes
	 */
	public function getCity_get(){
		$items = $this->api_db->getCity();
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * obtiene el nombre de la ciudad
	 */
	public function getCityById_get(){
		$items = $this->api_db->getCityById($this->get('city'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * obtiene el nombre de la ciudad
	 */
	public function getBeacons_get(){
		$items = $this->api_db->getBeacons();
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * obtenie los resultados del filtro
	 */
	public function getFilter_get(){
		$message = $this->verifyIsSet(array('idApp'));
		if($message == null){
			$items = "";
			if($this->get('type') == 1 || $this->get('type') == "1"){
				if($this->get('idFilter') == 0){
					$items = $this->api_db->getAllEvent($this->get('city'));
				}else{
					$items = $this->api_db->getFilterEvent($this->get('idFilter'),$this->get('city'));
				}
			} else {
				if($this->get('idFilter') == 0){
					$items = $this->api_db->getAllDeal($this->get('idApp'),$this->get('city'));
				}else{
					$items = $this->api_db->getFilterCoupon($this->get('idApp'), $this->get('idFilter'),$this->get('city'));
				}
			}
			$message = array('success' => true, 'items' => $items);
		}
        $this->response($message, 200);
	}
	
	/**
	 * obtiene los deals redimidos de un mes
	 */
	public function getDealsRedimir_get(){
		$items = $this->api_db->getDealsRedimir($this->get('idApp'));
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/**
	 * Comparte el deals por facebook
	 */
	public function shareDealsByFace_get(){
		$message = $this->verifyIsSet(array('idApp'));
		if($message == null){
			//consulta para obtener el id del amigo
			$idUser2 = $this->api_db->getIdByIdFriend($this->get('idFriend'));
			if(count($idUser2) > 0){
				//verifica que el usuario no haya descargado el deals
				$share = $this->api_db->getDealsShare($idUser2[0]->id, $this->get('idCoupon'));
				if(count($share) == 0){
					
					//verifica que existan deals disponibles
					$data = $this->api_db->verifyStockCoupon($this->get('idCoupon'));
					if( count($data) > 0 && $data[0]->stock > 0){
						
						$stock = $data[0]->stock - 1;
				
						$update = array(
							'id' 	=> $this->get('idCoupon'),
							'stock' 	=> $stock,
						);
				
						$message = $this->api_db->updateStock($update);
					
						$hoy = getdate();
						$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];
					
						$code = $this->get('idApp') . $this->getRandomCode() . $this->get('idCoupon');
					
						$insertC = array(
							'idCliente' 	=> $this->get('idApp'),
							'idCupon' 		=> $this->get('idCoupon'),
							'idEvent'		=> 0,
							'code'		=> $code,
							'date' 			=> $strHoy,
							'status' 		=> 3
						);
					
						$code = $idUser2[0]->id . $this->getRandomCode() . $this->get('idCoupon');
					
						$insertD = array(
							'idCliente' 	=> $idUser2[0]->id,
							'idCupon' 		=> $this->get('idCoupon'),
							'idEvent'		=> 0,
							'code'		=> $code,
							'date' 			=> $strHoy,
							'status' 		=> 1
						);
					
						//$fechaA = date("Y") . "/" . date("m") . "/" . date("d");
					
						$insertN = array(
							'tipo' => 2,
							'idRelacional' => $this->get('idCoupon'),
							'idUsuario' => $idUser2[0]->id,
							'leido' => 1,
							'fecha' => $strHoy
						);
					
						//inserta el deals
						$data = $this->api_db->insertDealShare($insertC, $insertD, $insertN);
						$message = array('success' => true, 'share' => true, 'message' => 'Se ha compartido el deal');
					
					}else{
						$message = array('success' => true, 'share' => false, 'message' => 'Ya no existen deals disponibles.');
					}
				}else{
					$message = array('success' => true, 'share' => false, 'message' => 'El usuario ya cuenta con el deals');
				}
				
			}else{
				$message = array('success' => true, 'share' => false, 'message' => 'Error al compartir el deal');
			}
			$this->response($message, 200);
		}
	}
	
	/**
	 * comparte el deals por correo
	 */
	public function shareDealsByEmail_get(){
		$message = $this->verifyIsSet(array('idApp'));
		if($message == null){
			//consulta para obtener el id del amigo
			$idUser2 = $this->api_db->getIdByEmailFriend($this->get('email'));
			if(count($idUser2) > 0){
				$share = $this->api_db->getDealsShare($idUser2[0]->id, $this->get('idCoupon'));
				
				if(count($share) == 0){
					
					//verifica que existan deals disponibles
					$data = $this->api_db->verifyStockCoupon($this->get('idCoupon'));
					if( count($data) > 0 && $data[0]->stock > 0){
						
						//$user =  $this->api_db->getUserInfo($this->get('idApp'));
						
						$stock = $data[0]->stock - 1;
				
						$update = array(
							'id' 	=> $this->get('idCoupon'),
							'stock' 	=> $stock,
						);
				
						$message = $this->api_db->updateStock($update);
					
						$hoy = getdate();
						$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];
					
						$code = $this->get('idApp') . $this->getRandomCode() . $this->get('idCoupon');
					
						$insertC = array(
							'idCliente' 	=> $this->get('idApp'),
							'idCupon' 		=> $this->get('idCoupon'),
							'idEvent'		=> 0,
							'code'		=> $code,
							'date' 			=> $strHoy,
							'status' 		=> 3
						);
					
						$code = $idUser2[0]->id . $this->getRandomCode() . $this->get('idCoupon');
					
						$insertD = array(
							'idCliente' 	=> $idUser2[0]->id,
							'idCupon' 		=> $this->get('idCoupon'),
							'idEvent'		=> 0,
							'code'		=> $code,
							'date' 			=> $strHoy,
							'status' 		=> 1
						);
					
						//$fechaA = date("Y") . "/" . date("m") . "/" . date("d");
					
						$insertN = array(
							'tipo' => 2,
							'idRelacional' => $this->get('idCoupon'),
							'idUsuario' => $idUser2[0]->id,
							'leido' => 1,
							'fecha' => $strHoy
						);
					
						//inserta el deals
						$data = $this->api_db->insertDealShare($insertC, $insertD, $insertN);
						
						$user =  $this->api_db->getUserInfo($this->get('idApp'));
						$menssage ="el usuario: " . $user[0]->email . " ha compartido un deals contigo, puedes visualizarlo en tu cartera en Go Deals." ;
						$resultEmail = $this->DealsEmail($this->get('email'),$user[0]->name,$user[0]->email,$menssage);
						
						$message = array('success' => true, 'share' => true, 'message' => 'Se ha compartido el deal');
					}else{
						$message = array('success' => true, 'share' => false, 'message' => 'Ya no existen deals disponibles.');
					}
				}else{
					$message = array('success' => true, 'share' => false, 'message' => 'El usuario ya cuenta con el deals');
				}
			}else{
				$user =  $this->api_db->getUserInfo($this->get('idApp'));
				$menssage ="el usuario: " . $user[0]->email . " ha querido compartir un deals contigo, para poder descargarlo descarga la aplicacion Go Deals disponible en Google Play y App Stores</br> godeals.mx" ;
				$resultEmail = $this->DealsEmail($this->get('email'),$user[0]->name,$user[0]->email,$menssage);
				$message = array('success' => true, 'share' => false, 'message' => 'Se ha compartido el deal');
			}
			$this->response($message, 200);
		}
	}
	
	/**
	 * Obtiene el formato de fecha correcto
	 */
	public function formatDate($birthday){
		
		$fechaA = $birthday;
		$fechaN = explode("-", $fechaA);
		if(count($fechaN) == 3){
			$fecha = $fechaN[2] . "-" . $fechaN[0] . "-" . $fechaN[1];
		}else{
			$fecha = "0000-00-00";
		}
		
		return $fecha;
	}
	
    /**
     * Obtiene un array sorting and sliced
     */
    public function sortSliceArray($array, $count){
        shuffle($array);
        if (count($array) > $count){
            $array = array_slice($array, 0, $count);
        }
        return $array;
    }

    /************** metodo generico ******************/
	
	/**
     * Verificamos si las variables obligatorias fueron enviadas
     */
    private function verifyIsSet($params){
    	foreach ($params as &$value) {
		    if ($this->get($value) ==  '')
		    	return array('success' => false, 'message' => 'El parametro '.$value.' es obligatorio');
		}
		return null;
    }
    
    /**
	 * Generamos codigo aleatorios
	 */
	 
	public function getRandomCode(){
        $an = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);
    }
	
	//envia correo del deals compartido
	public function DealsEmail($destinatario,$name,$email,$menssage){
    	
        // título
        $título = 'Go Deals: Deals compartido';

        // mensaje
        $mensaje = '
        <html>
            <body>
                <div style="width:100%; height:80px; background: #212121 url(http://godeals.mx/web/assets/img/web/logo.png) no-repeat center left; font-size:50px; color:#ffffff; padding: 20px 0 0 250px; ">
                    Contacto
                </div>
                <div style="width:100%; height:5px; background: #5ec62b;"></div>

                <div style="width:100%; margin: 20px 0;">
                    <h3>' . $name . '</h3>
					<h4>' . $email . '</h4>

                    <p style="font-family:Georgia; font-size:18px;">' . $menssage . '</p>

                </div>

                <div style="width:100%; height:5px; background: #5ec62b;"></div>
                <div style="width:100%; height:60px; background: #212121; font-size:18px; font-weight: bold; color:#ffffff;">
                    <div style="margin-left: 10px; display: inline-block; line-height: 60px; width:400px; background: url(http://godeals.mx/web/assets/img/web/logo.png) no-repeat center right;">DERECHOS RESERVADOS 2015</div>
                    <div style="margin-left: 10px; display: inline-block; line-height: 60px;">CANCUN QUINTANA ROO MEXICO</div>
                </div>
            </body>
        </html>
        ';

        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        //$cabeceras .= 'From: '.$name.' <'.$email.'>';
		$cabeceras .= 'From: '.$name.' <'.$email.'>';

        // Enviarlo
		//mail('conomia_alfredo@hotmail.com', $título, $mensaje, $cabeceras);
		mail($destinatario, $título, $mensaje, $cabeceras);
		return true;
		
    }
	
	
}