<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pintasan_model extends CI_Model
{
    public $table = 'p_pintasan';
    public $key = 'pintasan_id';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getpintasan()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getpintasanlimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('pintasan_id', $q);
                $this->db->or_like('pintasan_nama', $q);
                $this->db->or_like('pintasan_link', $q);
                $this->db->or_like('pintasan_img', $q);
                $this->db->or_like('pintasan_status', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countpintasan($q = NULL) {
        
        $this->db->like('pintasan_id', $q);
        $this->db->or_like('pintasan_nama', $q);
        $this->db->or_like('pintasan_link', $q);
        $this->db->or_like('pintasan_img', $q);
        $this->db->or_like('pintasan_status', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertpintasan($data)
    {
        /**
         * Buat Group Media Dengan Nama Partner
         */
        $this->db->where('nama_group','pintasan');
        $group=$this->db->get("m_groupmedia")->row();
        if(empty($group)){
            $group=array(
                'nama_group'=>'pintasan',
                'status_group'=>1
            );
            $this->db->insert('m_groupmedia', $group);
            $idgroup=$this->db->insert_id();
        }else{
            $idgroup=$group->id_group;
        }

        /***
         * Insert Data ke Tabel Media
         */
        $media=array(
            'id_groupmedia' => $idgroup,
            'namafile'      => $data["pintasan_img"],
            'keterangan'    => $data["pintasan_nama"],
            'status_media'  => 1
        );
        $this->db->insert('m_media', $media);

        /**
         * Insert Data Ke Tabel Partner
         */


        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deletepintasan($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getpintasan_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updatepintasan($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        if(empty($level)) $level=1;
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','pintasan');
            return $this->db->get('m_role_akses')->result_array();
        }

        function aktifkan($id){
            $this->db->where($this->key,$id);
            $this->db->update($this->table, array('pintasan_status'=>1));
        }
    
        function nonaktifkan($id){
            $this->db->where($this->key,$id);
            $this->db->update($this->table, array('pintasan_status'=>0));
        }
}