<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Role_akses_model extends CI_Model
{
    public $table = 'm_role_akses';
    public $key = 'id_akses';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getRole_akses()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getRole_akseslimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by('m_role_akses.role_id, modul_id, m_role_akses.id_aksi');
        $this->db->join('m_role','m_role.role_id=m_role_akses.role_id');
        $this->db->join('m_moduls','m_moduls.id_modul=m_role_akses.modul_id');
        $this->db->join('m_aksi','m_aksi.id_aksi=m_role_akses.id_aksi');
        $this->db->like('id_akses', $q);
                $this->db->or_like('role_nama', $q);
                $this->db->or_like('nama_modul', $q);
                $this->db->or_like('nama_aksi', $q);
                $this->db->or_like('tampil_menu', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countRole_akses($q = NULL) {
        $this->db->join('m_role','m_role.role_id=m_role_akses.role_id');
        $this->db->join('m_moduls','m_moduls.id_modul=m_role_akses.modul_id');
        $this->db->join('m_aksi','m_aksi.id_aksi=m_role_akses.id_aksi');
        $this->db->like('id_akses', $q);
                $this->db->or_like('role_nama', $q);
                $this->db->or_like('nama_modul', $q);
                $this->db->or_like('nama_aksi', $q);
        $this->db->or_like('tampil_menu', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertRole_akses($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteRole_akses($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getRole_akses_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateRole_akses($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','role_akses');
            return $this->db->get('m_role_akses')->result_array();
        }
    function getM_role(){
        return $this->db->get('m_role')->result();
    }
    function getM_moduls(){
        return $this->db->get('m_moduls')->result();
    }
    function getM_aksi(){
        return $this->db->get('m_aksi')->result();
    }
}