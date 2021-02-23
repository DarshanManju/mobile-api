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
		
		if($this->form_validation->run())
		{
			$data = array(
				'username'	=>	$this->input->post('username'),
				'email'		=>	$this->input->post('email'),
				'password'	=>	$this->input->post('password'),
				'cpassword'	=>	$this->input->post('cpassword'),
				'mobile'	=>	$this->input->post('mobile')
			);

			if(!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '')
			{
				$array = array(
					'status'				=>	0,
					'message'	 			=>	"Invalid email."
				);
			}
			elseif($check_email_exists  && $email != '')
			{
				$array = array(
					'status'				=>	0,
					'message'	 			=>	"Email - '".$email."' already exists in the database."
				);
			}
			elseif($this->input->post('password') != $this->input->post('cpassword'))
			{
				$array = array(
					'status'				=>	0,
					'message'		 		=>	'Passwords are not matching. Please confirm the password.'
				);
			}
			else
			{
				$this->api_model->insert_user($data);

				$array = array(
					'status'			=>	1,
					'message'			=>	'Successfully Registered'
				);
			}
			
		}
		else
		{	
			$array = array(
				'status'				=>	0,
				'message'				=>	form_error('username').', '.form_error('email').', '.form_error('password').', '.form_error('cpassword').', '.form_error('mobile')
			);
		}

		echo json_encode($array);
	}

	function signin()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[20]|min_length[8]');

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$check_email_exists = $this->api_model->check_user_exists($email);
		$check_user_data = $this->api_model->check_user_login_data($email, $password);
		
		$array = '';
		if($this->form_validation->run())
		{
			$data = array(
				'email'		=>	$this->input->post('email'),
				'password'	=>	$this->input->post('password')
			);
			
			if($check_email_exists == NULL  && $email != '')
			{
				$array = array(
					'status'		=>	0,
					'message'		=>	'User not registered.'
				);
			}
			elseif($check_user_data == NULL)
			{
				$array = array(
					'status'		=>	0,
					'message' 		=>	'Invalid password.'
				);
			}
			else
			{
				$array = array(
					'status'				=>	1,
					'message'		 		=>	''
				);
			}
			
		}
		else
		{
			$array = array(
				'status'				=>	0,
				'message' 		 		=>	form_error('email').', '.form_error('password')
			);
		}

		echo json_encode($array);
	}
	
	//dummy methods for testing 
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