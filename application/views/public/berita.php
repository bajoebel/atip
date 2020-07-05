<!-- Berita -->
<div class=" section top">
	<div class="text-center">
		<p>Home > <a href="<?= base_url() . "berita" ?>"> <?= $content_tipe ?></a></p>
	</div>
</div>
<div class="section ">
	<div class="container">


		<div class="row">
			<div class="col-md-12">
				<?php
				if (!empty($top)) {
					$thumb = explode(',', $top[0]->content_thumb);
				?>
					<div class="col-md-12 top1">
						<div class="card">
							<img src="<?= base_url() . "uploads/media/thumb/1370X430/_1370X430_" . $thumb[0]; ?>" style="width:100%; max-height:600px">
							<div class="card-body">

								<div class="row">
									<div class="col-md-12">
										<div class='tanggal-headline'><?= longdate($top[0]->content_tglpublish) ?></div>
									</div>
									<div class="col-md-5 col-sm-6 col-xs-6">
										<div class='top-headline-title'><a href="<?= base_url() . $top[0]->content_link ?>" class="link"><?= $top[0]->content_judul ?></a></div>
									</div>
									<div class="col-md-7 col-sm-6 col-xs-6">
										<div class="sub-detail show-desktop">
											<p> <?= strip_tags(substr($top[0]->content_isi, 0, 300)); ?></p>
										</div>
										<div class="sub-detail show-mobile">
											<p> <?= strip_tags(substr($top[0]->content_isi, 0, 170)); ?></p>
										</div>
									</div>
								</div>


							</div>
						</div>
					</div>

				<?php
				}
				?>
				<div id="list-berita" class='list-berita'>
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

	</div>
</div>
<!-- End Berita  -->