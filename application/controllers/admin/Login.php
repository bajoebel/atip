<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }
    public function index(){
    	$data['content']	= $this->load->view('admin/view_login','',true);
    	$this->load->view('view_depan',$data);
    }
    public function notfound(){
    	$data['content']	= $this->load->view('admin/view_notfound','',true);
    	$this->load->view('view_display',$data);
    }
    public function cekuser(){
    	$user=$this->auth_model->cek_user($this->input->post('username'),$this->input->post('userpass'),1);
    	//print_r($user);
    	//exit;
    	if(empty($user)){
    		$this->session->set_flashdata('error', 'Maaf Username Atau Password Yang Anda masukkan Salah!' );
    		header('location:' .base_url() ."login");
    	}else{
            if($user->group_user=='Admin');
            $detail=$this->auth_model->getAdmin($user->ref_id);

    		$data=array(
                'username'          => $this->input->post('username'),
                'level'              => $user->role,
                'group_user'        => $user->group_user,
                'user_namalengkap'  => $detail->nama_lengkap
            );  //print_r($data);exit;
            $this->session->set_userdata($data);
    		$this->session->set_flashdata('Info', 'Selamat Datang ' .$detail->nama_lengkap );
    		header('location:' .base_url() ."home");
    	}
    }
    public function logout(){
		$this->session->sess_destroy();
		header('location:'.base_url().'login');

	}
    
}
