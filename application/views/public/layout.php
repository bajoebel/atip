<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>ATI Padang</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/home.css" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/custome.css" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/slider.css" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="" href="#">
					<div class="logo"><img src="<?= base_url() . "assets/images/logo.png" ?>" alt="" class='img-logo'>
					</div>
				</a>
				<div class="pull-right search" onfocus="shoeSearchBox()">
					<div class=" task" onclick="showSearchBox()"><i class="fa fa-search" aria-hidden="true"></i></div>
				</div>
			</div>

			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right search-desktop">
					<li class=''>
						<div class=" task" onclick="showSearchBox()" onfocus="showSearchBox()"><i class="fa fa-search" aria-hidden="true"></i></div>
					</li>
					<li class=''>
						<div class=" task"><a href="#" onclick="otherMenu()"><i class="fa fa-bars" aria-hidden="true"></i></a></div>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
					$menu = $this->landing_model->getTopMenu();
					foreach ($menu as $m) {
					?>
						<li class=""><a href="<?php if($m->menu_baseurl==1) echo base_url() .$m->menu_link; else echo $m->menu_link ?>"><?= $m->menu_judul ?></a></li>
					<?php
					}
					?>
				</ul>

			</div>
		</div>
	</nav>
	<div class="search-box">
		<input type="hidden" name="show-search-box" id="show-search-box" value="0">
		<input type="text" class='form-control' name='search' id="search" placeholder="Search">
	</div>
	<?= $content ?>
	<!---footer-->
	<div class="footer">
		<div class="section">
			<div class="container container-footer">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-5 col-sm-5 col-xs-5 mob-nopadding">
							<h1 class='font-kampus'>Pendidikan Vokasi Negeri<br>Politeknik ATI Padang</h1>
							<p class='font-alamat'>Alamat Kampus : Jl Bungo Pasang Tabing<br>Padang 25171</p>
						</div>
						<div class="col-md-7 col-sm-7 col-xs-7 ">
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-4 mob-nopadding">
									<h3 class='footer-title'>Kontak Kami</h3>
									<div class="footer-content">
										<p>0751-000000<br>
											info@poltekatipdg.ac.id</p>
									</div>
									<p class='row-medsos'>
										<span class='box-medsos fa fa-facebook'></span>
										<span class='box-medsos fa fa-twitter'></span>
										<span class='box-medsos fa fa-google-plus'></span>
									</p>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-4 mob-nopadding">
									<h3 class='footer-title'>Archive</h3>
									<div class="footer-content">
										<p>May 2020<br>
											April 2020<br>
											Maret 2020</p>
									</div>

								</div>
								<div class="col-md-3 col-sm-3 col-xs-4 mob-nopadding wedo">
									<h3 class='footer-title'>What We Do</h3>

								</div>
								<div class="col-md-3 col-sm-3 col-xs-4 mob-nopadding">
									<h3 class='footer-title'>Tautan</h3>
									<div class="footer-content">
										<p>jarvis.kemenperin.go.id<br>
											jarvis.kemenperin.go.id<br>
											jarvis.kemenperin.go.id</p>
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-12 mob-nopadding">

									<p>@2020 POliteknik ATI Padang<br>All Rights Reserved</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--
		Modal Menu
	-->

	<!-- Modal -->
	<div id="modal_menu" class="modal" role="dialog">
		<div class="modal-dialog modal-fs">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<nav class="navbar navbar-default">
								<ul class="nav navbar-default navbar-nav">
									<li class="active"><a href="#">Profile</a></li>
									<li><a href="#">SPM-PT</a></li>
									<li><a href="#">Informasi Layanan</a></li>
									<li><a href="#">Informasi Publik</a></li>
									<li><a href="#">Akademik</a></li>
									<li><a href="#">Zona Integrasi</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<!--div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div-->
			</div>

		</div>
	</div>

	<!-- Modal -->
	<div id="modal_cari" class="modal" role="dialog">
		<div class="modal-dialog modal-fs">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="input-group">
								<input type="text" class="input-cari" placeholder="Search" aria-describedby="basic-addon2">
								<span class="input-group-addon" id="basic-addon2">-></span>
							</div>
						</div>
						<!--input type="text" class="input-cari" placeholder="Recipient's username" aria-describedby="basic-addon2"-->
					</div>
				</div>
				<!--div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div-->
			</div>

		</div>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js" crossorigin="anonymous"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			// PAGE IS FULLY LOADED  
			// FADE OUT YOUR OVERLAYING DIV
			//$('#overlay').fadeOut();
		});

		function otherMenu() {
			$('#modal_menu').modal('show');
		}

		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}

		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
			showSlides(slideIndex += n);
		}

		function currentSlide(n) {
			showSlides(slideIndex = n);
		}

		function showSlides(n) {
			var i;
			var slides = document.getElementsByClassName("mySlides");
			var dots = document.getElementsByClassName("dot");
			if (n > slides.length) {
				slideIndex = 1
			}
			if (n < 1) {
				slideIndex = slides.length
			}
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";
			}
			for (i = 0; i < dots.length; i++) {
				dots[i].className = dots[i].className.replace(" active", "");
			}
			slides[slideIndex - 1].style.display = "block";
			dots[slideIndex - 1].className += " active";
		}

		function showSearchBox1() {
			var show = $('#show-search-box').val();
			if (show == 0) {
				$('.search-box').show();
				$('#show-search-box').val("1");
			} else {
				$('.search-box').hide();
				$('#show-search-box').val("0");
			}

		}

		function showSearchBox() {
			$('#modal_cari').modal('show');
		}
	</script>
</body>

</html>