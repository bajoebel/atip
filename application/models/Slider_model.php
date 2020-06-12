<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Slider_model extends CI_Model
{
    public $table = 'p_slider';
    public $key = 'id_slider';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getSlider()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getSliderlimit($limit, $start = 0, $q = NULL) {
        $this->db->join('p_posting','post_id=id_posting','left');
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_slider', $q);
                $this->db->or_like('judul_posting', $q);
                $this->db->or_like('keterangan_slider', $q);
                $this->db->or_like('status_slider', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countSlider($q = NULL) {
        $this->db->join('p_posting','post_id=id_posting','left');
        $this->db->like('id_slider', $q);
        $this->db->or_like('judul_posting', $q);
        $this->db->or_like('keterangan_slider', $q);
        $this->db->or_like('status_slider', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertSlider($data)
    {
         /**
         * Buat Group Media Dengan Nama Partner
         */
        $this->db->where('nama_group','Slider');
        $group=$this->db->get("m_groupmedia")->row();
        if(empty($group)){
            $group=array(
                'nama_group'=>'Slider',
                'status_group'=>1
            );
            $this->db->insert('m_groupmedia', $group);
            $idgroup=$this->db->insert_id();
        }else{
            $idgroup=$group->id_group;
        }

        /***
         * Insert Data ke Tabel Media
         */
        $media=array(
            'id_groupmedia' => $idgroup,
            'namafile'      => $data["gambar_slider"],
            'keterangan'    => $data["keterangan_slider"],
            'status_media'  => 1
        );
        $this->db->insert('m_media1', $media);


        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteSlider($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getSlider_by_id($id){
        $this->db->where($this->key,$id);
        $this->db->join('p_posting','post_id=id_posting','left');
        return $this->db->get($this->table)->row();
    }
    function updateSlider($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','slider');
            return $this->db->get('m_role_akses')->result_array();
        }
}