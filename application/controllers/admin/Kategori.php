<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('kategori_model');
		$level=$this->session->userdata('level');
		
        $this->akses=$this->kategori_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/kategori/view_tabel', $data, true);
            $view=array(
				'content'   => $content,
				'modul'		=> 'Kategori',
				'libjs'		=> 'kategori.js'
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
            $row_count=$this->kategori_model->countKategori($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->kategori_model->getKategorilimit($limit,$start,$q),
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
            $row=$this->kategori_model->getKategori_by_id($id);
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
            $id_kategori=$this->input->post('id_kategori');
            if($this->input->post('status_kategori')==1) $status_kategori=1; else $status_kategori=0;
            $link=str_replace(' ', '-', strtolower($this->input->post('nama_kategori')));
            $link=str_replace('&','dan',$link);
            $link=str_replace('"', '', $link);
            $data = array(
                'nama_kategori' => $this->input->post('nama_kategori'),
                'link_kategori' => $link,
                'status_kategori' => $status_kategori,
            );
            $row=$this->kategori_model->getKategori_by_id($id_kategori);
            if(empty($row)){
                
                $this->form_validation->set_rules('nama_kategori', 'nama kategori', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->kategori_model->insertKategori($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_nama_kategori' => form_error('nama_kategori'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                $this->form_validation->set_rules('nama_kategori', 'nama kategori', 'required');
                if($this->form_validation->run())
                {
                    $this->kategori_model->updateKategori($data,$id_kategori);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_nama_kategori' => form_error('nama_kategori'),
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
            $this->kategori_model->deleteKategori($id);
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
                'data'  => $this->kategori_model->getKategori(),
            );
            $this->load->view('admin/kategori/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->kategori_model->getKategori(),
            );
            $html=$this->load->view('admin/kategori/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_KATEGORI.pdf";
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
            $this->kategori_model->aktifkan($id);
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
            $this->kategori_model->nonaktifkan($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Status Berhasil dinonaktifkan"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
}