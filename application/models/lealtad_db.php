<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class lealtad_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
	
	/////////////actual////////////////
	
	//obtiene todos los deals activos
	public function getAllCampana(){
        $this->db->select('lealtad_campana.id, lealtad_campana.nombre, lealtad_campana.status');
		$this->db->select('partner.name as partnerName');
		$this->db->select('(select count(*) from lealtad_recompensa where lealtad_campana.id = lealtad_recompensa.lealtadCampanaId) as recompensa');
        $this->db->from('lealtad_campana');
        $this->db->join('partner', 'lealtad_campana.partnerId = partner.id ');
        $this->db->where('(lealtad_campana.status = 1 || lealtad_campana.status = -1)');
		$this->db->order_by("id", "asc");
		
		return $this->db->get()->result();
    }
	
	/**
	* obtiene la descripcion, clientes y ubicacion de la busqueda relacionada
	**/
	public function getallSearchCampana($dato,$column,$order){
		$this->db->select('lealtad_campana.id, lealtad_campana.nombre, lealtad_campana.status');
		$this->db->select('partner.name as partnerName');
		$this->db->select('(select count(*) from lealtad_recompensa where lealtad_campana.id = lealtad_recompensa.lealtadCampanaId) as recompensa');
        $this->db->from('lealtad_campana');
        $this->db->join('partner', 'lealtad_campana.partnerId = partner.id ');
        $this->db->where('(lealtad_campana.status = 1 || lealtad_campana.status = -1)');
		$this->db->where('(lealtad_campana.nombre LIKE \'%'.$dato.'%\' OR partner.name LIKE \'%'.$dato.'%\')', NULL); 
		$this->db->order_by($column , $order);
        return  $this->db->get()->result();
	}
	
	//obtiene un deal por id
	public function getId($id){
        $this->db->select('lealtad_campana.id, lealtad_campana.nombre, lealtad_campana.descripcion');
		$this->db->select('lealtad_campana.status, lealtad_campana.partnerId');
		$this->db->select('partner.name as partnerName');
        $this->db->from('lealtad_campana');
        $this->db->join('partner', 'lealtad_campana.partnerId = partner.id ');
        $this->db->where('lealtad_campana.id = ', $id);
        return  $this->db->get()->result();
    }
	
	//obtiene las recompensas de la campaña
	public function getRecompensaCampana($id){
		$this->db->select('lealtad_recompensa.id,lealtad_recompensa.nombre,lealtad_recompensa.cantidadVigencia');
		$this->db->select('lealtad_status_recompensas.nombre as nombreStatus, lealtad_recompensa.lealtadStatusRecompensasId');
		$this->db->select('lealtad_tipos_vigencia.nombre as nombreVigencia');
		$this->db->from('lealtad_recompensa');
        $this->db->join('lealtad_status_recompensas', 'lealtad_status_recompensas.id = lealtad_recompensa.lealtadStatusRecompensasId ');
		$this->db->join('lealtad_tipos_vigencia', 'lealtad_tipos_vigencia.id = lealtad_recompensa.lealtadTiposVigenciaId');
		$this->db->where('lealtad_recompensa.lealtadCampanaId = ', $id);
		$this->db->where('lealtad_recompensa.lealtadStatusRecompensasId != 0');
		return  $this->db->get()->result();
	}
	
	//obtiene las recompensas pendientes a publicar
	public function pendingAuthorizations($status){
		$this->db->select('lealtad_recompensa.id, lealtad_recompensa.nombre, lealtad_recompensa.lealtadStatusRecompensasId');
		$this->db->select('lealtad_campana.partnerId, lealtad_campana.nombre as campanaNombre');
		$this->db->select('partner.name as namePartner, lealtad_status_recompensas.nombre as nameStatus');
		$this->db->from('lealtad_recompensa');
		$this->db->join('lealtad_campana', 'lealtad_campana.id = lealtad_recompensa.lealtadCampanaId');
		$this->db->join('partner', 'partner.id = lealtad_campana.partnerId');
		$this->db->join('lealtad_status_recompensas', 'lealtad_recompensa.lealtadStatusRecompensasId = lealtad_status_recompensas.id');
		$this->db->where('lealtad_recompensa.lealtadStatusRecompensasId = ', $status);
		$this->db->where('lealtad_campana.status = 1');
		return  $this->db->get()->result();
	}
	
	//obtiene las reglas de una recompensa
	public function requirementsAuthorizations($id){
		$this->db->select('xref_recompensas_regla.nombre as nameRule, xref_recompensas_regla.cantidadRequerida, lealtad_reglas.nombre, xref_recompensas_regla.lealtadReglasId');
		$this->db->from('xref_recompensas_regla');
		$this->db->join('lealtad_reglas', 'lealtad_reglas.id = xref_recompensas_regla.lealtadReglasId');
		$this->db->where('xref_recompensas_regla.lealtadRecompensaId = ',$id);
		return  $this->db->get()->result();
	}
	
	//obtiene los datos de la recompensa de campaña por id
	public function getRewardCampanaById($id){
		$this->db->select('lealtad_recompensa.id, lealtad_recompensa.nombre, lealtad_recompensa.cantidadVigencia');
		$this->db->select('lealtad_recompensa.lealtadCampanaId, lealtad_recompensa.fechaInicio, lealtad_recompensa.fechaTermino');
		$this->db->select('lealtad_recompensa.lealtadTiposVigenciaId');
		$this->db->select('lealtad_recompensa.lealtadStatusRecompensasId');
		$this->db->select('lealtad_tipos_vigencia.nombre as nameVigencia');
		$this->db->select('lealtad_status_recompensas.nombre as nameStatus');
		$this->db->from('lealtad_recompensa');
		$this->db->join('lealtad_tipos_vigencia', 'lealtad_recompensa.lealtadTiposVigenciaId = lealtad_tipos_vigencia.id');
		$this->db->join('lealtad_status_recompensas', 'lealtad_recompensa.lealtadStatusRecompensasId = lealtad_status_recompensas.id');
		$this->db->where('lealtad_recompensa.id = ',$id);
		return  $this->db->get()->result();
	}
	
	//obtiene los niveles de usuarios de la recompensa
	public function userLevelReward($id){
		$this->db->select('xref_nivelusuario_recompensa.id, xref_nivelusuario_recompensa.catNivelUsuariosId,');
		$this->db->select('xref_nivelusuario_recompensa.lealtadRecompensaId');
		$this->db->select('cat_nivel_usuarios.nombre');
		$this->db->from('xref_nivelusuario_recompensa');
		$this->db->join('cat_nivel_usuarios', 'cat_nivel_usuarios.id = xref_nivelusuario_recompensa.catNivelUsuariosId');
		$this->db->where('xref_nivelusuario_recompensa.lealtadRecompensaId = ',$id);
		return $this->db->get()->result();	
	}
	
	//obtiene los deals de la recompensa por id
	public function userDealslReward($id){
		$this->db->select('coupon.id, coupon.name');
		$this->db->from('xref_recompensa_deals');
		$this->db->join('coupon', 'coupon.id = xref_recompensa_deals.dealsId');
		$this->db->where('xref_recompensa_deals.recompensaId = ',$id);
		return $this->db->get()->result();
	}
	
	//inserta deals 
	public function insertCampana($data){
		$this->db->insert('lealtad_campana', $data);
	}
	
	//actualiza los datos del deals
	public function updateCampana($data){
		$this->db->where('id', $data['id']);
		$this->db->update('lealtad_campana', $data);
    }
	
	//elimina la campaña
	public function deleteCampana($data){
		$this->db->where('id', $data['id']);
		$this->db->update('lealtad_campana', $data);	
	}
	
	//inserta los datos de recompensas de una campana
	public function insertRewardCampana($data){
		$this->db->insert('lealtad_recompensa', $data);
		return $this->db->insert_id();
	}
	
	//inserta las referencias de regla y tipo de usuario
	public function insertXrefRecompensaCampana($insertR,$insertUL){
		$this->db->insert_batch('xref_recompensas_regla', $insertR);
		
		if(count($insertUL) > 0){
			$this->db->insert_batch('xref_nivelusuario_recompensa', $insertUL);	
		}	
	}
	
	public function deleteXrefRecompensaCampana($delete){
		$this->db->delete('xref_recompensas_regla',$delete);
		$this->db->delete('xref_nivelusuario_recompensa',$delete);
	}
	
	//actualiza los datos de la recompensa de las campañas
	public function updateRewardCampana($data){
		$this->db->where('id', $data['id']);
		$this->db->update('lealtad_recompensa', $data);
	}
	
	//aprueba la recompensa de la campaña selecionada
	public function approvedReward($data){
		$this->db->where('id', $data['id']);
		$this->db->update('lealtad_recompensa', $data);
	}
	
	/////////////////////////////////////////////////////
	
	//obtiene la busqueda de las autorizaciones
	public function getPendingAutoPa($dato,$column,$order){
		/*$this->db->select('lealtad_recompensa.id, lealtad_recompensa.nombre, lealtad_campana.nombre as campanaNombre');
		$this->db->select('partner.name as namePartner, lealtad_status_recompensas.nombre as nameStatus');
		$this->db->from('lealtad_recompensa');
		$this->db->join('lealtad_campana', 'lealtad_campana.id = lealtad_recompensa.lealtadCampanaId');
		$this->db->join('partner', 'partner.id = lealtad_campana.partnerId');
		$this->db->join('lealtad_status_recompensas', 'lealtad_recompensa.lealtadStatusRecompensasId = lealtad_status_recompensas.id');
        $this->db->where('lealtad_recompensa.lealtadStatusRecompensasId = 4');
		$this->db->where('lealtad_campana.status = 1');
		//$this->db->where('(lealtad_campana.nombre LIKE \'%'.$dato.'%\' OR partner.name LIKE \'%'.$dato.'%\')', NULL); 
		$this->db->order_by($column , $order);
        return  $this->db->get()->result();*/
		
		
		$this->db->select('lealtad_recompensa.id, lealtad_recompensa.nombre, lealtad_recompensa.lealtadStatusRecompensasId');
		$this->db->select('lealtad_campana.partnerId, lealtad_campana.nombre as campanaNombre');
		$this->db->select('partner.name as namePartner, lealtad_status_recompensas.nombre as nameStatus');
		$this->db->from('lealtad_recompensa');
		$this->db->join('lealtad_campana', 'lealtad_campana.id = lealtad_recompensa.lealtadCampanaId');
		$this->db->join('partner', 'partner.id = lealtad_campana.partnerId');
		$this->db->join('lealtad_status_recompensas', 'lealtad_recompensa.lealtadStatusRecompensasId = lealtad_status_recompensas.id');
		$this->db->where('lealtad_recompensa.lealtadStatusRecompensasId = ', $dato);
		$this->db->where('lealtad_campana.status = 1');
		$this->db->order_by($column , $order);
		return  $this->db->get()->result();
		
		
	}
	
	//////agrega los deals a la recompensa
	public function insertXrefRecompensaDeals($data, $id){
		$this->db->where('recompensaId', $id);
		$this->db->delete('xref_recompensa_deals');  
		$this->db->insert_batch('xref_recompensa_deals', $data);
	}
	
	///agrega 
	public function insertXrefProcesoAutorizacion($data){
		$this->db->insert('xref_recompensa_proceso_autorizacion', $data);
	}
	
	
	//////////////////recompensa/////////////////////
	
	/**
	 * Actualiza el status de la recompenza
	 */
	 
	public function shiftStatusReward($id,$data){
		$this->db->where('id', $id);
		$this->db->update('lealtad_recompensa', $data);
	}
	
	
	/**
	 * Obtiene los recompensas de todas las campañas
	 */
	public function getRewardCatalog(){
		$this->db->select('lealtad_recompensa.id, lealtad_recompensa.nombre, lealtad_recompensa.lealtadStatusRecompensasId');
		$this->db->select('lealtad_campana.partnerId, lealtad_campana.nombre as campanaNombre');
		$this->db->select('partner.name as namePartner, lealtad_status_recompensas.nombre as nameStatus');
		$this->db->from('lealtad_recompensa');
		$this->db->join('lealtad_campana', 'lealtad_campana.id = lealtad_recompensa.lealtadCampanaId');
		$this->db->join('partner', 'partner.id = lealtad_campana.partnerId');
		$this->db->join('lealtad_status_recompensas', 'lealtad_recompensa.lealtadStatusRecompensasId = lealtad_status_recompensas.id');
		$this->db->where('lealtad_recompensa.lealtadStatusRecompensasId != 0');
		$this->db->where('lealtad_campana.status != 0');
		return  $this->db->get()->result();
	}
	
	public function getAllSearchReward($dato2,$dato3,$dato4,$column,$order){
		$this->db->select('lealtad_recompensa.id, lealtad_recompensa.nombre, lealtad_campana.nombre as campanaNombre');
		$this->db->select('partner.name as namePartner, lealtad_status_recompensas.nombre as nameStatus');
		if($dato4 != 0){
			$this->db->select('xref_recompensas_regla.lealtadReglasId');
			$this->db->select('lealtad_reglas.nombre as nameRule');
		}
		$this->db->from('lealtad_recompensa');
		$this->db->join('lealtad_campana', 'lealtad_campana.id = lealtad_recompensa.lealtadCampanaId');
		$this->db->join('partner', 'partner.id = lealtad_campana.partnerId');
		$this->db->join('lealtad_status_recompensas', 'lealtad_recompensa.lealtadStatusRecompensasId = lealtad_status_recompensas.id');
		if($dato4 != 0){
			$this->db->join('xref_recompensas_regla', 'xref_recompensas_regla.lealtadRecompensaId = lealtad_recompensa.id');
			$this->db->join('lealtad_reglas', 'lealtad_reglas.id = xref_recompensas_regla.lealtadReglasId');
		}
		$this->db->where('lealtad_recompensa.lealtadStatusRecompensasId != 0');
		$this->db->where('lealtad_campana.status != 0');
		if($dato4 != 0){
			if($dato2 == "" && $dato3 == ""){
				$this->db->where('(lealtad_reglas.id LIKE \'%'.$dato4.'%\')', NULL);
			}else if($dato2 != "" && $dato3 != ""){
				$this->db->where('((partner.name LIKE \'%'.$dato2.'%\' AND lealtad_campana.nombre LIKE \'%'.$dato3.'%\') 
					AND lealtad_reglas.id LIKE \'%'.$dato4.'%\')', NULL);
			}else if($dato2 != "" && $dato3 == ""){
				$this->db->where('(partner.name LIKE \'%'.$dato2.'%\' AND lealtad_reglas.id LIKE \'%'.$dato4.'%\')', NULL);
			}else if($dato2 == "" && $dato3 != ""){
				$this->db->where('(lealtad_campana.nombre LIKE \'%'.$dato3.'%\' AND lealtad_reglas.id LIKE \'%'.$dato4.'%\')', NULL);
			}
		}else{
			if($dato2 != "" && $dato3 != ""){
				$this->db->where('(partner.name LIKE \'%'.$dato2.'%\' AND lealtad_campana.nombre LIKE \'%'.$dato3.'%\')', NULL);
			}else if($dato2 != "" && $dato3 == ""){
				$this->db->where('(partner.name LIKE \'%'.$dato2.'%\')', NULL);
			}else if($dato2 == "" && $dato3 != ""){
				$this->db->where('(lealtad_campana.nombre LIKE \'%'.$dato3.'%\')', NULL);
			}	
		}
		
		$this->db->order_by($column , $order);
		return  $this->db->get()->result();
	}

}
//end model