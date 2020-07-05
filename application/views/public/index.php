<!--
      Start Slider
    -->
<?php

if ($mode == 'slider') {
?>
	<div class="slideshow-container">
		<?php
		$nav = "";
		$no = 0;
		foreach ($slider as $s) {
			$no++;
			$nav .= '<span class="dot" onclick="currentSlide(' . $no . ')"></span>';
		?>
			<div class="mySlides <?= $s->animasi_transisi ?>">
				<div class="numbertext">1 / 3</div>
				<img src="<?= base_url() . "uploads/media/original/" . $s->gambar_slider; ?>" class='strech'>

				<div class="text">
					<div class="container">
						<div class="landing-text">
							<h2><?= $s->keterangan_slider; ?></h2>
							<a href="<?= base_url() . $s->content_link ?>" class="btn btn-primary btn-lg">Selengkapnya</a>
						</div>
					</div>

				</div>
			</div>
		<?php
		}
		?>

		<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		<a class="next" onclick="plusSlides(1)">&#10095;</a>
		<div style="text-align:center; z-index:1030">
			<?= $nav ?>
		</div>
	</div>
<?php
} else {
?>
	<!--div class="section-landing">
		<div class="home">
			<div class="container landing-container">
				<img src="<?= base_url() . "assets/images/campus_tampak_depan.jpg"; ?>" alt="" class='img img-responsive '>
				<div class="landing-text">
					<h1>Dunia Industri <br>Memanggil Anda</h1>
					<a href='<?= base_url() . "portofolio" ?>' class="btn btn-primary btn-lg">Apa yang sudah kita mulai</a>
				</div>
			</div>
		</div>
	</div-->
	<div class="section-landing">
		<img src="<?= base_url() . "assets/images/campus_tampak_depan_fix.jpg"; ?>" alt="" class='img-fixed-desktop'>
		<img src="<?= base_url() . "assets/images/campus_tampak_depan.jpg"; ?>" alt="" class='img-fixed-mobile'>
		<div class="container landing-container">
			<div class="landing-text">
				<div class='headline-title'>Dunia Industri <br>Memanggil Anda</div>
				<br>
				<a href='<?= base_url() . "portofolio" ?>' class="btn btn-primary blue btn-lg btn-block">Apa yang telah kita mulai  ?</a>
			</div>
		</div>

	</div>
<?php
}
?>

<!--
    End Slider  
    --->

<!-- Shorcut -->
<div class="section">
	<div class="pintasan">
		<div class='show-mobile pintasan-title'>Menu</div>
		<div class="container">
			<div id="myCarousel" class="carousel">

				<!-- Carousel items -->
				<div class="carousel-inner">
					<div class="item active">
						<div class="row-fluid">
							<?php
							$i = 0;
							foreach ($pintasan as $p) {
								$i++;

							?>
								<div class="col-8 col-xs-3 mob-padding10">
									<a href="#x" class="text-center link">
										<img src="<?= base_url() . "uploads/media/thumb/100X100/_100X100_" . $p->pintasan_img ?>" alt="Image" class='img-shorcut' />
										<div class='text-center judul-pintasan'><?= $p->pintasan_nama ?></div>
									</a>
								</div>
							<?php
								if ($i % 4 == 0) echo '<div class="mobile-sep"></div>';
								if ($i % 8 == 0) echo '</div><div class="item">';
							}
							?>
						</div>
					</div>

				</div>
				<!--/carousel-inner-->

				<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class='glyphicon glyphicon-chevron-left'></span></a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next"><span class='glyphicon glyphicon-chevron-right'></span></a>
			</div>
		</div>

		<!--/myCarousel-->
	</div>
</div>
<!-- End Shorcut -->

<!-- Prodi -->
<div class="section ">
	<div class="container">
		<div class='prodi'>Info Program Studi</div>
		<?php
		$jml = count($prodi) + 1;
		$no = 0;
		foreach ($prodi as $p) {
			$no++;
			$jml--;
			$thumb = explode(',', $p->content_thumb);
			if (!empty($thumb)) $image = $thumb[0];
			else $image = $p->content_thumb;
			if ($jml < 3) {
				if ($jml == 2) $offset = "col-md-offset-2";
				else $offset = "";

		?>
				<div class="col-md-4 <?= $offset ?> col-5 ">
					<a href="<?= base_url() . $p->content_link; ?>" class='link'>
						<div class="text-center">
							<img src="<?= base_url() . "uploads/media/thumb/100X100/_100X100_" . $image ?>" alt="" class='icon-jurusan'>
							<div class='judul-jurusan'><?= $p->content_judul; ?></div>
							<p class='deskripsi-jurusan'><?= strip_tags($p->content_isi); ?></p>
						</div>
					</a>
				</div>
			<?php
			} else {
			?>
				<div class="col-md-4 col-5">
					<a href="<?= base_url() . $p->content_link; ?>" class='link'>
						<div class="text-center">
							<img src="<?= base_url() . "uploads/media/thumb/100X100/_100X100_" . $p->content_thumb ?>" alt="" class='icon-jurusan'>
							<br>
							<div class='judul-jurusan'><?= $p->content_judul; ?></div>
							<p class='deskripsi-jurusan'><?= strip_tags($p->content_isi); ?></p>
						</div>
					</a>
				</div>
		<?php
			}
			if ($no % 3 == 0) echo "<div class='desktop-sep'></div>";
		}
		?>

	</div>
