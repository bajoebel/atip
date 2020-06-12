<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posting extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('posting_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->posting_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
			    'list_m_kategori'=>$this->posting_model->getM_kategori(),
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul'=> "Posting"
            );
            $content=$this->load->view('admin/posting/view_tabel', $data, true);
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
    function form($id=""){
        $save=array('aksi'=>'Save');
        if(in_array($save, $this->akses)){
            $data=array(
                'list_m_kategori'=>$this->posting_model->getM_kategori(),
                'data'  => $this->posting_model->getPosting_by_id($id),
                'menu'  => array(),
                'modul'=> "posting -> Tambah",
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/posting/view_form', $data, true);
            $view=array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout',$view);
        }
    }
	public function data(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = intval($this->input->get('limit'));
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

    public function datamedia(){
        $cek=array('aksi'=>"Save");
        if(in_array($cek, $this->akses)){
            $this->load->model('media_model');
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 20;
            $row_count=$this->media_model->countMedia($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->media_model->getMedialimit($limit,$start,$q),
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
    function detailmedia($idgroup){
        $cek=array('aksi'=>'Save');
        $this->load->model('media_model');
        if(in_array($cek, $this->akses)){
            $data=$this->media_model->getDatamedia($idgroup);
            $response=array(
                'status'    => true,
                'data'      => $data,
                'message'   => "OK"
            );
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
	function edit($id=""){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $row=$this->posting_model->getPosting_by_id($id);
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
            $id_posting=$this->input->post('id_posting');
            if($this->input->post('status_komentar')==1) $status_komentar=1; else $status_komentar=0;
            if($this->input->post('tampil_slider')==1) $tampil_slider=1; else $tampil_slider=0;
            $link=str_replace(' ', '-', strtolower($this->input->post('judul_posting')));
            $link=str_replace('&','dan',$link);
            $link=str_replace('"', '', $link);
            
            $row=$this->posting_model->getPosting_by_id($id_posting);
            $file="POST_" .date('dmY') ."_" .str_replace(' ', '_', $_FILES['userfile']['name']);
            $this->_file_upload(_DIR_MEDIA_,$file,'gif|jpg|png');
            if($_FILES['userfile']['name']!=""){
                if (!$this->upload->do_upload()){
                    $error=$this->upload->display_errors();
                    //echo $error;exit;
                    $this->session->set_flashdata('error', $error);
                    header('location:'.base_url() ."admin/posting/form");
                }
                else{
                    //SImpan
                    $file=$this->upload->data("file_name");
                    $data = array(
                        'id_kategori' => $this->input->post('id_kategori'),
                        'judul_posting' => $this->input->post('judul_posting'),
                        'isi_posting' => $this->input->post('isi_posting'),
                        'tgl_posting' => date('Y-m-d'),
                        'lampiran_gambar' => $file,
                        'link_posting' => $link,
                        'tgl_publish' => $this->input->post('tgl_publish'),
                        'tgl_exp' => $this->input->post('tgl_exp'),
                        'group_posting' => $this->input->post('group_posting'),
                        'status_komentar' => $status_komentar,
                        'status_posting' => $this->input->post('status_posting'),
                        'userinput' => $this->session->userdata("username"),
                    );
                    if(empty($row)){
                        $this->form_validation->set_rules('id_kategori', 'id kategori', 'required');
                        $this->form_validation->set_rules('judul_posting', 'judul posting', 'required');
                        $this->form_validation->set_rules('isi_posting', 'isi posting', 'required');
                        $this->form_validation->set_rules('group_posting', 'group posting', 'required');
                        if($this->form_validation->run())
                        {
                            $insert = $this->posting_model->insertPosting($data);
                            $error[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 500,500);
                            $icon[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_ICON_ .$file, 50,50);
                            /**
                             * Buat Group Media Dengan Nama Partner
                             */
                            $this->db->where('id_kategori', $this->input->post('id_kategori'));
                            $kat=$this->db->get('m_kategori')->row();
                            if(!empty($kat)) $kategori=$kat->nama_kategori;
                            else $kategori = 'unctegory';
                            $this->db->where('nama_group',$kategori);
                            $group=$this->db->get("m_groupmedia")->row();
                            if(empty($group)){
                                $group=array(
                                    'nama_group'=>$kategori,
                                    'status_group'=>1
                                );
                                $this->db->insert('m_groupmedia', $group);
                                $idgroup=$this->db->insert_id();
                            }else{
                                $idgroup=$group->id_group;
                            }

                            /***
                             * Insert Data ke Tabel Media
                             */
                            $media=array(
                                'id_groupmedia' => $idgroup,
                                'namafile'      => $file,
                                'keterangan'    => $this->input->post('judul_posting'),
                                'status_media'  => 1
                            );
                            $this->db->insert('m_media', $media);
                            //header('Content-Type: application/json');
                            //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                            header('location:'.base_url()."admin/posting");
                        }else{
                            $array = array(
                                'status'    => TRUE,
                                'error'     => TRUE,
                                'csrf'      => $this->security->get_csrf_hash(),
                                'message'   => "Data Belum Lengkap",
                                'err_id_kategori' => form_error('id_kategori'),
                                'err_judul_posting' => form_error('judul_posting'),
                                'err_isi_posting' => form_error('isi_posting'),
                                'err_lampiran_gambar' => form_error('lampiran_gambar'),
                                'err_group_posting' => form_error('group_posting'),
                            );
                            $this->session->set_flashdata('error', $array);
                            //print_r($array);
                            header('location:'.base_url()."admin/posting/form");
                            //header('Content-Type: application/json');
                            //echo json_encode($array);
                        }
                    }else{
                        $this->form_validation->set_rules('id_kategori', 'id kategori', 'required');
                        $this->form_validation->set_rules('judul_posting', 'judul posting', 'required');
                        $this->form_validation->set_rules('isi_posting', 'isi posting', 'required');
                        $this->form_validation->set_rules('group_posting', 'group posting', 'required');
                        if($this->form_validation->run())
                        {
                            $this->posting_model->updatePosting($data,$id_posting);
                            /**
                             * Buat Group Media Dengan Nama Partner
                             */
                            $this->db->where('id_kategori', $this->input->post('id_kategori'));
                            $kat=$this->db->get('m_kategori')->row();
                            if(!empty($kat)) $kategori=$kat->nama_kategori;
                            else $kategori = 'unctegory';
                            $this->db->where('nama_group',$kategori);
                            $group=$this->db->get("m_groupmedia")->row();
                            if(empty($group)){
                                $group=array(
                                    'nama_group'=>$kategori,
                                    'status_group'=>1
                                );
                                $this->db->insert('m_groupmedia', $group);
                                $idgroup=$this->db->insert_id();
                            }else{
                                $idgroup=$group->id_group;
                            }

                            /***
                             * Insert Data ke Tabel Media
                             */
                            $media=array(
                                'id_groupmedia' => $idgroup,
                                'namafile'      => $file,
                                'keterangan'    => $this->input->post('judul_posting'),
                                'status_media'  => 1
                            );
                            $this->db->insert('m_media', $media);
                            $error[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_THUMB_ .$file, 500,500);
                            $icon[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$file, _DIR_MEDIA_ICON_ .$file, 50,50);
                            header('location:'.base_url()."admin/posting");
                        }else{
                            $array = array(
                                'status'    => TRUE,
                                'error'     => TRUE,
                                'csrf'      => $this->security->get_csrf_hash(),
                                'message'   => "Data Belum Lengkap",
                                'err_id_kategori' => form_error('id_kategori'),
                                'err_judul_posting' => form_error('judul_posting'),
                                'err_isi_posting' => form_error('isi_posting'),
                                'err_group_posting' => form_error('group_posting'),
                            );
                            
                            header('location:'.base_url()."admin/posting/form/".$id_posting);
                        }
                    }
                    
                }
            }else{
                //JIka Tidak ada Gambar Yang DIupload
                    $data = array(
                        'id_kategori' => $this->input->post('id_kategori'),
                        'judul_posting' => $this->input->post('judul_posting'),
                        'isi_posting' => $this->input->post('isi_posting'),
                        'tgl_posting' => date('Y-m-d'),
                        'link_posting' => $link,
                        'lampiran_gambar'=> $this->input->post('lampiran_gambar'),
                        'tgl_publish' => $this->input->post('tgl_publish'),
                        'tgl_exp' => $this->input->post('tgl_exp'),
                        'group_posting' => $this->input->post('group_posting'),
                        'status_komentar' => $status_komentar,
                        'status_posting' => $this->input->post('status_posting'),
                        'userinput' => $this->session->userdata("username"),
                    );
                    if(empty($row)){
                        $this->form_validation->set_rules('id_kategori', 'id kategori', 'required');
                        $this->form_validation->set_rules('judul_posting', 'judul posting', 'required');
                        $this->form_validation->set_rules('isi_posting', 'isi posting', 'required');
                        $this->form_validation->set_rules('group_posting', 'group posting', 'required');
                        if($this->form_validation->run())
                        {
                            $insert = $this->posting_model->insertPosting($data);
                            //header('Content-Type: application/json');
                            //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                            header('location:'.base_url()."admin/posting");
                        }else{
                            $array = array(
                                'status'    => TRUE,
                                'error'     => TRUE,
                                'csrf'      => $this->security->get_csrf_hash(),
                                'message'   => "Data Belum Lengkap",
                                'err_id_kategori' => form_error('id_kategori'),
                                'err_judul_posting' => form_error('judul_posting'),
                                'err_isi_posting' => form_error('isi_posting'),
                                'err_lampiran_gambar' => form_error('lampiran_gambar'),
                                'err_group_posting' => form_error('group_posting'),
                            );
                            $this->session->set_flashdata('error', $array);
                            //print_r($array);
                            header('location:'.base_url()."admin/posting/form");
                            //header('Content-Type: application/json');
                            //echo json_encode($array);
                        }
                    }else{
                        $this->form_validation->set_rules('id_kategori', 'id kategori', 'required');
                        $this->form_validation->set_rules('judul_posting', 'judul posting', 'required');
                        $this->form_validation->set_rules('isi_posting', 'isi posting', 'required');
                        $this->form_validation->set_rules('group_posting', 'group posting', 'required');
                        if($this->form_validation->run())
                        {
                            $this->posting_model->updatePosting($data,$id_posting);
                            //header('Content-Type: application/json');
                            //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                            header('location:'.base_url()."admin/posting");
                        }else{
                            $array = array(
                                'status'    => TRUE,
                                'error'     => TRUE,
                                'csrf'      => $this->security->get_csrf_hash(),
                                'message'   => "Data Belum Lengkap",
                                'err_id_kategori' => form_error('id_kategori'),
                                'err_judul_posting' => form_error('judul_posting'),
                                'err_isi_posting' => form_error('isi_posting'),
                                'err_group_posting' => form_error('group_posting'),
                            );
                            //header('Content-Type: application/json');
                            //echo json_encode($array);
                            //$this->session->set_flashdata('error', $array);
                            header('location:'.base_url()."admin/posting/form/".$id_posting);
                        }
                    }
                
            }    
        }else{
            //header('Content-Type: application/json');
            //echo json_encode(array("status" => False,'error'=>TRUE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
            $this->session->set_flashdata('error', array("Anda tidak berhak untuk mengakases halaman ini"));
            header('location:'.base_url()."login");
        }
        //$isi=$this->input->post('isi_posting');
        //echo $isi;
    }
	function delete($id){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $this->posting_model->deletePosting($id);
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
                'data'  => $this->posting_model->getPosting(),
            );
            $this->load->view('admin/posting/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->posting_model->getPosting(),
            );
            $html=$this->load->view('admin/posting/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_POSTING.pdf";
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
        $config['max_width']            = 1200;
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

    function viewmedia($idmedia){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $this->load->model('media_model');
            $x['data']=$this->media_model->getDatamediabyid($idmedia);
            $this->load->view('admin/posting/view_media', $x);
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
    }

    function komentar($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('status_komentar'=>$val);
            $this->posting_model->updatePosting($data,$id_group);
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

    function status($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('status_posting'=>$val);
            $this->posting_model->updatePosting($data,$id_group);
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