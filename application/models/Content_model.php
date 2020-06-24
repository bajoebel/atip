<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Content_model extends CI_Model
{
    public $table = 'p_content';
    public $key = 'content_id';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getcontent()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getcontentlimit($limit, $start = 0, $q = NULL, $tipe="Berita")
    {
        $this->db->join('m_kategori', 'content_kategoriid=m_kategori.id_kategori','left');
        $this->db->order_by($this->key, $this->order);
        $this->db->where('content_tipe', ucwords(strtolower($tipe)));
        $this->db->group_start();
        $this->db->like('content_id', $q);
        $this->db->or_like('nama_kategori', $q);
        $this->db->or_like('content_judul', $q);
        $this->db->or_like('content_isi', $q);
        $this->db->or_like('content_tglpost', $q);
        $this->db->or_like('content_tglpublish', $q);
        $this->db->or_like('content_tglexp', $q);
        $this->db->or_like('content_thumb', $q);
        $this->db->or_like('content_link', $q);
        $this->db->or_like('content_tipe', $q);
        $this->db->or_like('content_komentar', $q);
        $this->db->or_like('content_status', $q);
        $this->db->or_like('content_hits', $q);
        $this->db->or_like('userinput', $q);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countcontent($q = NULL, $tipe = "Berita")
    {
        $this->db->join('m_kategori', 'content_kategoriid=m_kategori.id_kategori','left');
        $this->db->where('content_tipe', $tipe);
        $this->db->group_start();
        $this->db->like('content_id', $q);
        $this->db->or_like('nama_kategori', $q);
        $this->db->or_like('content_judul', $q);
        $this->db->or_like('content_isi', $q);
        $this->db->or_like('content_tglpost', $q);
        $this->db->or_like('content_tglpublish', $q);
        $this->db->or_like('content_tglexp', $q);
        $this->db->or_like('content_thumb', $q);
        $this->db->or_like('content_link', $q);
        $this->db->or_like('content_tipe', $q);
        $this->db->or_like('content_komentar', $q);
        $this->db->or_like('content_status', $q);
        $this->db->or_like('content_hits', $q);
        $this->db->or_like('userinput', $q);
        $this->db->group_end();
        return $this->db->get($this->table)->num_rows();
    }
    public function insertcontent($data)
    {


        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    function insertlampiran($data){
        $this->db->insert('p_lampiran', $data);
        return $this->db->insert_id();
    }
    public function deletecontent($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function deletelampiran($id)
    {
        $this->db->where('idx', $id);
        $this->db->delete('p_lampiran');
    }
    public function getcontent_by_id($id)
    {
        $this->db->where($this->key, $id);
        return $this->db->get($this->table)->row();
    }
    function updatecontent($data, $id)
    {
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function updatelampiran($data, $id)
    {
        $this->db->where('idx', $id);
        $this->db->update('p_lampiran', $data);
    }
    function getLampiran($content_id){
        $this->db->where('content_id', $content_id);
        return $this->db->get('p_lampiran')->result();
    }
    function getlampiran_by_id($id){
        $this->db->where('idx', $id);
        return $this->db->get('p_lampiran')->row();
    }
    function getAkses($level, $modul)
    {

        $this->db->select('nama_aksi as aksi');
        $this->db->join('m_role', 'm_role_akses.role_id=m_role.role_id');
        $this->db->join('m_moduls', 'm_role_akses.modul_id=m_moduls.id_modul');
        $this->db->join('m_aksi', 'm_role_akses.id_aksi=m_aksi.id_aksi');
        $this->db->where('m_role_akses.role_id', $level);
        $this->db->where('link', $modul);
        return $this->db->get('m_role_akses')->result_array();
    }
    function getM_kategori()
    {
        return $this->db->get('m_kategori')->result();
    }
}
