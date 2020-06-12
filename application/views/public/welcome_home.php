<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ATI Padang</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/home.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/slider.css" crossorigin="anonymous">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	
    <div class="row-no-gutters" id="kontent">
      <div class="container">
        <div class="lengkungbiru">
          <div class="logo-header">
            <img src="assets/images/Logo-Atip.png" class="logodepan">
            
            <div class="content">
              <!-- SLIDER -->
              <div class="row section">
                <div class="col-md-12">
                  <div class="header"><b>Informasi Terbaru</b></div>
                  <div class="slideshow-container">

                    <div class="mySlides fade">
                      <div class="numbertext">1 / 3</div>
                      <img src="<?= base_url() ?>assets/images/poli_depan.jpg" style="width:100%" class="img strech img-responsive img-rounded">
                      <div class="text">
                        <span class="judul-slider">Cegah Covid 19 DI Pliteknik ATI Padang</span><br>
                        <span class="tanggal-slider">Padang 4 April 2020</span>
                      </div>
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">2 / 3</div>
                      <img src="<?= base_url() ?>assets/images/atip-campus.jpg" style="width:100%" class="img strech img-responsive img-rounded">
                      <div class="text">
                        <span class="judul-slider">Cegah Covid 19 DI Pliteknik ATI Padang</span><br>
                        <span class="tanggal-slider">Padang 4 April 2020</span>
                      </div>
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">3 / 3</div>
                      <img src="<?= base_url() ?>assets/images/POLTEKATIP.jpg" style="width:100%" class="img strech img-responsive img-rounded">
                      <div class="text">
                        <span class="judul-slider">Cegah Covid 19 DI Pliteknik ATI Padang</span><br>
                        <span class="tanggal-slider">Padang 4 April 2020</span>
                      </div>
                    </div>

                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>

                  </div>
                  <div style="text-align:center">
                      <span class="dot" onclick="currentSlide(1)"></span> 
                      <span class="dot" onclick="currentSlide(2)"></span> 
                      <span class="dot" onclick="currentSlide(3)"></span> 
                  </div>
                </div>
              </div>
              <!-- END SLIDER-->
              <!-- INFO TERBARU -->
              <div class="row section">
                <div class="col-md-12">
                  <div class="header"><b>Menu</b></div>
                  <div class="center" >
                    <div class="col-md-12">
                      <div class="col-xs-3">
                        <div class="shorcut">
                          <div class="kotak">
                            <div class="menu"><span class="fa fa-building"></span></div>
                            <div class="judul-menu">Profile</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-3">
                        <div class="shorcut">
                        <div class="kotak">
                          <div class="menu">
                            <span class="fa fa-users"></span>
                          </div>
                          <div class="judul-menu">Jurusan</div>
                        </div></div>
                      </div>
                      <div class="col-xs-3">
                        <div class="shorcut">
                        <div class="kotak">
                          <div class="menu">
                            <span class="fa fa-check"></span>
                            
                          </div>
                          <div class="judul-menu">SPM-PT</div>
                        </div></div>
                      </div>

                      <div class="col-xs-3">
                        <div class="shorcut">
                        <div class="kotak">
                          <div class="menu"><span class="fa fa-globe"></span></div>
                          <div class="judul-menu">PMB Online</div>
                        </div></div>
                      </div>
                      <div class="col-xs-3">
                        <div class="shorcut">
                        <div class="kotak">
                          <div class="menu"><span class="fa fa-graduation-cap"></span></div>
                          <div class="judul-menu">Akademis</div>
                        </div></div>
                      </div>
                      <div class="col-xs-3">
                        <div class="shorcut">
                        <div class="kotak">
                          <div class="menu"><span class="fa fa-location-arrow"></span></div>
                          <div class="judul-menu">Portal Akademis</div>
                        </div></div>
                      </div>
                      <div class="col-xs-3">
                        <div class="shorcut">
                        <div class="kotak">
                          <div class="menu"><span class="fa fa-newspaper-o "></span></div>
                          <div class="judul-menu">Berita</div>
                        </div></div>
                      </div>
                      <div class="col-xs-3">
                        <div class="shorcut">
                        <div class="kotak">
                          <div class="menu"><span class="fa fa-info"></span></div>
                          <div class="judul-menu">Info Dan Layanan</div>
                        </div></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--END MENU-->
              <!-- BERITA TERKINI-->
              <div class="row section ">
                <div class="col-md-12">
                  <div class="header"><b>Berita Terkini</b></div>
                  <div class="row padding10">
                    <div class="col-xs-6 col-md-3">
                      <div class="news">
                          <img src="<?= base_url() ."assets/images/poli_depan.jpg" ?>" class='img img-responsive img-rounded'>
                          <div class="caption">
                            <p>Kuliah Umum Bersama Prof. Dr. Irwan Prayitno S.Psi Msc</p>
                            
                          </div>
                      </div>
                      
                    </div>
                    <div class="col-xs-6 col-md-3">
                      <div class="news">
                          <img src="<?= base_url() ."assets/images/atip-campus.jpg" ?>" class='img img-responsive img-rounded'>
                          <div class="caption">
                            
                            <p>Politeknik ATI Padang Selenggarakan Acara Temu Industri</p>
                            
                          </div>
                      </div>
                    </div>
                    <!--div id="enter"></div-->
                  <!--/div>
                  <div class="row padding10"-->
                    <div class="col-xs-6 col-md-3">
                      <div class="news">
                          <img src="<?= base_url() ."assets/images/POLTEKATIP.jpg" ?>" class='img img-responsive img-rounded'>
                          <div class="caption">
                            <p>Kuliah Umum Bersama Prof. Dr. Irwan Prayitno S.Psi Msc</p>
                          </div>
                      </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                      <div class="news">
                          <img src="<?= base_url() ."assets/images/poli_depan.jpg" ?>" class='img img-responsive img-rounded'>
                          <div class="caption">
                            <p>Politeknik ATI Padang Selenggarakan Acara Temu Industri</p>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- END BERITA TERKINI-->
              <div class="row section ">
                <p class="moto">Dunia Industri Memanggil Anda</p>
              </div>
              <!--Footer-->
              <div class="row" style="padding: 10px 0 10px 0">
                <div class="col-md-12">
                  <div class="footer"><b>
                  <p>POLITEKNIK ATI PADANG<br>
                  Jl. Bunga Pasang Tabing Padang 25171<br>
                  T. 07517055053<br>
                  E. info@poltekatipdg.ac.id</p>
                  <p class="right">@2020 Politeknik Padang</p></b>
                  </div>
                </div>
                
              </div>
              <!--End Footer-->
            </div>
            
              
          </div>
        </div>		
      </div>
    </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/slider.js"></script>
    <script type="text/javascript">
      /*var j=1;
      var myVar = setInterval(slide, 1000);
      function slide(){
        if(j==4){
          j=1;
        }
        console.log(j);
        showSlides(j);
        j++;

      }*/

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
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
      }
      /*$(window).load(function(){
    	   // PAGE IS FULLY LOADED  
    	   // FADE OUT YOUR OVERLAYING DIV
    	   //$('#overlay').fadeOut();
    	});*/
    </script>
  </body>
</html>