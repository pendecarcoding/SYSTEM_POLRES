<?php
use App\Cmenu;
use App\KordinatModel;

$class = new Cmenu();
$datamarker = KordinatModel::where('latitude','!=','')
                ->where('longitude','!=','')
                ->get();
  $clatitude   = '1.583164915316166';
  $clongitude  = '101.81656018345798';
   $zoom = 9;
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    
    <!--====== Title ======-->
    <title>APLIKASI-ABSENSI KABUPATEN BENGKALIS</title>
    
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{asset('frontend')}}/assets/images/favicon.png" type="image/png">
        
    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/magnific-popup.css">
        
    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/slick.css">
        
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/LineIcons.css">
        
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/bootstrap.min.css">
    
    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/default.css">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/style.css">
    <script src="https://kit.fontawesome.com/ec6fd0ee66.js" crossorigin="anonymous"></script>
    
</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
   
    <!--====== PRELOADER PART START ======-->

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->
    
    <!--====== NAVBAR TWO PART START ======-->

    <section class="navbar-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                       
                        <a href="#">
                            <img style="width:70px" src="{{asset('frontend')}}/assets/images/logo.png" alt="Logo">
                        </a>
                        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTwo" aria-controls="navbarTwo" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item active"><a class="page-scroll" href="#home">home</a></li>
                                <li class="nav-item"><a class="page-scroll" href="#services">Fitur Aplikasi</a></li>
                                <li class="nav-item"><a class="page-scroll" href="#portfolio">Panduan Aplikasi</a></li>
                                {{-- <li class="nav-item"><a class="page-scroll" href="#pricing">Pricing</a></li>
                                <li class="nav-item"><a class="page-scroll" href="#about">About</a></li> --}}
                                <li class="nav-item"><a class="page-scroll" href="#contact">Titik Kordinat</a></li>
                            </ul>
                        </div>
                        
                        <div class="navbar-btn d-none d-sm-inline-block">
                            <ul>
                                <li><a class="solid" href="{{url('/login')}}">Login</a></li>
                            </ul>
                        </div>
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== NAVBAR TWO PART ENDS ======-->
    
    <!--====== SLIDER PART START ======-->

    <section id="home" class="slider_area">
        <div id="carouselThree" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselThree" data-slide-to="0" class="active"></li>
                <li data-target="#carouselThree" data-slide-to="1"></li>
                <li data-target="#carouselThree" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="slider-content">
                                    <h1 class="title">E-ABSENSI</h1>
                                    <p class="text">Selamat datang di Sistem Aplikasi ABSENSI Online Kabupaten Bengkalis. Sistem ini merupakan inovasi Pemerintah kabupaten bengkalis dalam melakukan ABSENSI di seluruh SKPD Kabupaten Bengkalis</p>
                                    <ul class="slider-btn rounded-buttons">
                                        {{-- <li><a class="main-btn rounded-one" href="#">GET STARTED</a></li> --}}
                                        <li><a class="main-btn rounded-two" href="#">DOWNLOAD</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                    <div class="slider-image-box d-none d-lg-flex align-items-end">
                        <div class="slider-image">
                            <img src="{{asset('frontend')}}/assets/images/slider/1.png" alt="Hero">
                        </div> <!-- slider-imgae -->
                    </div> <!-- slider-imgae box -->
                </div> <!-- carousel-item -->

                <div class="carousel-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="slider-content">
                                    <h1 class="title">Fitur Geo Location</h1>
                                    <p class="text">Dengan fitur ini untuk melakukan absensi menggunakan smartphone dan harus berada pada radius yang telah ditentukan berdasarkan kordinat kantor </p>
                                    <ul class="slider-btn rounded-buttons">
                                        {{-- <li><a class="main-btn rounded-one" href="#">GET STARTED</a></li> --}}
                                        <li><a class="main-btn rounded-two" href="#">DOWNLOAD</a></li>
                                    </ul>
                                </div> <!-- slider-content -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                    <div class="slider-image-box d-none d-lg-flex align-items-end">
                        <div class="slider-image">
                            <img src="{{asset('frontend')}}/assets/images/slider/2.png" alt="Hero">
                        </div> <!-- slider-imgae -->
                    </div> <!-- slider-imgae box -->
                </div> <!-- carousel-item -->

                <div class="carousel-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="slider-content">
                                    <h1 class="title">E-Cuti & E-dinas</h1>
                                    <p class="text">Tersedia fitur untuk pengajuan Cuti dan Izin Dinas dalam Sistem Pemerintahan</p>
                                    <ul class="slider-btn rounded-buttons">
                                        {{-- <li><a class="main-btn rounded-one" href="#">GET STARTED</a></li> --}}
                                        <li><a class="main-btn rounded-two" href="#">DOWNLOAD</a></li>
                                    </ul>
                                </div> <!-- slider-content -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                    <div class="slider-image-box d-none d-lg-flex align-items-end">
                        <div class="slider-image">
                            <img src="{{asset('frontend')}}/assets/images/slider/3.png" alt="Hero">
                        </div> <!-- slider-imgae -->
                    </div> <!-- slider-imgae box -->
                </div> <!-- carousel-item -->
            </div>

            <a class="carousel-control-prev" href="#carouselThree" role="button" data-slide="prev">
                <i class="lni lni-arrow-left"></i>
            </a>
            <a class="carousel-control-next" href="#carouselThree" role="button" data-slide="next">
                <i class="lni lni-arrow-right"></i>
            </a>
        </div>
    </section>

    <!--====== SLIDER PART ENDS ======-->
    
    <!--====== FEATRES TWO PART START ======-->

    <section id="services" class="features-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section-title text-center pb-10">
                        <h3 class="title">Fitur Aplikasi</h3>
                        <p class="text">Adapun untuk fitur aplikasi pada Aplikasi ini berupa</p>
                    </div> <!-- row -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-features mt-40">
                        <div class="features-title-icon d-flex justify-content-between">
                            <h4 class="features-title"><a href="#">Absensi</a></h4>
                            <div class="features-icon">
                                <i class="lni lni-mobile"></i>
                                <img class="shape" src="{{asset('frontend')}}/assets/images/f-shape-1.svg" alt="Shape">
                            </div>
                        </div>
                        <div class="features-content">
                            <p class="text">Fitur ini digunakan untuk pembambilan absensi yang menggunakan titik titik lokasi radius. dimana pegawai hanya bisa melakukan absensi di lokasi yang sudah ditentukan titik lokasinya</p>
                            <a class="features-btn" href="#"></a>
                        </div>
                    </div> <!-- single features -->
                </div>
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-features mt-40">
                        <div class="features-title-icon d-flex justify-content-between">
                            <h4 class="features-title"><a href="#">Izini Dinas</a></h4>
                            <div class="features-icon">
                                <i class="lni lni-car"></i>
                                <img class="shape" src="{{asset('frontend')}}/assets/images/f-shape-1.svg" alt="Shape">
                            </div>
                        </div>
                        <div class="features-content">
                            <p class="text">Fitur ini digunakan untuk melakukan Izin dinas Pegawai. Pegawai untuk melakukan izin dinas mengupload bukti SPT dinas sebagai ke Aplikasi absensi</p>
                            <a class="features-btn" href="#"></a>
                        </div>
                    </div> <!-- single features -->
                </div>
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-features mt-40">
                        <div class="features-title-icon d-flex justify-content-between">
                            <h4 class="features-title"><a href="#">Izin Cuti</a></h4>
                            <div class="features-icon">
                                <i class="lni lni-calendar"></i>
                                <img class="shape" src="{{asset('frontend')}}/assets/images/f-shape-1.svg" alt="Shape">
                            </div>
                        </div>
                        <div class="features-content">
                            <p class="text">Short description for the ones who look for something new. Short description for the ones who look for something new.</p>
                            <a class="features-btn" href="#"></a>
                        </div>
                    </div> <!-- single features -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== FEATRES TWO PART ENDS ======-->
    
    <!--====== PORTFOLIO PART START ======-->

    <section id="portfolio" class="portfolio-area portfolio-four pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="section-title text-center pb-10">
                        <h3 class="title">Panduan Penggunaan Aplikasi</h3>
                        <p class="text">untuk penduan penggunaan Aplikasi anda dapat melihatnya dibawah ini</p>
                        <div class="light-rounded-buttons mt-30">
                        <iframe src="https://ppkl.menlhk.go.id/website/filebox/592/190408165734um_lhk_ditppa_file_management_2018_v01.pdf" style="width:100%;height:500px" frameborder="0"></iframe>
                        </div>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== PORTFOLIO PART ENDS ======-->
    
    <!--====== PRINICNG START ======-->

    {{-- <section id="pricing" class="pricing-area ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section-title text-center pb-25">
                        <h3 class="title">Pricing Plans</h3>
                        <p class="text">Stop wasting time and money designing and managing a website that doesn’t get results. Happiness guaranteed!</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="pricing-style mt-30">
                        <div class="pricing-icon text-center">
                            <img src="{{asset('frontend')}}/assets/images/basic.svg" alt="">
                        </div>
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">Basic</h5>
                            <p class="month"><span class="price">$ 199</span>/month</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni lni-check-mark-circle"></i> Carefully crafted components</li>
                                <li><i class="lni lni-check-mark-circle"></i> Amazing page examples</li>
                            </ul>
                        </div>
                        <div class="pricing-btn rounded-buttons text-center">
                            <a class="main-btn rounded-one" href="#">GET STARTED</a>
                        </div>    
                    </div> <!-- pricing style one -->
                </div>
                
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="pricing-style mt-30">
                        <div class="pricing-icon text-center">
                            <img src="{{asset('frontend')}}/assets/images/pro.svg" alt="">
                        </div>
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">Pro</h5>
                            <p class="month"><span class="price">$ 399</span>/month</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni lni-check-mark-circle"></i> Carefully crafted components</li>
                                <li><i class="lni lni-check-mark-circle"></i> Amazing page examples</li>
                            </ul>
                        </div>
                        <div class="pricing-btn rounded-buttons text-center">
                            <a class="main-btn rounded-one" href="#">GET STARTED</a>
                        </div>
                    </div> <!-- pricing style one -->
                </div>
                
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="pricing-style mt-30">
                        <div class="pricing-icon text-center">
                            <img src="{{asset('frontend')}}/assets/images/enterprise.svg" alt="">
                        </div>
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">Enterprise</h5>
                            <p class="month"><span class="price">$ 699</span>/month</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni lni-check-mark-circle"></i> Carefully crafted components</li>
                                <li><i class="lni lni-check-mark-circle"></i> Amazing page examples</li>
                            </ul>
                        </div>
                        <div class="pricing-btn rounded-buttons text-center">
                            <a class="main-btn rounded-one" href="#">GET STARTED</a>
                        </div>
                    </div> <!-- pricing style one -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== PRINICNG ENDS ======-->
    
    <!--====== ABOUT PART START ======-->

    <section id="about" class="about-area">
                    <div class="section-title text-center pb-10">
                        <h3 class="title">You are using free lite version</h3>
                        <p class="text">Please, purchase full version to get all pages and features</p>
                        <div class="light-rounded-buttons mt-30">
                        <a href="https://rebrand.ly/smash-ud" rel="nofollow" class="main-btn light-rounded-two">Purchase Now</a>
                        </div>
                    </div> <!-- section title -->
    </section> --}}

    <!--====== ABOUT PART ENDS ======-->
    

    
    <!--====== CONTACT PART START ======-->

    <section id="contact" class="contact-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section-title text-center pb-30">
                        <h3 class="title">Titik Sebaran Kordinat ABSENSI</h3>
                        <p class="text">Titik sebaran ini adalah lokasi absensi seluruh SKPD di pemerintah Kabupaten Bengkalis</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                     
              
                        <div class="peta" id="peta" style="margin-top:2px;width:100%;height:500px;"></div>
              
                        <script>
                        function initAutocomplete() {
                        var map = new google.maps.Map(document.getElementById('peta'), {
                        center: {lat: {{$clatitude}}, lng: {{$clongitude}}},
                        zoom: {{$zoom}},
                        mapTypeId: 'terrain'
              
                        });
              
                        // Create the search box and link it to the UI element.
                        var input = document.getElementById('pac-input');
                        var searchBox = new google.maps.places.SearchBox(input);
                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
              
                        // Bias the SearchBox results towards current map's viewport.
                        map.addListener('bounds_changed', function() {
                        searchBox.setBounds(map.getBounds());
              
                        });
              
                        var markers = [];
                        // Listen for the event fired when the user selects a prediction and retrieve
                        // more details for that place.
                        searchBox.addListener('places_changed', function() {
                        var places = searchBox.getPlaces();
              
                        if (places.length == 0) {
                        return;
                        }
              
                        // Clear out the old markers.
                        markers.forEach(function(marker) {
                        marker.setMap(null);
                        });
                        markers = [];
              
                        // For each place, get the icon, name and location.
                        var bounds = new google.maps.LatLngBounds();
                        places.forEach(function(place) {
                        if (!place.geometry) {
                          console.log("Returned place contains no geometry");
                          return;
                        }
                        var icon = {
                          url: place.icon,
                          size: new google.maps.Size(71, 71),
                          origin: new google.maps.Point(0, 0),
                          anchor: new google.maps.Point(17, 34),
                          scaledSize: new google.maps.Size(25, 25)
                        };
              
                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                          map: map,
                          icon: icon,
                          title: place.name,
                          position: place.geometry.location
                        }));
              
                        if (place.geometry.viewport) {
                          // Only geocodes have viewport.
                          bounds.union(place.geometry.viewport);
                        } else {
                          bounds.extend(place.geometry.location);
                        }
                        });
                        map.fitBounds(bounds);
                        });
                        var locations = [
              
                        @foreach($datamarker as $key => $v)
                        <?php
                        $instansi = $class->namainstansi($v->kode_unitkerja);
                        ?>
                        ['<h4><b style="color:red;">{{$instansi->nama_unitkerja}}</b></h4><hr><br><b>Kode Unitkerja </b>: </b> {{$v->kode_unitkerja}}<br><b>Kecamatan</b> : {{$instansi->kecamatan}}<br><b>Alamat</b> : {{$instansi->alamat}}<br><b>Radius</b> : <b style="color:red;">{{$v->radius}} meter</b><br><b>Latitude </b> : <b style="color:#ffae00;">{{$v->latitude}}</b><br><b>Longitude</b> : <b style="color:#ffae00;">{{$v->longitude}}</b>', {{$v->latitude}}, {{$v->longitude}},{{$v->radius}}],
                        @endforeach
              
                        ];
              
              
              
              
                        var infowindow = new google.maps.InfoWindow();
              
              
                        //
              
                        var marker, i,circle;
                        /* kode untuk menampilkan banyak marker */
                        for (i = 0; i < locations.length; i++) {
                        marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
              
              
                        // icon: "https://bengkaliskab.go.id/gis/images/building.png"
              
              
                        });
              
                        circle = new google.maps.Circle({
                        map: map,
                        radius: locations[i][3],    // 10 miles in metres
                        fillColor: '#b6e7bacc'
                        });
              
                        circle.bindTo('center', marker, 'position');
              
                        /* menambahkan event clik untuk menampikan
                        infowindows dengan isi sesuai denga
                        marker yang di klik */
              
                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                        }
                        })(marker, i));
                        }
              
                        }
              
                        </script>
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwxUvl3u_d_3fdomak3SKTITmJqQaDXak&libraries=places&callback=initAutocomplete"
                        async defer></script>
              
                    </div>
                  </div>
            </div> <!-- row -->
            {{-- <div class="contact-info pt-30">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-contact-info contact-color-1 mt-30 d-flex ">
                            <div class="contact-info-icon">
                                <i class="lni lni-map-marker"></i>
                            </div>
                            <div class="contact-info-content media-body">
                                <p class="text"> Elizabeth St, Melbourne<br>1202 Australia.</p>
                            </div>
                        </div> <!-- single contact info -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-contact-info contact-color-2 mt-30 d-flex ">
                            <div class="contact-info-icon">
                                <i class="lni lni-envelope"></i>
                            </div>
                            <div class="contact-info-content media-body">
                                <p class="text">hello@ayroui.com</p>
                                <p class="text">support@uideck.com</p>
                            </div>
                        </div> <!-- single contact info -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-contact-info contact-color-3 mt-30 d-flex ">
                            <div class="contact-info-icon">
                                <i class="lni lni-phone"></i>
                            </div>
                            <div class="contact-info-content media-body">
                                <p class="text">+333 789-321-654</p>
                                <p class="text">+333 985-458-609</p>
                            </div>
                        </div> <!-- single contact info -->
                    </div>
                </div> <!-- row -->
            </div> <!-- contact info -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-wrapper form-style-two pt-115">
                        <h4 class="contact-title pb-10"><i class="lni lni-envelope"></i> Leave <span>A Message.</span></h4>
                        
                        <form id="contact-form" action="assets/contact.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-input mt-25">
                                        <label>Name</label>
                                        <div class="input-items default">
                                            <input name="name" type="text" placeholder="Name">
                                            <i class="lni lni-user"></i>
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input mt-25">
                                        <label>Email</label>
                                        <div class="input-items default">
                                            <input type="email" name="email" placeholder="Email">
                                            <i class="lni lni-envelope"></i>
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <div class="col-md-12">
                                    <div class="form-input mt-25">
                                        <label>Massage</label>
                                        <div class="input-items default">
                                            <textarea name="massage" placeholder="Massage"></textarea>
                                            <i class="lni lni-pencil-alt"></i>
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <p class="form-message"></p>
                                <div class="col-md-12">
                                    <div class="form-input light-rounded-buttons mt-30">
                                        <button class="main-btn light-rounded-two">Send Message</button>
                                    </div> <!-- form input -->
                                </div>
                            </div> <!-- row -->
                        </form>
                    </div> <!-- contact wrapper form -->
                </div>
            </div> <!-- row --> --}}
        </div> <!-- container -->
    </section>

    <!--====== CONTACT PART ENDS ======-->
    
    <!--====== FOOTER PART START ======-->

    <footer
    class="text-center text-lg-start text-white"
    style="background-color: #1c2331"
    >
