<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
	//Form dan Halaman
	public function index()
	{
		$data=array(
			'content'=>$this->load->view('admin/kategori/view_kategori','',true),
			'libjs'	=> 'kategori.js',
			'modul'	=> 'Kategori'
		) ;
		$this->load->view('template/admin/view_layout', $data);
	}
	
	//Proses Data
	
}
