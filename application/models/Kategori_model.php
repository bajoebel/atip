<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Kategori_model extends CI_Model
{
    public $table = 'm_kategori';
    public $key = 'id_kategori';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getKategori()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getKategorilimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_kategori', $q);
                $this->db->or_like('nama_kategori', $q);
                $this->db->or_like('status_kategori', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countKategori($q = NULL) {
        
        $this->db->like('id_kategori', $q);
        $this->db->or_like('nama_kategori', $q);
        $this->db->or_like('status_kategori', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertKategori($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteKategori($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getKategori_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateKategori($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','kategori');
            return $this->db->get('m_role_akses')->result_array();
    }

    function aktifkan($id){
        $this->db->where($this->key,$id);
        $this->db->update($this->table, array('status_kategori'=>1));
    }

    function nonaktifkan($id){
        $this->db->where($this->key,$id);
        $this->db->update($this->table, array('status_kategori'=>0));
    }
}