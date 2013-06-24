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
	function permissions($id){ // permissions per users
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('permissions_groups', 'permissions_groups.group_id = users.group_id');
		$this->db->join('permissions', 'permissions_groups.permission_id = permissions.id');
		$this->db->where('users.id',$id);

	    $query = $this->db->get();

		return $query->result();

	}


};


