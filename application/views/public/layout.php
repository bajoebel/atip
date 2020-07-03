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
	<div class="content">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<!--button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"-->
					<button type="button" class="navbar-toggle" onclick="otherMenu()">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="" href="<?= base_url() ?>">
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
							<li class=""><a href="<?php if ($m->menu_baseurl == 1) echo base_url() . $m->menu_link;
													else echo $m->menu_link ?>"><?= $m->menu_judul ?></a></li>
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
				<div class="container-footer">
					<div class="row">
						<div class="col-md-12  mob-nopadding">
							<div class="footer-left">
								<div class='font-kampus'>Pendidikan Vokasi Negeri<br><?= _COMPANY_NAME ?></div>
								<p class='font-alamat'>Alamat Kampus : <?= _ALAMAT_ ?></p>
							</div>
							<div class="footer-right">
								<div class="row">
									<div class="kontak mob-nopadding">
										<div class='footer-title'>Kontak Kami</div>
										<div class="footer-content">
											<p><?= _NOTELP_ ?><br>
												<?= _EMAIL_ ?></p>
										</div>
										<p class='row-medsos'>
											<a href="<?= FB ?>" class="link"><span class='box-medsos fa fa-facebook'></span></a>
											<a href="<?= TW ?>" class="link"><span class='box-medsos fa fa-twitter'></span></a>
											<a href="<?= GP ?>" class="link"><span class='box-medsos fa fa-google-plus'></span></a>

										</p>
									</div>
									<div class="archive mob-nopadding">
										<div class='footer-title'>Archive</div>
										<div class="footer-content">

											<p>
												<?php
												$arc = $this->landing_model->getArchive();
												$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
												foreach ($arc as $a) {
												?>
													<a href="<?= base_url() . "archive/" . $a->tahun . "/" . $a->bulan ?>" class="link"><?= $bulan[intval($a->bulan)] . " " . $a->tahun ?></a><br>
												<?php
												}
												?>

										</div>

									</div>
									
									<div class="tautan mob-nopadding">
										<div class='footer-title'>Tautan</div>
										<div class="footer-content">
											<p>
												<?php
												$partner = $this->landing_model->getPartner();
												foreach ($partner as $p) {
												?>
													<a href="<?= $p->partner_link ?>" class='link' target="_blank"><?= $p->partner_nama ?></a><br>
												<?php
												}
												?>
											</p>

										</div>
									</div>

								</div>
								<div class="row">
									<div class="mob-nopadding">

										<p class='copyright show-desktop'>@2020 <?= _COMPANY_NAME ?><br>All Rights Reserved</p>
									</div>
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
					<div class="content">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
				</div>
				<div class="modal-body">
					<div class="content">
						<div id="othermenu"></div>
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
					<div class="content">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
				</div>
				<div class="modal-body">
					<div class="content">
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
		var base_url = "<?= base_url() ?>";

		function otherMenu() {
			$('#modal_menu').modal('show');
			var url = base_url + "welcome/othermenu";
			console.log(url);
			$.ajax({
				url: url,
				type: "GET",
				dataType: "json",
				data: {
					get_param: 'value'
				},
				success: function(data) {
					//menghitung jumlah data
					//console.clear();
					if (data["status"] == true) {
						var row = data["data"];
						var jmlData = row.length;

						var tabel = "";
						//Create Tabel

						var link;
						for (var i = 0; i < jmlData; i++) {

							link = row[i]["menu_link"];
							if (row[i]["menu_baseurl"] == 1) link = base_url + row[i]["menu_link"]
							style = 'col-7';
							tabel += '<div class="col-xs-12  ' + style + '"><a href="' + link + '">' + row[i]["menu_judul"] + '</a></div>';
						}
						console.log(tabel);
						$('#othermenu').html(tabel);

					}
				}
			});
		}

		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
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
	<?php
	if (!empty($lib)) {
	?>
		<script src="<?= base_url() . "assets/js/custome/" . $lib ?>"></script>
	<?php
	}
	?>
</body>

</html>