<!-- Berita -->
<style type="text/css">
	.comment {
		position: relative;
		max-width: 100%;
		background-color: #fff;
		padding: 1.125em 1.5em;
		font-size: 1.25em;
		border-radius: 1rem;
		box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, .3), 0 0.0625rem 0.125rem rgba(0, 0, 0, .2);
		margin-bottom: 20px;
	}

	.comment::before {
		content: '';
		position: absolute;
		width: 0;
		height: 0;
		bottom: 100%;
		left: 1.5em;
		border: .75rem solid transparent;
		border-top: none;

		border-bottom-color: #fff;
		filter: drop-shadow(0 -0.0625rem 0.0625rem rgba(0, 0, 0, .1));
	}
</style>
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
										<a href="<?= "https://www.facebook.com/share.php?u=" . base_url() . $row->content_link ?>"><span class='box-share fa fa-facebook'></span></a>
										<a href="<?= "https://twitter.com/intent/tweet?url=" . base_url() . $row->content_link ?>"><span class='box-share fa fa-twitter'></span></a>
											<span class='box-share fa fa-google-plus'></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<label for="komentar" id="label-komentar" class="label-control" <?php if ($row->content_komentar == 1) echo "style='display:block'";
																					else echo "style='display:none'";  ?>>Komentar</label>
					<div id="komentar">
						<input type="hidden" name="idx" id="idx" value="<?= $row->content_id ?>">
					</div>
					<?php
					if ($row->content_komentar == 1) {
					?>
						<form action="#" method="POST" id="form" class="form-horizontal">
							<hr>
							<input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
							<input type="hidden" name="id_post" id="id_post" value="<?= $row->content_id ?>">
							<div class="form-group">
								<div class="col-md-12">
									<label for="Email" class="label-control">Email</label>
									<input type="email" name="email" id="email" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label for="Email" class="label-control">Website</label>
									<input type="text" name="website" id="website" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label for="Nama" class="label-control">Nama</label>
									<input type="nama" name="nama" id="nama" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label for="Nama" class="label-control">Komentar</label>
									<textarea name="komentar" id="isi_komentar" cols="30" rows="10" class="form-control"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<button class="btn btn-primary" type="button" onclick="postKomentar()">Post Komentar</button>
								</div>
							</div>
						</form>
					<?php
					}
					?>

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
							} else $image = DEFAULT_IMAGE;
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