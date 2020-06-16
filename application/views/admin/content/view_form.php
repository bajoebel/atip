<!-- Main content -->
<script>
    // Add restrictions
    Dropzone.options.fileupload = {
        acceptedFiles: 'image/*',
        maxFilesize: 1 // MB
    };
</script>
<section class="content">

    <div class="row">
        <form class="form-horizontal" method="POST" id="form" action="<?php echo base_url() . "admin/content/save" ?>" enctype="multipart/form-data">
            <div class="col-md-8">
                <div class="panel panel-success">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title">
                            Form Posting
                        </h3>
                        <div class="panel-tools">

                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="panel-body">
                            <?php if (!empty($notif)) echo $notif;
                            $err = $this->session->flashdata('error');
                            if (!empty($err)) {
                                if (is_array($err)) {
                                    $error = $err;
                                } else {
                            ?>
                                    <div class="row">
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <strong>Error!</strong> <?= $err; ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>

                            <div class="row">
                                <div class="row">
                                    <input type="hidden" id="csrf" class='csrf' name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php if (!empty($data)) echo $data->content_id; ?>">
                                    <input type="hidden" id="content_tipe" name="content_tipe" value="<?= $tipe ?>">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 ">JUDUL</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="content_judul" name="content_judul" placeholder="Judulposting" value="<?php if (!empty($data)) echo $data->content_judul; ?>">
                                                <span class="text-error" id="err_content_judul"><?php if (!empty($error)) echo $error["err_content_isi"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class='row'>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 ">CONTENT</label>
                                            <div class="col-sm-12">
                                                <textarea class="summernote" name="content_isi" id="content_isi"><?php if (!empty($data)) echo $data->content_isi; ?></textarea>
                                                <span class="text-error" id="err_content_isi"><?php if (!empty($error)) echo $error["err_content_isi"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class='row'>
                                    <div class="row">
                                        <?php if ($tipe == "berita") { ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-12 ">TANGGAL PUBLISH</label>
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker" id="content_tglpublish" name="content_tglpublish" placeholder="Tglpublish" value="<?php if (!empty($data)) echo $data->content_tglpublish;
                                                                                                                                                                                                    else echo date('Y-m-d') ?>">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <span class="text-error" id="err_content_tglpublish"></span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-12 ">TANGGAL EXPIRE (Kosongkan
                                                        Jika Tidak ada)</label>
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker" id="content_tglexp" name="content_tglexp" placeholder="Tglexp" value="<?php if (!empty($data)) {
                                                                                                                                                                                            if ($data->content_tglexp != '0000-00-00') echo $data->content_tglexp;
                                                                                                                                                                                        }  ?>">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <span class="text-error" id="err_content_tglexp"><?php //if(!empty($error)) echo $error["err_content_tglexp"]; 
                                                                                                            ?></span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                $publish = array('aksi' => 'Publish');
                                                if (in_array($publish, $akses)) {
                                                ?>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-12 ">STATUS POSTING</label>
                                                        <div class="col-sm-12">
                                                            <?php if (!empty($data)) $status_publish =  $data->content_status;
                                                            else $status_publish = ""; ?>
                                                            <select class="form-control" name="content_status" id="content_status">
                                                                <option value="Draft" <?php if ($status_publish == "Draft") echo "selected"; ?>>Draft
                                                                </option>
                                                                <option value="Publish" <?php if ($status_publish == "Publish") echo "selected"; ?>>
                                                                    Publish</option>
                                                                <option value="Unpublish" <?php if ($status_publish == "Unpublish") echo "selected"; ?>>
                                                                    Unpublish</option>
                                                            </select>
                                                            <span class="text-error" id="err_content_status"><?php //if(!empty($error)) echo $error["err_content_status"]; 
                                                                                                                ?></span>
                                                        </div>
                                                    </div>
                                                <?php } else {
                                                ?>
                                                    <input type="hidden" name="content_status" id="content_status" value="Draft">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php

                                        } else {
                                            //echo $data->content_tglpublish;
                                            if (!empty($data)) {
                                                if ($data->content_tglpublish != '0000-00-00') $tp = $data->content_tglpublish;
                                            } else $tp = date('Y-m-d');
                                        ?>
                                            <input type="hidden" id="content_tglpublish" name="content_tglpublish" value="<?= $tp  ?>">
                                            <input type="hidden" id="content_tglexp" name="content_tglexp" value="<?php if (!empty($data)) {
                                                                                                                        if ($data->content_tglexp != '0000-00-00') echo $data->content_tglexp;
                                                                                                                    } else echo ""; ?>">
                                            <div class="col-sm-4">
                                                <?php
                                                $publish = array('aksi' => 'Publish');
                                                if (in_array($publish, $akses)) {
                                                ?>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-12 ">STATUS POSTING</label>
                                                        <div class="col-sm-12">
                                                            <?php if (!empty($data)) $status_publish =  $data->content_status;
                                                            else $status_publish = ""; ?>
                                                            <select class="form-control" name="content_status" id="content_status">
                                                                <option value="Draft" <?php if ($status_publish == "Draft") echo "selected"; ?>>Draft
                                                                </option>
                                                                <option value="Publish" <?php if ($status_publish == "Publish") echo "selected"; ?>>
                                                                    Publish</option>
                                                                <option value="Unpublish" <?php if ($status_publish == "Unpublish") echo "selected"; ?>>
                                                                    Unpublish</option>
                                                            </select>
                                                            <span class="text-error" id="err_content_status"><?php //if(!empty($error)) echo $error["err_content_status"]; 
                                                                                                                ?></span>
                                                        </div>
                                                    </div>
                                                <?php } else {
                                                ?>
                                                    <input type="hidden" name="content_status" id="content_status" value="Draft">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                </div>
                                <hr>

                                <div class='row'>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <?php
                                                if (!empty($data)) $content_komentar =  $data->content_komentar;
                                                else $content_komentar = "";
                                                if (!empty($data)) $content_top =  $data->content_top;
                                                else $content_top = "";
                                                ?>
                                                <input type="checkbox" id="content_komentar" name="content_komentar" value="1" <?php if ($content_komentar == 1) echo "checked"; ?>>Bisa
                                                komentar
                                                <input type="checkbox" id="content_top" name="content_top" value="1" <?php if ($content_top == 1) echo "checked"; ?>> Headlines
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" id="content_hits" name="content_hits" placeholder="Jmlhits" value="<?php if (!empty($data)) echo $data->content_hits;  ?>">
                                    <input type="hidden" class="form-control" id="userinput" name="userinput" placeholder="Userinput" value="<?php if (!empty($data)) echo $data->userinput; ?>">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <div class="btn-group"><button class="btn btn-success " type="submit">Simpan</button><a href="<?php echo base_url() . "admin/posting" ?>" class='btn btn-danger'>Kembali</a></div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title">
                            Media
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?php if ($tipe == 'berita') { ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class='col-md-12'>KATEGORI</label>
                                    <div class="col-md-12">
                                        <?php if (!empty($data)) $kategori =  $data->content_kategoriid;
                                        else $kategori = ""; ?>
                                        <select class="form-control" name="content_kategoriid" id="content_kategoriid" onchange="cekKategori()">
                                            <?php
                                            foreach ($list_m_kategori as $list) {
                                            ?>
                                                <option value='<?php echo $list->id_kategori; ?>' <?php if ($kategori == $list->id_kategori) echo "selected"; ?>>
                                                    <?php echo $list->nama_kategori; ?></option>
                                            <?php
                                            }
                                            ?>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        <span class="text-error" id="err_content_kategoriid"><?php if (!empty($error)) echo $error["err_content_kategoriid"]; ?></span>
                                    </div>
                                </div>
                                <hr>
                            <?php } else {
                            ?>
                                <input type="hidden" name="content_kategoriid" id="content_kategoriid" value="1">
                            <?php
                            }
                            ?>

                            <div class="form-group">
                                <label for="inputEmail3" class='col-md-12'>TAG</label>
                                <div class="col-md-12">
                                    <?php if (!empty($data)) $kategori =  $data->content_kategoriid;
                                    else $kategori = ""; ?>
                                    <input type="text" class="tagsinput" name="content_tag" id="content_tag" value="<?php if (!empty($data)) echo $data->content_tag ?>" />
                                    <span class="text-error" id="err_content_kategoriid"><?php if (!empty($error)) echo $error["err_content_kategoriid"]; ?></span>
                                </div>
                            </div>
                            <hr>
                            <?php
                            if (!empty($data)) {
                                $thumb = explode(',', $data->content_thumb);
                                $jml_lampiran = count($thumb);
                            } else {
                                $thumb = array();
                                $jml_lampiran = 0;
                            }
                            ?>
                            <div class='row'>
                                <input type="hidden" name="content_link" id="content_link" value="">
                                <div class="">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-12 ">THUMB</label>
                                        <div class="col-sm-12">
                                            <div id="priv-img">
                                                <?php
                                                $idx = 0;
                                                foreach ($thumb as $t) {
                                                    $idx++;
                                                ?>
                                                    <div id="lampiran<?= $idx ?>">
                                                        <div class="col-sm-4">
                                                            <div class="thumbnail">
                                                                <div class="caption text-center">
                                                                    <div class="position-relative"><img src="<?= base_url() . "uploads/media/thumb/" . $t ?>" class="img img-responsive">
                                                                        <input type="hidden" name="file[]" id="file<?= $idx ?>" value="<?= $t ?>"></div>

                                                                </div>
                                                                <div class="caption card-footer text-center">
                                                                    <ul class="list-inline">
                                                                        <li><button class="btn btn-danger btn-xs btn-block" type="button" onclick="removeThumb(<?= $idx ?>)"><i class="glyphicon glyphicon-remove"></i>Hapus Thumb</button></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <input type="hidden" id="jml_lampiran" name="jml_lampiran" value="<?= $jml_lampiran ?>">
                                            <input type="hidden" id="content_thumb" name="content_thumb" value="<?php if (!empty($data)) echo $data->content_thumb;  ?>">
                                            <!--div id="filecontrol"><input type="file" id="userfile" name="userfile"-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <hr>

                        <div class="input-group input-group-sm">
                            <input type="hidden" name="start" id="start" value="0">
                            <input type="text" name="q" id="q" class="form-control pull-right" onkeyup="getMedia(0)" placeholder="Search">
                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-green">
                                    <th style="width: 50px;">#</th>
                                    <th>Nama Group</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="2">
                                        <button type='button' class="btn btn-default btn-block" onclick="addGroup()">Tambah Group</button>
                                    </th>
                                </tr>
                            </tbody>
                            <tbody id="data-media"></tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-group" id="pagination"></div>
                </div>
            </div>
    </div>
    </form>
    </div>
</section>

<!--Modal-->
<div class="modal fade" id="modal_view" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="media-title">INSERT MEDIA</h3>
            </div>

            <div class="modal-body form">
                <form class="form-horizontal" method="POST" id="view-form-media" action="<?php echo base_url() . "media/updatemedia"; ?>" enctype="multipart/form-data">
                    <div class="panel-body" id="view-media">

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="insertThumb()" class="btn btn-success">Jadikan
                    Gambar Utama</button>
                <button type="button" id="btnSave" onclick="InsertPostOri()" class="btn btn-warning">Sisipkan Dengan Ukuran Asli</button>
                <button type="button" id="btnSave" onclick="InsertPostThumb()" class="btn btn-warning">Sisipkan Dengan Ukuran Kecil</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>

<!--Modal-->
<div class="modal fade" id="modal_kategori" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="media-title">Tambah kategori</h3>
            </div>

            <div class="modal-body form">
                <form class="form-horizontal" method="POST" id="form-kategori" action="<?= base_url() . "admin/content/add_kategori" ?>" enctype="multipart/form-data">
                    <div class="panel-body">
                        <input type="hidden" id="csrf" class='csrf' name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="input-group input-group-sm">
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control pull-right" placeholder="Kategori">
                            <span class="input-group-addon"><span class="fa fa-plus" onclick="addKategori()"> Add Kategori</span> </span>
                        </div>
                        <span class="text-error" id='err_nama_kategori'></span>

                    </div>
                </form>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>

<!--Modal-->
<div class="modal fade" id="modal_group" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="media-title">Tambah Group Media</h3>
            </div>

            <div class="modal-body form">
                <form class="form-horizontal" method="POST" id="form-group" action="<?= base_url() . "admin/content/add_group" ?>" enctype="multipart/form-data">
                    <div class="panel-body">
                        <input type="hidden" id="csrf_group" class='csrf' name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="input-group input-group-sm">
                            <input type="text" name="nama_group" id="nama_group" class="form-control pull-right" placeholder="Kategori">
                            <span class="input-group-addon"><span class="fa fa-plus" onclick="addGroupMedia()"> Add Group</span> </span>
                        </div>
                        <span class="text-error" id='err_nama_group'></span>

                    </div>
                </form>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>
<div class="modal fade" id="modal_upload" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="media-title">Tambah kategori</h3>
            </div>

            <div class="modal-body form">

                <form action="#" class="dropzone" id="fileupload">
                    <input type="hidden" id="csrf1" class='csrf' name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" id="uploadgroup" name="uploadgroup">
                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() . "lib/js/content.js"; ?>"></script>
<script type="text/javascript">
    getMedia(0);
</script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

    var foto_upload = new Dropzone("#fileupload", {
        url: "<?php echo base_url('index.php/admin/content/fileUpload') ?>",
        maxFilesize: 2,
        maxFiles: 10,
        method: "post",
        acceptedFiles: "image/*",
        paramName: "userfile",
        dictInvalidFileType: "Type file ini tidak dizinkan",
        addRemoveLinks: true,
        data: {
            "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"
        }
    });


    //Event ketika Memulai mengupload
    foto_upload.on("sending", function(a, b, c) {
        console.clear();
        console.log(a);
        console.log(b);
        console.log(c);

        a.token = "<?php echo $this->security->get_csrf_hash(); ?>";
        //c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
        c.append("<?php echo $this->security->get_csrf_token_name(); ?>", "<?php echo $this->security->get_csrf_hash(); ?>");
        //c.getAll();
        console.log(a.token);
    });

    foto_upload.on('success', function(file, response) {
        var args = Array.prototype.slice.call(arguments);

        // Look at the output in you browser console, if there is something interesting
        console.clear();
        console.log("Dropzone Upload Success");
        console.log(file);
        console.log(response);
        $('.csrf').val(response);
        var idgroup = $('#uploadgroup').val();

        $('.open').val("0");
        $('#open' + idgroup).val("1");
        $('.view-media').hide();
        $('#view-media' + idgroup).show();
        openMedia(idgroup);
    });

    //Event ketika foto dihapus
    foto_upload.on("removedfile", function(a) {
        var token = a.token;
        var url = "<?php echo base_url('index.php/admin/content/delete_image') ?>";
        console.clear();
        console.log(token);
        $.ajax({
            type: "post",
            data: {
                "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>",
                token: token
            },
            url: "<?php echo base_url('index.php/admin/content/delete_image') ?>",
            cache: false,
            dataType: 'json',
            success: function() {
                console.log("Foto terhapus");
            },
            error: function(file, errorMessage) {

                console.log(url);
                console.log(errorMessage);

            }
        });
    });


    function sendFile(file, editor, welEditable) {
        data = new FormData();
        data.append("file", file);
        url = "<?= base_url() . "admin/content/fileUpload" ?>";
        console.log(url);
        $.ajax({
            data: data,
            type: "POST",
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                editor.insertImage(welEditable, url);
            }
        });
    }
</script>