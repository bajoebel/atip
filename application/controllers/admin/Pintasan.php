<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pintasan extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('pintasan_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->pintasan_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul' => 'pintasan'
            );
            $content=$this->load->view('admin/pintasan/view_tabel', $data, true);
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
        //print_r($this->akses); exit;
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 20;
            $row_count=$this->pintasan_model->countpintasan($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->pintasan_model->getpintasanlimit($limit,$start,$q),
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
            $row=$this->pintasan_model->getpintasan_by_id($id);
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
            $pintasan_id=$this->input->post('pintasan_id');
            if($this->input->post('pintasan_status')==1) $pintasan_status=1; else $pintasan_status=0;
            
            $row=$this->pintasan_model->getpintasan_by_id($pintasan_id);
            if(empty($row)){
                $this->form_validation->set_rules('pintasan_nama', 'pintasan nama', 'required');
                $this->form_validation->set_rules('pintasan_link', 'pintasan link', 'required');
                if($this->form_validation->run())
                {
                    if($_FILES['userfile']['name']!=""){

                        $file="pintasan_" .date('dmY') ."_" .$_FILES['userfile']['name'];
                        $data = array(
                            'pintasan_nama' => $this->input->post('pintasan_nama'),
                            'pintasan_link' => $this->input->post('pintasan_link'),
                            'pintasan_img' => $file,
                            'pintasan_status' => $pintasan_status,
                        );
                        $this->_file_upload(_DIR_MEDIA_,$file,'gif|jpg|png');
                        if (!$this->upload->do_upload()){
                            $error=$this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => FALSE,'error'=>TRUE,"message"=>$error,'csrf'=> $this->security->get_csrf_hash()));
                        }
                        else{
                            $insert = $this->pintasan_model->insertpintasan($data);
                            $filename = $this->upload->data("file_name");
                            $error[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "/88X88/_88X88_" . $filename, 88, 88);
                            $error1[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "100X100/_100X100_" . $filename, 100, 100);
                            $error2[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "383X330/_383X330_" . $filename, 383, 330);
                            $error3[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "403X200/_403X200_" . $filename, 403, 200);
                            $error4[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "620X320/_620X320_" . $filename, 620, 320);
                            $error5[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1370X430/_1370X430_" . $filename, 1370, 430);
                            $error5[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1366X656/_1366X656_" . $filename, 1366, 656);
                            //$error[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 500,500);
                            
                            //$icon[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_ICON_ .$file, 50,50);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf'=> $this->security->get_csrf_hash()));
                        }
                        
                    }else{
                        header('Content-Type: application/json');
                        echo json_encode(array("status" => FALSE,'error'=>TRUE,"message"=>"Gambar Belum Lampirkan",'csrf'      => $this->security->get_csrf_hash()));
                    }
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_pintasan_nama' => form_error('pintasan_nama'),
                        'err_pintasan_link' => form_error('pintasan_link'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                $this->form_validation->set_rules('pintasan_nama', 'pintasan nama', 'required');
                $this->form_validation->set_rules('pintasan_link', 'pintasan link', 'required');
                if($this->form_validation->run())
                {
                    if($_FILES['userfile']['name']!=""){
                        $file="pintasan_" .date('dmY') ."_" .$_FILES['userfile']['name'];
                        $data = array(
                            'pintasan_nama' => $this->input->post('pintasan_nama'),
                            'pintasan_link' => $this->input->post('pintasan_link'),
                            'pintasan_img' => $file,
                            'pintasan_status' => $pintasan_status,
                        );
                        $this->_file_upload(_DIR_MEDIA_,$file,'gif|jpg|png');
                        if (!$this->upload->do_upload()){
                            $error=$this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);header('Content-Type: application/json');
                            echo json_encode(array("status" => FALSE,'error'=>TRUE,"message"=>$error,'csrf'=> $this->security->get_csrf_hash()));
                        }
                        else{
                            $this->pintasan_model->updatepintasan($data,$pintasan_id);
                            //$error[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 500,500);
                            //$icon[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_ICON_ .$file, 50,50);
                            $filename = $this->upload->data("file_name");
                            $error[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "/88X88/_88X88_" . $filename, 88, 88);
                            $error1[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "100X100/_100X100_" . $filename, 100, 100);
                            $error2[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "383X330/_383X330_" . $filename, 383, 330);
                            $error3[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "403X200/_403X200_" . $filename, 403, 200);
                            $error4[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "620X320/_620X320_" . $filename, 620, 320);
                            $error5[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1370X430/_1370X430_" . $filename, 1270, 420);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update", 'csrf'=> $this->security->get_csrf_hash()));
                        }
                    }else{
                        $data = array(
                            'pintasan_nama' => $this->input->post('pintasan_nama'),
                            'pintasan_link' => $this->input->post('pintasan_link'),
                            'pintasan_status' => $pintasan_status,
                        );
                        $this->pintasan_model->updatepintasan($data,$pintasan_id);
                        header('Content-Type: application/json');
                        echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update", 'csrf'=> $this->security->get_csrf_hash()));
                        
                    }
                    
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_pintasan_nama' => form_error('pintasan_nama'),
                        'err_pintasan_link' => form_error('pintasan_link'),
                        'err_pintasan_img' => form_error('pintasan_img'),
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
            $this->pintasan_model->deletepintasan($id);
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
                'data'  => $this->pintasan_model->getpintasan(),
            );
            $this->load->view('admin/pintasan/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->pintasan_model->getpintasan(),
            );
            $html=$this->load->view('admin/pintasan/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_pintasan.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }

    public function _file_upload($path,$filename,$filetype){
        $config['upload_path']          = $path;
        $config['allowed_types']        = $filetype;
        $config['max_size']             = 1000;
        $config['max_width']            = 1500;
        $config['max_height']           = 800;
        $config['overwrite']        = true;
        $config['file_name']            = $filename;
        $this->load->library('upload', $config);
    }

    public function _file_resize($source=null, $dest=null, $width=0, $height=0){
        $thumb['image_library']     = 'gd2';
        $thumb['source_image']      = $source;
        $thumb['create_thumb']      = FALSE;
        $thumb['maintain_ratio']    = TRUE;
        $thumb['width']             = $width;
        $thumb['height']            = $height;
        $thumb['new_image']         = $dest; 
        $this->load->library('image_lib', $thumb);
        $this->image_lib->clear();
        $this->image_lib->initialize($thumb);
        if (!$this->image_lib->resize()) {
            $error['thumb']= $this->image_lib->display_errors();
        }else{
            $error['thumb']= "";
        }
        $this->image_lib->clear();
        return $error['thumb'];
    }

    function aktifkan($id){
        $cek=array('aksi'=>ucwords("edit"));
        if(in_array($cek, $this->akses)){
            $this->pintasan_model->aktifkan($id);
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
            $this->pintasan_model->nonaktifkan($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Status Berhasil dinonaktifkan"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
}