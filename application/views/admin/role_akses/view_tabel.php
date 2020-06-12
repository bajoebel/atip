<!-- Main content -->
<section class="content">
    <?php if(!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">
                    <?php 
                    $save=array('aksi'=>'Save');
                    if(in_array($save, $akses)){
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
                                <select class="form-control" style="width: 40px;" id="limit" name='limit' onchange="getRole_akses(0)">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-group">
                            <input type="hidden" name='star' id='star' >
                                <input type="text" name='q' id='q' class="form-control" placeholder='Search' onkeyup="getRole_akses(0)">
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
                                    <th>Role</th>
                                    <th>Modul</th>
                                    <th>Aksi</th>
                                    <th>Tampil Menu</th><th class="text-right">#</th>
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
                            
                            <input type="hidden" name="id_akses" id="id_akses" value="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Roleid</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="role_id" id="role_id">
                                        <?php 
                                foreach ($list_m_role as $list) {
                                    ?>
                                    <option value='<?php echo $list->role_id; ?>' ><?php echo $list->role_nama; ?></option>
                                    <?php
                                }
                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Modulid</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="modul_id" id="modul_id">
                                        <?php 
                                foreach ($list_m_moduls as $list) {
                                    ?>
                                    <option value='<?php echo $list->id_modul; ?>' ><?php echo $list->nama_modul; ?></option>
                                    <?php
                                }
                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Idaksi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="id_aksi" id="id_aksi">
                                        <?php 
                                foreach ($list_m_aksi as $list) {
                                    ?>
                                    <option value='<?php echo $list->id_aksi; ?>' ><?php echo $list->nama_aksi; ?></option>
                                    <?php
                                }
                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" id="checkbox" name="checkbox" value="1">Ya
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
    var base_url= "<?php echo base_url()."admin/"; ?>";
</script>
<script src="<?php echo base_url() ."lib/js/role_akses.js"; ?>"></script>