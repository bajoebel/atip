<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Landing_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getSlider(){
        $this->db->where('status_slider',1);
        $this->db->join('p_posting','post_id=id_posting','LEFT');
        return $this->db->get('p_slider')->result();
    }
    function getPostslide(){
        $this->db->select('judul_posting,isi_posting,lampiran_gambar');
        $this->db->where('status_posting','Publish');
        $this->db->where('tgl_publish <= ', date('Y-m-d'));
        $this->db->group_start();
        $this->db->where('tgl_exp >= ', date('Y-m-d'));
        $this->db->or_where('tgl_exp','0000-00-00');
        $this->db->group_end();
        $this->db->where('tampil_slider',1);
        return $this->db->get('p_posting')->result();
    }
    function getTipe(){
        return $this->db->get('m_tipe')->result();
    }
    function getRumpun(){
        $this->db->where('status_rumpun',1);
        return $this->db->get('m_rumpun')->result();
    }
    function getBidang(){
        $this->db->where('status_bidang',1);
        return $this->db->get('m_bidang')->result();
    }

    function getIzinperbidang($id_bidang){
        $this->db->where('id_bidang',$id_bidang);
        return $this->db->get('m_izin')->result();
    }
    function getPertanyaan(){
        $this->db->where('status_faq',1);
        return $this->db->get('p_faq')->result();
    }
    function getArtikel($tgl_publish,$link){
        $this->db->select('*,count(id_komentar) as jml_komentar');
        $this->db->join('m_users','userinput=username','LEFT');
        $this->db->join('p_komentar','id_posting=id_post','LEFT');
        $this->db->where('status_posting','Publish');
        $this->db->where('tgl_publish', $tgl_publish);
        $this->db->where('tgl_publish <=', date('Y-m-d'));
        $this->db->where('link_posting', $link);
        return $this->db->get('p_posting')->row();
    }
    function getPage($link){
        $this->db->select('*,count(id_komentar) as jml_komentar');
        $this->db->join('m_users','userinput=username','LEFT');
        $this->db->join('p_komentar','id_posting=id_post','LEFT');
        $this->db->where('status_posting','Publish');
        $this->db->where('tgl_publish <=', date('Y-m-d'));
        $this->db->where('link_posting', $link);
        return $this->db->get('p_posting')->row();
    }
    function getPosting($id){
        $this->db->select('*,count(id_komentar) as jml_komentar');
        $this->db->join('m_users','userinput=username','LEFT');
        $this->db->join('p_komentar','id_posting=id_post','LEFT');
        $this->db->where('status_posting','Publish');
        $this->db->where('tgl_publish <=', date('Y-m-d'));
        $this->db->where('id_posting', $id);
        return $this->db->get('p_posting')->row();
    }
    function longdate($tgl){
        if(!empty($tgl)){
            $tg=explode(' ', $tgl);
            $bulan=array(
                '01'    => 'Januari',
                '02'    => 'Februari',
                '03'    => 'Maret',
                '04'    => 'April',
                '05'    => 'Mei',
                '06'    => 'Juni',
                '07'    => 'July',
                '08'    => 'Agustus',
                '09'    => 'September',
                '10'    => 'Oktober',
                '11'    => 'November',
                '12'    => 'Desember'
            );
            $t=explode('-', $tg[0]);
            return $t[2] ." " .$bulan[$t[1]] ." " .$t[0];
        }else return "";
    }

    function getCategory(){
        $this->db->select('nama_kategori,link_kategori,count(id_posting) as jml_artikel');
        $this->db->join('m_kategori','p_posting.id_kategori=m_kategori.id_kategori','LEFT');
        $this->db->group_by('p_posting.id_kategori');
        $this->db->where('group_posting','Artikel');
        return $this->db->get('p_posting')->result();
    }

    function getKategori($link="",$start=0,$limit=8){
        $this->db->select('*');
        $this->db->join('m_kategori','p_posting.id_kategori=m_kategori.id_kategori','LEFT');
        $this->db->where('group_posting','Artikel');
        $this->db->where('link_kategori',$link);
        $this->db->limit($limit, $start);
        return $this->db->get('p_posting')->result();
    }

    function getKategorilimit($limit=8,$start=0,$link=""){
        $this->db->select('*');
        $this->db->join('m_kategori','p_posting.id_kategori=m_kategori.id_kategori','LEFT');
        $this->db->where('group_posting','Artikel');
        if(!empty($link)) $this->db->where('link_kategori',$link);
        $this->db->limit($limit, $start);
        return $this->db->get('p_posting')->result();
    }

    function countKategori($link=""){
        $this->db->select('*');
        $this->db->join('m_kategori','p_posting.id_kategori=m_kategori.id_kategori','LEFT');
        $this->db->where('group_posting','Artikel');
        if(!empty($link)) $this->db->where('link_kategori',$link);
        return $this->db->get('p_posting')->num_rows();
    }

    function getKomentar($id_post){
        $this->db->where('id_post', $id_post);
        return $this->db->get('p_komentar')->result();
    }

    function hits($link){
        $this->db->query("UPDATE p_posting SET jml_hits=jml_hits+1 WHERE link_posting='$link'");
    }

    function getPopulerpost($limit){
        $sekarang=date('Y-m-d');
        $this->db->select('*');
        $this->db->where('status_posting','Publish');
        $this->db->where('group_posting','Artikel');
        $this->db->where('tgl_publish < ', $sekarang);
        $this->db->group_start();
        $this->db->where('tgl_exp','0000-00-00');
        $this->db->or_where('tgl_exp >',$sekarang);
        $this->db->group_end();
        $this->db->order_by('jml_hits','DESC');
        $this->db->limit($limit);
        return $this->db->get('p_posting')->result();
    }

    function getRecentpost($limit){
        $sekarang=date('Y-m-d');
        $this->db->select('*');
        $this->db->where('status_posting','Publish');
        $this->db->where('group_posting','Artikel');
        $this->db->where('tgl_publish < ', $sekarang);
        $this->db->group_start();
        $this->db->where('tgl_exp','0000-00-00');
        $this->db->or_where('tgl_exp >',$sekarang);
        $this->db->or_where('tgl_exp IS NULL');
        $this->db->group_end();
        $this->db->order_by('id_posting','DESC');
        $this->db->limit($limit);

        return $this->db->get('p_posting')->result();
    }

    function getMenuinduk(){
        $this->db->order_by('menu_idxutama');
        $this->db->order_by('menu_idxanak');
        $this->db->order_by('menu_idxsub');
        $this->db->where('menu_idxanak',0);
        $this->db->where('menu_status',1);
        return $this->db->get('m_menu')->result();
    }

    function getMenuanak($idxutama){
        //$this->db->order_by('menu_idxutama');
        $this->db->order_by('menu_idxanak');
        $this->db->order_by('menu_idxsub');
        //$this->db->group_by('menu_idxanak');
        $this->db->where('menu_status',1);
        $this->db->where('menu_idxanak >',0);
        $this->db->where('menu_idxutama', $idxutama);
        return $this->db->get('m_menu')->result();
    }

    function getMenulink($link=""){
        $this->db->where('menu_link', $link);
        $data =  $this->db->get("m_menu")->row();
        if(!empty($data)) return $data->menu_idxutama;
        else return "";
    }
    function getSubmenu($idxutama,$idxanak){
        $this->db->order_by('menu_idxutama');
        $this->db->order_by('menu_idxanak');
        $this->db->order_by('menu_idxsub');
        $this->db->where('menu_status',1);
        $this->db->where('menu_idxutama', $idxutama);
        $this->db->where('menu_idxanak',$idxanak);
        $this->db->where('menu_idxsub >',0);
        return $this->db->get('m_menu')->result();
    }

    function getGalery(){
        $this->db->join('m_groupmedia','id_groupmedia=id_group');
        $this->db->where('sebagai_galery',1);
        $this->db->where('status_group',1);
        $this->db->where('status_media',1);
        $this->db->order_by('id_groupmedia');
        return $this->db->get('m_media')->result();
    }

    function getGroupmedia(){
        $this->db->where('status_group',1);
        $this->db->where('sebagai_galery',1);
        return $this->db->get('m_groupmedia')->result();
    }

    function getPpid(){
        $this->db->join('m_groupmedia','id_groupmedia=id_group');
        $this->db->where('sebagai_ppid',1);
        return $this->db->get('m_media')->result();
    }
    function getDownload(){
        $this->db->join('m_groupmedia','id_groupmedia=id_group');
        $this->db->where('sebagai_download',1);
        return $this->db->get('m_media')->result();
    }

    function hits_statistik(){
        $IP=$_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
        $tanggal = date("Y-m-d"); // Mendapatkan tanggal sekarang
        $waktu   = time(); //

        $this->db->where('ip', $IP);
        $this->db->where('tanggal', $tanggal);
        $row=$this->db->get('statistik')->num_rows();
        if($row<=0){
            $data=array('ip'=> $IP,
                'tanggal'   => $tanggal,
                'hits'      => 1,
                'online'    => $waktu
            );

            $this->db->insert('statistik', $data);

        }else{
            $this->db->query("UPDATE statistik SET hits=hits+1, online='$waktu' WHERE ip='$IP' AND tanggal='$tanggal'");
        }
    }
    function getStatistik($tgl="",$online=""){
        $this->db->select("SUM(hits) as hits_visitor, count(ip) AS unique_visitor");
        if(!empty($tgl)) $this->db->where('tanggal',$tgl);
        if(!empty($online)) $this->db->where('online >= ', $online);
        return $this->db->get('statistik')->row();
    }
    function getStatistikbulanan($bulan=""){
        $this->db->select("SUM(hits) as hits_visitor, count(ip) AS unique_visitor");
        if(!empty($bulan)) $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->group_by('MONTH(tanggal)');
        if(!empty($bulan)) return $this->db->get('statistik')->row();
        else return $this->db->get('statistik')->result();
    }
    function getBanner(){
        $this->db->where('banner_status',1);
        return $this->db->get('p_banner')->result();
    }
    function getPartner(){
        $this->db->where('partner_status',1);
        return $this->db->get('p_partner')->result();
    }

    function getPermintaan($no_permintaan){
        $this->db->select('*,c.role_nama as tujuan,d.role_nama as asal');
        $this->db->where('no_permintaan', $no_permintaan);
        $this->db->join('t_permintaan','t_permintaan.id_permintaan=t_remark.remark_permintaanid');
        $this->db->join('m_izin','t_permintaan.id_izin=m_izin.id_izin');
        $this->db->join('m_pemohon','t_permintaan.id_pemohon=m_pemohon.id_pemohon');
        $this->db->join('m_proses','id_proses=remark_idproses');
        $this->db->join('m_users a','t_remark.remark_tujuanid = a.username');
        $this->db->join('m_users b','t_remark.remark_asal = b.username');
        $this->db->join('m_role c','a.role=c.role_id');
        $this->db->join('m_role d','b.role=d.role_id');
        $this->db->order_by('remark_id');
        return $this->db->get('t_remark')->result();
    }
}