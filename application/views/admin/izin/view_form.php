
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Data Izin</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> IZIN</a></li>
        <li > INDEX</li>
        <li class="active"> FORM</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php if(!empty($notif)) echo $notif; 
    $error=$this->session->flashdata('error');;
    //print_r($error);
    ?>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-success">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">Data Perizinan</h3>
                    <p class="text-muted text-center"><?php if(!empty($row)) echo $row->nama_perizinan; ?></p>
                    <div class="list-group-item">
                        <div class="row">
                            <b class="col-md-4">Tipe</b> <a class="pull-right col-md-8"><?php if(!empty($row)) echo $row->tipe_pemohon; ?></a>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <b class="col-md-4">Rumpun</b> <a class="pull-right col-md-8"><?php if(!empty($row)) echo $row->nama_rumpun; ?></a>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <b class="col-md-4">Bidang</b> <a class="pull-right col-md-8"><?php if(!empty($row)) echo $row->nama_bidang; ?></a>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <b class="col-md-4">Waktu Penyelesaian</b> <a class="pull-right col-md-8"><?php if(!empty($row)) echo $row->waktu_penyelesaian; ?></a>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <b class="col-md-4">Biaya</b> 
                            <a class="pull-right col-md-8">
                                <?php 
                                if(!empty($row)) {
                                    $biaya = $row->biaya; 
                                    if($biaya<=0) {
                                        echo "Gratis";
                                    }else {
                                        echo "Rp. " .$biaya;
                                    }
                                }
                                ?>
                            </a>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <b class="col-md-4">Defenisi</b> <a class="pull-right col-md-8"><?php if(!empty($row)) echo $row->definisi; ?></a>
                        </div>
                    </div>
                    <a href="#" class="btn btn-success btn-block" onclick="edit('<?php echo $row->id_izin; ?>')"><b><span class="fa fa-edit"></span> Ubah</b></a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#persyaratan" data-toggle="tab" aria-expanded="false">Persyaratan<span class="pull-right-container" onclick="addPersyaratan()"><small class="label pull-right bg-orange">New</small></span></a></li>
                    <li class=""><a href="#mekanisme" data-toggle="tab" aria-expanded="false">Mekanisme<span class="pull-right-container" onclick="addMekanisme()"><small class="label pull-right bg-orange">New</small></span></a></li>
                    <li class=""><a href="#dasarhukum" data-toggle="tab" aria-expanded="true">Dasar Hukum<span class="pull-right-container" onclick="addDasarhukum()"><small class="label pull-right bg-orange">New</small></span></a></li>
                    <li class=""><a href="#produklayanan" data-toggle="tab" aria-expanded="true">Produk Layanan<span class="pull-right-container"></a></li>
                    <li><input type="hidden" name="csrf_baru" class='csrf' class="form-control" id="csrf_baru" value="<?=$this->security->get_csrf_hash();?>" ></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="persyaratan">
                        <table class="table table-bordered">
                            <thead class="bg-green">
                                <th>#</th>
                                <th>Persyaratan</th>
                                <th>Lampiran</th>
                                <th class="text-right">#</th>
                            </thead>
                            <!--thead>
                                <td colspan="2">
                                    <label>Persyaratan</label>
                                    <input type="text" name="persyaratan" id="persyaratan" class="form-control" value="">
                                </td>
                                <td>
                                    <label>Lampiran</label>
                                    <input type="file" name="lampiran">
                                </td>
                                <td><button type="button" class="btn btn-success btn-sm">Simpan</button></td>
                            </thead-->
                            <tbody id="d_persyaratan">
                                <?php 
                                $no=0;
                                foreach ($persyaratan as $p) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $p->nama_persyaratan; ?></td>
                                        <td><?= $p->lampiran; ?></td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-warning btn-xs" onclick="editPersyaratan('<?php echo $p->id_syarat; ?>')"><span class="fa fa-edit"></span>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="hapusPersyaratan('<?php echo $p->id_syarat; ?>','<?php echo $p->id_izin ?>')"><span class="fa fa-remove"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="mekanisme">
                        <table class="table table-bordered">
                            <thead class="bg-green">
                                <th>#</th>
                                <th>Mekanisme Dan Prosedur</th>
                                <th class="text-right">#</th>
                            </thead>
                            <tbody id="d_mekanisme">
                                <?php 
                                $no=0;
                                //print_r($mekanisme);
                                foreach ($mekanisme as $m) {
                                    //echo $m->mekanisme_pelayanan;
                                    //echo "<br>";
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo $m->mekanisme_pelayanan; ?></td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-warning btn-xs" onclick="editMekanisme('<?php echo $m->id_mekanisme; ?>')"><span class="fa fa-edit"></span>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="hapusMekanisme('<?php echo $m->id_mekanisme; ?>','<?php echo $m->id_izin; ?>')"><span class="fa fa-remove"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane " id="dasarhukum">
                        <table class="table table-bordered">
                            <thead class="bg-green">
                                <th>#</th>
                                <th>Dasar Hukum</th>
                                <th class="text-right">#</th>
                            </thead>
                            <tbody id="d_dasarhukum">
                                <?php 
                                $no=0;
                                foreach ($dasarhukum as $d) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $d->dasar_hukum; ?></td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-warning btn-xs" onclick="editDasarhukum('<?php echo $d->id_dasar; ?>')"><span class="fa fa-edit"></span>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="hapusDasarhukum('<?php echo $d->id_dasar; ?>')"><span class="fa fa-remove"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane " id="produklayanan">
                        <div class="row">
                            <div class="col-md-4">
                                <?php 
                                $no=0;
                                $sele_prod=array();
                                foreach ($select_produk as $s) {
                                    $sele_prod[]=$s->id_produk;
                                }
                                if(!empty($row)) $id_izin=$row->id_izin; else $id_izin="";
                                foreach ($produk as $p) {
                                    $no++;
                                    ?>
                                    <input type="checkbox" name="produklayanan<?php echo $no ?>" id="produklayanan<?php echo $no ?>" value="<?php echo $p->id_produk; ?>" <?php if(in_array($p->id_produk, $sele_prod)) echo "checked"; ?> onclick="pilihProduk('<?php echo $id_izin; ?>','<?php echo $p->id_produk; ?>','<?php echo $no ?>')"><?php echo $p->nama_produk_layanan ."<br>"; ?>
                                    <?php
                                    if($no%25==0) echo "</div><div class='col-md-4'>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
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
                            <input type="hidden" id="csrf" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
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
                                <label for="inputEmail3" class="col-sm-3 control-label">BIAYA</label>
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
                                    <input type="checkbox" id="status_perizinan" name="status_perizinan" value="1">Ya
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
<!--Modal-->
    <div class="modal fade" id="form_persyaratan" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="" method="POST" id="form_syarat" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf_persyaratan" class="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="id_syarat" id="id_syarat" value="">
                            <input type="hidden" name="id_izin" id="id_izin_persyaratan" value="<?= $row->id_izin; ?>">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label">PERSYARATAN</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="nama_persyaratan" name="nama_persyaratan" placeholder="Persyaratan"></textarea>
                                    <span class ext-error" id="err_nama_persyaratan"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label">LAMPIRAN</label>
                                <div class="col-sm-12">
                                    <input type="file" name="lampiran">
                                    <span class ext-error" id="err_lampiran"></span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="savePersyaratan()" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
<!--Modal-->
    <div class="modal fade" id="form_mekanisme" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="" method="POST" id="f_mekanisme" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf_mekanisme" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="id_mekanisme" id="id_mekanisme" value="">
                            <input type="hidden" name="id_izin" id="id_izin_mekanisme" value="<?= $row->id_izin; ?>">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label">MEKANISME PELAYANAN</label>
                                <div class="col-sm-12">
                                    
                                    <textarea class="form-control" id="mekanisme_pelayanan" name="mekanisme_pelayanan" placeholder="Mekanisme Pelayanan"></textarea>
                                    <span class ext-error" id="err_mekanisme_pelayanan"></span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="saveMekanisme()" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
<!--Modal-->
    <div class="modal fade" id="form_dasarhukum" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="" method="POST" id="f_dasarhukum" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf_dasarhukum" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="id_dasar" id="id_dasar" value="">
                            <input type="hidden" name="id_izin" id="id_izin_dasarhukum" value="<?= $row->id_izin; ?>">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label">DASAR HUKUm</label>
                                <div class="col-sm-12">
                                    
                                    <textarea class="form-control" id="dasar_hukum" name="dasar_hukum" placeholder="Dasar Hukum"></textarea>
                                    <span class ext-error" id="err_dasar_hukum"></span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="saveDasarhukum()" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
<script type="text/javascript">
    var base_url= "<?php echo base_url(); ?>";
    <?php 
    if(empty($this->uri->segment(3))) {
       ?>
        $(window).on('load',function(){
          $('#modal_form').modal('show');
        });

        /*$('#form')[0].reset(); 
        $('#modal_form').modal('show'); 
        $('#modal_form').modal({backdrop: 'static', keyboard: false})  */
       <?php 
    }

    ?>
</script>
<script src="<?php echo base_url() ."js/izin.js"; ?>"></script>