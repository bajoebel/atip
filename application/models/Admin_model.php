<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin_model extends CI_Model
{
    public $table = 'm_admin';
    public $key = 'id_admin';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getAdmin()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getAdminlimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->join('m_users','ref_id=id_admin');
        $this->db->join('m_role','role=role_id');
        $this->db->like('id_admin', $q);
                $this->db->or_like('m_admin.nama_lengkap', $q);
                $this->db->or_like('email', $q);
                $this->db->or_like('alamat', $q);
                $this->db->or_like('nohp', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countAdmin($q = NULL) {
        $this->db->join('m_users','ref_id=id_admin');
        $this->db->join('m_role','role=role_id');
        $this->db->like('id_admin', $q);
        $this->db->or_like('m_admin.nama_lengkap', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('alamat', $q);
        $this->db->or_like('nohp', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertAdmin($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteAdmin($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);

        $this->db->where('ref_id', $id);
        $this->db->delete('m_users');
    }
    public function getAdmin_by_id($id){
        $this->db->where($this->key,$id);
        $this->db->join('m_users','ref_id=id_admin');
        return $this->db->get($this->table)->row();
    }
    function updateAdmin($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function getRole($role_group){
        $this->db->where('role_group', $role_group);
        return $this->db->get('m_role')->result();
    }
    function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','admin');
            return $this->db->get('m_role_akses')->result_array();
        }
}