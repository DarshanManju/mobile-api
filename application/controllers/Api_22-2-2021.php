<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->library('form_validation');
	}

	function index()
	{
		$data = $this->api_model->fetch_all();
		echo json_encode($data->result_array());
	}

	function signup()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[20]|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[20]|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|max_length[20]|min_length[8]');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric|max_length[10]|min_length[10]');
		
		$email = $this->input->post('email');
		$check_email_exists = $this->api_model->check_user_exists($email);
		
		if($this->input->post('password') != $this->input->post('cpassword'))
		{
			$array = array(
				'error'					=>	true,
				'username_error'		=>	'',
				'email_error'	 		=>	'',
				'password_error' 		=>	'',
				'cpassword_error' 		=>	'Passwords are not matching. Please confirm the password.',
				'mobile_error'	 		=>	''
			);
		}
		elseif($check_email_exists)
		{
			$array = array(
				'error'					=>	true,
				'username_error'		=>	'',
				'email_error' 			=>	"Email - '".$email."' already exists in the database.",
				'password_error' 		=>	'',
				'cpassword_error' 		=>	'',
				'mobile_error'	 		=>	''
			);
		}
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$array = array(
				'error'					=>	true,
				'username_error'		=>	'',
				'email_error' 			=>	"Invalid email.",
				'password_error' 		=>	'',
				'cpassword_error' 		=>	'',
				'mobile_error'	 		=>	''
			);
		}elseif($this->form_validation->run())
		{
			$data = array(
				'username'	=>	$this->input->post('username'),
				'email'		=>	$this->input->post('email'),
				'password'	=>	$this->input->post('password'),
				'cpassword'	=>	$this->input->post('cpassword'),
				'mobile'	=>	$this->input->post('mobile')
			);

			$this->api_model->insert_user($data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{	
			$array = array(
				'error'					=>	true,
				'username_error'		=>	form_error('username'),
				'email_error'	 		=>	form_error('email'),
				'password_error' 		=>	form_error('password'),
				'cpassword_error' 		=>	form_error('cpassword'),
				'mobile_error'	 		=>	form_error('mobile')
			);
		}
		echo json_encode($array);
	}

	function insert()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'first_name'	=>	$this->input->post('first_name'),
				'last_name'		=>	$this->input->post('last_name')
			);

			$this->api_model->insert_api($data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'first_name_error'		=>	form_error('first_name'),
				'last_name_error'		=>	form_error('last_name')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_single()
	{
		if($this->input->post('id'))
		{
			$data = $this->api_model->fetch_single_user($this->input->post('id'));

			foreach($data as $row)
			{
				$output['first_name'] = $row['first_name'];
				$output['last_name'] = $row['last_name'];
			}
			echo json_encode($output);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');

		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		if($this->form_validation->run())
		{	
			$data = array(
				'first_name'		=>	$this->input->post('first_name'),
				'last_name'			=>	$this->input->post('last_name')
			);

			$this->api_model->update_api($this->input->post('id'), $data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'				=>	ture,
				'first_name_error'	=>	form_error('first_name'),
				'last_name_error'	=>	form_error('last_name')
			);
		}
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->api_model->delete_single_user($this->input->post('id')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}

}


?>