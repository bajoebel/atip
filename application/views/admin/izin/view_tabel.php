
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Data Izin</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> IZIN</a></li>
        <li class="active"> INDEX</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php if(!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                    <?php 
                    $save=array('aksi'=>'Save');
                    if(in_array($save, $akses)){
                        ?>
                        <button type="button" class="btn btn-success btn-sm" onclick="add()"><span class="fa fa-plus"></span> Tambah</button>
                        <?php
                    }
                    ?>
                    </h3>
                    <div class="box-tools">
                        <form action="#" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="hidden" name="start" id="start" value="0">
                                <input type="text" name="q" id="q" class="form-control pull-right" placeholder="Search">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default" onclick="getIzin(0)"><i class="fa fa-search"></i></button>
                                    <?php 
                                    $excel=array('aksi'=>'Excel');
                                    $pdf=array('aksi'=>'Pdf');
                                    if(in_array($excel, $akses)){
                                        ?>
                                        <a href="<?php echo base_url() ."izin/exel" ?>" class="btn btn-success btn-sm"><span class="fa fa-file-excel-o"></span></a>
                                        <?php
                                    }
                                    if(in_array($pdf, $akses)){
                                        ?>
                                        <a href="<?php echo base_url() ."izin/pdf" ?>" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead class="bg-green">
                            <th>#</th>
                            <th>Tipe</th>
                            <th>Rumpun</th>
                            <th>Bidang</th>
                            <th>Nama Perizinan</th>
                            <th>Definisi</th>
                            <th>Status Perizinan</th>
                            <th class="text-right">#</th>
                        </thead>
                        <tbody id="data"></tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="btn-group" id="pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Modal-->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="form-horizontal" method="POST" id="form" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="id_izin" id="id_izin" value="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">TIPE</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="id_tipe" id="id_tipe" >
                                        <option value="">Pilih</option>
                                        <?php 
                                            foreach ($list_tipe as $list) {
                                                ?>
                                                <option value='<?php echo $list->id_tipe; ?>' ><?php echo $list->tipe_pemohon; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <span class ext-error" id="err_id_tipe"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">RUMPUN</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="id_rumpun" id="id_rumpun">
                                        <option value="">Pilih</option>
                                        <?php 
                                            foreach ($list_m_rumpun as $list) {
                                                ?>
                                                <option value='<?php echo $list->id_rumpun; ?>' ><?php echo $list->nama_rumpun; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <span class ext-error" id="err_id_rumpun"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">BIDANG</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="id_bidang" id="id_bidang">
                                        <option value="">Pilih</option>
                                        <?php 
                                            foreach ($list_m_bidang as $list) {
                                                ?>
                                                <option value='<?php echo $list->id_bidang; ?>' ><?php echo $list->nama_bidang; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <span class ext-error" id="err_id_bidang"></span>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NAMA PERIZINAN</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_perizinan" name="nama_perizinan" placeholder="Namaperizinan">
                                    <span class ext-error" id="err_nama_perizinan"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">WAKTU PENYELESAIAN</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="waktu_penyelesaian" name="waktu_penyelesaian" placeholder="Waktu Penyelesaian">
                                    <span class ext-error" id="err_waktu_penyelesaian"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Biaya</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="biaya" name="biaya" placeholder="Waktu Penyelesaian">
                                    <span class ext-error" id="err_biaya"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">DEFINISI</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="definisi" id="definisi"></textarea>
                                    <span class ext-error" id="err_definisi"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" id="status_perizinan" name="status_perizinan" value="1">Aktif
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
    var base_url= "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() ."js/izin.js"; ?>"></script>