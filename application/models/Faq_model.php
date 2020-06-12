<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Faq_model extends CI_Model
{
    public $table = 'p_faq';
    public $key = 'id_faq';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getFaq()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getFaqlimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_faq', $q);
                $this->db->or_like('judul_faq', $q);
                $this->db->or_like('isi_faq', $q);
                $this->db->or_like('link_faq', $q);
                $this->db->or_like('status_faq', $q);
                $this->db->or_like('userinput', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countFaq($q = NULL) {
        
        $this->db->like('id_faq', $q);
        $this->db->or_like('judul_faq', $q);
        $this->db->or_like('isi_faq', $q);
        $this->db->or_like('link_faq', $q);
        $this->db->or_like('status_faq', $q);
        $this->db->or_like('userinput', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertFaq($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteFaq($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getFaq_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateFaq($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','faq');
            return $this->db->get('m_role_akses')->result_array();
        }

        function aktifkan($id){
            $this->db->where($this->key,$id);
            $this->db->update($this->table, array('status_faq'=>1));
        }
    
        function nonaktifkan($id){
            $this->db->where($this->key,$id);
            $this->db->update($this->table, array('status_'=>0));
        }
}