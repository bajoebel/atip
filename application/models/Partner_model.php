<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class partner_model extends CI_Model
{
    public $table = 'p_partner';
    public $key = 'partner_id';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getpartner()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getpartnerlimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('partner_id', $q);
                $this->db->or_like('partner_nama', $q);
                $this->db->or_like('partner_link', $q);
                $this->db->or_like('partner_img', $q);
                $this->db->or_like('partner_status', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countpartner($q = NULL) {
        
        $this->db->like('partner_id', $q);
        $this->db->or_like('partner_nama', $q);
        $this->db->or_like('partner_link', $q);
        $this->db->or_like('partner_img', $q);
        $this->db->or_like('partner_status', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertpartner($data)
    {
        /**
         * Buat Group Media Dengan Nama Partner
         */
        $this->db->where('nama_group','Partner');
        $group=$this->db->get("m_groupmedia")->row();
        if(empty($group)){
            $group=array(
                'nama_group'=>'Partner',
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
            'namafile'      => $data["partner_img"],
            'keterangan'    => $data["partner_nama"],
            'status_media'  => 1
        );
        $this->db->insert('m_media', $media);

        /**
         * Insert Data Ke Tabel Partner
         */

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    public function deletepartner($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getpartner_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updatepartner($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        if(empty($level)) $level=1;
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','partner');
            return $this->db->get('m_role_akses')->result_array();
        }
}