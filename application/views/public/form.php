<div class="section top">
    <div class="text-center">
        <p>Home > <a href="<?= base_url() . "pengumuman" ?>"><?= $content_tipe; ?></a></p>
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
                        <form class="form-horizontal" id="form" method="POST" action="#">
                            <input type="hidden" name="form_id" id="form_id" value="<?= $form->form_id ?>">
                            <input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
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
                                                <input type="text" class="form-control control datepicker" id="<?= $f->field ?>" name="<?= $f->field ?>" placeholder="<?= $f->alias ?>">
                                            <?php
                                            } elseif ($f->control == "combobox") {
                                            ?>
                                                <select id="<?= $f->field ?>" name="<?= $f->field ?>" placeholder="<?= $f->alias ?>" class="form-control control">
                                                    <?php
                                                    $source = explode(',', $f->source);
                                                    foreach ($source as $s) {
                                                        echo "<option value='" . $s . "' class='control'>" . $s . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            <?php
                                            } elseif ($f->control == "radio") {
                                                $source = explode(',', $f->source);
                                                foreach ($source as $s) {
                                                    echo "<input type='radio' name='" . $f->field . "' id='" . $s . "' value='" . $s . "'>" . $s;
                                                }
                                            } elseif ($f->control == "checkbox") {
                                                $source = explode(',', $f->source);
                                                echo "<input type='checkbox' name='" . $f->field . "' id='" . $f->field . "' value='" . $source[0] . "'>" . $source[0];
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
                            ?>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label col-sm-4" for="">&nbsp;</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-success " type='button' onclick="simpanData()"> Simpan</button>
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
            success: function(data) {
                console.log(data);

                if (data.status == true) var tipe = 'success';
                else var tipe = 'error';
                swal({
                    title: "Sukses",
                    text: data["message"],
                    type: tipe,
                    timer: 5000
                });
                //$("#form").trigger("reset");

                //$('#csrf').val(data["csrf"]);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: "Terjadi Kesalahan ",
                    text: "Gagal Menyimpan Data",
                    type: "error",
                    timer: 5000
                });
            }
        });
    }
</script>