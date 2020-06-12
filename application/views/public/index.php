<!--
      Start Slider
    -->
<?php 
      $mode='non-slider';
      if($mode=='slider'){
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
      }else{
        ?>
<div class="section-landing">
	<div class="home">
		<div class="container landing-container" style="">
			<!--img src="<?= base_url() ."assets/images/campus_tampak_depan.jpg"; ?>" alt="" class='img img-responsive '-->
			<div class="landing-text">
				<h1>Dunia Industri <br>Memanggil Anda</h1>
				<button class="btn btn-primary btn-lg">Apa yang sudah kita mulai</button>
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
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/medical.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Laporan Kesehatan</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/target.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Jurusan</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/check.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>SPM-PT</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/medical.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>PMB Online</div>
										</a>
									</div>
									<div class="mobile-sep"></div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/graduation.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Akademis</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/Click.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Portal Akademis</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/www.png" ?>" alt="Image"
												class='img-shorcut' />
											<div class='text-center'>Berita</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/info.png" ?>" alt="Image"
												class='img-shorcut' />

											<div class='text-center'>Info dan Layanan</div>
										</a>
									</div>

								</div>
								<!--/row-fluid-->
							</div>
							<!--/item-->

							<div class="item">
								<div class="row-fluid">
									<div class="col-8 col-xs-3">
										<a href="#" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/medical.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Laporan Kesehatan</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/target.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Jurusan</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/check.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>SPM-PT</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/medical.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>PMB Online</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/graduation.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Akademis</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/Click.png" ?>"
												alt="Image" class='img-shorcut' />
											<div class='text-center'>Portal Akademis</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/www.png" ?>" alt="Image"
												class='img-shorcut' />
											<div class='text-center'>Berita</div>
										</a>
									</div>
									<div class="col-8 col-xs-3">
										<a href="#x" class="text-center">
											<img src="<?= base_url() ."assets/images/icon/menu/info.png" ?>" alt="Image"
												class='img-shorcut' />

											<div class='text-center'>Info dan Layanan</div>
										</a>
									</div>

								</div>
								<!--/row-fluid-->
							</div>
							<!--/item-->
						</div>
						<!--/carousel-inner-->

						<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span
								class='glyphicon glyphicon-chevron-left'></span></a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next"><span
								class='glyphicon glyphicon-chevron-right'></span></a>
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
		<div class="col-md-4 col-5">
			<div class="text-center">
				<img src="<?= base_url() ."assets/images/icon/prodi/analisis_kimia.png" ?>" alt="" class='icon-jurusan'>
				<br>
				<div class='judul-jurusan'>Analisis Kimia</div>
				<p class='deskripsi-jurusan'>Ilmu Teknik atau rekayasa yang mempelajari pemrosesan bahan alam mentah
					Berupa
					Bahan Nabati Menjadi Produk yang lebih berguna</p>
			</div>
		</div>

		<div class="col-md-4 col-5">
			<div class="text-center">
				<img src="<?= base_url() ."assets/images/icon/prodi/analisis_kimia.png" ?>" alt="" class='icon-jurusan'>
				<br>
				<div class='judul-jurusan'>Analisis Kimia</div>
				<p class='deskripsi-jurusan'>Ilmu Teknik atau rekayasa yang mempelajari pemrosesan bahan alam mentah
					Berupa
					Bahan Nabati Menjadi Produk yang lebih berguna</p>
			</div>
		</div>

		<div class="col-md-4 col-5">
			<div class="text-center col-5">
				<img src="<?= base_url() ."assets/images/icon/prodi/analisis_kimia.png" ?>" alt="" class='icon-jurusan'>
				<br>
				<div class='judul-jurusan'>Analisis Kimia</div>
				<p class='deskripsi-jurusan'>Ilmu Teknik atau rekayasa yang mempelajari pemrosesan bahan alam mentah
					Berupa
					Bahan Nabati Menjadi Produk yang lebih berguna</p>
			</div>
		</div>

		<div class="col-md-4 col-md-offset-2 col-5">
			<div class="text-center">
				<img src="<?= base_url() ."assets/images/icon/prodi/analisis_kimia.png" ?>" alt="" class='icon-jurusan'>
				<br>
				<div class='judul-jurusan'>Analisis Kimia</div>
				<p class='deskripsi-jurusan'>Ilmu Teknik atau rekayasa yang mempelajari pemrosesan bahan alam mentah
					Berupa
					Bahan Nabati Menjadi Produk yang lebih berguna</p>
			</div>
		</div>

		<div class="col-md-4 col-5">
			<div class="text-center">
				<img src="<?= base_url() ."assets/images/icon/prodi/analisis_kimia.png" ?>" alt="" class='icon-jurusan'>
				<br>
				<div class='judul-jurusan'>Analisis Kimia</div>
				<p class='deskripsi-jurusan'>Ilmu Teknik atau rekayasa yang mempelajari pemrosesan bahan alam mentah
					Berupa
					Bahan Nabati Menjadi Produk yang lebih berguna</p>
			</div>
		</div>
	</div>
</div>
<!-- End Prodi  -->

<!-- Pengumuman -->
<div class="section ">
	<div class="container">
		<h2 class='prodi'>Pengumuman</h2>

		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="text-center">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>" alt=""
					class='img img-responsive thumbnail'>

			</div>
			<div class="judul-pengumuman">Lomba Desaign Info Grafis Anti Korupsi</div>
		</div>

		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="text-center">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman2.jpg" ?>" alt=""
					class='img img-responsive thumbnail'>

			</div>
			<div class="judul-pengumuman">Lomba Desaign Info Grafis Anti Korupsi</div>
		</div>
	</div>
</div>
<!-- End Pengumuman  -->
<!-- Berita -->
<div class="section ">
	<div class="container">
		<h2 class='prodi'>Berita Politeknik Ati Padang</h2>
		<div class="col-md-12">
			<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>" alt=""
				class='img img-responsive thumbnail'>
			<div class="judul-pengumuman">Cegah Covid 19 Di Politeknik ATI Padang</div>
		</div>
		<div class="space">&nbsp;</div>
		<div class="col-md-4 col-sm-6 col-xs-6">
			<div class="card">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>" alt="Avatar"
					class='img img-responsive img-rounded' style="width:100%">
				<div class="card-body">
					<div class='tanggal'>20 Sep 2020</div>
					<h4>Jalur Penerimaan Vokasi Industri Kementerian Perindustrian RI (JARVIS)
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 col-xs-6">
			<div class="card">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>"
					class='img img-responsive img-rounded' alt="Avatar" style="width:100%">
				<div class="card-body">
					<div class='tanggal'>20 Sep 2020</div>
					<h4>Jalur Penerimaan Vokasi Industri Kementerian Perindustrian RI (JARVIS)</h4>

				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 col-xs-6">
			<div class="card">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>"
					class='img img-responsive img-rounded' alt="Avatar" style="width:100%">
				<div class="card-body">
					<div class='tanggal'>20 Sep 2020</div>
					<h4>Jalur Penerimaan Vokasi Industri Kementerian Perindustrian RI (JARVIS)</h4>

				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 col-xs-6">
			<div class="card">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>"
					class='img img-responsive img-rounded' alt="Avatar" style="width:100%">
				<div class="card-body">
					<div class='tanggal'>20 Sep 2020</div>
					<h4>Jalur Penerimaan Vokasi Industri Kementerian Perindustrian RI (JARVIS)</h4>

				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 col-xs-6">
			<div class="card">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>"
					class='img img-responsive img-rounded' alt="Avatar" style="width:100%">
				<div class="card-body">
					<div class='tanggal'>20 Sep 2020</div>
					<h4>Jalur Penerimaan Vokasi Industri Kementerian Perindustrian RI (JARVIS)</h4>

				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 col-xs-6">
			<div class="card">
				<img src="<?= base_url() ."assets/images/pengumuman/pengumuman1.jpg" ?>"
					class='img img-responsive img-rounded' alt="Avatar" style="width:100%">
				<div class="card-body">
					<div class='tanggal'>20 Sep 2020</div>
					<h4>Jalur Penerimaan Vokasi Industri Kementerian Perindustrian RI (JARVIS)</h4>

				</div>
			</div>
		</div>


	</div>
</div>
<!-- End Berita  -->