</div>
<!-- End Prodi  -->

<!-- Pengumuman -->
<div class="section ">
	<div class="container">
		<h2 class='prodi'>Pengumuman</h2>
		<?php
		foreach ($pengumuman as $p) {
		?>
			<div class="col-md-6 col-sm-6 col-xs-6 mob-padding5">
				<div class="text-center">
					<img src="<?= base_url() . "uploads/media/thumb/620X320/_620X320_" . $p->content_thumb ?>" alt="" class='img img-responsive img-rounded image-content'>

				</div>

				<div class="judul-pengumuman">
					<div class="col-md-7">
						<a href="<?= base_url() . $p->content_link ?>" class='top-link'><?= $p->content_judul; ?></a>
					</div>
				</div>

			</div>
		<?php
		}
		?>
		<div class="row">
			<div class="col-md-12">
				<p class='pull-right lainnya' style="padding: 10px;"><a href="<?= base_url() . "pengumuman" ?>" class="link-bold">Pengumuman Lainnya >></a></p>
			</div>
		</div>
	</div>
</div>
<!-- End Pengumuman  -->
<!-- Berita -->
<div class="section ">
	<div class="container">
		<div class='prodi'>Berita Politeknik ATI Padang</div>
		<?php
		$j = 0;
		foreach ($berita as $b) {
			$j++;
			if ($b->content_thumb != "") $image = base_url() . "uploads/media/thumb/1370X430/_1370X430_" . $b->content_thumb;
			else $image = DEFAULT_IMAGE;
			if ($j == 1) {
		?>
				<div class="col-md-12 show-desktop">
					<div class="topnews">
						<img src="<?= $image ?>" alt="" class='img-top-news img-rounded'>

						<div class='judul-berita'>
							<div class="col-md-6" style="padding-left: 50px;">
								<a href="<?= base_url() . $b->content_link ?>" class='link-top-berita top-link'><?= $b->content_judul ?></a>
								<p class='info-berita'><br>Padang<br><?= longdate($b->content_tglpublish) ?></p>
							</div>

						</div>
					</div>
					<div class="space">&nbsp;</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6 mob-padding5 show-mobile">
					<div class="card">
						<img src="<?= base_url() . "uploads/media/thumb/383X330/_383X330_" . $b->content_thumb ?>" alt="Avatar" class='img img-responsive img-rounded img-thumb-content'>
						<div class="card-body">
							<div class='tanggal'><?= longdate($b->content_tglpublish) ?></div>
							<div class='judul-headline'><a href="<?= base_url() . $b->content_link ?>" class='link'><?= $b->content_judul ?></a></div>
						</div>
					</div>
				</div>
			<?php
			} else {
			?>
				<div class="col-md-4 col-sm-6 col-xs-6 mob-padding5 <?php if ($j > 4) echo 'show-desktop' ?>">
					<div class="card">
						<img src="<?= $image ?>" alt="Avatar" class='img img-responsive img-rounded img-thumb-content'>
						<div class="card-body">
							<div class='tanggal'><?= longdate($b->content_tglpublish) ?></div>
							<div class='judul-headline'><a href="<?= base_url() . $b->content_link ?>" class='link'><?= $b->content_judul ?></a></div>
						</div>
					</div>
				</div>
		<?php
			}
			if ($j % 2 == 0) echo '<div class="mobile-sep"></div>';
			if ($j % 3 == 1) echo '<div class="desktop-sep"></div>';
		}
		?>

		<div class="row">
			<div class="col-md-12">
				<p class='pull-right lainnya' style="padding: 10px;"><a href="<?= base_url() . "berita" ?>" class="link-bold">Berita Lainnya >></a></p>
			</div>
		</div>
	</div>
</div>
<!-- End Berita  -->