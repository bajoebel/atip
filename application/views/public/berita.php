<!-- Berita -->
<div class=" section top">
	<div class="text-center content-tipe">
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
					<div class="col-md-12 top1 show-desktop">
						<div class="card topnews">
							<img src="<?= base_url() . "uploads/media/thumb/" . $thumb[0]; ?>" alt="" class='img img-responsive ' style="width:100%; max-height:600px">
							<div class="card-body">

								<div class="row">
									<div class="col-md-12">
										<div class='tanggal'><?= longdate($top[0]->content_tglpublish) ?></div>
									</div>
									<div class="col-md-5 col-sm-6 col-xs-6">
										<div class='top-headline-title'><a href="<?= base_url() . $top[0]->content_link ?>" class="link"><?= $top[0]->content_judul ?></a></div>
									</div>
									<div class="col-md-7 col-sm-6 col-xs-6">
										<div class="sub-detail">
											<p><?= strip_tags(substr($top[0]->content_isi, 0, 300)); ?></p>
										</div>
									</div>
								</div>


							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-6 show-mobile ">
						<div class="card"><img src="<?= base_url() . "uploads/media/thumb/" . $thumb[0]; ?>" class="img img-responsive img-rounded" alt="Avatar" style="width:100%">
							<div class="card-body">
								<div class="tanggal"><?= longdate($top[0]->content_tglpublish) ?></div>
								<h4><a href="<?= base_url() . $top[0]->content_link ?>" class="link"><?= $top[0]->content_judul ?></a></h4>
							</div>
						</div>
					</div>

				<?php
				}
				?>
				<div id="list-berita" class='list-berita'>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- End Berita  -->