<!-- Berita -->
<div class="section  top">
    <div class="text-center">
        <p>Home > <a href="#"><?= $content_tipe ?></a></p>
    </div>
</div>
<div class="section ">
    <div class="container">
        <input type="hidden" id="bulan" name="bulan" value="<?= $bulan ?>">
        <input type="hidden" id="tahun" name="tahun" value="<?= $tahun ?>">
        <h2 class='prodi'>Berita Politeknik Ati Padang</h2>

        <div id="list-berita">
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="pagination">
                    <div class="col-md-6 col-sm-6 col-xs-6 pull-left">
                        <a href="#" class="link">
                            << Sebelumnya</a> </div> <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                                <a href="#" class="link">Selanjutnya >></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Berita  -->