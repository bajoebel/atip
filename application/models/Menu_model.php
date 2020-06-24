<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Menu_model extends CI_Model
{
    public $table = 'm_menu';
    public $key = 'menu_id';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getMenu()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getMenulimit($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by('menu_idxutama');
        $this->db->order_by('menu_idxanak');
        $this->db->order_by('menu_top');
        $this->db->like('menu_id', $q);
        $this->db->or_like('menu_judul', $q);
        $this->db->or_like('menu_link', $q);
        $this->db->or_like('menu_baseurl', $q);
        $this->db->or_like('menu_idxutama', $q);
        $this->db->or_like('menu_idxanak', $q);
        $this->db->or_like('menu_top', $q);
        $this->db->or_like('menu_status', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countMenu($q = NULL)
    {

        $this->db->like('menu_id', $q);
        $this->db->or_like('menu_judul', $q);
        $this->db->or_like('menu_link', $q);
        $this->db->or_like('menu_baseurl', $q);
        $this->db->or_like('menu_idxutama', $q);
        $this->db->or_like('menu_idxanak', $q);
        $this->db->or_like('menu_top', $q);
        $this->db->or_like('menu_status', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertMenu($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteMenu($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getMenu_by_id($id)
    {
        $this->db->where($this->key, $id);
        return $this->db->get($this->table)->row();
    }
    function updateMenu($data, $id)
    {
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function getAkses($level)
    {

        $this->db->select('nama_aksi as aksi');
        $this->db->join('m_role', 'm_role_akses.role_id=m_role.role_id');
        $this->db->join('m_moduls', 'm_role_akses.modul_id=m_moduls.id_modul');
        $this->db->join('m_aksi', 'm_role_akses.id_aksi=m_aksi.id_aksi');
        $this->db->where('m_role_akses.role_id', $level);
        $this->db->where('link', 'menu');
        return $this->db->get('m_role_akses')->result_array();
    }
}
