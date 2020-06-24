<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META SECTION -->
    <title>Halaman Administartor ATI Padang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <!--script src="<?php //echo base_url() . "assets/" 
                    ?>swal/sweetalert.js"></script>
    <link rel="stylesheet" href="<?php //echo base_url() . "assets/" 
                                    ?>swal/sweetalert.css"-->
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() . "assets/"; ?>css/theme-default.css" />
    <!-- EOF CSS INCLUDE -->

    <!--FRAMEWORK VUE.JS -->
    <!--script src="<?php echo base_url() ?>assets/js/vue.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/axios.min.js"></script-->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url() . "assets/" ?>swal/sweetalert.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() . "assets/" ?>swal/sweetalert.css">
    <script type="text/javascript" src="<?php echo base_url() . "assets/" ?>js/plugins/dropzone/dropzone.min.js"></script>
    <style type="text/css">
        div.tagsinput span.tag {
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            display: block;
            float: left;
            text-decoration: none;
            background: #33a829;
            color: #FFF;
            margin: 2px 0px 2px 2px;
            line-height: 20px;
            padding: 2px 5px 2px 20px;
            position: relative;
        }
    </style>
    <!--EOF FRAMEWORK VUE.JS-->
</head>

<body>
    <!-- START PAGE CONTAINER -->
    <div class="page-container">

        <!-- START PAGE SIDEBAR -->
        <div class="page-sidebar">
            <!-- START X-NAVIGATION -->
            <ul class="x-navigation ">
                <li class="xn-logo">
                    <a href="<?= base_url() ?>">ATI PDG</a>
                    <a href="#" class="x-navigation-control"></a>
                </li>
                <li class="xn-profile">
                    <a href="#" class="profile-mini">
                        <img src="<?= base_url() . "assets/"; ?>images/Logo-Atip.png" alt="John Doe" />
                    </a>
                    <div class="profile">
                        <div class="profile-image">
                            <img src="<?= base_url() . "assets/"; ?>images/Logo-Atip.png" alt="John Doe" />
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name">Administtrator</div>
                            <div class="profile-data-title">ATI Padang</div>
                        </div>
                        <div class="profile-controls">
                            <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                            <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                        </div>
                    </div>
                </li>
                <?php
                $role = $this->session->userdata('level');
                $q = "";
                $menu = $this->auth_model->getMenu($role, $q);
                $link = $this->uri->segment(2);
                $buka = $this->auth_model->indukaktif($link);
                $data = array(
                    'menu_data' => $menu,
                    'link'  => $link,
                    'buka'  => $buka,
                    'jmlData'  => 20
                );
                $this->load->view('template/admin/menu', $data);

                ?>
            </ul>
            <!-- END X-NAVIGATION -->
        </div>
        <!-- END PAGE SIDEBAR -->

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                <!-- TOGGLE NAVIGATION -->
                <li class="xn-icon-button">
                    <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                </li>
                <!-- END TOGGLE NAVIGATION -->
                <!-- SEARCH -->
                <li class="xn-search">
                    <form role="form">
                        <input type="text" name="search" id="cari" placeholder="Search..." />
                    </form>
                </li>
                <!-- END SEARCH -->
                <!-- SIGN OUT -->
                <li class="xn-icon-button pull-right">
                    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                </li>
                <!-- END SIGN OUT -->
                <!-- MESSAGES -->
                <li class="xn-icon-button pull-right">
                    <a href="#"><span class="fa fa-comments"></span></a>
                    <div class="informer informer-danger">4</div>
                    <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>
                            <div class="pull-right">
                                <span class="label label-danger">4 new</span>
                            </div>
                        </div>
                        <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                            <a href="#" class="list-group-item">
                                <div class="list-group-status status-online"></div>
                                <img src="<?= base_url() . "assets/"; ?>assets/images/users/user2.jpg" class="pull-left" alt="John Doe" />
                                <span class="contacts-title">John Doe</span>
                                <p>Praesent placerat tellus id augue condimentum</p>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="list-group-status status-away"></div>
                                <img src="<?= base_url() . "assets/"; ?>assets/images/users/user.jpg" class="pull-left" alt="Dmitry Ivaniuk" />
                                <span class="contacts-title">Dmitry Ivaniuk</span>
                                <p>Donec risus sapien, sagittis et magna quis</p>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="list-group-status status-away"></div>
                                <img src="<?= base_url() . "assets/"; ?>assets/images/users/user3.jpg" class="pull-left" alt="Nadia Ali" />
                                <span class="contacts-title">Nadia Ali</span>
                                <p>Mauris vel eros ut nunc rhoncus cursus sed</p>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="list-group-status status-offline"></div>
                                <img src="<?= base_url() . "assets/"; ?>assets/images/users/user6.jpg" class="pull-left" alt="Darth Vader" />
                                <span class="contacts-title">Darth Vader</span>
                                <p>I want my money back!</p>
                            </a>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="pages-messages.html">Show all messages</a>
                        </div>
                    </div>
                </li>
                <!-- END MESSAGES -->
                <!-- TASKS -->
                <li class="xn-icon-button pull-right">
                    <a href="#"><span class="fa fa-tasks"></span></a>
                    <div class="informer informer-warning">3</div>
                    <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-tasks"></span> Tasks</h3>
                            <div class="pull-right">
                                <span class="label label-warning">3 active</span>
                            </div>
                        </div>
                        <div class="panel-body list-group scroll" style="height: 200px;">
                            <a class="list-group-item" href="#">
                                <strong>Phasellus augue arcu, elementum</strong>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                                </div>
                                <small class="text-muted">John Doe, 25 Sep 2014 / 50%</small>
                            </a>
                            <a class="list-group-item" href="#">
                                <strong>Aenean ac cursus</strong>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
                                </div>
                                <small class="text-muted">Dmitry Ivaniuk, 24 Sep 2014 / 80%</small>
                            </a>
                            <a class="list-group-item" href="#">
                                <strong>Lorem ipsum dolor</strong>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">95%</div>
                                </div>
                                <small class="text-muted">John Doe, 23 Sep 2014 / 95%</small>
                            </a>
                            <a class="list-group-item" href="#">
                                <strong>Cras suscipit ac quam at tincidunt.</strong>
                                <div class="progress progress-small">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                </div>
                                <small class="text-muted">John Doe, 21 Sep 2014 /</small><small class="text-success"> Done</small>
                            </a>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="pages-tasks.html">Show all tasks</a>
                        </div>
                    </div>
                </li>
                <!-- END TASKS -->
            </ul>
            <!-- END X-NAVIGATION VERTICAL -->

            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
                <li><a href="#">Admin</a></li>
                <li class="active"><?= $modul; ?></li>
            </ul>
            <!-- END BREADCRUMB -->

            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">
                <?php if (!empty($content)) echo $content; ?>

            </div>
            <!-- END PAGE CONTENT WRAPPER -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->

    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                <div class="mb-content">
                    <p>Are you sure you want to log out?</p>
                    <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                        <button class="btn btn-default btn-lg mb-control-close">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MESSAGE BOX-->

    <!-- START PRELOADS -->
    <audio id="audio-alert" src="<?= base_url() . "assets/"; ?>audio/alert.mp3" preload="auto"></audio>
    <audio id="audio-fail" src="<?= base_url() . "assets/"; ?>audio/fail.mp3" preload="auto"></audio>
    <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
    <!-- START PLUGINS -->
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/bootstrap/bootstrap.min.js"></script>
    <!-- END PLUGINS -->

    <!-- START THIS PAGE PLUGINS-->
    <script type='text/javascript' src='<?= base_url() . "assets/"; ?>js/plugins/icheck/icheck.min.js'></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/scrolltotop/scrolltopcontrol.js"></script>

    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/morris/raphael-min.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/morris/morris.min.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/rickshaw/d3.v3.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/rickshaw/rickshaw.min.js"></script>
    <script type='text/javascript' src='<?= base_url() . "assets/"; ?>js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
    <script type='text/javascript' src='<?= base_url() . "assets/"; ?>js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>
    <script type='text/javascript' src='<?= base_url() . "assets/"; ?>js/plugins/bootstrap/bootstrap-datepicker.js'></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/owl/owl.carousel.min.js"></script>

    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/moment.min.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/plugins/summernote/summernote.js"></script>
    <!-- END THIS PAGE PLUGINS-->

    <!-- START TEMPLATE -->
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/settings.js"></script>

    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins.js"></script>
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/actions.js"></script>

    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/demo_dashboard.js"></script>
    <!-- END TEMPLATE -->
    <script type="text/javascript" src="<?= base_url() . "assets/"; ?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

    <!-- START PROSES -->
    <?php if (!empty($libjs)) { ?>
        <script Type="text/javascript">
            var base_url = "<?= base_url() ?>";
        </script>;
        <script type="text/javascript" src="<?= base_url() . "lib/js/" . $libjs; ?>"></script>
    <?php } ?>
    <?php $link = $this->uri->segment(2); ?>
    <script type="text/javascript">
        /*$(document).ready(function() {
            $('#summernote').summernote({
                height: "300px",
                callbacks: {
                    onImageUpload: function(image) {
                        uploadImage(image[0]);
                    },
                    onMediaDelete: function(target) {
                        deleteImage(target[0].src);
                    }
                }
            });

            function uploadImage(image) {
                var data = new FormData();
                data.append("image", image);
                $.ajax({
                    url: "<?php echo site_url('admin/content/upload_image') ?>",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: "POST",
                    success: function(url) {
                        $('#summernote').summernote("insertImage", url);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            function deleteImage(src) {
                $.ajax({
                    data: {
                        src: src
                    },
                    type: "POST",
                    url: "<?php echo site_url('admin/content/delete_image') ?>",
                    cache: false,
                    success: function(response) {
                        console.log(response);
                    }
                });
            }

        });*/

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?php echo site_url('post/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#summernote').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: "<?php echo site_url('post/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }
        //menu('<?php //echo $this->auth_model->indukaktif($link); ?>', '<?php //echo $link ?>');

        function menu1(buka, link) {
            var cari = $('#cari').val();
            var url = "<?php echo base_url(); ?>" + "admin/home/menu?q=" + cari;
            console.log(url);
            //alert(cari);
            $.ajax({
                url: "<?php echo base_url(); ?>" + "admin/home/menu?q=" + cari,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    var jmlData = data.length;
                    var menu = '<li class="xn-title">Navigation</li>';
                    menu += '<li>'
                    menu += '<a href="<?php echo base_url() . "home"; ?>">';
                    menu += '<i class="fa fa-home"></i> <span>Home</span>';
                    menu += '<span class="pull-right-container">';
                    menu += '<small class="label pull-right bg-orange">new</small>';
                    menu += '</span>';
                    menu += '</a>';
                    menu += '</li>';
                    var induk = "";
                    var open = "";
                    var link1 = "";
                    //console.log(data[0]["induk_nama"]);
                    for (var i = 0; i < jmlData; i++) {
                        //alert(i);
                        //console.log("MENU INDUK : "+data[i]["induk_nama"]);
                        //alert(data[i]["induk_id"]);
                        if (buka == data[i]["induk_id"]) open = 'active';
                        else open = "";
                        if (link == data[i]["link"]) link1 = 'active';
                        else link1 = '';
                        if (i == 0) {
                            menu += "<li class=\"xn-openable " + open + "\">";
                            menu += "<a href=\"#\"><i class=\"" + data[i]["induk_icon"] + "\"></i>" + data[i]["induk_nama"] + "</a>";
                            menu += "<ul>";
                            menu += "<li class='" + link + "'><a href=\"" + data[i]["link"] + "\"><span class=\"fa fa-circle-o\"></span>" + data[i]["nama_modul"] + "</a></li>";
                            induk = data[i]["induk_nama"];
                        } else {
                            if (induk == data[i]["induk_nama"]) {
                                if (i - 1 == jmlData) {
                                    menu += "<li ><a href=\"<?php echo base_url(); ?>" + data[i]["link"] + "\"><span class=\"fa fa-circle-o\"></span>" + data[i]["nama_modul"] + "</a></li>";
                                    menu += "</ul></li>";

                                } else {
                                    menu += "<li ><a href=\"<?php echo base_url(); ?>" + data[i]["link"] + "\"><span class=\"fa fa-circle-o\"></span>" + data[i]["nama_modul"] + "</a></li>";
                                    //alert("INDUK LAMA "+induk+" INDUK : "+data[i]["induk_nama"]+" ANAK NAMA: "+data[i]["nama_modul"]);
                                }
                                induk = data[i]["induk_nama"];
                            } else {
                                //alert("BEDA INDUK LAMA "+induk+" INDUK : "+data[i]["induk_nama"]+" ANAK NAMA: "+data[i]["nama_modul"]);
                                menu += "</ul></li>";
                                if (i - 1 == jmlData) {

                                    menu += "<li class=\"treeview\">";
                                    menu += "<a href=\"#\"><i class=\"" + data[i]["induk_icon"] + "\"></i>" + data[i]["induk_nama"] + "</a>";
                                    menu += "<ul class=\"treeview-menu " + open + "\">'";
                                    menu += "<li ><a href=\"<?php echo base_url(); ?>" + data[i]["link"] + "\"><span class=\"fa fa-circle-o\"></span>" + data[i]["nama_modul"] + "</a></li>";

                                } else {
                                    menu += "<li class=\"treeview " + open + "\">";
                                    menu += "<a href=\"#\"><i class=\"" + data[i]["induk_icon"] + "\"></i>" + data[i]["induk_nama"] + "</a>";
                                    menu += "<ul >'";
                                    menu += "<li ><a href=\"<?php echo base_url(); ?>" + data[i]["link"] + "\"><span class=\"fa fa-circle-o\"></span>" + data[i]["nama_modul"] + "</a></li>";
                                    induk = data[i]["induk_nama"];
                                }


                            }

                        }
                    }
                    console.log(menu);
                    $('#menu').html(menu);
                    //console.clear();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Error",
                        text: "Terjadi Kesalahan Saat Pengambilan data",
                        type: "error",
                        timer: 5000
                    });
                }
            });
            //console.clear();
            console.log("cari");
        }

        function menu(buka, link) {
            var cari = $('#cari').val();
            var url = "<?php echo base_url(); ?>" + "admin/home/menu_html?q=" + cari + "&buka=" + buka + "&link=" + link;
            console.log(url);
            //alert(cari);
            $.ajax({
                url: "<?php echo base_url(); ?>" + "admin/home/menu_html?q=" + cari + "&buka=" + buka + "&link=" + link,
                type: "GET",
                dataType: "HTML",
                success: function(data) {

                    console.log(data);
                    $('#menu').html(data);
                    //console.clear();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Error",
                        text: "Terjadi Kesalahan Saat Pengambilan data",
                        type: "error",
                        timer: 5000
                    });
                }
            });
            //console.clear();
            console.log("cari");
        }

        function gantiPassword() {
            $('#form')[0].reset();
            $('#modal_password').modal('show');
            $('.modal-title').text('Ganti Password');
        }

        function ubahPassword() {
            var url;
            url = "<?= base_url(); ?>" + "home/ubahpassword";
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(data) {
                    //console.clear();
                    console.log(data);
                    if (data["status"] == true) {
                        $('#modal_password').modal('hide');
                        $('.csrf').val(data["csrf"]);
                        var start = $('#start').val();
                        swal({
                            title: "Sukses",
                            text: data["message"],
                            type: "success",
                            timer: 5000
                        });
                    } else {
                        $('#csrf').val(data["csrf"]);
                        swal({
                            title: "Peringatan",
                            text: data["message"],
                            type: "warning",
                            timer: 5000
                        });
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Terjadi Kesalahan ",
                        text: "Gagal Menyimpan Data",
                        type: "error",
                        timer: 5000
                    });
                }
            });
        }
    </script>
    <!-- END PROSES -->
    <!-- END SCRIPTS -->
    
</body>

</html>