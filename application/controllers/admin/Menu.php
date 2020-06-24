<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->menu_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul' => "menu"
            );
            $content=$this->load->view('admin/menu/view_tabel', $data, true);
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
            $row_count=$this->menu_model->countMenu($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count, 
                'limit'     => $limit,
                'data'     => $this->menu_model->getMenulimit($limit,$start,$q),
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
            $row=$this->menu_model->getMenu_by_id($id);
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
            $menu_id=$this->input->post('menu_id');
            if($this->input->post('menu_baseurl')==1) $menu_baseurl=1; else $menu_baseurl=0;
            if($this->input->post('menu_status')==1) $menu_status=1; else $menu_status=0;
            if($this->input->post('menu_newtab')==1) $menu_newtab=1; else $menu_newtab=0;
            $data = array(
                'menu_judul' => $this->input->post('menu_judul'),
                'menu_link' => $this->input->post('menu_link'),
                'menu_baseurl' => $menu_baseurl,
                'menu_newtab' => $menu_newtab,
                'menu_idxutama' => $this->input->post('menu_idxutama'),
                'menu_idxanak' => $this->input->post('menu_idxanak'),
                'menu_top' => $this->input->post('menu_top'),
                'menu_status' => $menu_status,
            );
            $row=$this->menu_model->getMenu_by_id($menu_id);
            if(empty($row)){
                $this->form_validation->set_rules('menu_judul', 'menu judul', 'required');
                $this->form_validation->set_rules('menu_link', 'menu link', 'required');
                $this->form_validation->set_rules('menu_idxutama', 'menu idxutama', 'required');
                $this->form_validation->set_rules('menu_idxanak', 'menu idxanak', 'required');
                $this->form_validation->set_rules('menu_top', 'menu idxsub', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->menu_model->insertMenu($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_menu_judul' => form_error('menu_judul'),
                        'err_menu_link' => form_error('menu_link'),
                        'err_menu_idxutama' => form_error('menu_idxutama'),
                        'err_menu_idxanak' => form_error('menu_idxanak'),
                        'err_menu_top' => form_error('menu_top'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                $this->form_validation->set_rules('menu_judul', 'menu judul', 'required');
                $this->form_validation->set_rules('menu_link', 'menu link', 'required');
                $this->form_validation->set_rules('menu_idxutama', 'menu idxutama', 'required');
                $this->form_validation->set_rules('menu_idxanak', 'menu idxanak', 'required');
                $this->form_validation->set_rules('menu_top', 'menu idxsub', 'required');
                if($this->form_validation->run())
                {
                    $this->menu_model->updateMenu($data,$menu_id);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_menu_judul' => form_error('menu_judul'),
                        'err_menu_link' => form_error('menu_link'),
                        'err_menu_idxutama' => form_error('menu_idxutama'),
                        'err_menu_idxanak' => form_error('menu_idxanak'),
                        'err_menu_top' => form_error('menu_top'),
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
            $this->menu_model->deleteMenu($id);
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
                'data'  => $this->menu_model->getMenu(),
            );
            $this->load->view('admin/menu/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->menu_model->getMenu(),
            );
            $html=$this->load->view('admin/menu/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_MENU.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }

    function status($menu_id,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('menu_status'=>$val);
            $this->menu_model->updateMenu($data,$menu_id);
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

    function newtab($menu_id,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('menu_newtab'=>$val);
            $this->menu_model->updateMenu($data,$menu_id);
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
    function newtop($menu_id, $val)
    {
        $cek = array('aksi' => 'Edit');
        if (in_array($cek, $this->akses)) {
            $data = array('menu_top' => $val);
            $this->menu_model->updateMenu($data, $menu_id);
            $response = array("status" => TRUE, 'error' => FALSE, "message" => "Data berhasil di update");
        } else {
            $response = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}