<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('media_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->media_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'modul' => "Media",
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/media/view_tabel', $data, true);
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

    /*public function datamedia($idgroup){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'data'     => $this->media_model->getDatamedia($idgroup),
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
    }*/
	function edit($id=""){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $row=$this->media_model->getMedia_by_id($id);
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

    function status($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('status_group'=>$val);
            $this->media_model->updateMedia($data,$id_group);
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

    function galery($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('sebagai_galery'=>$val);
            $this->media_model->updateMedia($data,$id_group);
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

    function ppid($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('sebagai_ppid'=>$val);
            $this->media_model->updateMedia($data,$id_group);
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
    function download($id_group,$val){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $data=array('sebagai_download'=>$val);
            $this->media_model->updateMedia($data,$id_group);
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

    function upload(){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $image=$this->media_model->upload_files(_DIR_MEDIA_,'MEDIA',$_FILES['userfile']);
            //print_r($image); 
            $keterangan=$this->input->post('keterangan');
            //print_r($keterangan); exit;
            if(empty($image)){
                $response = array("status" => FALSE,'error'=>TRUE,"message"=>"Gagal Upload Data",'csrf'=> $this->security->get_csrf_hash(),);
            }else{
                $i=0;
                foreach ($image as $im) {
                    if(empty($im["error"])){
                        $data[]=array(
                            'id_groupmedia' => $this->input->post('id_group'),
                            'namafile'      => $im["filename"],
                            'keterangan'    => $keterangan[$i],
                            'status_media'  => 1
                        );
                    }else{
                        $error[]=$im["error"];
                    }
                    $i++;
                }
                if(empty($error)){
                    $this->db->insert_batch('m_media',$data);
                    $response = array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di upload",'csrf'=> $this->security->get_csrf_hash(),);
                }else{
                    $response = array("status" => FALSE,'error'=>TRUE,"message"=>$error[0],'csrf'=> $this->security->get_csrf_hash(),);
                }
            }
            
        }
        else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'csrf'=> $this->security->get_csrf_hash(),
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function datamedia($idgroup){
        $cek=array('aksi'=>'Edit');
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
    function viewmedia($idmedia){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $x['data']=$this->media_model->getDatamediabyid($idmedia);
            $this->load->view('admin/media/view_media', $x);
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
    }

    function updatemedia(){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $id_media=$this->input->post('x-id_media');
            $data=array(
                'keterangan'=>$this->input->post('keterangan'),
            );
            $this->db->where('id_media', $id_media);
            $this->db->update('m_media',$data);
            $response=array(
                'status'    => true,
                'id_group'  => $this->input->post('x-idgroup'),
                'message'   => "Berhasil Update media",
                'csrf'=> $this->security->get_csrf_hash(),
            );
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'csrf'=> $this->security->get_csrf_hash(),
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function deletemedia($id_media, $idgroup){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            //$id_media=$this->input->post('id_media');
            
            $this->db->where('id_media', $id_media);
            $this->db->delete('m_media');
            
            $response=array(
                'status'    => true,
                'id_group'  => $idgroup,
                'message'   => "Berhasil Delete media",
                'csrf'=> $this->security->get_csrf_hash(),
            );
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'csrf'=> $this->security->get_csrf_hash(),
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
	function save(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $id_group=$this->input->post('id_group');
            if($this->input->post('status_group')==1) $status_group=1; else $status_group=0;
            if($this->input->post('sebagai_galery')==1) $sebagai_galery=1; else $sebagai_galery=0;
            if($this->input->post('sebagai_download')==1) $sebagai_download=1; else $sebagai_download=0;
            if($this->input->post('sebagai_ppid')==1) $sebagai_ppid=1; else $sebagai_ppid=0;
            $data = array(
                'nama_group' => $this->input->post('nama_group'),
                'status_group' => $status_group,
                'sebagai_galery' => $sebagai_galery,
                'sebagai_download' => $sebagai_download,
                'sebagai_ppid' => $sebagai_ppid,
            );
            $row=$this->media_model->getMedia_by_id($id_group);
            if(empty($row)){
                $this->form_validation->set_rules('nama_group', 'nama group', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->media_model->insertMedia($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_nama_group' => form_error('nama_group'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                $this->form_validation->set_rules('nama_group', 'nama group', 'required');
                if($this->form_validation->run())
                {
                    $this->media_model->updateMedia($data,$id_group);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_nama_group' => form_error('nama_group'),
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
            $this->media_model->deleteMedia($id);
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
                'data'  => $this->media_model->getMedia(),
            );
            $this->load->view('admin/media/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->media_model->getMedia(),
            );
            $html=$this->load->view('admin/media/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_MEDIA.pdf";
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
            $this->media_model->aktifkan($id);
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
            $this->media_model->nonaktifkan($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Status Berhasil dinonaktifkan"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }

    
}