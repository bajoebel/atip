<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }
    public function index(){
    	//$username=$this->session->userdata('username');
        //if(!empty($username)){
            $x=array(
            );
            $data['content']    = $this->load->view('view_home',$x,true);
            $this->load->view('view_layout',$data);
        //}else{
        //    header('location:' .base_url() ."login");
        //}
    	
    }
    function menu(){
        $q=urldecode($this->input->get('q',TRUE));
        $role=$this->session->userdata('level');
        //if(empty($role)) $role=1;
        $data=$this->auth_model->getMenu($role,$q);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function menu_html(){
        $q=urldecode($this->input->get('q',TRUE));
        $role=$this->session->userdata('level');
        //if(empty($role)) $role=1;
        $menu=$this->auth_model->getMenu($role,$q);
        $buka=$this->input->get('buka');
        $link=$this->input->get('link');
        $data=array(
            'menu_data'=>$menu,
            'link'  => $link,
            'buka'  =>$buka,
            'jmlData'  => 20
        );
        $this->load->view('template/admin/menu', $data);
        //header('Content-Type: application/json');
        //echo json_encode($data);
    }

    function ubahpassword(){
        $username=$this->session->userdata('username');
        if(!empty($username)){
            $cek=$this->auth_model->getUser($username);
            if(empty($cek)){
                $response=array('status'=>false,'message'=>'User tidak ditemukan');
            }else{
                $password_lama=$cek->password;
                $password_lama_input=md5($this->input->post('password_lama'));
                if($password_lama==$password_lama_input){
                    $password_baru=$this->input->post('password_baru');
                    $konfirmasi_password=$this->input->post('konfirmasi_password');
                    if($password_baru==$konfirmasi_password){
                        $data=array('password'=>md5($password_baru));
                        $this->db->where('username', $username);
                        $this->db->update('m_users',$data);
                        $response=array('status'=>true,'message'=>'Password Berhasil diupdate', 'csrf'=> $this->security->get_csrf_hash());
                    }else{
                        $response=array('status'=>false,'message'=>'Konfirmasi Password yang anda input salah', 'csrf'=> $this->security->get_csrf_hash());
                    }
                }else{
                    $response=array('status'=>false,'message'=>'Password Lama yang anda input salah', 'csrf'=> $this->security->get_csrf_hash());
                }
            }
        }else{
            $response=array('status'=>false,'message'=>'Anda tidak berhak login', 'csrf'=> $this->security->get_csrf_hash());
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
