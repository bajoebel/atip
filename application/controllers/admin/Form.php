<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('form_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->form_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul' => "Form",
                'role'  => $this->form_model->getRole('form')
            );
            $content=$this->load->view('admin/form/view_tabel', $data, true);
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

    public function tambah($id="")
    {
        $cek = array('aksi' => "Save");
        if (in_array($cek, $this->akses)) {
            $row=$this->form_model->getform_by_id($id);
            
            $data = array(
                'menu'  => array(),
                'akses' => $this->akses,
                'modul' => "Form",
                'role'  => $this->form_model->getRole('form'),
                'row'=>$row
            );
            $content = $this->load->view('admin/form/view_tambah', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }
    function source(){
        $source = $this->db->get('p_form')->result();
        header('Content-Type: application/json');
        echo json_encode($source);
    }
	public function data(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = intval($this->input->get('limit'));
            $row_count=$this->form_model->countform($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->form_model->getformlimit($limit,$start,$q),
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
            $row=$this->form_model->getform_by_id($id);
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
    function lihat($id = "")
    {
        $cek = array('aksi' => "Save");
        if (in_array($cek, $this->akses)) {
            $row = $this->form_model->getform_by_id($id);

            $data = array(
                'menu'  => array(),
                'akses' => $this->akses,
                'modul' => "Form",
                'role'  => $this->form_model->getRole('form'),
                'row' => $row
            );
            $content = $this->load->view('admin/form/view_lihat', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }
    public function data_form($form_id)
    {
        $cek = array('aksi' => "Index");
        if (in_array($cek, $this->akses)) {
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = intval($this->input->get('limit'));
            $row_count = $this->form_model->countformdata($form_id,$q);
            $x['header']=$this->form_model->getform_by_id($form_id);
            $x["start"]=$start;
            $x['data_form']=$this->form_model->getformdata($form_id,$limit, $start, $q);
            $data=$this->load->view('admin/form/data_form', $x, true);
            //echo $data; exit;
            $list = array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $data
            );
        } else {
            $list = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'data'      => array()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($list);
    }
	function save(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $id_form=$this->input->post('form_id');
            $link = str_replace(' ', '-', strtolower($this->input->post('form_title')));
            $link = str_replace('&', 'dan', $link);
            $link = str_replace('"', '', $link);
            
            $row=$this->form_model->getform_by_id($id_form);
            if(empty($row)){
                
                $this->form_validation->set_rules('form_title', 'nama lengkap', 'required');
                
                if($this->form_validation->run())
                {
                    
                    $idx=$this->input->post('idx');
                    foreach ($idx as $i) {
                        $source= $this->input->post('source' . $i);
                        if($source=="-") $source= $this->input->post('source_lain' . $i);
                        $field[] = array(
                            'field' => str_replace(" ","_", $this->input->post('field' . $i)), 
                            'alias' => $this->input->post('field' . $i),
                            'control' => $this->input->post('control' . $i), 
                            'source' => $source,
                        );
                    }
                    if(empty($field)) $field=json_encode(array());
                    $field=json_encode($field);
                    $data = array(
                        'form_title' => $this->input->post('form_title'),
                        'form_link' => $link,
                        'form_field' => $field,
                        'form_tglbuat' => date('Y-m-d H:i:s'),
                        'form_userbuat' => $this->session->userdata('username')
                    );
                    $insert = $this->form_model->insertform($data);
                    header('location:'.base_url() ."admin/form");
                    //header('Content-Type: application/json');
                    //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_form_title' => form_error('form_title'),
                    );
                    header('location:' . base_url() . "admin/form");
                }
            }else{
                
                $this->form_validation->set_rules('form_title', 'nama lengkap', 'required');
                if($this->form_validation->run())
                {
                    $idx = $this->input->post('idx');
                    foreach ($idx as $i) {
                        $source = $this->input->post('source' . $i);
                        if ($source == "-") $source = $this->input->post('source_lain' . $i);
                        $field[] = array(
                            'field' => str_replace(" ", "_", $this->input->post('field' . $i)),
                            'alias' => $this->input->post('field' . $i),
                            'control' => $this->input->post('control' . $i),
                            'source' => $source
                        );
                    }
                    if (empty($field)) $field = json_encode(array());
                    $field = json_encode($field);
                    $data = array(
                        'form_title' => $this->input->post('form_title'),
                        'form_link' => $link,
                        'form_field' => $field,
                        'form_tglbuat' => date('Y-m-d H:i:s'),
                        'form_userbuat' => $this->session->userdata('username')
                    );
                    $this->form_model->updateform($data,$id_form);
                    header('location:' . base_url() . "admin/form");
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_form_title' => form_error('form_title'),
                    );
                    header('location:' . base_url() . "admin/form");
                }
            }
        }else{
            header('Content-Type: application/json');
            header('location:' . base_url() . "login");
        }
    }
	function delete($id){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $this->form_model->deleteform($id);
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
                'data'  => $this->form_model->getform(),
            );
            $this->load->view('form/admin/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->form_model->getform(),
            );
            $html=$this->load->view('form/admin/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_form.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }
}