<div class="col-md-12">
    <?php 
    if(!empty($data)){
        ?>
        <input type="hidden" class='csrf' id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
        <input type="hidden" name="x-id_media" id="x-id_media" value="<?= $data->id_media; ?>">
        <input type="hidden" name="x-idgroup" id="x-idgroup" value="<?= $data->id_groupmedia; ?>">
        <img src="<?= base_url() ."uploads/media/thumb/" .$data->namafile; ?>" class='img img-responsive'>
        <input type="text" name="keterangan" id="keterangan" value="<?= $data->keterangan; ?>" class='form-control'>
        <!--input type="submit" name="simpan"-->
    <?php } ?>
</div>