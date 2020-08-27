<!-- Main content -->
<style>
    .dropdown-menu {
        position: relative;
    }
</style>
<section class="content">
    <?php if (!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="box-title">
                        <?php
                        $save = array('aksi' => 'Save');
                        if (in_array($save, $akses)) {
                        ?>
                            <a href="<?php echo base_url() . "admin/" . strtolower($content_tipe) . "/form" ?>" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> Tambah</a>
                        <?php
                        }
                        ?>
                    </h3>

                </div>
                <div class="box-body">
                    <div class="row">
                        <input type="hidden" id="tipe" name="tipe" value="<?= $content_tipe ?>">
                        <div class="col-xs-9">
                            <div class="text-right">
                                <select class="form-control" style="width: 40px;" id="limit" name='limit' onchange="getcontent(0)">
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
                                <input type="text" name='q' id='q' class="form-control" placeholder='Search' onkeyup="getcontent(0)">
                                <input type="hidden" name="start" id="start" value="0">
                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12" style="overflow-x:auto;">
                            <table class="table table-bordered">
                                <thead class="bg-green">
                                    <th>#</th>
                                    <th>Judul Posting</th>
                                    <?php if ($content_tipe == "Berita") { ?>
                                        <th>Kategori</th>
                                    <?php } ?>
                                    <th>Tgl Posting</th>
                                    <th>Tgl Publish</th>
                                    <?php if ($content_tipe == "Berita") { ?>
                                        <th>Tgl Exp</th>
                                    <?php } ?>
                                    <th>Link</th>
                                    <th>Status Komentar</th>
                                    <th>Status Posting</th>
                                    <th>Jml Hits</th>
                                    <th>Userinput</th>
                                    <th class="text-right">#</th>
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
                    <div class="box-body">
                        <input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id_posting" id="id_posting" value="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Idkategori</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="id_kategori" id="id_kategori">
                                    <?php
                                    foreach ($list_m_kategori as $list) {
                                    ?>
                                        <option value='<?php echo $list->id_kategori; ?>'><?php echo $list->nama_kategori; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-error" id="err_id_kategori"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Judulposting</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="judul_posting" name="judul_posting" placeholder="Judulposting">
                                <span class="text-error" id="err_judul_posting"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Isiposting</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="isi_posting" id="isi_posting"></textarea>
                                <span class="text-error" id="err_isi_posting"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Tglposting</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tgl_posting" name="tgl_posting" placeholder="Tglposting">
                                <span class="text-error" id="err_tgl_posting"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Tglpublish</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="tgl_publish" name="tgl_publish" placeholder="Tglpublish">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <span class="text-error" id="err_tgl_publish"></span>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Tglexp</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="tgl_exp" name="tgl_exp" placeholder="Tglexp">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <span class="text-error" id="err_tgl_exp"></span>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Lampirangambar</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lampiran_gambar" name="lampiran_gambar" placeholder="Lampirangambar">
                                <span class="text-error" id="err_lampiran_gambar"></span>
                            </div>
                        </div>
                        <input type="hidden" name="link_posting" id="link_posting" value="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Groupposting</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="group_posting" id="group_posting">

                                    <option value="Halaman">Halaman</option>
                                    <option value="Artikel">Artikel</option>
                                </select>
                                <span class="text-error" id="err_group_posting"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-9">
                                <input type="checkbox" id="status_komentar" name="status_komentar" value="1">Ya
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Statusposting</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status_posting" id="status_posting">

                                    <option value="Draft">Draft</option>
                                    <option value="Publish">Publish</option>
                                    <option value="Unpublish">Unpublish</option>
                                </select>
                                <span class="text-error" id="err_status_posting"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Jmlhits</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="jml_hits" name="jml_hits" placeholder="Jmlhits">
                                <span class="text-error" id="err_jml_hits"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Userinput</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="userinput" name="userinput" placeholder="Userinput">
                                <span class="text-error" id="err_userinput"></span>
                            </div>
                        </div>
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
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() . "lib/js/" . strtolower($tipe) . ".js"; ?>"></script>
<script type="text/javascript">
    getcontent(0);
</script>