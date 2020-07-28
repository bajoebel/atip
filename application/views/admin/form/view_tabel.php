<!-- Main content -->
<section class="content">
    <?php if (!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading ui-draggable-handlel">
                    <h3 class="panel-title">
                        <?php
                        $save = array('aksi' => 'Save');
                        if (in_array($save, $akses)) {
                        ?>
                            <a href="<?= base_url() . "admin/form/tambah" ?>" type="button" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> Tambah</a>
                        <?php
                        }
                        ?>
                    </h3>

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="text-right">
                                <select class="form-control" style="width: 40px;" id="limit" name='limit' onchange="getAdmin(0)">
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
                                <input type="text" name='q' id='q' class="form-control" placeholder='Search' onkeyup="getAdmin(0)">
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
                                    <th>#</th>
                                    <th>Judul Form</th>
                                    <th>Link</th>
                                    <th>Lampiran</th>
                                    <th>Status</th>
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
                    <div class="panel-body">
                        <input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="form_id" id="form_id" value="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Judul</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="form_title" name="form_title" placeholder="Judul Form">
                                <input type="hidden" class="form-control" id="form_link" name="form_link" placeholder="form_link">
                                <span class ext-error" id="err_nama_kategori"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Jml Field</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="jml_field" name="jml_field" placeholder="Jumlah Field" value="1" onchange="CreateField()">
                                <span class ext-error" id="err_jml_field"></span>
                            </div>
                        </div>
                        <hr>
                        <div id="field">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="field">Field</label>
                                    <input type="text" name="field[]" id="field" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="field">Control</label>
                                    <select name="control[]" id="control" class="form-control" required>
                                        <option value="textbox">Textbox</option>
                                        <option value="datepicker">Datepicker</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="combobox">Combobox</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="Radio">Radio</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="field">Source</label>
                                    <input type="text" name="source[]" id="source" class="form-control" value="-" required>
                                </div>
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
    var base_url = "<?php echo base_url() . "admin/"; ?>";
    var base_link = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() . "lib/js/form.js"; ?>"></script>
<script>
    getform(0);
</script>