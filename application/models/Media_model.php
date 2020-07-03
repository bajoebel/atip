<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Media_model extends CI_Model
{
    public $table = 'm_groupmedia';
    public $key = 'id_group';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getMedia()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getMedialimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_group', $q);
                $this->db->or_like('nama_group', $q);
                $this->db->or_like('status_group', $q);
                $this->db->or_like('sebagai_galery', $q);
                $this->db->or_like('sebagai_download', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function getDatamediabyid($id_media){
        $this->db->where('id_media', $id_media);
        $this->db->order_by('id_media', 'desc');
        return $this->db->get('m_media')->row();
    }
    function countMedia($q = NULL) {
        
        $this->db->like('id_group', $q);
        $this->db->or_like('nama_group', $q);
        $this->db->or_like('status_group', $q);
        $this->db->or_like('sebagai_galery', $q);
        $this->db->or_like('sebagai_download', $q);
        return $this->db->get($this->table)->num_rows();
    }

    function getdatamedia($id_group){
        $this->db->where('id_groupmedia',$id_group);
        return $this->db->get('m_media')->result();
    }
    public function insertMedia($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteMedia($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getMedia_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateMedia($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','media');
            return $this->db->get('m_role_akses')->result_array();
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
        $i=0;
        foreach ($files['name'] as $key => $image) {
            $i++;
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $fileName = $title .'_'. $i ."_" .str_replace(' ', '_', $_FILES['images[]']['name']);
            $ext=explode('/', $_FILES['images[]']['type']);
            

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
                $filename = $this->upload->data("file_name");
                $error[]=$this->_file_resize(_DIR_MEDIA_ ."/" .$filename, _DIR_MEDIA_THUMB_ ."/88X88/_88X88_" .$filename, 88,88);
                $error1[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "100X100/_100X100_" . $filename, 100, 100);
                $error2[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "383X330/_383X330_" . $filename, 383, 330);
                $error3[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "403X200/_403X200_" . $filename, 403, 200);
                $error4[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "620X320/_620X320_" . $filename, 620, 320);
                $error5[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1370X430/_1370X430_" . $filename, 1370, 430);
                $error6[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1366X656/_1366X656_" . $filename, 1366, 656);
                //$icon[]=$this->_file_resize(_DIR_MEDIA_ ."/".$filename, _DIR_MEDIA_ICON_ ."/" .$filename, 80,80);
                $images[] = array('filename'=>  $filename,'error'=>'');

            } else {
                $images[] = array('filename'=>  $fileName,'error'=>$this->upload->display_errors()); ;
            }
        }

        return $images;
    }

    public function _file_resize($source=null, $dest=null, $width=0, $height=0){
        $thumb['image_library']     = 'gd2';
        $thumb['source_image']      = $source;
        $thumb['create_thumb']      = FALSE;
        $thumb['maintain_ratio']    = FALSE;
        $thumb['width']             = $width;
        $thumb['height']            = $height;
        $thumb['new_image']         = $dest; 
        $this->load->library('image_lib', $thumb);
        $this->image_lib->clear();
        $this->image_lib->initialize($thumb);
        if (!$this->image_lib->resize()) {
            $error['thumb']= $this->image_lib->display_errors();
        }else{
            $error['thumb']= "";
        }
        $this->image_lib->clear();
        return $error['thumb'];
    }
    function aktifkan($id){
        $this->db->where($this->key,$id);
        $this->db->update($this->table, array('status_group'=>1));
    }

    function nonaktifkan($id){
        $this->db->where($this->key,$id);
        $this->db->update($this->table, array('status_group'=>0));
    }
}