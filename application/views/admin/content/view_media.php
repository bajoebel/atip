<div class="col-md-12">
    <?php
    if (!empty($data)) {
    ?>
        <input type="hidden" class='csrf' id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="id_media" id="x-id_media" value="<?= $data->id_media; ?>">
        <input type="hidden" name="id_group" id="x-id_group" value="<?= $data->id_groupmedia; ?>">
        <p align="center">
            <img src="<?= base_url() . "uploads/media/thumb/" . $data->namafile; ?>" class='img img-responsive'>
        </p>
        <input type="hidden" name="keterangan" id="keterangan" value="<?= $data->keterangan; ?>" class='form-control'>
        <input type="hidden" name="namafile" id="namafile" value="<?= $data->namafile ?>">
        <input type="hidden" name="thumb_gambar" id="thumb_gambar" value="<img src='<?= base_url() . "uploads/media/thumb/" . $data->namafile; ?>' class='img img-responsive'>">
        <input type="hidden" name="icon_gambar" id="icon_gambar" value="<img src='<?= base_url() . "uploads/media/icon/" . $data->namafile; ?>' class='img img-responsive'>">
        <input type="hidden" name="original_gambar" id="original_gambar" value="<img src='<?= base_url() . "uploads/media/original/" . $data->namafile; ?>' class='img img-responsive'>">
        <label for=""><p align="center"><?= $data->keterangan; ?></p></label>
        <!--input type="submit" name="simpan"-->
    <?php } ?>
</div>