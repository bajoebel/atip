<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $level=$this->session->userdata('level');
        
        $this->akses=$this->admin_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,
                'modul' => "Admin",
                'role'  => $this->admin_model->getRole('Admin')
            );
            $content=$this->load->view('admin/admin/view_tabel', $data, true);
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
            $row_count=$this->admin_model->countAdmin($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->admin_model->getAdminlimit($limit,$start,$q),
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
            $row=$this->admin_model->getAdmin_by_id($id);
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
            $id_admin=$this->input->post('id_admin');
            $data = array(
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'nohp' => $this->input->post('nohp'),
            );
            $row=$this->admin_model->getAdmin_by_id($id_admin);
            if(empty($row)){
                
                $this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'required');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email');
                $this->form_validation->set_rules('alamat', 'alamat', 'required');
                $this->form_validation->set_rules('nohp', 'nohp', 'required');
                $this->form_validation->set_rules('username', 'Username', 'required|is_unique[m_users.username]');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('role', 'Role Akses', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->admin_model->insertAdmin($data);
                    $users=array(
                        'username'  => $this->input->post('username'),
                        'password'  => md5($this->input->post('password')),
                        'ref_id'    => $insert,
                        'nama_lengkap'=> $this->input->post('nama_lengkap'),
                        'group_user'  => 'Admin',
                        'role'        => $this->input->post('role'),
                        'status_user'   => 1
                    );
                    $this->db->insert('m_users', $users);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_nama_lengkap' => form_error('nama_lengkap'),
                        'err_email' => form_error('email'),
                        'err_alamat' => form_error('alamat'),
                        'err_nohp' => form_error('nohp'),
                        'err_username' => form_error('username'),
                        'err_password' => form_error('password'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                $this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'required');
                $this->form_validation->set_rules('email', 'email', 'required');
                $this->form_validation->set_rules('alamat', 'alamat', 'required');
                $this->form_validation->set_rules('nohp', 'nohp', 'required');
                if($this->form_validation->run())
                {
                    $this->admin_model->updateAdmin($data,$id_admin);

                    $users=array(
                        'nama_lengkap'=> $this->input->post('nama_lengkap'),
                        'role'        => $this->input->post('role')
                    );
                    $this->db->where('username', $this->input->post('username'));
                    $this->db->update('m_users', $users);

                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_nama_lengkap' => form_error('nama_lengkap'),
                        'err_email' => form_error('email'),
                        'err_alamat' => form_error('alamat'),
                        'err_nohp' => form_error('nohp'),
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
            $this->admin_model->deleteAdmin($id);
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
                'data'  => $this->admin_model->getAdmin(),
            );
            $this->load->view('admin/admin/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(3)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->admin_model->getAdmin(),
            );
            $html=$this->load->view('admin/admin/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_ADMIN.pdf";
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