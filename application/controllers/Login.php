<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		if($this->session->userdata('admin')){
			$this->session->sess_destroy();
		}

		$data['title'] = 'Sign in - Stok BBM Satu Harga';

		$this->load->view('template_signin', $data);
	}

	public function cek_login() {		

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if($username == 'mz' && $password == 'helper') {
			$this->session->set_userdata('admin', 'Ridha');
			redirect('home');
		} else if($username == 'admin' && $password == '123456') {
			$this->session->set_userdata('admin', 'Super Admin');
			redirect('home');						
		} else {
			redirect('login/index/err');
		}

	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login/index/logout');
	}	
}
