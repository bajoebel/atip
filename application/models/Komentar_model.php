<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Komentar_model extends CI_Model
{
    public $table = 'p_komentar';
    public $key = 'id_komentar';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getKomentar()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getKomentarlimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->join('p_posting','p_posting.id_posting=p_komentar.id_post');
        $this->db->like('id_komentar', $q);
                $this->db->or_like('judul_posting', $q);
                $this->db->or_like('email', $q);
                $this->db->or_like('nama', $q);
                $this->db->or_like('komentar', $q);
                $this->db->or_like('status', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countKomentar($q = NULL) {
         $this->db->join('p_posting','p_posting.id_posting=p_komentar.id_post');
        $this->db->like('id_komentar', $q);
        $this->db->or_like('judul_posting', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('nama', $q);
        $this->db->or_like('komentar', $q);
        $this->db->or_like('status', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertKomentar($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteKomentar($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getKomentar_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateKomentar($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','komentar');
            return $this->db->get('m_role_akses')->result_array();
    }
    function aktifkan($id){
        $this->db->where($this->key,$id);
        $this->db->update($this->table, array('status'=>1));
    }

    function nonaktifkan($id){
        $this->db->where($this->key,$id);
        $this->db->update($this->table, array('status'=>0));
    }
}