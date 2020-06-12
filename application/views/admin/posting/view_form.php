<!-- Main content -->
<section class="content">
    
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-success">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">
                    Form Posting
                    </h3>
                    <div class="panel-tools">
                        
                    </div>
                </div>
                <form class="form-horizontal" method="POST" id="form" action="<?php echo base_url() ."admin/posting/save" ?>" enctype="multipart/form-data">
                <div class="panel-body">
                    <div class="panel-body"><?php if(!empty($notif)) echo $notif; 
                        $err=$this->session->flashdata('error');
                        if(!empty($err)){
                            if(is_array($err)){
                                $error=$err;
                            }else{
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
                        
                        //print_r($error);
                        //echo "<br>";
                        //echo $error["err_isi_posting"];
                        ?>

                        <div class="row">
                            <div class="row">
                                <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                                <input type="hidden" name="id_posting" id="id_posting" value="<?php if(!empty($data)) echo $data->id_posting; ?>">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-12 ">JUDUL</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="judul_posting" name="judul_posting" placeholder="Judulposting" value="<?php if(!empty($data)) echo $data->judul_posting; ?>">
                                            <span class ext-error" id="err_judul_posting"><?php if(!empty($error)) echo $error["err_isi_posting"]; ?></span>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 ">KATEGORI</label>
                                            <div class="col-sm-12">
                                                <?php if(!empty($data)) $kategori =  $data->id_kategori; else $kategori=""; ?>
                                                <select class="form-control" name="id_kategori" id="id_kategori">
                                                    <?php 
                                                        foreach ($list_m_kategori as $list) {
                                                            ?>
                                                            <option value='<?php echo $list->id_kategori; ?>' <?php if($kategori==$list->id_kategori) echo "selected"; ?>><?php echo $list->nama_kategori; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                                <span class ext-error" id="err_id_kategori"><?php if(!empty($error)) echo $error["err_id_kategori"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-12 ">GROUP</label>
                                            <div class="col-sm-12">
                                                <?php if(!empty($data)) $group =  $data->group_posting; else $group=""; ?>
                                                <select class="form-control" name="group_posting" id="group_posting">
                                                    <option value="Halaman" <?php if($group=='Halaman') echo "selected"; ?>>Halaman</option>
                                                    <option value="Artikel" <?php if($group=='Artikel') echo "selected"; ?>>Artikel</option>
                                                </select>
                                                <span class ext-error" id="err_group_posting"><?php if(!empty($error)) echo $error["err_group_posting"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 ">CONTENT</label>
                                    <div class="col-sm-12">
                                        <textarea class="summernote" name="isi_posting" id="isi_posting"><?php if(!empty($data)) echo $data->isi_posting; ?></textarea>
                                        <span class ext-error" id="err_isi_posting"><?php if(!empty($error)) echo $error["err_isi_posting"]; ?></span>
                                    </div>
                                </div>
                                </div><br>
                                <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 ">TANGGAL PUBLISH</label>
                                                <div class="col-sm-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker" id="tgl_publish" name="tgl_publish" placeholder="Tglpublish" value="<?php if(!empty($data)) echo $data->tgl_publish; else echo date('Y-m-d') ?>">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <span class ext-error" id="err_tgl_publish"><?php //if(!empty($error)) echo $error["err_tgl_publish"]; ?></span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 ">TANGGAL EXPIRE (Kosongkan Jika Tidak ada)</label>
                                                <div class="col-sm-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker" id="tgl_exp" name="tgl_exp" placeholder="Tglexp" value="<?php if(!empty($data)) echo $data->tgl_exp;  ?>">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <span class ext-error" id="err_tgl_exp"><?php //if(!empty($error)) echo $error["err_tgl_exp"]; ?></span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php 
                                            $publish=array('aksi'=>'Publish');
                                            if(in_array($publish, $akses)){
                                            ?>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 ">STATUS POSTING</label>
                                                <div class="col-sm-12">
                                                    <?php if(!empty($data)) $status_publish =  $data->status_posting; else $status_publish=""; ?>
                                                    <select class="form-control" name="status_posting" id="status_posting">
                                                        <option value="Draft" <?php if($status_publish=="Draft") echo "selected"; ?>>Draft</option>
                                                        <option value="Publish" <?php if($status_publish=="Publish") echo "selected"; ?>>Publish</option>
                                                        <option value="Unpublish" <?php if($status_publish=="Unpublish") echo "selected"; ?>>Unpublish</option>
                                                    </select>
                                                    <span class ext-error" id="err_status_posting"><?php //if(!empty($error)) echo $error["err_status_posting"]; ?></span>
                                                </div>
                                            </div>
                                            <?php }
                                            else{
                                                ?>
                                                <input type="hidden" name="status_posting" id="status_posting" value="Draft">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                </div><br>
                                
                                <input type="hidden" name="link_posting" id="link_posting" value="">
                                <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 ">THUMB</label>
                                    <div class="col-sm-12">
                                        <div id="priv-img"></div>
                                        <input type="hidden" class="form-control" id="lampiran_gambar" name="lampiran_gambar" placeholder="Lampirangambar" value="<?php if(!empty($data)) echo $data->lampiran_gambar;  ?>">
                                        <div id="filecontrol"><input type="file"  id="userfile" name="userfile" ></div>
                                        <span class ext-error" id="err_lampiran_gambar"></span>
                                    </div>
                                </div>
                                </div><br>
                                <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <?php if(!empty($data)) $status_komentar =  $data->status_komentar; else $status_komentar=""; ?>
                                        <input type="checkbox" id="status_komentar" name="status_komentar" value="1" <?php if($status_komentar==1) echo "checked"; ?>>Bisa komentar
                                        
                                    </div>
                                </div>
                                </div>
                                <input type="hidden" class="form-control" id="jml_hits" name="jml_hits" placeholder="Jmlhits" value="<?php if(!empty($data)) echo $data->jml_hits;  ?>">
                                <input type="hidden" class="form-control" id="userinput" name="userinput" placeholder="Userinput" value="<?php if(!empty($data)) echo $data->userinput; ?>">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <div class="btn-group" ><button class="btn btn-success " type="submit">Simpan</button><a href="<?php echo base_url()."admin/posting" ?>" class='btn btn-danger'>Kembali</a></div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">
                    Media
                    </h3>
                </div>
                <div class="panel-body">
                    <form action="#" method="GET">
                    <div class="input-group input-group-sm">
                        <input type="hidden" name="start" id="start" value="0" onkeyup="getMedia(0)">
                        <input type="text" name="q" id="q" class="form-control pull-right" placeholder="Search">
                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                    </div>
                    </form>
                    <br>
                    <table class="table table-bordered">
                        <thead class="bg-green">
                            <th style="width: 50px;">#</th>
                            <th>Nama Group</th>
                        </thead>
                        <tbody id="data-media"></tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="btn-group" id="pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Modal-->
<div class="modal fade" id="modal_view" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="media-title">INSERT MEDIA</h3>
                </div>

                <div class="modal-body form">
                    <form class="form-horizontal" method="POST" id="view-form-media" action="<?php echo base_url() ."media/updatemedia"; ?>" enctype="multipart/form-data">
                        <div class="panel-body" id="view-media">
                            
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="insertThumb()" class="btn btn-success">Jadikan Thumbnail</button>
                    <button type="button" id="btnSave" onclick="InsertPostOri()" class="btn btn-warning">Insert Original Size</button>
                    <button type="button" id="btnSave" onclick="InsertPostThumb()" class="btn btn-warning">Insert Thumb Size</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
<script type="text/javascript">
    /*$(function () {
        CKEDITOR.replace('isi_posting',
            {
                enterMode : CKEDITOR.ENTER_BR,
                toolbar :
                [
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                    { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                    
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                    
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                    { name: 'others', items: [ '-' ] },
                    { name: 'about', items: [ 'About' ] },
                    
                ]
            }
        );

        CKEDITOR.editorConfig = function( config ) {
            config.toolbarGroups = [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'forms', groups: [ 'forms' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                '/',
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'about', groups: [ 'about' ] }
            ];
        };
        //Date picker
        $('.datepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
        })
    })*/
    var base_url= "<?php echo base_url(); ?>";
    
</script>
<script src="<?php echo base_url() ."lib/js/posting.js"; ?>"></script>
<script type="text/javascript">
getMedia(0);
</script>