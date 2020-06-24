<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('landing_model');
	}
	public function index()
	{
		//$prodi_condition=array('content_tipe', 'Prodi',);
		$kon_prodi = array('content_tipe' => 'Prodi');
		$kon_pengumuman = array('content_tipe' => 'Pengumuman');
		$data=array(
			'mode'=> 'non-slider',
			'pintasan'=> $this->landing_model->getPintasan(),
			'prodi'	=> $this->landing_model->getContent($kon_prodi, 5),
			'pengumuman'	=> $this->landing_model->getContent($kon_pengumuman, 2)
		);
		$view=array( 
			'content'=> $this->load->view('public/index', $data, true)
		);
		$this->load->view('public/layout', $view);
	}
	function berita($tgl="", $link=""){
		if(empty($tgl)) {
			$data=array('list'=> array());
			$content=$this->load->view('public/berita', $data, true);
		}
		else {
			$data=array('row'=> array());
			$content=$this->load->view('public/berita_detail',	$data, true);
		}
		$view=array(
			'content'=> $content
		);
		$this->load->view('public/layout', $view);
	}

	function detail($tgl = "", $link = "")
	{
		if (empty($tgl)) {
			$data = array('list' => array());
			$content = $this->load->view('public/berita', $data, true);
		} else {
			$data = array('row' => array());
			$content = $this->load->view('public/berita_detail',	$data, true);
		}
		$view = array(
			'content' => $content
		);
		$this->load->view('public/layout', $view);
	}
	function slider(){
		$this->load->view('public/welcome_slider');
	}
	function notfound(){
		echo "Notfoud...";
	}
}