<!-- Section: Social media -->
<section
       class="d-flex justify-content-between p-4"
       style="background-color: #0266f4;"
       >
<!-- Left -->
<div class="me-5">
  <span>Terhubung dengan kami di jejaring sosial:</span>
</div>
<!-- Left -->

<!-- Right -->
<div>
  <a href="" class="text-white me-4">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a href="" class="text-white me-4">
    <i class="fab fa-twitter"></i>
  </a>
  <a href="" class="text-white me-4">
    <i class="fab fa-google"></i>
  </a>
  <a href="" class="text-white me-4">
    <i class="fab fa-instagram"></i>
  </a>
  <a href="" class="text-white me-4">
    <i class="fab fa-linkedin"></i>
  </a>
  <a href="" class="text-white me-4">
    <i class="fab fa-github"></i>
  </a>
</div>
<!-- Right -->
</section>
<!-- Section: Social media -->

<!-- Section: Links  -->
<section class="">
<div class="container text-center text-md-start mt-5">
  <!-- Grid row -->
  <div class="row mt-3">
    <!-- Grid column -->
    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
      <!-- Content -->
      <h6 class="text-uppercase fw-bold" style="color:white;text-align:left">Badan Kepegawaian, Pendidikan Dan Pelatihan Kabupaten Bengkalis</h6>
      <hr
          class="mb-4 mt-0 d-inline-block mx-auto"
          style="width: 60px; background-color: #7c4dff; height: 2px"
          />
      <p style="text-align:left;color:white">Alamat : F4FF+8H9, Jl. Antara, Senggoro, Kec. Bengkalis, Kabupaten Bengkalis, Riau 28711</p>
      <p style="text-align:left;color:white">Email : bkpp@bengkaliskab.go.id</p>
      <p style="text-align:left;color:white">Telp : (0766) 21072</p>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div style="text-align: left;"class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
      <!-- Links -->
      <h6 style="text-align:left;color:white" class="text-uppercase fw-bold">APLIKASI KEPEGAWAIAN</h6>
      <hr
          class="mb-4 mt-0 d-inline-block mx-auto"
          style="width: 60px; background-color: #7c4dff; height: 2px"
          />
      <p>
        <a style="color:white;text-align:left" href="https://siasn.bkn.go.id/" class="text-white">SI ASN</a>
      </p>
      <p>
        <a style="color:white;text-align:left" href="https://mysapk.bkn.go.id/" class="text-white">My SAPK</a>
      </p>
      <p>
        <a style="color:white;text-align:left" href="https://simpegnas.bkn.go.id/" class="text-white">SIMPEGNAS</a>
      </p>
      <p>
        <a style="color:white;text-align:left" href="https://pinka.bengkaliskab.go.id" class="text-white">PINKA</a>
      </p>
      <p>
        <a style="color:white;text-align:left" href="https://kinerja.bkn.go.id/login" class="text-white">E-KINERJA</a>
      </p>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div style="text-align: left;"class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
      <!-- Links -->
      <h6 style="text-align:left;color:white" class="text-uppercase fw-bold">INFORMASI BENGKALIS</h6>
      <hr
          class="mb-4 mt-0 d-inline-block mx-auto"
          style="width: 60px; background-color: #7c4dff; height: 2px"
          />
      <p>
        <a style="color:white;text-align:left" href="https://diskominfotik.bengkaliskab.go.id/" class="text-white">DISKOMINFOTIK</a>
      </p>
      <p>
        <a style="color:white;text-align:left" href="https://humas.bengkaliskab.go.id/" class="text-white">HUMAS</a>
      </p>
      <p>
        <a style="color:white;text-align:left" href="https://bkpp.bengkaliskab.go.id/" class="text-white">BKPP</a>
      </p>
      <p>
        <a style="color:white;text-align:left" href="https://cctv.bengkaliskab.go.id" class="text-white">CCTV</a>
      </p>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
      <!-- Links -->
      <h6 style="color:white" class="text-uppercase fw-bold" style="color:white;">Downlad</h6>
      <div style="margin-top:20px">
        <img src="/public/frontend/assets/images/playstoredownload.png" alt="">
      </div>
    </div>
    <!-- Grid column -->
  </div>
  <!-- Grid row -->
