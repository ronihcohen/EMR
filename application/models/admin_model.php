<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	function getAllData($start,$limit,$sidx,$sord,$where){
	    $this->db->select('id,username,group_id');
	    $this->db->limit($limit);
	    if($where != NULL)
	        $this->db->where($where,NULL,FALSE);
	    $this->db->order_by($sidx,$sord);
	    $query = $this->db->get('users',$limit,$start);

	    return $query->result();
	}

	function del($id){
		$this->db->delete('users', array('id' => $id));
	}

	function edit($username,$group_id,$id){
		$data = array(
   			'username' =>$username ,
  			'group_id' => $group_id ,
		);

		$this->db->where('id', $id);
		$this->db->update('users', $data);
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


