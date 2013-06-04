<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Patients_model extends CI_Model
{
	function getAllData($start,$limit,$sidx,$sord,$where){
	    $this->db->select('id,first_name,last_name');
	    $this->db->limit($limit);
	    if($where != NULL)
	        $this->db->where($where,NULL,FALSE);
	    $this->db->order_by($sidx,$sord);
	    $query = $this->db->get('patients',$limit,$start);

	    return $query->result();
	}

	function del($id){
		$this->db->delete('patients', array('id' => $id));
	}

	function add($first_name,$last_name){
		$data = array(
   			'first_name' =>$first_name ,
  			'last_name' => $last_name ,
  		);

		$this->db->insert('patients', $data); 
	}
	function edit($first_name,$last_name,$id){
		$data = array(
   			'first_name' =>$first_name ,
  			'last_name' => $last_name ,
		);

		$this->db->where('id', $id);
		$this->db->update('patients', $data);
	}
	function diagnosis($id){ // diagnosis per patient
		$this->db->select('*');
		$this->db->from('patients_diagnosis');
		$this->db->join('diagnosis', 'patients_diagnosis.diagnosis_id = diagnosis.id');
		$this->db->where('patients_id',$id);

		$query = $this->db->get();

		return $query->result();

	}


};


