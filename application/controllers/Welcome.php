<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data=array();
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
