<!-- Main content -->
<section class="content">
    <?php if (!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">
                        <?php
                        $save = array('aksi' => 'Save');
                        if (in_array($save, $akses)) {
                        ?>
                            <button type="button" class="btn btn-success btn-sm" onclick="add()"><span class="fa fa-plus"></span> Tambah</button>
                        <?php
                        }
                        ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="text-right">
                                <select class="form-control" style="width: 40px;" id="limit" name='limit' onchange="getMedia(0)">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-group">
                                <input type="hidden" name='star' id='star'>
                                <input type="text" name='q' id='q' class="form-control" placeholder='Search' onkeyup="getMedia(0)">
                                <input type="hidden" name="start" id="start" value="0">
                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-bordered">
                                <thead class="bg-green">
                                    <th style="width: 50px;">#</th>
                                    <th>Nama Group</th>
                                    <th style="width: 15px;">Status</th>
                                    <!--th style="width: 100px;">Tampil Digalery</th>
                                    <th style="width: 100px;">Tampil Dihalaman PPID</th>
                                    <th style="width: 100px;">Tampil Dihalaman Download</th-->
                                    <th class="text-right" style="width: 100px;">#</th>
                                </thead>
                                <tbody id="data"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-group" id="pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--img src=""-->
<!--Modal-->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">COBA</h3>
            </div>

            <div class="modal-body form">
                <form class="form-horizontal" method="POST" id="form" action="#" enctype="multipart/form-data">
                    <div class="panel-body">
                        <input type="hidden" class="csrf" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id_group" id="id_group" value="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Namagroup</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_group" name="nama_group" placeholder="Namagroup">
                                <span class ext-error" id="err_nama_group"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-9">
                                <input type="checkbox" class='' id="status_group" name="status_group" value="1">Aktif
                                <input type="hidden" class='' id="sebagai_galery" name="sebagai_galery" value="0">
                                <input type="hidden" class='' id="sebagai_ppid" name="sebagai_ppid" value="0">
                                <input type="hidden" class='' id="sebagai_download" name="sebagai_download" value="0">
                            </div>
                        </div>
                        <!--div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" class='' id="sebagai_galery" name="sebagai_galery" value="1">Post Dihalaman Galery
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" class='' id="sebagai_ppid" name="sebagai_ppid" value="1">Post Dihalaman PPID
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" class='' id="sebagai_download" name="sebagai_download" value="1">Post Dihalaman Download
                                </div>
                            </div-->
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

<!--Modal-->
<div class="modal fade" id="modal_media" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="media-title">UPLOAD FILE</h3>
            </div>

            <div class="modal-body form">
                <form class="form-horizontal" method="POST" id="form-media" action="<?php echo base_url() . "media/upload"; ?>" enctype="multipart/form-data">
                    <div class="panel-body">
                        <input type="hidden" class="csrf" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id_group" id="x-id_group" value="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-12">JUMLAH FILE</label>
                            <div class="col-sm-12">

                                <select class="form-control" name="jumlah_file" id="jumlah_file" onchange="halamanBerkas()">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                                <span class ext-error" id="err_jumlah_file"></span>
                            </div>
                        </div>
                        <div id="file_berkas">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12">FILE 1</label>
                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control" id="nama_file" name="nama_file" placeholder="Namafile">
                                    <input type="file" id="file1" name="userfile[]" class="form-control" placeholder="Nama File">
                                    <span class ext-error" id="err_nama_file"></span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="keterangan" id="keterangan[]" placeholder="Keterangan" class="form-control" value="-">
                                </div>
                            </div>

                        </div>
                        <!--div class="form-group">
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div-->

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="upload()" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

<!--Modal-->
<div class="modal fade" id="modal_view" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="media-title">UPDATE MEDIA</h3>
            </div>

            <div class="modal-body form">
                <form class="form-horizontal" method="POST" id="view-form-media" action="<?php echo base_url() . "media/updatemedia"; ?>" enctype="multipart/form-data">
                    <div class="panel-body" id="view-media">

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="updateMedia()" class="btn btn-success">Update</button>
                <button type="button" id="btnSave" onclick="deleteMedia()" class="btn btn-warning">Hapus</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() . "lib/js/media.js"; ?>"></script>