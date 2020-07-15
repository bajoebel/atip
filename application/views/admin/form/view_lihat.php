<!-- Main content -->
<section class="content">
    <?php if (!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading ui-draggable-handlel">
                    <h3 class="panel-title">
                        Lihat data <?= $row->form_title; ?>
                    </h3>

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="text-right">
                                <select class="form-control" style="width: 40px;" id="limit" name='limit' onchange="getfield(<?= $row->form_id ?>, 0)">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-group">
                                <input type="hidden" name='star' id='star'>
                                <input type="text" name='q' id='q' class="form-control" placeholder='Search' onkeyup="getfield(<?= $row->form_id ?>, 0)">
                                <input type="hidden" name="start" id="start" value="0">
                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div id="data"></div>
                        <div id="paginatioan"></div>
                    </div>
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
<script>
    getfield(<?= $row->form_id ?>, 0);
</script>