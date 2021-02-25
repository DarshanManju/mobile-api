<?php
class Api_model extends CI_Model
{
	function fetch_all()
	{
		$this->db->order_by('id', 'DESC');
		return $this->db->get('tbl_sample');
	}

	function insert_api($data)
	{
		$this->db->insert('tbl_sample', $data);
	}

	function fetch_single_user($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get('tbl_sample');
		return $query->result_array();
	}

	function update_api($user_id, $data)
	{
		$this->db->where('id', $user_id);
		$this->db->update('tbl_sample', $data);
	}

	function delete_single_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete('tbl_sample');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function fetch_all_users()
	{
		$this->db->order_by('id', 'DESC');
		return $this->db->get('users');
	}

	function insert_user($data)
	{
		$this->db->insert('users', $data);
	}

	function check_user_exists($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		return $query->result_array();
	}

	function check_user_login_data($email, $password)
	{
		$this->db->where(['email' => $email, 'password' => $password]);
		$query = $this->db->get('users');
		return $query->result_array();
	}

	function insert_user_login_otp($data)
	{
		$this->db->insert('user_signin_otp', $data);
	}	

	function check_otp($user_id, $otp)
	{
		$this->db->where(['user_id' => $user_id, 'otp' => $otp]);
		$query = $this->db->get('user_signin_otp');
		return $query->row_array();
	}
}

?>