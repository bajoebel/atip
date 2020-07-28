<style type="text/css">

</style>
<div id="loading">
    <div class="loader"></div>
</div>
<div class="section top">
    <div class="text-center">
        <p>Home > <a href="#"><?= $content_tipe; ?></a>
        </p>
    </div>
</div>
<div class="section ">

    <div class="container">
        <?php
        if (!empty($form)) {
            $field = json_decode($form->form_field);
        ?>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3><?= $form->form_title ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $err = $this->session->flashdata('error');
                        if (!empty($err)) {
                            if (is_array($err)) {
                                //$error = $err;
                                foreach ($err as $e) {
                        ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                <strong>Info!</strong> <?= $e; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <strong>Info!</strong> <?= $err; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        }

                        $info = $this->session->flashdata('success');
                        if (!empty($info)) {
                            if (is_array($info)) {
                                $error = $info;
                            } else {
                            ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <strong>Info!</strong> <?= $info; ?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }

                        ?>
                        <form class="form-horizontal" id="form" method="POST" action="#">
                            <input type="hidden" name="form_id" id="form_id" value="<?= $form->form_id ?>">
                            <input type="hidden" id="csrf" class='form-control' name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <?php
                            foreach ($field as $f) {
                                //print_r($f);
                            ?>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-sm-4" for="<?= $f->alias ?>"><?= $f->alias ?>:</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="field[]" id="field_<?= $f->field ?>" value="<?= $f->field; ?>">
                                            <input type="hidden" name="control_<?= $f->field ?>" id="control_<?= $f->field ?>" value="<?= $f->control; ?>">
                                            <input type="hidden" name="source_<?= $f->field ?>" id="source_<?= $f->field ?>" value="<?= $f->source; ?>">
                                            <?php
                                            if ($f->control == "datepicker") {
                                            ?>
                                                <input type="text" class="form-control datepicker" id="<?= $f->field ?>" name="<?= $f->field ?>" placeholder="<?= $f->alias ?>">
                                            <?php
                                            } elseif ($f->control == "combobox") {
                                            ?>
                                                <select id="<?= $f->field ?>" name="<?= $f->field ?>" placeholder="<?= $f->alias ?>" class="form-control control">
                                                    <?php
                                                    $source = explode(',', $f->source);
                                                    if (count($source) > 1) {
                                                        foreach ($source as $s) {
                                                            echo "<option value='" . $s . "' class='control'>" . $s . "</option>";
                                                        }
                                                    } else {
                                                        $isi = $this->landing_model->getIsi($source[0]);
                                                        $form_field = json_decode($isi[0]->form_field);
                                                        $nama_field = $form_field[0]->field;
                                                        foreach ($isi as $s) {
                                                            $row_isi = json_decode($s->isi_baris);
                                                    ?>
                                                            <option value="<?php echo $row_isi->$nama_field ?>"><?php echo $row_isi->$nama_field ?></option>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                                <?php //echo count($source);print_r($row_isi);
                                                ?>
                                            <?php
                                            } elseif ($f->control == "Radio") {
                                                $source = explode(',', $f->source);
                                                foreach ($source as $s) {
                                                    echo "<input type='radio' name='" . $f->field . "' id='" . $s . "' value='" . $s . "'>" . $s;
                                                }
                                            } elseif ($f->control == "checkbox") {
                                                $source = explode(',', $f->source);
                                                echo "<input type='checkbox' name='" . $f->field . "' id='" . $f->field . "' value='" . $source[0] . "'>" . $source[0];
                                            } elseif ($f->control == "textarea") {
                                                echo "<textarea class='form-control' name='" . $f->field . "' id='" . $f->field . "' placeholder='" . $f->field . "'></textarea>";
                                            } else {
                                            ?>
                                                <input type="text" class="form-control" id="<?= $f->field ?>" name="<?= $f->field ?>" placeholder="<?= $f->alias ?>">
                                            <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <?php

                            }

                            if ($form->form_lampiran != "") {
                                $lampiran = explode(',', $form->form_lampiran);
                                foreach ($lampiran as $l) {
                                ?>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="Lampiran" class="control-label col-md-4"><?= $l ?></label>
                                            <div class="col-sm-8">
                                                <input type="file" name="userfile[]" id="userfile[]" class="form-control ">
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>
                            <input type="hidden" id="form_lampiran" name="form_lampiran" value="<?= $form->form_lampiran ?>">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label col-sm-4" for="">&nbsp;</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-success " id="simpan" type='button' onclick="simpanData()"> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">

                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    var base_url = "<?= base_url(0) ?>";

    function simpanData() {
        var url;
        url = base_url + "welcome/simpandata";
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            beforeSend: function() {
                // setting a timeout
                $('#loading').show();
                $("#simpan").prop("disabled", true);
            },
            success: function(data) {
                console.log(data);
                if (data.status == true) {
                    var tipe = 'success';
                    $('#form')[0].reset();
                    $('#csrf').val(data["csrf"]);

                    swal({
                        title: "Sukses",
                        text: data["message"],
                        type: tipe,
                        timer: 5000
                    });
                    //location.reload();
                } else {
                    var tipe = 'error';
                    swal({
                        title: "Sukses",
                        text: data["message"],
                        type: tipe,
                        timer: 5000
                    });
                    $('#csrf').val(data["csrf"]);
                }

                //$("#form").trigger("reset");

                //$('#csrf').val(data["csrf"]);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: "Terjadi Kesalahan ",
                    text: "Gagal Menyimpan Data",
                    type: "error",
                    timer: 5000
                });
            },
            complete: function() {
                $('#loading').hide();
                $("#simpan").prop("disabled", false);
            },
        });
    }
</script>