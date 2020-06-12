<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('partner_model');
        $level=$this->session->userdata('level');
        $level = 1;
        $this->akses=$this->partner_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul'=> "Partner"
            );
            $content=$this->load->view('admin/partner/view_tabel', $data, true);
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
            $limit = 20;
            $row_count=$this->partner_model->countpartner($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->partner_model->getpartnerlimit($limit,$start,$q),
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
            $row=$this->partner_model->getpartner_by_id($id);
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
            $partner_id=$this->input->post('partner_id');
            if($this->input->post('partner_status')==1) $partner_status=1; else $partner_status=0;
            
            $row=$this->partner_model->getpartner_by_id($partner_id);
            if(empty($row)){
                $this->form_validation->set_rules('partner_nama', 'partner nama', 'required');
                $this->form_validation->set_rules('partner_link', 'partner link', 'required');
                if($this->form_validation->run())
                {
                    if($_FILES['userfile']['name']!=""){

                        $file="partner_" .date('dmY') ."_" .$_FILES['userfile']['name'];
                        
                        $this->_file_upload(_DIR_MEDIA_,$file,'gif|jpg|png');
                        if (!$this->upload->do_upload()){
                            $error=$this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => FALSE,'error'=>TRUE,"message"=>$error,'csrf'=> $this->security->get_csrf_hash()));
                        }
                        else{
                            $file=$this->upload->data("file_name");
                            $data = array(
                                'partner_nama' => $this->input->post('partner_nama'),
                                'partner_link' => $this->input->post('partner_link'),
                                'partner_img' => $file,
                                'partner_status' => $partner_status,
                            );
                            
                            $insert = $this->partner_model->insertpartner($data);
                            $error[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 500,300);
                            $icon[]=$this->_file_resize(_DIR_MEDIA_ ."/".$file, _DIR_MEDIA_ICON_ .$file, 300,180);
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
                        'err_partner_nama' => form_error('partner_nama'),
                        'err_partner_link' => form_error('partner_link'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                $this->form_validation->set_rules('partner_nama', 'partner nama', 'required');
                $this->form_validation->set_rules('partner_link', 'partner link', 'required');
                if($this->form_validation->run())
                {
                    if($_FILES['userfile']['name']!=""){
                        $file="partner_" .date('dmY') ."_" .$_FILES['userfile']['name'];
                        $data = array(
                            'partner_nama' => $this->input->post('partner_nama'),
                            'partner_link' => $this->input->post('partner_link'),
                            'partner_img' => $file,
                            'partner_status' => $partner_status,
                        );
                        $this->_file_upload(_DIR_MEDIA_,$file,'gif|jpg|png');
                        if (!$this->upload->do_upload()){
                            $error=$this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);header('Content-Type: application/json');
                            echo json_encode(array("status" => FALSE,'error'=>TRUE,"message"=>$error,'csrf'=> $this->security->get_csrf_hash()));
                        }
                        else{
                            $this->partner_model->updatepartner($data,$partner_id);
                            $error[]=$this->_file_resize(_DIR_MEDIA_  ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 500,500);
                            $icon[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_ICON_ .$file, 50,50);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di     ", 'csrf'=> $this->security->get_csrf_hash()));
                        }
                    }else{
                        $data = array(
                            'partner_nama' => $this->input->post('partner_nama'),
                            'partner_link' => $this->input->post('partner_link'),
                            'partner_status' => $partner_status,
                        );
                        $this->partner_model->updatepartner($data,$partner_id);
                        header('Content-Type: application/json');
                        echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update", 'csrf'=> $this->security->get_csrf_hash()));
                        
                    }
                    
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_partner_nama' => form_error('partner_nama'),
                        'err_partner_link' => form_error('partner_link'),
                        'err_partner_img' => form_error('partner_img'),
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
            $this->partner_model->deletepartner($id);
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
                'data'  => $this->partner_model->getpartner(),
            );
            $this->load->view('admin/partner/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->partner_model->getpartner(),
            );
            $html=$this->load->view('admin/partner/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_partner.pdf";
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
        $config['max_size']             = _SIZE_PARTNER_ORIGINAL_;
        $config['max_width']            = _WIDTH_PARTNER_ORIGINAL_;
        $config['max_height']           = _HEIGHT_PARTNER_ORIGINAL_;
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

    function status($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('partner_status'=>$val);
            $this->partner_model->updatePartner($data,$id_group);
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