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
		$kon_prodi = array('content_tipe' => 'Prodi', 'content_status' => 'Publish');
		$kon_pengumuman = array('content_tipe' => 'Pengumuman', 'content_status' => 'Publish');
		$kon_berita = array('content_tipe' => 'Berita', 'content_top'=>1, 'content_status'=>'Publish');
		$data=array(
			'mode'=> 'non-slider',
			'pintasan'=> $this->landing_model->getPintasan(),
			'prodi'	=> $this->landing_model->getContent($kon_prodi, 5),
			'pengumuman'	=> $this->landing_model->getContent($kon_pengumuman, 2),
			'berita'		=> $this->landing_model->getContent($kon_berita, 7)
		);
		$view=array( 
			'content'=> $this->load->view('public/index', $data, true)
		);
		$this->load->view('public/layout', $view);
	}
	function portofolio(){
		
		$data=array('content_tipe' => 'Apa Yang Sudah Kami Lakukan');
		$content = $this->load->view('public/portofolio',	$data, true);
		$view = array(
			'lib'	=> 'lib.js',
			'content' => $content
		);
		$this->load->view('public/layout', $view);
	}
	function dataportofolio($start){
		$start = intval($this->input->get('start'));
		$limit = 6;
		$kondisi=array('content_tipe'=> 'Portofolio');
		$row_count = $this->landing_model->countContent($kondisi);
		$list = array(
			'status'    => true,
			'message'   => "OK",
			'start'     => $start,
			'row_count' => $row_count,
			'limit'     => $limit,
			'data'     => $this->landing_model->getContentlimit($kondisi,$limit, $start),
		);
		header('Content-Type: application/json');
		echo json_encode($list);
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

	function detail($link = "")
	{
		$row= $this->landing_model->getDetailContent($link);
		if(!empty($row)){
			if($row->content_tipe=='Prodi') {
				$con_content=array('content_tipe'=>$row->content_tipe);
				$con_tag = array();
			}
			else {
				$con_content = array('content_tipe' => $row->content_tipe);
				$con_tag = explode(',', $row->content_tag);
				
			}
			$terkait=$this->landing_model->getContentTerkait($con_content, $con_tag, $link);
		}else{
			$terkait=array();
		}
		$lampiran=$this->landing_model->getLampiran($link);
		$data = array('row' => $row, 'terkait'=> $terkait,'lampiran'=>$lampiran);
		$content = $this->load->view('public/berita_detail',	$data, true);
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
