<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Halaman extends CI_Controller
{
    private $akses = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model('content_model');
        $level = $this->session->userdata('level');

        $this->akses = $this->content_model->getAkses($level, 'halaman');
    }

    
    public function index()
    {
        $cek = array('aksi' => "Index");
        if (in_array($cek, $this->akses)) {
            $data = array(
                'list_m_kategori' => $this->content_model->getM_kategori(),
                'menu'  => array(),
                'akses' => $this->akses,
                'content_tipe'=>"Halaman",
                'tipe'  => 'halaman',
                'modul' => "content </li><li> Halaman </li>"
            );
            $content = $this->load->view('admin/content/view_tabel', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }
    public function halaman()
    {
        $cek = array('aksi' => "Halaman");
        if (in_array($cek, $this->akses)) {
            $data = array(
                'list_m_kategori' => $this->content_model->getM_kategori(),
                'menu'  => array(),
                'akses' => $this->akses,
                'content_tipe' => "Halaman",
                'modul' => "content </li><li> Halaman </li>"
            );
            $content = $this->load->view('admin/content/view_tabel', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }

    public function pengumuman()
    {
        $cek = array('aksi' => "Pengumuman");
        if (in_array($cek, $this->akses)) {
            $data = array(
                'list_m_kategori' => $this->content_model->getM_kategori(),
                'menu'  => array(),
                'akses' => $this->akses,
                'content_tipe' => "Pengumuman",
                'modul' => "content </li><li> Pengumuman </li>"
            );
            $content = $this->load->view('admin/content/view_tabel', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }

    public function Portofolio()
    {
        $cek = array('aksi' => "Artikel");
        if (in_array($cek, $this->akses)) {
            $data = array(
                'list_m_kategori' => $this->content_model->getM_kategori(),
                'menu'  => array(),
                'akses' => $this->akses,
                'content_tipe' => "Portofolio",
                'modul' => "content </li><li> Portofolio </li>"
            );
            $content = $this->load->view('admin/content/view_tabel', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }
    public function prodi()
    {
        $cek = array('aksi' => "Artikel");
        if (in_array($cek, $this->akses)) {
            $data = array(
                'list_m_kategori' => $this->content_model->getM_kategori(),
                'menu'  => array(),
                'akses' => $this->akses,
                'content_tipe' => "Prodi",
                'modul' => "content </li><li> Prodi </li>"
            );
            $content = $this->load->view('admin/content/view_tabel', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }
    function form($id = "")
    {
        $save = array('aksi' => 'Save');
        $tipe="halaman";
        if(empty($id)) $modul= "Content </li><li> Tambah </li><li>" . ucwords($tipe) . "</li>";
        else $modul= "Content </li><li> Edit </li><li>" . ucwords($tipe) . "</li><li>".$id ."</li>";
        if (in_array($save, $this->akses)) {
            $data = array(
                'list_m_kategori' => $this->content_model->getM_kategori(),
                'data'  => $this->content_model->getcontent_by_id($id),
                'menu'  => array(),
                'modul' => $modul,
                'tipe'  => $tipe,
                'akses' => $this->akses 
            );
            $content = $this->load->view('admin/content/view_form', $data, true);
            $view = array(
                'content'   => $content
            );
            $this->load->view('template/admin/view_layout', $view);
        }
        
    }
    public function data()
    {
        $cek = array('aksi' => "Index");
        if (in_array($cek, $this->akses)) {
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = intval($this->input->get('limit'));
            $tipe = urldecode($this->input->get('tipe', TRUE));
            $row_count = $this->content_model->countcontent($q, $tipe);
            $list = array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit, 
                'data'     => $this->content_model->getcontentlimit($limit, $start, $q, $tipe),
            );
        } else {
            $list = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'data'      => array()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($list);
    }

    public function datamedia()
    {
        $cek = array('aksi' => "Save");
        if (in_array($cek, $this->akses)) {
            $this->load->model('media_model');
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 20;
            $row_count = $this->media_model->countMedia($q);
            $list = array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->media_model->getMedialimit($limit, $start, $q),
            );
        } else {
            $list = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'data'      => array()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($list);
    }
    function detailmedia($idgroup)
    {
        $cek = array('aksi' => 'Save');
        $this->load->model('media_model');
        if (in_array($cek, $this->akses)) {
            $data = $this->media_model->getDatamedia($idgroup);
            $response = array(
                'status'    => true,
                'data'      => $data,
                'message'   => "OK"
            );
        } else {
            $response = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($id = "")
    {
        $cek = array('aksi' => ucwords($this->uri->segment(3)));
        if (in_array($cek, $this->akses)) {
            $row = $this->content_model->getcontent_by_id($id);
            if (!empty($row)) {
                $response = array(
                    'status'    => true,
                    'message'   => "OK",
                    'data'      => $row,
                    'csrf'      => $this->security->get_csrf_hash(),
                );
            } else {
                $response = array(
                    'status'    => false,
                    'message'   => "Data Tidak ditemukan",
                    'data'      => array(),
                    'csrf'      => $this->security->get_csrf_hash(),
                );
            }
        } else {
            $response = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function save(){
        $cek=array('aksi'=> ucwords($this->uri->segment(3)));
        if(in_array($cek,$this->akses)){
            //SImpan
            //$file = $this->upload->data("file_name");
            $content_id = $this->input->post('content_id');
            if ($this->input->post('content_komentar') == 1) $content_komentar = 1;
            else $content_komentar = 0;
            if ($this->input->post('content_top') == 1
            ) $content_top = 1;
            else $content_top = 0;
            //if ($this->input->post('tampil_slider') == 1) $tampil_slider = 1;
            //else $tampil_slider = 0;
            $link = str_replace(' ', '-', strtolower($this->input->post('content_judul')));
            $link = str_replace('&', 'dan', $link);
            $link = str_replace('"', '', $link);
            $tipe = $this->input->post('content_tipe');
            $row = $this->content_model->getcontent_by_id($content_id);
            $f=$this->input->post('file');
            $file=implode(',',$f);
            $data = array(
                'content_kategoriid' => $this->input->post('content_kategoriid'),
                'content_judul' => $this->input->post('content_judul'),
                'content_isi' => trim($this->input->post('content_isi')),
                'content_tglpost' => date('Y-m-d H:i:s'),
                'content_thumb' => $file,
                'content_link' => $link,
                'content_tglpublish' => $this->input->post('content_tglpublish'),
                'content_tglexp' => $this->input->post('content_tglexp'),
                'content_tipe' => $this->input->post('content_tipe'),
                'content_komentar' => $content_komentar,
                'content_top' => $content_top,
                'content_tag' => $this->input->post('content_tag'),
                'content_status' => $this->input->post('content_status'),
                'userinput' => $this->session->userdata("username"),
            );
            if (empty($row)) {
                $this->form_validation->set_rules('content_kategoriid', 'id kategori', 'required');
                $this->form_validation->set_rules('content_judul', 'judul content', 'required');
                $this->form_validation->set_rules('content_isi', 'isi content', 'required');
                $this->form_validation->set_rules('content_tipe', 'group content', 'required');
                if ($this->form_validation->run()) {
                    $insert = $this->content_model->insertcontent($data);
                    header('location:' . base_url() . "admin/halaman");
                } else {
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_content_kategoriid' => form_error('content_kategoriid'),
                        'err_content_judul' => form_error('content_judul'),
                        'err_content_isi' => form_error('content_isi'),
                        'err_content_thumb' => form_error('content_thumb'),
                        'err_content_tipe' => form_error('content_tipe'),
                    );
                    $this->session->set_flashdata('error', $array);
                    //print_r($array);
                    header('location:' . base_url() . "admin/halaman/form");
                    //header('Content-Type: application/json');
                    //echo json_encode($array);
                }
            } else {
                $this->form_validation->set_rules('content_kategoriid', 'id kategori', 'required');
                $this->form_validation->set_rules('content_judul', 'judul content', 'required');
                $this->form_validation->set_rules('content_isi', 'isi content', 'required');
                $this->form_validation->set_rules('content_tipe', 'group content', 'required');
                if ($this->form_validation->run()) {
                    $this->content_model->updatecontent($data, $content_id);
                    header('location:' . base_url() . "admin/halaman");
                } else {
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_content_kategoriid' => form_error('content_kategoriid'),
                        'err_content_judul' => form_error('content_judul'),
                        'err_content_isi' => form_error('content_isi'),
                        'err_content_tipe' => form_error('content_tipe'),
                    );

                    header('location:' . base_url() . "admin/halaman/form/" . $content_id);
                }
            }
        }
    }
    function save1()
    {
        $cek = array('aksi' => ucwords($this->uri->segment(3))); 
        if (in_array($cek, $this->akses)) {
            $content_id = $this->input->post('content_id');
            if ($this->input->post('content_komentar') == 1) $content_komentar = 1;
            else $content_komentar = 0;
            if ($this->input->post('content_top') == 1) $content_top = 1;
            else $content_top = 0;
            //if ($this->input->post('tampil_slider') == 1) $tampil_slider = 1;
            //else $tampil_slider = 0;
            $link = str_replace(' ', '-', strtolower($this->input->post('content_judul')));
            $link = str_replace('&', 'dan', $link);
            $link = str_replace('"', '', $link);
            $tipe=$this->input->post('content_tipe');
            $row = $this->content_model->getcontent_by_id($content_id);
            $file = "POST_" . date('dmY') . "_" . str_replace(' ', '_', $_FILES['userfile']['name']);
            $this->_file_upload(_DIR_MEDIA_, $file, 'gif|jpg|png');
            if ($_FILES['userfile']['name'] != "") {
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    //echo $error;exit;
                    $this->session->set_flashdata('error', $error);
                    header('location:' . base_url() . "admin/halaman/form/" .$tipe);
                } else {
                    //SImpan
                    $file = $this->upload->data("file_name");
                    $data = array(
                        'content_kategoriid' => $this->input->post('content_kategoriid'),
                        'content_judul' => $this->input->post('content_judul'),
                        'content_isi' => $this->input->post('content_isi'),
                        'content_tglpost' => date('Y-m-d'),
                        'content_thumb' => $file,
                        'content_link' => $link,
                        'content_tglpublish' => $this->input->post('content_tglpublish'),
                        'content_tglexp' => $this->input->post('content_tglexp'),
                        'content_tipe' => $this->input->post('content_tipe'),
                        'content_komentar' => $content_komentar,
                        'content_top' => $content_top,
                        'content_tag' => $this->input->post('content_tag'),
                        'content_status' => $this->input->post('content_status'),
                        'userinput' => $this->session->userdata("username"),
                    );
                    if (empty($row)) {
                        $this->form_validation->set_rules('content_kategoriid', 'id kategori', 'required');
                        $this->form_validation->set_rules('content_judul', 'judul content', 'required');
                        $this->form_validation->set_rules('content_isi', 'isi content', 'required');
                        $this->form_validation->set_rules('content_tipe', 'group content', 'required');
                        if ($this->form_validation->run()) {
                            $insert = $this->content_model->insertcontent($data);
                            $error[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $file, _DIR_MEDIA_THUMB_ . $file, 500, 500);
                            $icon[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $file, _DIR_MEDIA_ICON_ . $file, 50, 50);
                            /**
                             * Buat Group Media Dengan Nama Partner
                             */
                            $this->db->where('content_kategoriid', $this->input->post('content_kategoriid'));
                            $kat = $this->db->get('m_kategori')->row();
                            if (!empty($kat)) $kategori = $kat->nama_kategori;
                            else $kategori = 'unctegory';
                            $this->db->where('nama_group', $kategori);
                            $group = $this->db->get("m_groupmedia")->row();
                            if (empty($group)) {
                                $group = array(
                                    'nama_group' => $kategori,
                                    'status_group' => 1
                                );
                                $this->db->insert('m_groupmedia', $group);
                                $idgroup = $this->db->insert_id();
                            } else {
                                $idgroup = $group->id_group;
                            }

                            /***
                             * Insert Data ke Tabel Media
                             */
                            $media = array(
                                'id_groupmedia' => $idgroup,
                                'namafile'      => $file,
                                'keterangan'    => $this->input->post('content_judul'),
                                'status_media'  => 1
                            );
                            $this->db->insert('m_media', $media);
                            //header('Content-Type: application/json');
                            //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                            header('location:' . base_url() ."admin/content/" . $tipe);
                        } else {
                            $array = array(
                                'status'    => TRUE,
                                'error'     => TRUE,
                                'csrf'      => $this->security->get_csrf_hash(),
                                'message'   => "Data Belum Lengkap",
                                'err_content_kategoriid' => form_error('content_kategoriid'),
                                'err_content_judul' => form_error('content_judul'),
                                'err_content_isi' => form_error('content_isi'),
                                'err_content_thumb' => form_error('content_thumb'),
                                'err_content_tipe' => form_error('content_tipe'),
                            );
                            $this->session->set_flashdata('error', $array);
                            //print_r($array);
                            header('location:' . base_url() ."admin/content/form/" . $tipe);
                            //header('Content-Type: application/json');
                            //echo json_encode($array);
                        }
                    } else {
                        $this->form_validation->set_rules('content_kategoriid', 'id kategori', 'required');
                        $this->form_validation->set_rules('content_judul', 'judul content', 'required');
                        $this->form_validation->set_rules('content_isi', 'isi content', 'required');
                        $this->form_validation->set_rules('content_tipe', 'group content', 'required');
                        if ($this->form_validation->run()) {
                            $this->content_model->updatecontent($data, $content_id);
                            /**
                             * Buat Group Media Dengan Nama Partner
                             */
                            $this->db->where('content_kategoriid', $this->input->post('content_kategoriid'));
                            $kat = $this->db->get('m_kategori')->row();
                            if (!empty($kat)) $kategori = $kat->nama_kategori;
                            else $kategori = 'unctegory';
                            $this->db->where('nama_group', $kategori);
                            $group = $this->db->get("m_groupmedia")->row();
                            if (empty($group)) {
                                $group = array(
                                    'nama_group' => $kategori,
                                    'status_group' => 1
                                );
                                $this->db->insert('m_groupmedia', $group);
                                $idgroup = $this->db->insert_id();
                            } else {
                                $idgroup = $group->id_group;
                            }

                            /***
                             * Insert Data ke Tabel Media
                             */
                            $media = array(
                                'id_groupmedia' => $idgroup,
                                'namafile'      => $file,
                                'keterangan'    => $this->input->post('content_judul'),
                                'status_media'  => 1
                            );
                            $this->db->insert('m_media', $media);
                            $error[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $file, _DIR_MEDIA_THUMB_ . $file, 500, 500);
                            $icon[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $file, _DIR_MEDIA_ICON_ . $file, 50, 50);
                            header('location:' . base_url() . "admin/halaman/". $tipe);
                        } else {
                            $array = array(
                                'status'    => TRUE,
                                'error'     => TRUE,
                                'csrf'      => $this->security->get_csrf_hash(),
                                'message'   => "Data Belum Lengkap",
                                'err_content_kategoriid' => form_error('content_kategoriid'),
                                'err_content_judul' => form_error('content_judul'),
                                'err_content_isi' => form_error('content_isi'),
                                'err_content_tipe' => form_error('content_tipe'),
                            );

                            header('location:' . base_url() . "admin/halaman/form/" . $content_id);
                        }
                    }
                }
            } else {
                //JIka Tidak ada Gambar Yang DIupload
                $data = array(
                    'content_kategoriid' => $this->input->post('content_kategoriid'),
                    'content_judul' => $this->input->post('content_judul'),
                    'content_isi' => $this->input->post('content_isi'),
                    'content_tglpost' => date('Y-m-d'),
                    'content_link' => $link,
                    'content_thumb' => $this->input->post('content_thumb'),
                    'content_tglpublish' => $this->input->post('content_tglpublish'),
                    'content_tglexp' => $this->input->post('content_tglexp'),
                    'content_tipe' => $this->input->post('content_tipe'),
                    'content_komentar' => $content_komentar,
                    'content_top' => $content_top,
                    'content_tag' => $this->input->post('content_tag'),
                    'content_status' => $this->input->post('content_status'),
                    'userinput' => $this->session->userdata("username"),
                );
                if (empty($row)) {
                    $this->form_validation->set_rules('content_kategoriid', 'id kategori', 'required');
                    $this->form_validation->set_rules('content_judul', 'judul content', 'required');
                    $this->form_validation->set_rules('content_isi', 'isi content', 'required');
                    $this->form_validation->set_rules('content_tipe', 'group content', 'required');
                    if ($this->form_validation->run()) {
                        $insert = $this->content_model->insertcontent($data);
                        //header('Content-Type: application/json');
                        //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf' => $this->security->get_csrf_hash()));
                        header('location:' . base_url() . "admin/halaman");
                    } else {
                        $array = array(
                            'status'    => TRUE,
                            'error'     => TRUE,
                            'csrf'      => $this->security->get_csrf_hash(),
                            'message'   => "Data Belum Lengkap",
                            'err_content_kategoriid' => form_error('content_kategoriid'),
                            'err_content_judul' => form_error('content_judul'),
                            'err_content_isi' => form_error('content_isi'),
                            'err_content_thumb' => form_error('content_thumb'),
                            'err_content_tipe' => form_error('content_tipe'),
                        );
                        $this->session->set_flashdata('error', $array);
                        //print_r($array);
                        header('location:' . base_url() . "admin/halaman/form/". $tipe);
                        //header('Content-Type: application/json');
                        //echo json_encode($array);
                    }
                } else {
                    $this->form_validation->set_rules('content_kategoriid', 'id kategori', 'required');
                    $this->form_validation->set_rules('content_judul', 'judul content', 'required');
                    $this->form_validation->set_rules('content_isi', 'isi content', 'required');
                    $this->form_validation->set_rules('content_tipe', 'group content', 'required');
                    if ($this->form_validation->run()) {
                        $this->content_model->updatecontent($data, $content_id);
                        //header('Content-Type: application/json');
                        //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                        header('location:' . base_url() . "admin/halaman/" .$tipe);
                    } else {
                        $array = array(
                            'status'    => TRUE,
                            'error'     => TRUE,
                            'csrf'      => $this->security->get_csrf_hash(),
                            'message'   => "Data Belum Lengkap",
                            'err_content_kategoriid' => form_error('content_kategoriid'),
                            'err_content_judul' => form_error('content_judul'),
                            'err_content_isi' => form_error('content_isi'),
                            'err_content_tipe' => form_error('content_tipe'),
                        );
                        //header('Content-Type: application/json');
                        //echo json_encode($array);
                        //$this->session->set_flashdata('error', $array);
                        header('location:' . base_url() . "admin/halaman/form/". $tipe ."/" . $content_id);
                    }
                }
            }
        } else {
            //header('Content-Type: application/json');
            //echo json_encode(array("status" => False,'error'=>TRUE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
            $this->session->set_flashdata('error', array("Anda tidak berhak untuk mengakases halaman ini"));
            header('location:' . base_url() . "login");
        }
        //$isi=$this->input->post('content_isi');
        //echo $isi;
    }
    function add_kategori(){
        $cek = array('aksi' => 'Save');

        if (in_array($cek, $this->akses)) {
            //$data=array('nama_kategori'=> $this->input->post('nama_kategori'));
            $this->load->model('kategori_model');

            $status_kategori = 1;
            $link = str_replace(' ', '-', strtolower($this->input->post('nama_kategori')));
            $link = str_replace('&', 'dan', $link);
            $link = str_replace('"', '', $link);
            $data = array(
                'nama_kategori' => $this->input->post('nama_kategori'),
                'link_kategori' => $link,
                'status_kategori' => $status_kategori,
            );
            $this->form_validation->set_rules('nama_kategori', 'nama kategori', 'required');
            if ($this->form_validation->run()) {
                $insert = $this->kategori_model->insertKategori($data);
                header('Content-Type: application/json');
                echo json_encode(array("status" => TRUE, 'error' => FALSE, "message" => "Data berhasil di simpan", 'csrf' => $this->security->get_csrf_hash(), 'idx'=>$insert));
            } else {
                $array = array(
                    'status'    => TRUE,
                    'error'     => TRUE,
                    'csrf'      => $this->security->get_csrf_hash(),
                    'message'   => "Data Belum Lengkap",
                    'err_nama_kategori' => form_error('nama_kategori'),
                );
                header('Content-Type: application/json');
                echo json_encode($array);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("status" => False,'error'=>TRUE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
            
        }

    }
    function getKategori(){
        $this->load->model('kategori_model');
        $kategori=$this->kategori_model->getKategori();
        $response=array('status'=>true,'message'=>"ok",'data'=> $kategori);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function delete($id)
    {
        $cek = array('aksi' => ucwords($this->uri->segment(3)));
        if (in_array($cek, $this->akses)) {
            $this->content_model->deletecontent($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message" => "Data Berhasil dihapus"));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message" => "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
    function excel()
    {
        $cek = array('aksi' => ucwords($this->uri->segment(3)));
        if (in_array($cek, $this->akses)) {
            $data = array(
                'data'  => $this->content_model->getcontent(),
            );
            $this->load->view('admin/content/view_data_excel', $data);
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }
    function pdf()
    {
        $cek = array('aksi' => ucwords($this->uri->segment(3)));
        if (in_array($cek, $this->akses)) {
            $data = array(
                'data'  => $this->content_model->getcontent(),
            );
            $html = $this->load->view('admin/content/view_data_pdf', $data, true);
            $pdfFilePath = "DATA_content.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        } else {
            $this->session->set_flashdata('error', 'Opps... Session expired');
            header('location:' . base_url() . "login");
        }
    }
    public function _file_upload($path, $filename, $filetype)
    {
        $config['upload_path']          = $path;
        $config['allowed_types']        = $filetype;
        /*$config['max_size']             = 1000;
        $config['max_width']            = 1200;
        $config['max_height']           = 800;*/
        $config['overwrite']        = true;
        $config['file_name']            = $filename;
        $this->load->library('upload', $config);
    }

    public function _file_resize($source = null, $dest = null, $width = 0, $height = 0)
    {
        $thumb['image_library']     = 'gd2';
        $thumb['source_image']      = $source;
        $thumb['create_thumb']      = FALSE;
        $thumb['maintain_ratio']    = TRUE;
        $thumb['width']             = $width;
        $thumb['height']            = $height;
        $thumb['new_image']         = $dest;
        $this->load->library('image_lib', $thumb);
        $this->image_lib->clear();
        $this->image_lib->initialize($thumb);
        if (!$this->image_lib->resize()) {
            $error['thumb'] = $this->image_lib->display_errors();
        } else {
            $error['thumb'] = "";
        }
        $this->image_lib->clear();
        return $error['thumb'];
    }

    function viewmedia($idmedia)
    {
        $cek = array('aksi' => 'Edit');
        if (in_array($cek, $this->akses)) {
            $this->load->model('media_model');
            $x['data'] = $this->media_model->getDatamediabyid($idmedia);
            $this->load->view('admin/content/view_media', $x);
        } else {
            $response = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
    }

    function komentar($id_group, $val)
    {
        $cek = array('aksi' => 'Edit');
        if (in_array($cek, $this->akses)) {
            $data = array('content_komentar' => $val);
            $this->content_model->updatecontent($data, $id_group);
            $response = array("status" => TRUE, 'error' => FALSE, "message" => "Data berhasil di update");
        } else {
            $response = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function status($id_group, $val)
    {
        $cek = array('aksi' => 'Edit');
        if (in_array($cek, $this->akses)) {
            $data = array('content_status' => $val);
            $this->content_model->updatecontent($data, $id_group);
            $response = array("status" => TRUE, 'error' => FALSE, "message" => "Data berhasil di update");
        } else {
            $response = array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function fileUpload()
    {
        if (!empty($_FILES['userfile']['name'])) {
            $file = "POST_" . date('dmY') . "_" . str_replace(' ', '_', $_FILES['userfile']['name']);
            $this->_file_upload(_DIR_MEDIA_, $file, 'gif|jpg|png');
            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors();
                //echo $error;exit;
                $this->session->set_flashdata('error', $error);
                //header('location:' . base_url() . "admin/halaman/form/" . $tipe);
            } else {
                //SImpan
                $filename = $this->upload->data("file_name");
                $data=array(
                    'id_groupmedia'=>$this->input->post('uploadgroup'),
                    'namafile' => $filename,
                    'keterangan'    => $_FILES['userfile']['name'],
                    'status_media'  => 1
                );
                $this->db->insert('m_media', $data);

                $error[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "/88X88/_88X88_" . $filename, 88, 88);
                $error1[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "100X100/_100X100_" . $filename, 100, 100);
                $error2[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "383X330/_383X330_" . $filename, 383, 330);
                $error3[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "403X200/_403X200_" . $filename, 403, 200);
                $error4[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "620X320/_620X320_" . $filename, 620, 320);
                $error5[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1370X430/_1370X430_" . $filename, 1370, 430);
                $error6[] = $this->_file_resize(_DIR_MEDIA_ . "/" . $filename, _DIR_MEDIA_THUMB_ . "1366X656/_1366X656_" . $filename, 1366, 656);
            }
        }
        echo $this->security->get_csrf_hash();
        
    }

    //Upload image summernote
    function upload_image()
    {
        if (isset($_FILES["image"]["name"])) {
            $config['upload_path'] = './uploads/content/original/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $this->upload->display_errors();
                return FALSE;
            } else {
                $data = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/content/original/' . $data['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['width'] = 800;
                $config['height'] = 800;
                $config['new_image'] = './uploads/content/original/' . $data['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                echo base_url() . 'uploads/content/original/' . $data['file_name'];
            }
        }
    }

    //Delete image summernote
    function delete_image()
    {
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if (unlink($file_name)) {
            echo 'File Delete Successfully';
        }
    }
    function add_group(){
        $data=array(
            'nama_group'    => $this->input->post('nama_group'),
            'status_group'  => 1,
        );
        $this->db->insert('m_groupmedia', $data);
        $insertID=$this->db->insert_id();
        if($insertID){
            $response = array(
                'status' => true,
                'message' => 'Berhasil Menambahkan Group Media',
                'csrf'      => $this->security->get_csrf_hash(),
            );
        }else{
            $response = array(
                'status' => false,
                'message' => 'Gagal Menambahkan Group Media',
                'csrf'      => $this->security->get_csrf_hash(),
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
