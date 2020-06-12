<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('faq_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->faq_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,'modul'=>'faq'
            );
            $content=$this->load->view('admin/faq/view_tabel', $data, true);
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
            $row_count=$this->faq_model->countFaq($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->faq_model->getFaqlimit($limit,$start,$q),
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
            $row=$this->faq_model->getFaq_by_id($id);
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
            $id_faq=$this->input->post('id_faq');
            if($this->input->post('status_faq')==1) $status_faq=1; else $status_faq=0;
            $link=str_replace(' ', '-', strtolower($this->input->post('judul_faq')));
            $link=str_replace('&','dan',$link);
            $link=str_replace('"', '', $link);
            $data = array(
                'judul_faq' => $this->input->post('judul_faq'),
                'isi_faq' => $this->input->post('isi_faq'),
                'link_faq' => $link,
                'status_faq' => $status_faq,
                'userinput' => $this->session->userdata('username'),
            );
            $row=$this->faq_model->getFaq_by_id($id_faq);
            if(empty($row)){
                $this->form_validation->set_rules('judul_faq', 'judul faq', 'required');
                $this->form_validation->set_rules('isi_faq', 'isi faq', 'required');
                    
                if($this->form_validation->run())
                {
                    $insert = $this->faq_model->insertFaq($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf'      => $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_judul_faq' => form_error('judul_faq'),
                        'err_isi_faq' => form_error('isi_faq'),
                        'err_link_faq' => form_error('link_faq'),
                        'err_userinput' => form_error('userinput'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                $this->form_validation->set_rules('judul_faq', 'judul faq', 'required');
                $this->form_validation->set_rules('isi_faq', 'isi faq', 'required');
                if($this->form_validation->run())
                {
                    $this->faq_model->updateFaq($data,$id_faq);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_judul_faq' => form_error('judul_faq'),
                        'err_isi_faq' => form_error('isi_faq'),
                        'err_link_faq' => form_error('link_faq'),
                        'err_userinput' => form_error('userinput'),
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
            $this->faq_model->deleteFaq($id);
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
                'data'  => $this->faq_model->getFaq(),
            );
            $this->load->view('admin/faq/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->faq_model->getFaq(),
            );
            $html=$this->load->view('admin/faq/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_FAQ.pdf";
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
            $this->faq_model->aktifkan($id);
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
            $this->faq_model->nonaktifkan($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Status Berhasil dinonaktifkan"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
}