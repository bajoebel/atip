<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('landing_model');
		$this->landing_model->hits_statistik();
	}
	public function index()
	{
		//$prodi_condition=array('content_tipe', 'Prodi',);
		$kon_prodi = array('content_tipe' => 'Prodi', 'content_status' => 'Publish');
		$kon_pengumuman = array('content_tipe' => 'Pengumuman', 'content_status' => 'Publish');
		$kon_berita = array('content_tipe' => 'Berita', 'content_top'=>1, 'content_status'=>'Publish');
		$data=array(
			'mode'=> _MODE_,
			'pintasan'=> $this->landing_model->getPintasan(),
			'slider'	=> $this->landing_model->getSlider(),
			'prodi'	=> $this->landing_model->getContent($kon_prodi, 5, '','ASC'),
			'pengumuman'	=> $this->landing_model->getContent($kon_pengumuman, 2),
			'berita'		=> $this->landing_model->getContent($kon_berita, 7)
		);
		$view=array( 
			'content'=> $this->load->view('public/index', $data, true),
			'lib'=>'slider.js'
		);
		$this->load->view('public/layout', $view);
	}
	function font(){
		$this->load->view('public/font');
	}
	function form($link){
		$data = array(
			'content_tipe'=>'Form',
			'form'		=> $this->landing_model->getForm($link)
		);
		$view = array(
			'content' => $this->load->view('public/form', $data, true),
			'lib' => 'slider.js'
		);
		$this->load->view('public/layout', $view);
	}
	function json(){
		$field[]=array('field'=>'alamat_email','alias'=>'Alamat Email','type'=>'varchar','control'=>'textbox','source'=>'');
		$field[] = array('field' => 'nip', 'alias' => 'Nip', 'type' => 'varchar', 'control' => 'textbox', 'source' => '');
		$field[] = array('field' => 'nama_pegawai', 'alias' => 'Nama Pegawai', 'type' => 'varchar', 'control' => 'textbox', 'source' => '');
		$field[] = array('field' => 'lokasi_kerja', 'alias' => 'Lokasi Kerja', 'type' => 'varchar', 'control' => 'combobox', 'source' => 'Kantor,Rumah,Lainnya');
		$field[] = array('field' => 'kondisi_saat_ini', 'alias' => 'Bagaimana Kondisi Anda Saat Ini ?', 'type' => 'varchar', 'control' => 'radio', 'source' => 'Sehat,Tidak Sehat');
		$field[] = array('field' => 'apakah_anda_batuk', 'alias' => 'Apakah Anda Batuk ?', 'type' => 'varchar', 'control' => 'checkbox', 'source' => 'Ya, Tidak');
		$field[] = array('field' => 'apakah_anda_pilek', 'alias' => 'Apakah Anda Pilek ?', 'type' => 'varchar', 'control' => 'checkbox', 'source' => 'Ya, Tidak');
		$field[] = array('field' => 'apakah_anda_demam', 'alias' => 'Apakah Anda Demam ?', 'type' => 'varchar', 'control' => 'checkbox', 'source' => 'Ya, Tidak');
		header('Content-Type: application/json');
		echo json_encode($field);
	}
	function portofolio(){
		
		$data=array('content_tipe' => 'Apa Yang Sudah Kami Lakukan');
		$content = $this->load->view('public/portofolio',	$data, true);
		$view = array(
			'lib'	=> 'portofolio.js',
			'content' => $content
		);
		$this->load->view('public/layout', $view);
	}
	function dataportofolio($start){
		$start = intval($this->input->get('start'));
		$limit = 6;
		$kondisi=array('content_tipe'=> 'Portofolio', 'content_status' => 'Publish');
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
	function berita(){
		
		$kon_berita = array('content_tipe' => 'Berita', 'content_top' => 1, 'content_status' => 'Publish');
		$top= $this->landing_model->getContent($kon_berita);
		if(!empty($top)) $kecuali=array('content_link', $top[0]->content_link);
		$data = array('content_tipe' => 'Berita','top'=>$top,1);
		$content = $this->load->view('public/berita', $data, true);
		$view=array(
			'lib'	=> 'berita.js',
			'content'=> $content
		);
		$this->load->view('public/layout', $view);
	}
	function archive($tahun,$bulan)
	{
		$data = array('content_tipe' => 'Archive','tahun'=>$tahun,'bulan'=>$bulan);
		$content = $this->load->view('public/archive', $data, true);
		$view = array(
			'lib'	=> 'archive.js',
			'content' => $content
		);
		$this->load->view('public/layout', $view);
	}
	function cari(){
		$q=$this->input->get('q');
		$start = intval($this->input->get('start'));
		$limit = 6;
		$kondisi = array('content_status' => 'Publish');
		$row_count = $this->landing_model->countCari($kondisi, $q);
		$list = array(
			'status'    => true,
			'message'   => "OK",
			'start'     => $start,
			'row_count' => $row_count,
			'limit'     => $limit,
			'data'     => $this->landing_model->getCari($kondisi, $limit, $start, $q),
		);
		header('Content-Type: application/json');
		echo json_encode($list);
	}
	function databerita($start=0)
	{
		//$start = intval($this->input->get('start'));
		$limit = 3;
		$kon_berita = array('content_tipe' => 'Berita', 'content_top' => 1, 'content_status' => 'Publish');
		$top = $this->landing_model->getContent($kon_berita);
		if (!empty($top)) $kecuali = array($top[0]->content_link);else $kecuali=array();

		$kondisi = array('content_tipe' => 'Berita', 'content_status' => 'Publish');
		$row_count = $this->landing_model->countContent($kondisi,$kecuali);
		$list = array(
			'status'    => true,
			'message'   => "OK",
			'start'     => $start,
			'row_count' => $row_count,
			'limit'     => $limit,
			'data'     => $this->landing_model->getContentlimit($kondisi, $limit, $start, $kecuali),
		);
		header('Content-Type: application/json');
		echo json_encode($list);
	}

	function dataarchive($start = 0)
	{
		$bulan = intval($this->input->get('bulan'));
		$tahun = intval($this->input->get('tahun'));
		$limit = 6;
		$kon_berita = array('content_tipe' => 'Berita', 'content_top' => 1, 'content_status' => 'Publish','YEAR(content_tglpublish)'=> $tahun,'MONTH(content_tglpublish)'=> $bulan);
		$top = $this->landing_model->getContent($kon_berita);
		if (!empty($top)) $kecuali = array($top[0]->content_link);
		else $kecuali = array();

		$kondisi = array('content_tipe' => 'Berita', 'content_status' => 'Publish');
		$row_count = $this->landing_model->countContent($kondisi, $kecuali);
		$list = array(
			'status'    => true,
			'message'   => "OK",
			'start'     => $start,
			'row_count' => $row_count,
			'limit'     => $limit,
			'data'     => $this->landing_model->getContentlimit($kondisi, $limit, $start, $kecuali),
		);
		header('Content-Type: application/json');
		echo json_encode($list);
	}

	function pengumuman()
	{

		$data = array('content_tipe' => 'Pengumuman', 'content_status'=> 'Publish');
		$content = $this->load->view('public/pengumuman', $data, true);
		$view = array(
			'lib'	=> 'pengumuman.js',
			'content' => $content
		);
		$this->load->view('public/layout', $view);
	}
	function datapengumuman($start = 0)
	{
		$start = intval($this->input->get('start'));
		$limit = 6;
		$kondisi = array('content_tipe' => 'Pengumuman', 'content_status' => 'Publish');
		$row_count = $this->landing_model->countContent($kondisi);
		$list = array(
			'status'    => true,
			'message'   => "OK",
			'start'     => $start,
			'row_count' => $row_count,
			'limit'     => $limit,
			'data'     => $this->landing_model->getContentlimit($kondisi, $limit, $start),
		);
		header('Content-Type: application/json');
		echo json_encode($list);
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
	function otherMenu(){
		$data=$this->db->get('m_menu')->result();
		$respone=array(
			'status'=>true,
			'data'=>$data
		);
		echo json_encode($respone);
	}
	function notfound(){
		echo "Notfoud...";
	}
	function layout($page='homepage'){
		$data=array('page'=>$page);
		$this->load->view('public/contoh', $data);
	}
	function simpandata(){
		$field=$this->input->post('field');
		$form_id = $this->input->post('form_id');
		foreach ($field as $f ) {
			$control	= $this->input->post('control_' .$f);
			$source		= $this->input->post('source_' .$f);
			$isi["field"] = $f;
			
			if($control=="checkbox"){
				$src=explode(',',$source);
				if(count($src)>1){
					$val= $this->input->post($f);
					if($val==$src[0]) $isi[$f]=$val;
					else $isi[$f]=$src[1];
				}
			}else{
				$isi[$f] = $this->input->post($f);
			}
		}
		if(empty($isi)) $isi=array();
		$data=array('isi_formid'=>$form_id,'isi_baris'=>json_encode($isi));
		$this->db->insert('p_form_isi',$data);
		$insert_id = $this->db->insert_id();
		if($insert_id){
			$response=array('status'=>true,'message'=>'Data Berhasil disimpan');
		}else{
			$response = array('status' => false, 'message' => 'Gagal saat penyimpanan data');
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}
