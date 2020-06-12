<!DOCTYPE html>
<html lang="en" class="body-full-height">

<head>
    <!-- META SECTION -->
    <title>Halaman Login ATI Padang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() . "assets/" ?>css/theme-default.css" />
    <!-- EOF CSS INCLUDE -->
</head>

<body>

    <div class="login-container">

        <div class="login-box animated fadeInDown">
            <div class="login-logo"></div>
            <div class="login-body">
                <div class="login-title"><strong>Welcome</strong>, Please login</div>
                <form action="<?php echo base_url() . "index.php/login/cekuser" ?>" class="form-horizontal" method="post">
                    <input type="hidden" id="csrf" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <?php
                    $error = $this->session->flashdata('error');
                    ?>
                    <p class="login-box-msg" style="text-align: center;">

                        <img src="<?php echo base_url() . "assets/images/Logo-Atip.png" ?>" style="width:100px;"><br>
                        <?php
                        if (!empty($error)) {
                            if (is_array($error)) {
                                foreach ($error as $e) {
                                    echo "<div class='alert alert-danger' role='alert'><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span><span class=\"sr-only\">Close</span></button>" . $e . "</div>";
                                }
                            } else echo "<div class='alert alert-danger' role='alert'><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span><span class=\"sr-only\">Close</span></button>" . $error . "</div>";
                        } else echo "<div class='alert alert-success' role='success'>Sign in to start your session</div>"; ?></p>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name='username' id='username' class="form-control" placeholder="Username" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name='userpass' id="userpass" class="form-control" placeholder="Password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                <div class="pull-left">
                    &copy; 2014 AppName
                </div>
                <div class="pull-right">
                    <a href="#">About</a> |
                    <a href="#">Privacy</a> |
                    <a href="#">Contact Us</a>
                </div>
            </div>
        </div>

    </div>

</body>

</html>