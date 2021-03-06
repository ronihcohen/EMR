<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	function get_users($start,$limit,$sidx,$sord,$where){
	    $this->db->select('users.id as id,username,groups.id as group_id,groups.group_name');
	    $this->db->limit($limit);
	    if($where != NULL)
	        $this->db->where($where,NULL,FALSE);
	    $this->db->order_by($sidx,$sord);
	    $this->db->join('groups', 'groups.id = users.group_id');
	    $query = $this->db->get('users',$limit,$start);

	    return $query->result();
	}

	function get_groups($start,$limit,$sidx,$sord,$where){
	    $this->db->select('*');
	    $this->db->limit($limit);
	    if($where != NULL)
	        $this->db->where($where,NULL,FALSE);
	    $this->db->order_by($sidx,$sord);
	    $query = $this->db->get('groups',$limit,$start);

	    return $query->result();
	}

	function delUser($id){
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
	function permissionsPerUsers($id){ // permissions per users
		$this->db->select('permissions.name,permissions.id');
		$this->db->from('permissions_groups');
		$this->db->join('permissions', 'permissions.id = permissions_groups.permission_id');
		$this->db->join('users', 'users.group_id = permissions_groups.group_id');
		$this->db->where('users.id',$id);

	    $query = $this->db->get();

		return $query->result();

	}

	function permissionsPerGroups($id){ // permissions per groups
		$this->db->select('permissions.name,permissions.id');
		$this->db->from('permissions_groups');
		$this->db->join('permissions', 'permissions.id = permissions_groups.permission_id');
		$this->db->where('permissions_groups.group_id',$id);

	    $query = $this->db->get();

		return $query->result();
	}

	function permissions(){ // permissions per groups
		$this->db->select('*');
		$this->db->from('permissions');
	    $query = $this->db->get();
		return $query->result();
	}

	function addPermissionToGroup($group_id,$permission_id){
		if (!$this->permission_group_exists($group_id,$permission_id))
		{
			$data = array(
			   'group_id' => $group_id ,
			   'permission_id' => $permission_id ,
			);

			$this->db->insert('permissions_groups', $data); 
		}
	}

	function permission_group_exists($group_id,$permission_id){
	    $this->db->where('group_id',$group_id);
	    $this->db->where('permission_id',$permission_id);
	    $query = $this->db->get('permissions_groups');
	    if ($query->num_rows() > 0){
	        return true;
	    }
	    else{
	        return false;
	    }
	}

	function delPermissionFromGroup($group_id,$permission_id){
	    $this->db->where('group_id',$group_id);
	    $this->db->where('permission_id',$permission_id);
	    $this->db->delete('permissions_groups');
	}

};


