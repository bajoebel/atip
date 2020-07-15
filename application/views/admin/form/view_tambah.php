<!-- Main content -->
<section class="content">
    <?php if (!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading ui-draggable-handlel">
                    <h3 class="panel-title">
                        Tambah Form
                    </h3>

                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" id="form" action="<?= base_url() . "admin/form/save" ?>" enctype="multipart/form-data">
                        <div class="panel-body">
                            <input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" name="form_id" id="form_id" value="<?php if (!empty($row)) echo $row->form_id; ?>">
                            <?php
                            if (!empty($row)) {
                                $field = json_decode($row->form_field);
                            } else {
                                $field = array();
                            }
                            ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Judul</label>
                                <div class="col-sm-10">
                                    <input type="hidden" id="jml_field" name="jml_field" value="<?= count($field) ?>">
                                    <input type="text" class="form-control" id="form_title" name="form_title" value="<?php if (!empty($row)) echo $row->form_title; ?>" placeholder="Judul Form" required>
                                    <input type="hidden" class="form-control" id="form_link" name="form_link" placeholder="form_link" value="<?php if (!empty($row)) echo $row->form_link; ?>">
                                    <span class="text-error" id="err_nama_kategori"></span>
                                </div>
                            </div>
                            <!--div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jml Field</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jml_field" name="jml_field" placeholder="Jumlah Field" value="1" onchange="CreateField()">
                                    <span class="text-error" id="err_jml_field"></span>
                                </div>
                            </div-->
                            <hr>
                            <div id="field">
                                <?php
                                if (empty($field)) {
                                ?>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label for="field">Field</label>
                                            <input type="hidden" name="idx[]" id="idx0" class="form-control" value="0" required>
                                            <input type="text" name="field0" id="field0" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="field">Control</label>
                                            <select name="control0" id="control0" class="form-control" onchange="getSource(0)" required>
                                                <option value="textbox">Textbox</option>
                                                <option value="datepicker">Datepicker</option>
                                                <option value="textarea">Textarea</option>
                                                <option value="combobox">Combobox</option>
                                                <option value="checkbox">Checkbox</option>
                                                <option value="Radio">Radio</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <label for="field">Source</label>
                                            </div>

                                            <div class="col-md-6">
                                                <select name="source0" id="source0" class="form-control" onchange="lainnya(0)">
                                                    <option value="-">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6" id="lain" style="display: block;">
                                                <div class="input-group">
                                                    <input type="text" name="source_lain0" id="source_lain0" class="form-control" value="-" required>
                                                    <span class="input-group-addon"><a href='#' onclick="addField()"><span class="fa fa-plus"></span></a></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php
                                } else {
                                    //print_r($field);
                                ?>
                                    <?php
                                    $i = 0;
                                    foreach ($field as $f) {
                                        //echo $f->control;
                                    ?>

                                        <div class="form-group" id="row<?= $i ?>">
                                            <div class="col-md-3">
                                                <?php if ($i == 0) echo "<label>Field</label>"; ?>
                                                <input type="hidden" name="idx[]" id="idx<?= $i ?>" class="form-control" value="<?= $i ?>" required>
                                                <input type="text" name="field<?= $i ?>" id="field<?= $i ?>" class="form-control" value="<?= $f->alias ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <?php if ($i == 0) echo "<label>Control</label>"; ?>
                                                <select name="control<?= $i ?>" id="control<?= $i ?>" class="form-control" onchange="getSource(0)" required>
                                                    <option value="textbox" <?php if ($f->control == "textbox") echo "selected" ?>>Textbox</option>
                                                    <option value="datepicker" <?php if ($f->control == "datepicker") echo "selected" ?>>Datepicker</option>
                                                    <option value="textarea" <?php if ($f->control == "textarea") echo "selected" ?>>Textarea</option>
                                                    <option value="combobox" <?php if ($f->control == "combobox") echo "selected" ?>>Combobox</option>
                                                    <option value="checkbox" <?php if ($f->control == "checkbox") echo "selected" ?>>Checkbox</option>
                                                    <option value="Radio" <?php if ($f->control == "Radio" || $f->control == "radio") echo "selected" ?>>Radio</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">

                                                <?php if ($i == 0) echo "<div class='col-md-12'><label>Source</label></div>"; ?>
                                                <div class="col-md-6">
                                                    <select name="source<?= $i ?>" id="source<?= $i ?>" class="form-control" onchange="lainnya(0)">
                                                        <option value="-">Lainnya</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6" id="lain" style="display: block;">
                                                    <div class="input-group">
                                                        <input type="text" name="source_lain<?= $i ?>" id="source_lain<?= $i ?>" class="form-control" value="<?php if (!empty($f->source)) echo $f->source;
                                                                                                                                                                else echo "-" ?>" required>
                                                        <span class="input-group-addon" <?php if ($i == 0) echo "";
                                                                                        else echo 'style="background-color:#b92727;border-coloe:#b92727;color#fff"' ?>>
                                                            <?php if ($i == 0) echo '<a href=\'#\' onclick="addField()"><span class="fa fa-trash-o"></span></a>';
                                                            else echo '<a href=\'#\' onclick="removeField(' . $i . ')"><span class="fa fa fa-trash-o" ></span></a>' ?>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                <?php
                                        $i++;
                                    }
                                }
                                ?>


                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-12"><button class="btn btn-info">Simpan</button></div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    var base_url = "<?php echo base_url() . "admin/"; ?>";
    var base_link = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() . "lib/js/form.js"; ?>"></script>