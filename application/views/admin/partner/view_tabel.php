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
                                <select class="form-control" style="width: 40px;" id="limit" name='limit' onchange="getKategori(0)">
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
                                <input type="text" name='q' id='q' class="form-control" placeholder='Search' onkeyup="getKategori(0)">
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
                                    <th>Nama</th>
                                    <th>Link</th>
                                    <th>Img</th>
                                    <th>Status</th><th class="text-right">#</th>
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
                            <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="partner_id" id="partner_id" value="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="partner_nama" name="partner_nama" placeholder="partnernama">
                                    <span class	ext-error" id="err_partner_nama"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Link</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="partner_link" name="partner_link" placeholder="partnerlink">
                                    <span class	ext-error" id="err_partner_link"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Gambar</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="partner_img" name="userfile" placeholder="partnerimg">
                                    <span class	ext-error" id="err_partner_img"></span>
                                    <label for="" style="color:#8a1515">Max Size : <?= _SIZE_PARTNER_ORIGINAL_ ?> Kb </label>
                                    <label for="" style="color:#342b9d">Max Width : <?= _WIDTH_PARTNER_ORIGINAL_ ?> px </label>
                                    <label for="" style="color:#299f10">Max Height : <?= _HEIGHT_PARTNER_ORIGINAL_ ?> px </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" id="partner_status" name="partner_status" value="1">Aktif
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
    var base_url= "<?php echo base_url() ; ?>";
</script>
<script src="<?php echo base_url() ."lib/js/partner.js"; ?>"></script>