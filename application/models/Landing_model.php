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
        $this->db->join('p_content','content_id=post_id','LEFT');
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
        $this->db->limit(5);
        return $this->db->get('p_partner')->result();
    }

    function getTopMenu(){
        $this->db->order_by('menu_idxutama');
        $this->db->where('menu_top', 1);
        $this->db->where('menu_status', 1);
        return $this->db->get('m_menu')->result();
    }
    function getContent($condition, $limit=0, $kecuali=array(), $urut='DESC'){
        $this->db->where($condition);
        $this->db->where('content_tglpublish <= ', date('Y-m-d'));
        if(!empty($kecuali)) $this->db->where_not_in('content_link', $kecuali);
        $this->db->group_start();
        $this->db->where('content_tglexp','0000-00-00');
        $this->db->or_where('content_tglexp > ', date('Y-m-d'));
        $this->db->group_end();
        $this->db->order_by('content_tglpublish', 'desc');
        $this->db->order_by('content_id', $urut);
        if($limit>0) $this->db->limit($limit);
        return $this->db->get('p_content')->result();
    }
    
    function getForm($link){
        $this->db->where('form_status',1);
        $this->db->where('form_link',$link);
        return $this->db->get('p_form')->row();
    }
    function getIsi($link){
        $this->db->where('form_link',$link);
        $this->db->join('p_form_isi','form_id=isi_formid');
        return $this->db->get('p_form')->result();
    }
    function getCari($condition, $limit = 0, $start= 0 ,$q="", $urut = 'DESC')
    {
        $this->db->where($condition);
        $this->db->where('content_tglpublish <= ', date('Y-m-d'));
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('content_judul', $q);
            $this->db->or_like('content_isi', $q);
            $this->db->group_end();
        }
        $this->db->group_start();
        $this->db->where('content_tglexp', '0000-00-00');
        $this->db->or_where('content_tglexp > ', date('Y-m-d'));
        $this->db->group_end();
        $this->db->order_by('content_tglpublish', 'desc');
        $this->db->order_by('content_id', $urut);
        $this->db->limit($limit, $start);
        return $this->db->get('p_content')->result();
    }
    function countCari($kondisi, $q="")
    {
        $this->db->where($kondisi);
        $this->db->where('content_tglpublish <= ', date('Y-m-d'));
        if (!empty($q)) {
            //$this->db->group_start();
            $this->db->like('content_judul', $q);
            $this->db->or_like('content_isi', $q);
            //$this->db->group_end();
        }
        $this->db->group_start();
        $this->db->where('content_tglexp', '0000-00-00');
        $this->db->or_where('content_tglexp > ', date('Y-m-d'));
        $this->db->group_end();
        $this->db->order_by('content_tglpublish', 'desc');
        $this->db->order_by('content_id', 'desc');
        return $this->db->get('p_content')->num_rows();
    }
    function getDetailContent($link){
        $this->db->where('content_link', $link);
        $this->db->where('content_tglpublish <= ', date('Y-m-d'));
        $this->db->group_start();
        $this->db->where('content_tglexp', '0000-00-00');
        $this->db->or_where('content_tglexp > ', date('Y-m-d'));
        $this->db->group_end();
        $this->db->join('m_users','m_users.username=p_content.userinput','left');
        return $this->db->get('p_content')->row();
    }
    function getPintasan(){
        $this->db->where('pintasan_status',1);
        return $this->db->get('p_pintasan')->result();
    }
    function getContentTerkait($kondisi, $tag, $link){
        $this->db->where($kondisi);
        $this->db->where_not_in('content_link', array($link));
        if(!empty($tag)){
            $i=0;
            if(count($tag)>1) $this->db->group_start();
            foreach ($tag as $t ) {
                $i++;
                if($i==1) $this->db->like('content_tag',$t.",");
                else $this->db->or_like('content_tag', $t .",");
                
            }
            if (count($tag) > 1) $this->db->group_end();
        }
        return $this->db->get('p_content')->result();
    }
    function getLampiran($link){
        $this->db->where('content_link', $link);
        $this->db->join('p_lampiran', 'p_lampiran.content_id=p_content.content_id');
        return $this->db->get('p_content')->result();
    }
    function getLinkMedia($idmedia){
        $this->db->where('id_media', $idmedia);
        $data=$this->db->get('m_groupmedia')->row();
        if(!empty($data)) return $data->media_link;
    }
    function countContent($kondisi, $kecuali=array()){
        $this->db->where($kondisi);
        $this->db->where('content_tglpublish <= ', date('Y-m-d'));
        if (!empty($kecuali)) $this->db->where_not_in('content_link', $kecuali);
        $this->db->group_start();
        $this->db->where('content_tglexp', '0000-00-00');
        $this->db->or_where('content_tglexp > ', date('Y-m-d'));
        $this->db->group_end();
        $this->db->order_by('content_tglpublish', 'desc');
        $this->db->order_by('content_id', 'desc');
        return $this->db->get('p_content')->num_rows();
    }
    function getContentlimit($kondisi,$limit, $start, $kecuali=array()){
        $this->db->where($kondisi);
        $this->db->where('content_tglpublish <= ', date('Y-m-d'));
        if (!empty($kecuali)) $this->db->where_not_in('content_link', $kecuali);
        $this->db->group_start();
        $this->db->where('content_tglexp', '0000-00-00');
        $this->db->or_where('content_tglexp > ', date('Y-m-d'));
        $this->db->group_end();
        $this->db->order_by('content_tglpublish', 'desc');
        $this->db->order_by('content_id', 'desc');
        $this->db->limit($limit, $start);
        return $this->db->get('p_content')->result();
    }
    function getArchive(){
        $this->db->select("YEAR(content_tglpublish) as tahun, MONTH(content_tglpublish) as bulan");
        $this->db->group_by("DATE_FORMAT(`content_tglpublish`,'%Y-%m')");
        return $this->db->get('p_content')->result();
    }
    function upload_files($path, $title, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'jpg|gif|png|jpeg|pdf|doc|docx|xls|xlsx|zip|rar',
            'max_size'    => '20480',
            'overwrite'     => 1,
        );


        $this->load->library('upload', $config);

        $images = array();
        $i = 0;
        foreach ($files['name'] as $key => $image) {
            $i++;
            $_FILES['images[]']['name'] = $files['name'][$key];
            $_FILES['images[]']['type'] = $files['type'][$key];
            $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['images[]']['error'] = $files['error'][$key];
            $_FILES['images[]']['size'] = $files['size'][$key];

            $fileName = $title . '_' . $i . "_" . str_replace(' ', '_', $_FILES['images[]']['name']);
            $ext = explode('/', $_FILES['images[]']['type']);


            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
                $filename = $this->upload->data("file_name");
                $images[] = array('filename' =>  $filename, 'error' => '');
            } else {
                $images[] = array('filename' =>  $fileName, 'error' => $this->upload->display_errors());;
            }
        }

        return $images;
    }
    
}