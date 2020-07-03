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

<style>
    p{
        font-size:18pt;
    }
</style>
</head>

<body>
    <div class="content">

        <p style="font-family: Helvetica Neu Bold;">Helvetica Neu Bold</p>
        <p style="font-family: HelveticaNeue BlackCond;">HelveticaNeue BlackCond</p>
        <p style="font-family: HelveticaNeue Light;">HelveticaNeue Light</p>
        <p style="font-family: HelveticaNeue Medium;">HelveticaNeue Medium</p>
        <p style="font-family: HelveticaNeue Thin;">HelveticaNeue Thin</p>
        <p style="font-family: HelveticaNeue;">HelveticaNeue</p>
        <p style="font-family: HelveticaNeueBd;">HelveticaNeueBd</p>
        <p style="font-family: HelveticaNeueHv;">HelveticaNeueHv</p>
        <p style="font-family: HelveticaNeueIt;">HelveticaNeueIt</p>
        <p style="font-family: HelveticaNeueLt;">HelveticaNeueLt</p>
        <p style="font-family: HelveticaNeueMed;">HelveticaNeueMed</p>

        <p style="font-family: Cambria;">Cambria</p>
        <p style="font-family: cambriab;">cambriab</p>
        <p style="font-family: CAMBRIAI;">CAMBRIAI</p>
        <p style="font-family: CAMBRIAZ;">CAMBRIAZ</p>
        <p style="font-family: Rubik-Black;">Rubik-Black</p>
        <p style="font-family: Rubik-BlackItalic;">Rubik-BlackItalic</p>
        <p style="font-family: Rubik-Bold;">Rubik-Bold</p>
        <p style="font-family: Rubik-BoldItalic;">Rubik-BoldItalic</p>
        <p style="font-family: Rubik-Italic;">Rubik-Italic</p>
        <p style="font-family: Rubik-Light;">Rubik-Light</p>
        <p style="font-family: Rubik-LightItalic;">Rubik-LightItalic</p>
        <p style="font-family: Rubik-Medium;">Rubik-Medium</p>
        <p style="font-family: Rubik-MediumItalic;">Rubik-MediumItalic</p>
        <p style="font-family: Rubik-Regular;">Rubik-Regular</p>
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
        var base_url = "<?= base_url() ?>";

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