</div>
</section>
<!-- Section: Links  -->

<!-- Copyright -->
<div
   class="text-center p-3"
   style="background-color: rgba(0, 0, 0, 0.2)"
   >
© 2020 Copyright:
<a class="text-white" href="https://mdbootstrap.com/"
   >MDBootstrap.com| Modify By Tim IT Dinas Komunikasi Informatika dan Statistik Kabupaten Bengkalis</a
  >
</div>
<!-- Copyright -->
</footer>

    <!--====== FOOTER PART ENDS ======-->
    
    <!--====== BACK TOP TOP PART START ======-->

    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>

    <!--====== BACK TOP TOP PART ENDS ======-->    

    <!--====== PART START ======-->

<!--
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-">
                    
                </div>
            </div>
        </div>
    </section>
-->

    <!--====== PART ENDS ======-->




    <!--====== Jquery js ======-->
    <script src="{{asset('frontend')}}/assets/js/vendors/jquery-1.12.4.min.js"></script>
    <script src="{{asset('frontend')}}/assets/js/vendors/modernizr-3.7.1.min.js"></script>
    
    <!--====== Bootstrap js ======-->
    <script src="{{asset('frontend')}}/assets/js/popper.min.js"></script>
    <script src="{{asset('frontend')}}/assets/js/bootstrap.min.js"></script>
    
    
    <!--====== Isotope js ======-->
    <script src="{{asset('frontend')}}/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="{{asset('frontend')}}/assets/js/isotope.pkgd.min.js"></script>
    
    <!--====== Scrolling Nav js ======-->
    <script src="{{asset('frontend')}}/assets/js/jquery.easing.min.js"></script>
    <script src="{{asset('frontend')}}/assets/js/scrolling-nav.js"></script>
    
    <!--====== Main js ======-->
    <script src="{{asset('frontend')}}/assets/js/main.js"></script>
    
</body>

</html>
