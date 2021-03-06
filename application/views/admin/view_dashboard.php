<div class="row">
	<div class="col-md-3">
		<div class="col-md-12">
			<div class="widget widget-default widget-item-icon" onclick="location.href='<?= base_url() . "admin/berita"; ?>';">
				<div class="widget-item-left">
					<span class="fa fa-globe"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count"><?= $berita ?></div>
					<div class="widget-title">News</div>
					<div class="widget-subtitle">Berita</div>
				</div>
			</div>

		</div>
		<div class="col-md-12">

			<div class="widget widget-default widget-item-icon" onclick="location.href='<?= base_url() . "admin/halaman"; ?>';">
				<div class="widget-item-left">
					<span class="fa fa-file"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count"><?= $halaman ?></div>
					<div class="widget-title">Pages</div>
					<div class="widget-subtitle">Halaman</div>
				</div>

			</div>

		</div>

		<div class="col-md-12">

			<div class="widget widget-default widget-item-icon" onclick="location.href='<?= base_url() . "admin/pengumuman"; ?>';">
				<div class="widget-item-left">
					<span class="fa fa-bullhorn"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count"><?= $pengumuman ?></div>
					<div class="widget-title">Announcement</div>
					<div class="widget-subtitle">Pengumuman</div>
				</div>
			</div>

		</div>
		<div class="col-md-12">

			<div class="widget widget-default widget-item-icon" onclick="location.href='<?= base_url() . "admin/portofolio"; ?>';">
				<div class="widget-item-left">
					<span class="fa fa-user"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count"><?= $portofolio ?></div>
					<div class="widget-title">Portofolio</div>
					<div class="widget-subtitle">Apa yang sudah kami lakukan ?</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title-box">
					<h3>Statistik</h3>
				</div>
				<ul class="panel-controls" style="margin-top: 2px;">
					<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
					<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a>
							</li>
							<li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="panel-body padding-0">
				<div class="chart-holder" id="dashboard-line-1" style="height: 480px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<marquee behavior="" direction="horizontal">
			<h1>Selamat Datang <?= $this->session->userdata('user_namalengkap') ?></h1>
		</marquee>
	</div>
</div>
<!--div class="row">
	<div class="col-md-3">
		<div class="widget widget-default widget-carousel">
			<div class="owl-carousel" id="owl-example">
				<div>
					<div class="widget-title">Total Visitors</div>
					<div class="widget-subtitle">27/08/2014 15:23</div>
					<div class="widget-int">3,548</div>
				</div>
				<div>
					<div class="widget-title">Returned</div>
					<div class="widget-subtitle">Visitors</div>
					<div class="widget-int">1,695</div>
				</div>
				<div>
					<div class="widget-title">New</div>
					<div class="widget-subtitle">Visitors</div>
					<div class="widget-int">1,977</div>
				</div>
			</div>
			<div class="widget-controls">
				<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
			</div>
		</div>

	</div>
	<div class="col-md-3">
		<div class="widget widget-default widget-item-icon" onclick="location.href='pages-messages.html';">
			<div class="widget-item-left">
				<span class="fa fa-envelope"></span>
			</div>
			<div class="widget-data">
				<div class="widget-int num-count">48</div>
				<div class="widget-title">New messages</div>
				<div class="widget-subtitle">In your mailbox</div>
			</div>
			<div class="widget-controls">
				<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
			</div>
		</div>

	</div>
	<div class="col-md-3">

		<div class="widget widget-default widget-item-icon" onclick="location.href='pages-address-book.html';">
			<div class="widget-item-left">
				<span class="fa fa-user"></span>
			</div>
			<div class="widget-data">
				<div class="widget-int num-count">375</div>
				<div class="widget-title">Registred users</div>
				<div class="widget-subtitle">On your website</div>
			</div>
			<div class="widget-controls">
				<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
			</div>
		</div>

	</div>
	<div class="col-md-3">
		<div class="widget widget-info widget-padding-sm">
			<div class="widget-big-int plugin-clock">00:00</div>
			<div class="widget-subtitle plugin-date">Loading...</div>
			<div class="widget-controls">
				<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
			</div>
			<div class="widget-buttons widget-c3">
				<div class="col">
					<a href="#"><span class="fa fa-clock-o"></span></a>
				</div>
				<div class="col">
					<a href="#"><span class="fa fa-bell"></span></a>
				</div>
				<div class="col">
					<a href="#"><span class="fa fa-calendar"></span></a>
				</div>
			</div>
		</div>

	</div>
</div-->

