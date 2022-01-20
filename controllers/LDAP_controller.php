<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('Form_validation');
		$this->load->helper('url');
		$this->load->helper('LDAP_helper');
		$this->load->library('table');
	}

	public function index()
	{
		if ($this->session->userdata()) {
			$this->session->sess_destroy();
		}
		$this->load->model('Login_Model');
		$this->load->view('Login');

	}
	public function who()
	{
		if ($this->input->post()) {
			$mail = preg_replace('/@.*?$/', '', $this->input->post('username')) . $this->input->post('domain');
			$pwd = $this->input->post('password');
			$domain = $this->input->post('domain');
			$ldap_enter = ldap_enter($mail, $pwd, $domain);

			if ($ldap_enter) {
				loglogin($mail, 1);
				if (check_user_loaction_info($this->session->userdata('user_data')->personel_id)) {
					redirect('home');
				} else {
					error_message("Plese add profile info!");
					redirect('profile/edit');
				}
			} else {
				loglogin($mail, 0);
				if ($domain == "@abc.com") {
					redirect('login/index/abc', 'refresh');
				} else {
					redirect('login/index', 'refresh');
				}
			}
		} else redirect('login/index', 'refresh');
	}


	public function logout()
	{
		logout();
	}
}
