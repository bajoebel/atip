<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		if($this->session->userdata("username")){
			$data=array(
				'content'=>$this->load->view('admin/view_dashboard','',true),
				'modul'	=> 'Dashboard'
			) ;
			$this->load->view('template/admin/view_layout', $data);
		}else{
			$this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
		}
		
	}
	function login(){
		$this->load->view('view_login');
	}
	
}
