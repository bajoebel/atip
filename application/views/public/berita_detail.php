<!-- Berita -->
<?php
if (!empty($row)) {
?>
	<div class="section top">
		<div class="text-center">
			<p>Home > <a><?= $row->content_tipe; ?></a></p>
		</div>
	</div>
	<div class="section ">
		<div class="container detail-berita">

			<div class="col-md-6 col-sm-8">
				<div class="judul-content"><?= $row->content_judul ?></div>
			</div>
			<div class="col-md-6 col-sm-4">&nbsp;</div>
			<div class="content-left">
				<div class="card">
					

					<div class="card-body">

						<div class="row">
							<div class="col-md-12">
								<div class="content-detail">
									<?= $row->content_isi ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class='lampiran'>
									<?php
									foreach ($lampiran as $l) {
										if ($l->jenis_lampiran == 'Link') $link = $l->isi_lampiran;
										else if ($l->jenis_lampiran == "Group") {
											//$media=$this->landing_model->getLinkMedia($l->content_isi);
											$link = base_url() . "files/" . $l->isi_lampiran;
										} else $link = base_url() . $row->content_link . "/" . $l->link_lampiran;
									?>
										<p><a href="<?= $link ?>" class="link"><?= $l->judul_lampiran ?> <span class='fa fa-play'></span> </a></p>
									<?php
									}
									?>
								</div>

							</div>
						</div>

					</div>
					<div class="card-footer">
						<div class="share">
							<div class="row">
								<div class="col-md-12">
									<div class='float-left'>Bagikan :</div>
									<div class='float-right'>
										<span class='box-share fa fa-facebook'></span>
										<span class='box-share fa fa-twitter'></span>
										<span class='box-share fa fa-google-plus'></span>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="content-right">
				<div class="widget">
					<div class="widget-header">
						Published
					</div>
					<div class="widget-body">

						<?= getHari($row->content_tglpublish) . ", " . longdate($row->content_tglpublish) ?>

					</div>
				</div>

				<div class="widget">
					<div class="widget-header">
						Author
				</div>
					<div class="widget-body">
						<?= $row->nama_lengkap; ?>
					</div>
				</div>
				<div class="widget">
					<div class="widget-header">
						Tag
					</div>
					<div class="widget-body">
						<?php
						if (!empty($row->content_tag)) {
							$content_tag = explode(',', $row->content_tag);
							foreach ($content_tag as $t) {
								echo ' <span class="btn btn-success btn-sm btn-radius">' . $t . '</span>';
							}
						}
						?>
					</div>
				</div>
				<div class="widget-info">
					<div class="widget-header">
						Informasi Terkait
					</div>
					<div class="widget-body">
						<?php
						foreach ($terkait as $t) {
							
							if ($t->content_thumb != "") {
								$img = explode(',', $t->content_thumb);
								$image = base_url() . "uploads/media/thumb/100X100/_100X100_" . $img[0];
							}
							else $image = DEFAULT_IMAGE;
						?>
							<div class="row widget-list">
								<div class="col-md-12">
									<div class="info-list">
										<div class="img-list">
											<img src="<?= $image ?>" alt="" class='img img-responsive iconterkait'>
										</div>
										<div class="title-list">
											<div class="content-link">
												<a href="<?= base_url() . $t->content_link; ?>" class="link"><?= $t->content_judul ?></a>
											</div>

										</div>
									</div>
								</div>
							</div>
						<?php
						}
						?>

					</div>
				</div>
			</div>





		</div>
	</div>
<?php
} else {
?>
	<div class="section  top">
		<div class="text-center">
			<p>Home > 404</p>
		</div>
	</div>
	<div class="section ">
		<div class="container detail-berita">

			<div class='error'>
				<h3 class='text-center'>Opss...!</h3>
				<h1 class='text-center' style="font-size: 800%;font-weight:bold;">404</h1>
				<p class='text-center'>Halaman Yang anda Cari tidak ditemukan</p>
			</div>
		</div>
	</div>
<?php
}
?>
<!-- End Berita  -->