<!--div class="row">
	<div class="col-md-4">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title-box">
					<h3>Users Activity</h3>
					<span>Users vs returning</span>
				</div>
				<ul class="panel-controls" style="margin-top: 2px;">
					<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
					<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a>
							</li>
							<li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="panel-body padding-0">
				<div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
			</div>
		</div>

	</div>
	<div class="col-md-4">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title-box">
					<h3>Visitors</h3>
					<span>Visitors (last month)</span>
				</div>
				<ul class="panel-controls" style="margin-top: 2px;">
					<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
					<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a>
							</li>
							<li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="panel-body padding-0">
				<div class="chart-holder" id="dashboard-donut-1" style="height: 200px;"></div>
			</div>
		</div>

	</div>

	<div class="col-md-4">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title-box">
					<h3>Projects</h3>
					<span>Projects activity</span>
				</div>
				<ul class="panel-controls" style="margin-top: 2px;">
					<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
					<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a>
							</li>
							<li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="panel-body panel-body-table">

				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="50%">Project</th>
								<th width="20%">Status</th>
								<th width="30%">Activity</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong>Joli Admin</strong></td>
								<td><span class="label label-danger">Developing</span></td>
								<td>
									<div class="progress progress-small progress-striped active">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Gemini</strong></td>
								<td><span class="label label-warning">Updating</span></td>
								<td>
									<div class="progress progress-small progress-striped active">
										<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Taurus</strong></td>
								<td><span class="label label-warning">Updating</span></td>
								<td>
									<div class="progress progress-small progress-striped active">
										<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Leo</strong></td>
								<td><span class="label label-success">Support</span></td>
								<td>
									<div class="progress progress-small progress-striped active">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Virgo</strong></td>
								<td><span class="label label-success">Support</span></td>
								<td>
									<div class="progress progress-small progress-striped active">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
									</div>
								</td>
							</tr>

						</tbody>
					</table>
				</div>

			</div>
		</div>

	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title-box">
					<h3>Sales</h3>
					<span>Sales activity by period you selected</span>
				</div>
				<ul class="panel-controls panel-controls-title">
					<li>
						<div id="reportrange" class="dtrange">
							<span></span><b class="caret"></b>
						</div>
					</li>
					<li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
				</ul>

			</div>
			<div class="panel-body">
				<div class="row stacked">
					<div class="col-md-4">
						<div class="progress-list">
							<div class="pull-left"><strong>In Queue</strong></div>
							<div class="pull-right">75%</div>
							<div class="progress progress-small progress-striped active">
								<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">75%</div>
							</div>
						</div>
						<div class="progress-list">
							<div class="pull-left"><strong>Shipped Products</strong></div>
							<div class="pull-right">450/500</div>
							<div class="progress progress-small progress-striped active">
								<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">90%</div>
							</div>
						</div>
						<div class="progress-list">
							<div class="pull-left"><strong class="text-danger">Returned Products</strong></div>
							<div class="pull-right">25/500</div>
							<div class="progress progress-small progress-striped active">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">5%</div>
							</div>
						</div>
						<div class="progress-list">
							<div class="pull-left"><strong class="text-warning">Progress Today</strong></div>
							<div class="pull-right">75/150</div>
							<div class="progress progress-small progress-striped active">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
							</div>
						</div>
						<p><span class="fa fa-warning"></span> Data update in end of each hour. You can update it manual
							by pressign update button</p>
					</div>
					<div class="col-md-8">
						<div id="dashboard-map-seles" style="width: 100%; height: 200px"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-content">
			<ul class="list-inline item-details">
				<li><a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin
						templates</a></li>
				<li><a href="http://themescloud.org">Bootstrap themes</a></li>
			</ul>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title-box">
					<h3>Sales & Event</h3>
					<span>Event "Purchase Button"</span>
				</div>
				<ul class="panel-controls" style="margin-top: 2px;">
					<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
					<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a>
							</li>
							<li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="panel-body padding-0">
				<div class="chart-holder" id="dashboard-line-1" style="height: 200px;"></div>
			</div>
		</div>
	</div>
</div-->

<div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
<div class="block-full-width">

</div>
<style type="text/css">
	sup {
		vertical-align: super;
		font-size: smaller;
	}

	.fa sup {
		padding: 5px;
		font-size: 24px;
	}

	.tile {
		border-radius: 10px;
	}
</style>
<script>
	$(function() {

		/* Line dashboard chart */
		Morris.Line({
			element: 'dashboard-line-1',
			data: [
				<?php
				foreach ($hits as $h) {
					$tgl = explode('-', $h->tanggal);
					////$bulan=array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des');
					echo "{
					y: '" . $h->tanggal . "',
					a: " . $h->hits . "
				},";
				}
				?>
			],
			xkey: 'y',
			ykeys: ['a'],
			labels: ['Hits'],
			resize: true,
			hideHover: true,
			xLabels: 'day',
			gridTextSize: '10px',
			lineColors: ['#1E51A4'],
			gridLineColor: '#E5E5E5'
		});


	});
</script>
<!--div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend>Content</legend>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/content/halaman"
							?>" class="tile tile-success">
                    <span class="fa fa-file-o"><sup>3</sup></span>
                    <p><b>Halaman</b></p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/content/artikel"
							?>" class="tile tile-success">
                    <span class="fa fa-file-o"><sup>3</sup></span>
                    <p><b>Artikel</b></p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/content/program-studi"
							?>" class="tile tile-success">
                    <span class="fa fa-file-o"><sup>3</sup></span>
                    <p><b>Program Studi</b></p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/content/pengumuman"
							?>" class="tile tile-success">
                    <span class="fa fa-file-o"><sup>3</sup></span>
                    <p><b>Pengumuman</b></p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="<?= base_url() . "admin/kategori"
							?>" class="tile tile-default">
                    <span class="fa fa-folder-open-o"><sup>3</sup></span>
                    <p><b>Kategori</b></p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/komentar"
							?>" class="tile tile-danger">
                    <span class="fa fa fa-comments-o"><sup>3</sup></span>
                    <p><b>Komentar</b></p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/faq"
							?>" class="tile tile-info">
                    <span class="fa fa-info"><sup>3</sup></span>
                    <p><b>Faq</b></p>
                </a>
            </div>
        </fieldset>
        <fieldset>
            <legend>Media</legend>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/slider"
							?>" class="tile tile-default">
                    <span class="fa fa-folder-open-o"><sup>3</sup></span>
                    <p><b>Kategori</b></p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/banner"
							?>" class="tile tile-danger">
                    <span class="fa fa fa-comments-o"><sup>3</sup></span>
                    <p><b>Komentar</b></p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url() . "admin/partner"
							?>" class="tile tile-info">
                    <span class="fa fa-info"><sup>3</sup></span>
                    <p><b>Faq</b></p>
                </a>
            </div>
        </fieldset>
    </div>
    <div class="col-md-6">

    </div>
</div-->