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
                                <select class="form-control" style="width: 40px;" id="limit" name='limit' onchange="getSlider(0)">
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
                                <input type="text" name='q' id='q' class="form-control" placeholder='Search' onkeyup="getSlider(0)">
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
                                    <th>Gambar Slider</th>
                                    <th>Keterangan Slider</th>
                                    <th>Posting Terkait</th>
                                    <th style="width: 80px;">Status Slider</th>
                                    <th class="text-right" style="width: 80px;">#</th>
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
                    <div class="panel-body">
                        <input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id_slider" id="id_slider" value="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Top Posting</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-sm">
                                    <input type="hidden" name="id_posting" id="id_posting" value="">
                                    <input type="text" name="judul_posting" id="judul_posting" class="form-control pull-right" placeholder="Top Posting" onclick="cariArtikel(0)" readonly>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-success" onclick="cariArtikel(0)"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div id="cari-artikel" class="popup-pencarian" style="display: none;">
                                    <div class="content-pencarian">
                                        <input type="hidden" name="show" id="show" value="0">
                                        <table class="table table-bordered">
                                            <thead class="bg-green">
                                                <tr>
                                                    <td style="width: 50px;"></td>
                                                    <td>Judul Posting</td>
                                                    <td style="width: 80px;">#</td>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 0px;" colspan="3"><input type="text" name="q-posting" id="q-posting" class="form-control input-sm" onkeyup="getPosting(0)" placeholder="Cari Artikel"></td>

                                                </tr>
                                            </tbody>
                                            <tbody id="data-posting"></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" style="text-align: right;">
                                                        <div id="pagination-posting"></div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <span class ext-error" id="err_keterangan_slider"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="keterangan_slider" id="keterangan_slider"></textarea>
                                <span class ext-error" id="err_keterangan_slider"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Gambar</label>
                            <div class="col-sm-9">
                                <input type="file" id="userfile" name="userfile" placeholder="Gambarslider">
                                <span class ext-error" id="err_gambar_slider"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-9">
                                <input type="checkbox" id="status_slider" name="status_slider" value="1">Aktif
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
<script src="<?php echo base_url() . "lib/js/slider.js"; ?>"></script>