<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('dashboard_db');
		$this->load->library('excel_pdf_manager');
        if ($this->session->userdata('type') == 1 || !$this->session->userdata('type')) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        $data['page'] = 'dashboard';
		$data['nameUser'] = $this->session->userdata('username'); 
		$data['DealsD'] = $this->sliceArray($this->dashboard_db->getDealsDescargados(), 10);
        $data['DealsR'] = $this->sliceArray($this->dashboard_db->getDealsRedimidos(), 10);
        $data['DealsActivos'] = $this->dashboard_db->getDealsActivos()[0]->total;
        $data['TotalUser'] = $this->dashboard_db->getTotalUser()[0]->total;
        $this->load->view('admin/vwDashboard',$data);
	}
    
    /**
     * Obtiene los datos de la grafica
     */
    public function getDownloadAll(){
		if($this->input->is_ajax_request()){
            $array = $this->dashboard_db->getDownloadAll();
            
            $label = array();
            $total = array();
            $months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
            // Set extra data
            foreach ($array as $item):
                array_push($label, date('d', strtotime($item->fecha)) . '-' . $months[date('n', strtotime($item->fecha))]);
                array_push($total, $item->total);
            endforeach;
            
            echo json_encode(array('label' => $label, 'total' => $total));
        }
	}
    
    /**
     * Obtiene los datos de la grafica
     */
    public function getRedimidosAll(){
		if($this->input->is_ajax_request()){
            $array = $this->dashboard_db->getRedimidosAll();
            
            $label = array();
            $total = array();
            $months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
            // Set extra data
            foreach ($array as $item):
                array_push($label, date('d', strtotime($item->fecha)) . '-' . $months[date('n', strtotime($item->fecha))]);
                array_push($total, $item->total);
            endforeach;
            
            echo json_encode(array('label' => $label, 'total' => $total));
        }
	}
    
    /**
     * Obtiene los datos de la grafica
     */
    public function getNewUsuariosAll(){
		if($this->input->is_ajax_request()){
            $array = $this->dashboard_db->getNewUsuariosAll();
            
            $label = array();
            $total = array();
            $months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
            // Set extra data
            foreach ($array as $item):
                array_push($label, date('d', strtotime($item->fecha)) . '-' . $months[date('n', strtotime($item->fecha))]);
                array_push($total, $item->total);
            endforeach;
            
            echo json_encode(array('label' => $label, 'total' => $total));
        }
	}
    
    /**
     * Obtiene los datos de la grafica
     */
    public function getActivesAll(){
		if($this->input->is_ajax_request()){
            $array = $this->dashboard_db->getActivesAll();
            
            $label = array();
            $total = array();
            $months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
            // Set extra data
            foreach ($array as $item):
                array_push($label, date('d', strtotime($item->fecha)) . '-' . $months[date('n', strtotime($item->fecha))]);
                array_push($total, $item->total);
            endforeach;
            
            echo json_encode(array('label' => $label, 'total' => $total));
        }
	}
    
    /**
     * Obtiene un array Sliced
     */
    public function sliceArray($array, $count){
        // Slice
        if (count($array) > $count){
            $array = array_slice($array, 0, $count);
        }
        return $array;
    }
	
	/**
	 * Obtiene el todal de deals descargado por fecha
	 */
	public function getDealsDescargadosDate(){
		if($this->input->is_ajax_request()){
			$data = $this->dashboard_db->getDealsDescargadosDate($_POST['iniDate'],$_POST['endDate'],$_POST['type']);
			echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene el todal de deals redimidos por fecha
	 */
	public function getDealsRedimidosDate(){
		if($this->input->is_ajax_request()){
			$data = $this->dashboard_db->getDealsRedimidosDate($_POST['iniDate'],$_POST['endDate'],$_POST['type']);
			echo json_encode($data);
		}
	}
	
}