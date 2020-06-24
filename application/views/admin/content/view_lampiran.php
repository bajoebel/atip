<style type="text/css">
    .popup-pencarian {
        position: relative;
    }

    .content-pencarian {
        display: inherit;
        position: absolute;
        top: 0px;
        left: 0px;
        z-index: 1;
        width: 100%;
        /*max-height: 500px;*/
        min-width: 700px;
        /*padding:15px;*/
        background: #fefefe;
        font-size: .875em;
        border-radius: 5px;
        panel-shadow: 0 1px 3px #ccc;
        border: 1px solid #ddd;
        /*overflow:hidden;*/
        /*overflow-y: scroll;*/
        background-color: #fefefe;
    }
</style>
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
        <form class="form-horizontal" method="POST" id="form" action="<?php echo base_url() . "admin/" . strtolower($tipe) . "/save" ?>" enctype="multipart/form-data">
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title">
                            Form Lampiran <?php if (!empty($post)) echo $post->content_judul ?>
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
                                    <input type="hidden" name="content_id" id="content_id" value="<?php if (!empty($content_id)) echo $content_id; ?>">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 ">JUDUL LAMPIRAN</label>
                                            <div class="col-sm-12">
                                                <input type="hidden" id="id_lampiran" name="id_lampiran" value="">
                                                <input type="text" class="form-control" id="judul_lampiran" name="judul_lampiran" placeholder="Judul Lampiran" value="<?php if (!empty($data)) echo $data->judul_lampiran; ?>">
                                                <span class="text-error" id="err_judul_lampiran"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="radio" name="jenis_lampiran" id="gambar" value="Gambar" onclick="showMedia()"> Gambar
                                                <input type="radio" name="jenis_lampiran" id="link" value="Link" onclick="showMedia()"> Link
                                                <input type="radio" name="jenis_lampiran" id="group" value="Group" onclick="showMedia()"> Group Media
                                                <span class="text-error" id="err_jenis_lampiran"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div id="cari-lampiran" class="popup-pencarian" style="display: none;">
                                    <div class="content-pencarian">
                                        <input type="hidden" name="show" id="showmemdia" value="0">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div id="viewlampiran">

                                            </div>
                                            <div class='text-error' id="err_isi_lampiran"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <div class="btn-group"><button class="btn btn-success " type="button" onclick="saveLampiran()">Simpan</button><a href="<?php echo base_url() . "admin/posting" ?>" class='btn btn-danger'>Kembali</a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title">
                            List Lampiran
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-borderd'>
                            <thead class="bg-green">
                                <tr>
                                    <th>#</th>
                                    <th>Judul Lampiran</th>
                                    <th>jenis Lampiran</th>
                                    <th>Isi</th>
                                    <th class="text-right">#</th>
                                </tr>
                            </thead>
                            <tbody id="data-lampiran"></tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-group" id="pagination"></div>
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
                <button type="button" id="btnSave" onclick="insertLampiran()" class="btn btn-success">Sisipkan</button>

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
<script src="<?php echo base_url() . "lib/js/" . strtolower($tipe) . ".js"; ?>"></script>
<script type="text/javascript">
    getMedia(0);
    getlampiran('<?= $id ?>');
</script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

    var foto_upload = new Dropzone("#fileupload", {
        url: "<?php echo base_url('index.php/admin/' . strtolower($tipe) . '/fileUpload') ?>",
        maxFilesize: 2,
        maxFiles: 10,
        method: "post",
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
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
        url = "<?= base_url() . "admin/" . strtolower($tipe) . "/fileUpload" ?>";
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