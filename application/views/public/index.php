<!--
      Start Slider
    -->
<?php

if ($mode == 'slider') {
?>
	<div class="slideshow-container">
		<div class="mySlides animate-zoom">
			<div class="numbertext">1 / 3</div>
			<img src="<?= base_url(); ?>assets/images/img_nature_wide.jpg" class='strech' style="width:100%">
			<div class="text">Caption Text</div>
		</div>

		<div class="mySlides fade">
			<div class="numbertext">2 / 3</div>
			<img src="<?= base_url() ?>assets/images/img_snow_wide.jpg" style="width:100%" class="strech">
			<div class="text">Caption Two</div>
		</div>

		<div class="mySlides animate-bottom">
			<div class="numbertext">3 / 3</div>
			<img src="<?= base_url() ?>assets/images/img_mountains_wide.jpg" style="width:100%" class="strech">
			<div class="text">Caption Three</div>
		</div>

		<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		<a class="next" onclick="plusSlides(1)">&#10095;</a>
		<div style="text-align:center; z-index:1030">
			<span class="dot" onclick="currentSlide(1)"></span>
			<span class="dot" onclick="currentSlide(2)"></span>
			<span class="dot" onclick="currentSlide(3)"></span>
		</div>
	</div>
<?php
} else {
?>
	<div class="section-landing">
		<div class="home">
			<div class="container landing-container">
				<!--img src="<?= base_url() . "assets/images/campus_tampak_depan.jpg"; ?>" alt="" class='img img-responsive '-->
				<div class="landing-text">
					<h1>Dunia Industri <br>Memanggil Anda</h1>
					<a href='<?= base_url() ."portofolio" ?>' class="btn btn-primary btn-lg">Apa yang sudah kita mulai</a>
				</div>
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
<div class="section margin-top-min150">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="">
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
										<div class="col-8 col-xs-3">
											<a href="#x" class="text-center link">
												<img src="<?= base_url() . "uploads/media/thumb/" . $p->pintasan_img ?>" alt="Image" class='img-shorcut' />
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
					<!--/myCarousel-->

				</div>
				<!--/well-->
			</div>
		</div>
	</div>
</div>
<!-- End Shorcut -->

<!-- Prodi -->
<div class="section ">
	<div class="container">
		<h2 class='prodi'>Program Studi</h2>
		<?php
		$jml = count($prodi) + 1;

		foreach ($prodi as $p) {
			$jml--;

			if ($jml < 3) {
				if ($jml == 2) $offset = "col-md-offset-2";
				else $offset = "";
		?>
				<div class="col-md-4 <?= $offset ?> col-5">
					<a href="<?= base_url() . $p->content_link; ?>" class='link'>
						<div class="text-center">
							<img src="<?= base_url() . "uploads/media/thumb/" . $p->content_thumb ?>" alt="" class='icon-jurusan'>
							<br>
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
							<img src="<?= base_url() . "uploads/media/thumb/" . $p->content_thumb ?>" alt="" class='icon-jurusan'>
							<br>
							<div class='judul-jurusan'><?= $p->content_judul; ?></div>
							<p class='deskripsi-jurusan'><?= strip_tags($p->content_isi); ?></p>
						</div>
					</a>
				</div>
		<?php
			}
			//if ($jml % 3 == 0) echo "<div class='row'></div>";
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
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="text-center">
					<img src="<?= base_url() . "uploads/media/thumb/" . $p->content_thumb ?>" alt="" class='img img-responsive thumbnail' style="width:100%; max-height:400px">

				</div>
				<a href="<?= base_url() . $p->content_link ?>" class='link'>
					<div class="judul-pengumuman"><?= $p->content_judul; ?></div>
				</a>
			</div>
		<?php
		}
		?>
	</div>
</div>
<!-- End Pengumuman  -->
<!-- Berita -->
<div class="section ">
	<div class="container">
		<h2 class='prodi'>Berita Politeknik Ati Padang</h2>
		<?php
		$j = 0;
		foreach ($berita as $b) {
			$j++;
			if ($b->content_thumb != "") $image = base_url() . "uploads/media/thumb/" . $b->content_thumb;
			else $image = DEFAULT_IMAGE;
			if ($j == 1) {
		?>
				<div class="col-md-12">
					<img src="<?= $image ?>" alt="" class='img img-responsive thumbnail' style="width:100%">
					<div class="judul-pengumuman"><a href="<?= base_url() . $b->content_link ?>" class='link'><?= $b->content_judul ?></a></div>
				</div>
				<div class="space">&nbsp;</div>
			<?php
			} else {
			?>
				<div class="col-md-4 col-sm-6 col-xs-6">
					<div class="card">
						<img src="<?= $image ?>" alt="Avatar" class='img img-responsive img-rounded' style="width:100%">
						<div class="card-body">
							<div class='tanggal'><?= longdate($b->content_tglpublish) ?></div>
							<h4><a href="<?= base_url() . $b->content_link ?>" class='link'><?= $b->content_judul ?></a></h4>
						</div>
					</div>
				</div>
		<?php
			}
			if ($j % 2 == 1) echo '<div class="mobile-sep"></div>';
			if($j%3==1) echo '<div class="desktop-sep"></div>';
		}
		?>


	</div>
</div>
<!-- End Berita  -->