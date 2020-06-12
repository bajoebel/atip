<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_akses extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('role_akses_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->role_akses_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
			'list_m_role'=>$this->role_akses_model->getM_role(),
			'list_m_moduls'=>$this->role_akses_model->getM_moduls(),
			'list_m_aksi'=>$this->role_akses_model->getM_aksi(),
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul'=> 'Role Akses'
            );
            $content=$this->load->view('admin/role_akses/view_tabel', $data, true);
            $view=array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout',$view);
        }
        else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }
	public function data(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = intval($this->input->get('limit'));
            $row_count=$this->role_akses_model->countRole_akses($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->role_akses_model->getRole_akseslimit($limit,$start,$q),
            );
        }else{
            $list=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'data'      => array()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($list);
    }
	function edit($id=""){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $row=$this->role_akses_model->getRole_akses_by_id($id);
            if(!empty($row)){
                $response=array(
                    'status'    => true,
                    'message'   => "OK",
                    'data'      => $row
                );
            }else{
                $response=array(
                    'status'    => false,
                    'message'   => "Data Tidak ditemukan",
                    'data'      => array()
                );
            }
            
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
	function save(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $id_akses=$this->input->post('id_akses');
        if($this->input->post('tampil_menu')==1) $tampil_menu=1; else $tampil_menu=0;
            $data = array(
                
                'role_id' => $this->input->post('role_id'),
                'modul_id' => $this->input->post('modul_id'),
                'id_aksi' => $this->input->post('id_aksi'),
                'tampil_menu' => $tampil_menu,
            );
            $row=$this->role_akses_model->getRole_akses_by_id($id_akses);
            if(empty($row)){
                $insert = $this->role_akses_model->insertRole_akses($data);
                header('Content-Type: application/json');
                echo json_encode(array("status" => TRUE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
            }else{
                $this->role_akses_model->updateRole_akses($data,$id_akses);
                header('Content-Type: application/json');
                echo json_encode(array("status" => TRUE,"message"=>"Data berhasil di update"));
            }
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => False, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
	function delete($id){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $this->role_akses_model->deleteRole_akses($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Data Berhasil dihapus"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
        
    }
	function excel(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->role_akses_model->getRole_akses(),
            );
            $this->load->view('admin/role_akses/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->role_akses_model->getRole_akses(),
            );
            $html=$this->load->view('admin/role_akses/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_ROLE_AKSES.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }
    function tampil($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('tampil_menu'=>$val);
            $this->role_akses_model->updateRole_akses($data,$id_group);
            $response = array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update");
        }
        else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}