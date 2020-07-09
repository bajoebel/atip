<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		if($this->session->userdata("username")){
			$arr=$this->db->query("SELECT SUM(CASE WHEN `content_tipe` = 'Halaman' THEN 1 ELSE 0 END) AS `halaman`,
			SUM(CASE WHEN `content_tipe` = 'Berita' THEN 1 ELSE 0 END) AS `berita`,
			SUM(CASE WHEN `content_tipe` = 'Pengumuman' THEN 1 ELSE 0 END) AS `pengumuman`,
			SUM(CASE WHEN `content_tipe` = 'Prodi' THEN 1 ELSE 0 END) AS `prodi`,
			SUM(CASE WHEN `content_tipe` = 'Portofolio' THEN 1 ELSE 0 END) AS `portofolio`
			FROM `p_content`")->row_array();
			$this->db->select('tanggal, SUM(hits) as hits');
			$this->db->where('tanggal <=', date('Y-m-d'));
			$this->db->group_by('tanggal');
			$this->db->limit(10);
			$arr["hits"] = $this->db->get('statistik')->result();
			$data=array(
				'content'=>$this->load->view('admin/view_dashboard',$arr,true),
				'modul'	=> 'Dashboard'
			) ;
			$this->load->view('template/admin/view_layout', $data);
		}else{
			$this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
		}
		
	}
	function json(){
		$arr=array(array('y'=> '2014-10-10','b'=>12),array('y'=> '2014-10-10','b'=>12),array('y'=> '2014-10-10','b'=>12));
		
		header('Content-Type: application/json');
		echo json_encode($arr);
	}
	function login(){
		$this->load->view('view_login');
	}
	
}
