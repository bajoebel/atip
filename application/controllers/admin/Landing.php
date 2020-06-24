<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('landing_model');
        
        
    }
        
	public function index(){
        $data=array(
            'slide'=>$this->landing_model->getSlider(),
            'recent'=> $this->landing_model->getRecentpost(3),
            'banner'    => $this->landing_model->getBanner(),
            'partner'   => $this->landing_model->getPartner()
        );
        $view=array(
            'slider'    => $this->load->view('public/view_slider',$data,true),
            'shorcut'   => $this->load->view('public/view_shorcut',$data, true),
            'content'      => $this->load->view('public/view_blog',$data,true),
            'banner'      => $this->load->view('public/view_banner',$data,true),
            'partner'      => $this->load->view('public/view_partner',$data,true)
        );
        $this->landing_model->hits_statistik();
        $this->load->view('public/view_layout',$view);
    }
    function berita(){
        $data=array();
        $view=array(
            'content'      => $this->load->view('public/view_artikel',$data,true)
        );
        $this->landing_model->hits_statistik();
        $this->load->view('public/view_layout',$view);
    }
    function list_berita(){
        $this->load->model('posting_model');
        $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 20;
            $row_count=$this->posting_model->countPosting($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->posting_model->getPostinglimit($limit,$start,$q),
            );
        header('Content-Type: application/json');
        echo json_encode($list);
    }
    public function notfound(){

        $view=array(
            'content'    => $this->load->view('public/view_404','',true)
        );
        $this->load->view('public/view_layout',$view);
    }
	public function layanan(){
        $this->landing_model->hits_statistik();
        $data=array(
            'tipe'      => $this->landing_model->getTipe(),
            'rumpun'    => $this->landing_model->getRumpun(),                                                                                                                                                                                                                                                                                                                                                                                                      
            'bidang'    => $this->landing_model->getBidang(),
            'judul' => 'Layanan'
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_persyaratan',$data,true)
        );
        $this->load->view('public/view_layout',$view);
     }

     public function detail_layanan($id){
        $this->landing_model->hits_statistik();
        $this->load->model('izin_model');
        $row=$this->izin_model->getIzin_by_id($id);
        //print_r($row); exit;
        $data=array(
                'row'=>$this->izin_model->getIzin_by_id($id),
                'list_m_rumpun'=>$this->izin_model->getM_rumpun(),
                'mekanisme' => $this->izin_model->getMekanisme($id),
                'persyaratan'=> $this->izin_model->getPersyaratan($id),
                'dasarhukum'=> $this->izin_model->getDasarhukum($id),
                'list_m_bidang'=>$this->izin_model->getM_bidang(),
                'list_tipe'=>$this->izin_model->getTipe(),
                'produk'    => $this->izin_model->getProduk(),
                'select_produk' => $this->izin_model->selectProduk($id),
                'judul' => 'Detail Layanan'
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_detail_persyaratan',$data,true)
        );
        $this->load->view('public/view_layout',$view);
     }

     public function izin(){
        $this->landing_model->hits_statistik();
        $this->load->model('izin_model');
        $q = urldecode($this->input->get('q', TRUE));
        $bidang=$this->input->get('bidang');
        $tipe = $this->input->get('tipe');
        $rumpun = $this->input->get('rumpun');
        $start = intval($this->input->get('start'));
        $limit = 20;
        $row_count=$this->izin_model->countIzin($q);
        $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->izin_model->cariIzin($limit,$start,$q, $bidang,$tipe,$rumpun),
        );
        header('Content-Type: application/json');
        echo json_encode($list);
    }

     function izin_bidang($id_bidang){
        $this->landing_model->hits_statistik();
        $bidang=$this->landing_model->getIzinperbidang($id_bidang);
        $response=array('status'=>true,'data'=>$bidang);
        header('Content-Type: application/json');
        echo json_encode($response);
     }

     function faq(){
        $this->landing_model->hits_statistik();
        $data=array(
            'pertanyaan'=> $this->landing_model->getPertanyaan(),
            'judul' => 'faq'
        );

        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_faq',$data,true)
        );
        $this->load->view('public/view_layout',$view);
     }

     public function daftar(){
        $this->landing_model->hits_statistik();
        $data=array(
            'tipe'  => $this->landing_model->getTipe()
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan','',true),
            'content'    => $this->load->view('public/view_persyaratan',$data,true)
        );
        $this->load->view('public/view_layout',$view);
     }

     function detail($tgl_publish,$link){
        $this->landing_model->hits_statistik();
        $artikel=$this->landing_model->getArtikel($tgl_publish,$link);
        $data=array(
            'artikel'   => $artikel,
            'judul'     => $artikel->judul_posting,
            'desc'      => substr(strip_tags($artikel->isi_posting), 0,200)
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_detail_artikel',$data,true)
        );
        $this->landing_model->hits($link);
        $this->load->view('public/view_layout',$view);
     }

    function page($link){
        $this->landing_model->hits_statistik();
        $artikel=$this->landing_model->getPage($link);
        $data=array(
            'artikel'   => $artikel,
            'judul'     => $artikel->judul_posting,
            'desc'      => substr(strip_tags($artikel->isi_posting), 0,2)
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_detail_page',$data,true)
        );
        $this->landing_model->hits($link);
        $this->load->view('public/view_layout',$view);
    }

    function pdf($id){
        $data=array(
            'artikel'=>$this->landing_model->getPosting($id)
        );
        $html=$this->load->view('public/view_cetak_pdf', $data, true);
        $pdfFilePath = "CONTENT_" .$id .".pdf";
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "D");
        $pdf->Output();
    }
    function insert_komentar(){
            $this->load->model("komentar_model");
            $data = array(
                'id_post' => $this->input->post('id_post'),
                'email' => $this->input->post('email'),
                'nama' => $this->input->post('nama'),
                'website'=> $this->input->post('website'),
                'komentar' => $this->input->post('komentar'),
                'tgl_komentar'  => date('Y-m-d H:i:s'),
                'status' => 1,
            );
            $this->form_validation->set_rules('id_post', 'id post', 'required');
            $this->form_validation->set_rules('email', 'email', 'required');
            $this->form_validation->set_rules('nama', 'nama', 'required');
            $this->form_validation->set_rules('komentar', 'komentar', 'required');
            if($this->form_validation->run())
            {
                $insert = $this->komentar_model->insertKomentar($data);
                header('Content-Type: application/json');
                echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
            }else{
                $array = array(
                    'status'    => TRUE,
                    'error'     => TRUE,
                    'csrf'      => $this->security->get_csrf_hash(),
                    'message'   => "Data Belum Lengkap",
                    'err_id_post' => form_error('id_post'),
                    'err_email' => form_error('email'),
                    'err_nama' => form_error('nama'),
                    'err_komentar' => form_error('komentar'),
                );
                header('Content-Type: application/json');
                echo json_encode($array);
            }
    }

    function getkomen($id_post){
        $list=array(
                'status'    => true,
                'message'   => "OK",
                'data'     => $this->landing_model->getKomentar($id_post),
        );
        header('Content-Type: application/json');
        echo json_encode($list);
    }

    function galery(){
        $this->landing_model->hits_statistik();
        $data=array(
            'galery'   => $this->landing_model->getGalery(),
            'group'     => $this->landing_model->getGroupmedia(),
            'judul'     => 'Galery'
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_galery',$data,true)
        );
        $this->load->view('public/view_layout',$view);
    }

    function ppid(){
        $this->landing_model->hits_statistik();
        $data=array(
            'ppid'   => $this->landing_model->getPpid(),
            'judul'     => 'PPID'
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_ppid',$data,true)
        );
        $this->load->view('public/view_layout',$view);
    }
    function download(){
        $this->landing_model->hits_statistik();
        $data=array(
            'download'   => $this->landing_model->getDownload(),
            'judul'     => 'Download'
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_download',$data,true)
        );
        $this->load->view('public/view_layout',$view);
    }

    function lacak(){
        $this->landing_model->hits_statistik();
        $data=array(
            'judul'     => 'Lacak'
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_lacak',$data,true)
        );
        $this->load->view('public/view_layout',$view);
    }

    function category($link=""){
        $this->landing_model->hits_statistik();
        $k=$this->landing_model->getKategori($link);
        //print_r($k);exit;
        if(!empty($k)) $judul = $k[0]->nama_kategori; else $judul="Kategori";
        $data=array(
            'kategori'   => $this->landing_model->getKategori($link),
            'judul'     => $judul,
            'url'      => $link
        );
        $view=array(
            'shorcut'   => $this->load->view('public/view_judul_persyaratan',$data,true),
            'content'    => $this->load->view('public/view_kategori',$data,true)
        );
        $this->load->view('public/view_layout',$view);
    }

    function data_kategori($link=""){
        $start = intval($this->input->get('start'));
        $limit = 4;
        $row_count=$this->landing_model->countKategori($link);
        $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->landing_model->getKategorilimit($limit,$start,$link),
        );
        header('Content-Type: application/json');
        echo json_encode($list);
    }

    function statistik(){
        $saat=time()-300;
        $bulan=date('m');
        $bln=array('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'Mei', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September','10'=>'October','11'=>'November', '12'=>'December');
        $data=array(
            'semua'     => $this->landing_model->getStatistik(),
            'sekarang'  => $this->landing_model->getStatistik(date('Y-m-d')),
            'online'    => $this->landing_model->getStatistik(date('Y-m-d'), $saat),
            'bulanini'  => $this->landing_model->getStatistikbulanan($bulan),
            'bulan'     => $bln[$bulan]
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function data_berita(){
        $start = intval($this->input->get('start'));
        $limit = 8;
        $row_count=$this->landing_model->countBerita();
        $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->landing_model->getBeritalimit($limit,$start),
        );
        header('Content-Type: application/json');
        echo json_encode($list);
    }

    function cek(){
        $q=$this->input->get('q');
        $list=array(
            'status'    => true,
            'message'   => "OK",
            'data'      => $this->landing_model->getPermintaan($q)
        );
        header('Content-Type: application/json');
        echo json_encode($list);
    }
}