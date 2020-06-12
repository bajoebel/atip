<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Posting_model extends CI_Model
{
    public $table = 'p_posting';
    public $key = 'id_posting';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getPosting()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getPostinglimit($limit, $start = 0, $q = NULL) {
        $this->db->join('m_kategori','p_posting.id_kategori=m_kategori.id_kategori');
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_posting', $q);
                $this->db->or_like('nama_kategori', $q);
                $this->db->or_like('judul_posting', $q);
                $this->db->or_like('isi_posting', $q);
                $this->db->or_like('tgl_posting', $q);
                $this->db->or_like('tgl_publish', $q);
                $this->db->or_like('tgl_exp', $q);
                $this->db->or_like('lampiran_gambar', $q);
                $this->db->or_like('link_posting', $q);
                $this->db->or_like('group_posting', $q);
                $this->db->or_like('status_komentar', $q);
                $this->db->or_like('status_posting', $q);
                $this->db->or_like('jml_hits', $q);
                $this->db->or_like('userinput', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countPosting($q = NULL) {
        $this->db->join('m_kategori','p_posting.id_kategori=m_kategori.id_kategori');
        $this->db->like('id_posting', $q);
        $this->db->or_like('nama_kategori', $q);
        $this->db->or_like('judul_posting', $q);
        $this->db->or_like('isi_posting', $q);
        $this->db->or_like('tgl_posting', $q);
        $this->db->or_like('tgl_publish', $q);
        $this->db->or_like('tgl_exp', $q);
        $this->db->or_like('lampiran_gambar', $q);
        $this->db->or_like('link_posting', $q);
        $this->db->or_like('group_posting', $q);
        $this->db->or_like('status_komentar', $q);
        $this->db->or_like('status_posting', $q);
        $this->db->or_like('jml_hits', $q);
        $this->db->or_like('userinput', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertPosting($data)
    {
        

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deletePosting($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getPosting_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updatePosting($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','posting');
            return $this->db->get('m_role_akses')->result_array();
        }
    function getM_kategori(){
        return $this->db->get('m_kategori')->result();
    }
}