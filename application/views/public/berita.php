<!-- Berita -->
<div class="section  top100">
	<div class="text-center">
		<h3>Home > <?= $content_tipe ?></h3>
	</div>
</div>
<div class="section ">
	<div class="container">
		<h2 class='prodi'>Berita Politeknik Ati Padang</h2>
		<?php
		if (!empty($top)) {
			$thumb = explode(',', $top[0]->content_thumb);
		?>
			<div class="col-md-12">
				<div class="card">
					<img src="<?= base_url() . "uploads/media/thumb/" . $thumb[0]; ?>" alt="" class='img img-responsive ' style='width:100%'>
					<div class="card-body">

						<div class="row">
							<div class="col-md-5 col-sm-6 col-xs-6">
								<div class='tanggal'>20 Sep 2020</div>
								<h3><a href="<?= base_url() . $top[0]->content_link ?>" class="link"><?= $top[0]->content_judul ?></a></h3>
							</div>
							<div class="col-md-7 col-sm-6 col-xs-6">
								<p style="font-size: 14pt;text-align:justify; padding:10px"><?= strip_tags(substr($top[0]->content_isi, 0, 300)); ?></p>
							</div>
						</div>


					</div>
				</div>
			</div>
			
		<?php
		}
		?>
		<div id="list-berita">
		</div>
	</div>
</div>
<!-- End Berita  -->