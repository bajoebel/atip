<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komentar extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('komentar_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->komentar_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'modul'=>"Komentar",
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/komentar/view_tabel', $data, true);
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
            $row_count=$this->komentar_model->countKomentar($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->komentar_model->getKomentarlimit($limit,$start,$q),
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
            $row=$this->komentar_model->getKomentar_by_id($id);
            if(!empty($row)){
                $response=array(
                    'status'    => true,
                    'message'   => "OK",
                    'data'      => $row,
                    'csrf'      => $this->security->get_csrf_hash(),
                );
            }else{
                $response=array(
                    'status'    => false,
                    'message'   => "Data Tidak ditemukan",
                    'data'      => array(),
                    'csrf'      => $this->security->get_csrf_hash(),
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
            $id_komentar=$this->input->post('id_komentar');
        if($this->input->post('status')==1) $status=1; else $status=0;
            $data = array(
                
                'id_post' => $this->input->post('id_post'),
                'email' => $this->input->post('email'),
                'nama' => $this->input->post('nama'),
                'komentar' => $this->input->post('komentar'),
                'status' => $status,
            );
            $row=$this->komentar_model->getKomentar_by_id($id_komentar);
            if(empty($row)){
                
                    $this->form_validation->set_rules('id_post', 'id post', 'required');
                    $this->form_validation->set_rules('email', 'email', 'required');
                    $this->form_validation->set_rules('nama', 'nama', 'required');
                    $this->form_validation->set_rules('komentar', 'komentar', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->komentar_model->insertKomentar($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_id_post' => form_error('id_post'),
                'err_email' => form_error('email'),
                'err_nama' => form_error('nama'),
                'err_komentar' => form_error('komentar'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                    $this->form_validation->set_rules('id_post', 'id post', 'required');
                    $this->form_validation->set_rules('email', 'email', 'required');
                    $this->form_validation->set_rules('nama', 'nama', 'required');
                    $this->form_validation->set_rules('komentar', 'komentar', 'required');
                if($this->form_validation->run())
                {
                    $this->komentar_model->updateKomentar($data,$id_komentar);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_id_post' => form_error('id_post'),
                'err_email' => form_error('email'),
                'err_nama' => form_error('nama'),
                'err_komentar' => form_error('komentar'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => False,'error'=>TRUE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
	function delete($id){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $this->komentar_model->deleteKomentar($id);
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
                'data'  => $this->komentar_model->getKomentar(),
            );
            $this->load->view('admin/komentar/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->komentar_model->getKomentar(),
            );
            $html=$this->load->view('admin/komentar/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_KOMENTAR.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }

    function aktifkan($id){
        $cek=array('aksi'=>ucwords("edit"));
        if(in_array($cek, $this->akses)){
            $this->komentar_model->aktifkan($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Status Berhasil diaktifkan"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }

    function nonaktifkan($id){
        $cek=array('aksi'=>ucwords("edit"));
        if(in_array($cek, $this->akses)){
            $this->komentar_model->nonaktifkan($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Status Berhasil dinonaktifkan"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
}