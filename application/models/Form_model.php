<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class form_model extends CI_Model
{
    public $table = 'p_form';
    public $key = 'form_id';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getform()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getformlimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('form_id', $q);
                $this->db->or_like('p_form.form_title', $q);
                $this->db->or_like('form_link', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function getformdata($form_id,$limit, $start = 0, $q = NULL)
    {
        $this->db->where('isi_formid',$form_id);
        $this->db->order_by('isi_id', $this->order);
        $this->db->like('isi_baris', $q);
        $this->db->limit($limit, $start);
        return $this->db->get('p_form_isi')->result();
    }
    function countformdata($form_id, $q){
        $this->db->where('isi_formid', $form_id);
        $this->db->order_by('isi_id', $this->order);
        $this->db->like('isi_baris', $q);
        return $this->db->get('p_form_isi')->num_rows();
    }
    function countform($q = NULL) {
        $this->db->like('form_id', $q);
        $this->db->or_like('p_form.form_title', $q);
        $this->db->or_like('form_link', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertform($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteform($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getform_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateform($data,$id){
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
            $this->db->where('link','form');
            return $this->db->get('m_role_akses')->result_array();
        }
}