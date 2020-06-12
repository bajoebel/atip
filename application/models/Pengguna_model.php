<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pengguna_model extends CI_Model
{
    public $table = 'm_users';
    public $key = 'username';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getPengguna()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getPenggunalimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->join('m_role','role=role_id');
        $this->db->like('username', $q);
                $this->db->or_like('nama_lengkap', $q);
                $this->db->or_like('role_nama', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countPengguna($q = NULL) {
        
        $this->db->join('m_role','role=role_id');
        $this->db->like('username', $q);
                $this->db->or_like('nama_lengkap', $q);
                $this->db->or_like('role_nama', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertPengguna($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deletePengguna($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getPengguna_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updatePengguna($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','pengguna');
            return $this->db->get('m_role_akses')->result_array();
        }
    function getM_role(){
        return $this->db->get('m_role')->result();
    }
}