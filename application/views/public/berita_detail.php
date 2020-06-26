<!-- Berita -->
<?php
if (!empty($row)) {
?>
	<div class="section  top100">
		<div class="text-center">
			<h3>Home > <?= $row->content_tipe; ?></h3>
		</div>
	</div>
	<div class="section ">
		<div class="container">

			<div class="col-md-9 col-sm-8">
				<h3><?= $row->content_judul ?></h3>
			</div>
			<div class="col-md-3 col-sm-4">&nbsp;</div>
			<div class="col-md-9 col-sm-8">
				<div class="card">
					<?php
					if (!empty($row->content_thumb) && $row->content_tipe == "Berita") {

					?>
						<img src="<?= base_url() . "uploads/media/thumb/" . $row->content_thumb ?>" alt="" class='img img-responsive ' style='width:100%'>
					<?php
					}
					?>

					<div class="card-body">

						<div class="row">

							<div class="col-md-12">
								<?= $row->content_isi ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class='lampiran'>
									<?php
									foreach ($lampiran as $l) {
										if($l->jenis_lampiran=='Link') $link=$l->isi_lampiran;
										else if($l->jenis_lampiran=="Group") {
											//$media=$this->landing_model->getLinkMedia($l->content_isi);
											$link= base_url() ."files/".$l->isi_lampiran;
										}
										else $link= base_url() . $row->content_link . "/" . $l->link_lampiran;
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
			<div class="col-md-3 col-sm-4">
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
							if ($t->content_thumb != "") $image = base_url() . "uploads/media/icon/" . $t->content_thumb;
							else $image = DEFAULT_IMAGE;
						?>
							<div class="row">
								<div class="col-md-12">
									<div class="info-list">
										<div class="img-list">
											<img src="<?= $image ?>" alt="" class='img img-responsive iconterkait'>
										</div>
										<div class="title-list"><a href="<?= base_url() . $t->content_link; ?>" class="link"><?= $t->content_judul ?></a></div>
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
	<div class="section  top100">
		<div class="text-center">
			<h3>Home > 404</h3>
		</div>
	</div>
	<div class="section ">
		<div class="container">
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