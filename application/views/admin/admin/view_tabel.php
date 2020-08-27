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
                        <div class="col-xs-12" style="overflow-x:auto;">
                            <table class="table table-bordered">
                                <thead class="bg-green">
                                    <th>#</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Nohp</th>
                                    <th>Role Akses</th>
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
                        <input type="hidden" name="id_admin" id="id_admin" value="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Namalengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Namalengkap">
                                <span class="text-error" id="err_nama_lengkap"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                <span class="text-error" id="err_email"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
                                <span class="text-error" id="err_alamat"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Nohp</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nohp" name="nohp" placeholder="Nohp">
                                <span class="text-error" id="err_nohp"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Role</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="role" id="role">
                                    <?php
                                    foreach ($role as $r) {
                                    ?>
                                        <option value="<?php echo $r->role_id; ?>"><?= $r->role_nama; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-error" id="err_role"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                <span class="text-error" id="err_username"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <span class="text-error" id="err_password"></span>
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
</script>
<script src="<?php echo base_url() . "lib/js/admin.js"; ?>"></script>