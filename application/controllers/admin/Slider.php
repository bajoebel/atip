<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('slider_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->slider_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul'=>'Slider'
            );
            $content=$this->load->view('admin/slider/view_tabel', $data, true);
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
            $limit =  intval($this->input->get('limit'));
            $row_count=$this->slider_model->countSlider($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->slider_model->getSliderlimit($limit,$start,$q),
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
    public function dataposting(){
        $cek=array('aksi'=>"Save");
        $this->load->model("posting_model");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 10;
            $row_count=$this->posting_model->countPosting($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->posting_model->getPostinglimit($limit,$start,$q),
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
            $row=$this->slider_model->getSlider_by_id($id);
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
            $id_slider=$this->input->post('id_slider');
            if($this->input->post('status_slider')==1) $status_slider=1; else $status_slider=0;
            
            $row=$this->slider_model->getSlider_by_id($id_slider);
            if(empty($row)){
                $this->form_validation->set_rules('keterangan_slider', 'keterangan slider', 'required');
                if($this->form_validation->run())
                {
                    $file="SLIDER_" .date('dmY') ."_" .$_FILES['userfile']['name'];
                    $this->_file_upload(_DIR_MEDIA_,$file,'gif|jpg|png');
                    if($_FILES['userfile']['name']!=""){
                        if (!$this->upload->do_upload()){
                            $error=$this->upload->display_errors();
                            //echo $error;exit;
                            $this->session->set_flashdata('error', $error);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>$error));                        }
                        else{
                            $filename = $this->upload->data("file_name");
                            $data = array(
                                'gambar_slider' => $filename,
                                'keterangan_slider' => $this->input->post('keterangan_slider'),
                                'post_id'   => $this->input->post("id_posting"),
                                'status_slider' => $status_slider,
                            );
                            $insert = $this->slider_model->insertSlider($data);
                            $error[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "88X88/_88X88_" . $filename, 88, 88);
                            $error1[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "100X100/_100X100_" . $filename, 100, 100);
                            $error2[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "383X330/_383X330_" . $filename, 383, 330);
                            $error3[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "403X200/_403X200_" . $filename, 403, 200);
                            $error4[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "620X320/_620X320_" . $filename, 620, 320);
                            $error5[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1370X430/_1370X430_" . $filename, 1370, 430);
                            $error6[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1366X656/_1366X656_" . $filename, 1366, 656);
                            //$thumb[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 450,150);
                            //$icon[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_ICON_ .$file, 150,50);
                            $media = array(
                                'id_groupmedia' => 13,
                                'namafile'      => $filename,
                                'keterangan'    => $this->input->post('keterangan_slider'),
                                'status_media'  => 1
                            );
                            $this->db->insert('m_media', $media);
                            
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                        }
                    }else{
                        header('Content-Type: application/json');
                        echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"File Slider belum dipilih"));
                    }
                    
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_gambar_slider' => form_error('gambar_slider'),
                        'err_keterangan_slider' => form_error('keterangan_slider'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                $this->form_validation->set_rules('keterangan_slider', 'keterangan slider', 'required');
                if($this->form_validation->run())
                {
                    $file="SLIDER_" .date('dmY') ."_" .$_FILES['userfile']['name'];
                    $this->_file_upload(_DIR_MEDIA_,$file,'gif|jpg|png');
                    if($_FILES['userfile']['name']!=""){
                        if (!$this->upload->do_upload()){
                            $error=$this->upload->display_errors();
                            //echo $error;exit;
                            $this->session->set_flashdata('error', $error);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>$error));                        }
                        else{
                            $filename = $this->upload->data("file_name");
                            $data = array(
                                'gambar_slider' => $filename,
                                'keterangan_slider' => $this->input->post('keterangan_slider'),
                                'post_id'   => $this->input->post("id_posting"),
                                'status_slider' => $status_slider,
                            );
                            $this->slider_model->updateSlider($data,$id_slider);
                            $error[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "/88X88/_88X88_" . $filename, 88, 88);
                            $error1[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "100X100/_100X100_" . $filename, 100, 100);
                            $error2[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "383X330/_383X330_" . $filename, 383, 330);
                            $error3[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "403X200/_403X200_" . $filename, 403, 200);
                            $error4[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "620X320/_620X320_" . $filename, 620, 320);
                            $error5[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1370X430/_1370X430_" . $filename, 1370, 430);
                            $error6[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1366X656/_1366X656_" . $filename, 1366, 656);
                            //$thumb[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 500,200);
                            //$icon[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_ICON_ .$file, 150,50);
                            $media = array(
                                'id_groupmedia' => 13,
                                'namafile'      => $filename,
                                'keterangan'    => $this->input->post('keterangan_slider'),
                                'status_media'  => 1
                            );
                            $this->db->insert('m_media', $media);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                        }
                    }else{
                        $data = array(
                                'keterangan_slider' => $this->input->post('keterangan_slider'),
                                'post_id'   => $this->input->post("id_posting"),
                                'status_slider' => $status_slider,
                            );
                            $this->slider_model->updateSlider($data,$id_slider);
                            header('Content-Type: application/json');
                            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                    }
                    
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_gambar_slider' => form_error('gambar_slider'),
                        'err_keterangan_slider' => form_error('keterangan_slider'),
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
            $this->slider_model->deleteSlider($id);
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
                'data'  => $this->slider_model->getSlider(),
            );
            $this->load->view('admin/slider/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->slider_model->getSlider(),
            );
            $html=$this->load->view('admin/slider/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_SLIDER.pdf";
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
        $config['max_size']             = 1024;
        $config['max_width']            = 2500;
        $config['max_height']           = 1000;
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
            $data=array('status_slider'=>$val);
            $this->slider_model->updateSlider($data,$id_group);
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