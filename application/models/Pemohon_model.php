<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pemohon_model extends CI_Model
{
    public $table = 'm_pemohon';
    public $key = 'id_pemohon';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getPemohon()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getPemohonlimit($limit, $start = 0, $q = NULL) {
        $this->db->select('*,m_jenis_identitas.jenis_identitas as jenis_identitas');
        $this->db->join('m_jenis_identitas','id_jenis=m_pemohon.jenis_identitas');
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_pemohon', $q);
                $this->db->or_like('m_jenis_identitas.jenis_identitas', $q);
                $this->db->or_like('no_identitas', $q);
                $this->db->or_like('nama_pemohon', $q);
                $this->db->or_like('no_hp', $q);
                $this->db->or_like('alamat_pemohon', $q);
                $this->db->or_like('provinsi', $q);
                $this->db->or_like('kabupaten', $q);
                $this->db->or_like('kecamatan', $q);
                $this->db->or_like('kelurahan', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countPemohon($q = NULL) {
        $this->db->join('m_jenis_identitas','id_jenis=m_pemohon.jenis_identitas');
        $this->db->like('id_pemohon', $q);
        $this->db->or_like('m_jenis_identitas.jenis_identitas', $q);
        $this->db->or_like('no_identitas', $q);
        $this->db->or_like('nama_pemohon', $q);
        $this->db->or_like('no_hp', $q);
        $this->db->or_like('alamat_pemohon', $q);
        $this->db->or_like('provinsi', $q);
        $this->db->or_like('kabupaten', $q);
        $this->db->or_like('kecamatan', $q);
        $this->db->or_like('kelurahan', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertPemohon($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deletePemohon($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getPemohon_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updatePemohon($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        if(empty($level)) $level=1;
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','pemohon');
            return $this->db->get('m_role_akses')->result_array();
        }
    function getM_jenis_identitas(){
        return $this->db->get('m_jenis_identitas')->result();
    }
}