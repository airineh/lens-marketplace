<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Lens - Marketplace Penyewaan Alat Fotografi</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>

        <!-- Slick -->
        <link type="text/css" rel="stylesheet" href="{{ asset('css/slick.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/slick-theme.css') }}"/>

        <!-- nouislider -->
        <link type="text/css" rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}"/>

        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

        <!-- Custom stylesheet -->
        <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}"/>
            <style>
            @media (max-width: 768px) {
                #top-header .header-links {
                    float: none !important;
                    text-align: center;
                    margin-bottom: 5px;
                }

                .header-logo {
                    text-align: center;
                    margin-bottom: 15px;
                }

                .header-search {
                    margin: 15px 0;
                }

                .header-search form {
                    display: block;
                }

                .header-search .input-select,
                .header-search .input,
                .header-search .search-btn {
                    width: 100% !important;
                    margin-bottom: 8px;
                    border-radius: 4px !important;
                }

                .header-ctn {
                    text-align: center;
                }

                .main-nav {
                    text-align: center;
                }

                .main-nav > li {
                    display: block;
                    width: 100%;
                }

                .hot-deal h1 {
                    font-size: 38px !important;
                }

                .shop {
                    margin-bottom: 20px;
                }

                .product {
                    margin-bottom: 20px;
                }

                .section-title {
                    text-align: center;
                }

                .section-nav {
                    float: none !important;
                    text-align: center;
                    margin-top: 10px;
                }

                .section-tab-nav li {
                    display: inline-block;
                    margin: 5px;
                }

                .footer {
                    margin-bottom: 25px;
                    text-align: center;
                }
            }
            </style>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="tel:+6285155212362"><i class="fa fa-phone"></i> +62 851 5521 2362</a></li>
                        <li><a href="mailto:lens@gmail.com"><i class="fa fa-envelope-o"></i> lens@gmail.com</a></li>
                        <li><a href="{{ route('about') }}"><i class="fa fa-map-marker"></i> Gandaria, Jakarta Selatan</a></li>
					</ul>
					<ul class="header-links pull-right">
						@auth
                                <li><a href="{{ route('dashboard') }}"><i class="fa fa-user-o"></i> Profil Saya</a></li>
                            @else
                                <li><a href="{{ route('login') }}"><i class="fa fa-user-o"></i> Masuk</a></li>
                            @endauth
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="{{ route('home') }}" class="logo">
									<img src="{{ asset('img/lens02.png') }}" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
                                <form action="{{ route('catalog') }}" method="GET" style="display:flex;">
                                    <input class="input"
                                        type="text"
                                        name="search"
                                        placeholder="Cari alat fotografi"
                                        value="{{ request('search') }}">

                                    <button class="search-btn" type="submit">
                                        Cari
                                    </button>
                                </form>
                            </div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<div>
                                        @auth
                                            <a href="{{ route('dashboard') }}">
                                                <i class="fa fa-user-o"></i>
                                                <span>Dashboard</span>
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}">
                                                <i class="fa fa-user-o"></i>
                                                <span>Masuk</span>
                                            </a>
                                        @endauth
                                    </div>
								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
                 <ul class="main-nav nav navbar-nav">
    <li><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('catalog') }}">Katalog</a></li>
    <li><a href="{{ route('about') }}">Tentang</a></li>

    @guest
       
        <li><a href="{{ route('register') }}">Daftar</a></li>
    @endguest
</ul>
                    <!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

        <!-- HERO SECTION -->
        <div id="hot-deal" class="section">
            <div class="container">
                <div class="row">

                    <div class="col-md-12">
                        <div class="hot-deal text-center">

                            <h1 style="font-size:60px; font-weight:bold;">                             
                                LENS.
                            </h1>

                            <h3>
                                Marketplace Penyewaan
                                Alat Fotografi
                            </h3>

                            <p>
                                Temukan kamera, lensa, drone,
                                dan alat fotografi terbaik
                                untuk kebutuhan kontenmu.
                            </p>

                            <br>

                            <a class="primary-btn cta-btn" href="/catalog">
                                Jelajahi Alat
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /HERO SECTION -->


        <!-- KATEGORI -->
        <div class="section">
            <div class="container">

                <div class="row">

                    <!-- Kamera -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="shop">
                            <div class="shop-img">
                                <img src="{{ asset('img/kamera01.png') }}" alt="">
                            </div>

                            <div class="shop-body">
                                <h3>Kamera</h3>

                               <a href="{{ route('catalog', ['category' => 'kamera']) }}" class="cta-btn">
                                    Lihat Alat <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tripod -->
                    <div class="col-md-4 col-xs-6">
                        <div class="shop">
                            <div class="shop-img">
                                <img src="{{ asset('img/tripod01.png') }}" alt="">
                            </div>

                            <div class="shop-body">
                                <h3>Tripod</h3>

                                <a href="{{ route('catalog', ['category' => 'tripod']) }}" class="cta-btn">
                                    Lihat Alat <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Drone -->
                    <div class="col-md-4 col-xs-6">
                        <div class="shop">
                            <div class="shop-img">
                                <img src="{{ asset('img/drone01.png') }}" alt="">
                            </div>

                            <div class="shop-body">
                                <h3>Drone</h3>

                               <a href="{{ route('catalog', ['category' => 'drone']) }}" class="cta-btn">
                                    Lihat Alat <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- /KATEGORI -->


        <!-- ALAT POPULER -->
        <div class="section">
            <div class="container">

                <div class="row">

                    <!-- Section Title -->
                    <div class="col-md-12">
                        <div class="section-title">
                            <h3 class="title">Alat Tersedia</h3>

                            <div class="section-nav">
                                <ul class="section-tab-nav tab-nav">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab1">
                                            Camera
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#tab1">
                                            Lens
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#tab1">
                                            Drone
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#tab1">
                                            Lighting
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <!-- /Section Title -->


                    <!-- PRODUCT -->
                    <div class="col-md-12">

                       <div class="row">

                            <!-- PRODUCT 1 -->
                             <div class="col-md-3 col-sm-6 col-xs-12">
                                 <div class="product">

                                <div class="product-img">
                                    <img src="{{ asset('img/CanonEOSR50.png') }}" alt="">
                                </div>

                                <div class="product-body">

                                    <p class="product-category">
                                        Camera
                                    </p>

                                    <h3 class="product-name">
                                        <a href="#">
                                            Canon EOS R50
                                        </a>
                                    </h3>

                                    <h4 class="product-price">
                                        Rp250.000 / hari
                                    </h4>

                                    <div class="product-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>

                                </div>

                                <div class="add-to-cart">
                                    <a href="{{ route('catalog') }}" class="add-to-cart-btn">
                                            <i class="fa fa-calendar"></i>
                                            Sewa Sekarang
                                        </a>
                                </div>
                            </div>
                            </div>
                            <!-- /PRODUCT -->


                            <!-- PRODUCT 2 -->
                             <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="product">

                                <div class="product-img">
                                    <img src="{{ asset('img/DJI-Mini-3-GL-01.png') }}" alt="">
                                </div>

                                <div class="product-body">

                                    <p class="product-category">
                                        Drone
                                    </p>

                                    <h3 class="product-name">
                                        <a href="#">
                                            DJI Mini 3
                                        </a>
                                    </h3>

                                    <h4 class="product-price">
                                        Rp400.000 / hari
                                    </h4>

                                    <div class="product-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>

                                </div>

                                <div class="add-to-cart">
                                    <a href="{{ route('catalog') }}" class="add-to-cart-btn">
                                        <i class="fa fa-calendar"></i>
                                        Sewa Sekarang
                                    </a>
                                </div>
                            </div>
                            </div>
                            <!-- /PRODUCT -->


                            <!-- PRODUCT 3 -->
                             <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="product">

                                <div class="product-img">
                                    <img src="{{ asset('img/Godox-SL60W.png') }}" alt="">
                                </div>

                                <div class="product-body">

                                    <p class="product-category">
                                        Lighting
                                    </p>

                                    <h3 class="product-name">
                                        <a href="#">
                                            Godox SL60W
                                        </a>
                                    </h3>

                                    <h4 class="product-price">
                                        Rp120.000 / hari
                                    </h4>

                                    <div class="product-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>

                                </div>

                                <div class="add-to-cart">
                                    <a href="{{ route('catalog') }}" class="add-to-cart-btn">
                                        <i class="fa fa-calendar"></i>
                                        Sewa Sekarang
                                    </a>
                                </div>
                            </div>
                            </div>
                            <!-- /PRODUCT -->


                            <!-- PRODUCT 4 -->
                             <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="product">

                                <div class="product-img">
                                    <img src="{{ asset('img/canonrf50mm.png') }}" alt="">
                                </div>

                                <div class="product-body">

                                    <p class="product-category">
                                        Lens
                                    </p>

                                    <h3 class="product-name">
                                        <a href="#">
                                            Canon RF 50mm
                                        </a>
                                    </h3>

                                    <h4 class="product-price">
                                        Rp100.000 / hari
                                    </h4>

                                    <div class="product-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>

                                </div>

                                <div class="add-to-cart">
                                   <a href="{{ route('catalog') }}" class="add-to-cart-btn">
                                        <i class="fa fa-calendar"></i>
                                        Sewa Sekarang
                                    </a>
                                </div>
                            </div>
                            </div>
                            <!-- /PRODUCT -->

                        </div>

                    

                    </div>
                    <!-- /PRODUCT -->

                </div>

            </div>
        </div>
        <!-- /ALAT POPULER -->


        <!-- KEUNGGULAN -->
        <div class="section">
            <div class="container">

                <div class="row">

                    <div class="col-md-12">
                        <div class="section-title text-center">
                            <h3 class="title">
                                Kenapa Memilih LENS?
                            </h3>
                        </div>
                    </div>

                    <!-- CARD 1 -->
                    <div class="col-md-4">
                        <div class="product">

                            <div class="product-body text-center">

                                <i class="fa fa-camera"
                                style="font-size:50px; margin-bottom:20px;">
                                </i>

                                <h3>
                                    Alat Lengkap
                                </h3>

                                <p>
                                    Berbagai kamera, lensa,
                                    drone, dan lighting tersedia
                                    untuk kebutuhan fotografi.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- CARD 2 -->
                    <div class="col-md-4">
                        <div class="product">

                            <div class="product-body text-center">

                                <i class="fa fa-money"
                                style="font-size:50px; margin-bottom:20px;">
                                </i>

                                <h3>
                                    Harga Terjangkau
                                </h3>

                                <p>
                                    Sewa alat fotografi
                                    dengan harga hemat
                                    dan kualitas terbaik.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- CARD 3 -->
                    <div class="col-md-4">
                        <div class="product">

                            <div class="product-body text-center">

                                <i class="fa fa-clock-o"
                                style="font-size:50px; margin-bottom:20px;">
                                </i>

                                <h3>
                                    Booking Cepat
                                </h3>

                                <p>
                                    Proses pemesanan mudah,
                                    cepat, dan praktis
                                    langsung dari website.
                                </p>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- /KEUNGGULAN -->

            <div class="section">
                <div class="container">
                    <div class="section-title text-center">
                        <h3 class="title">Cara Kerja Lens</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            <div class="product">
                                <div class="product-body text-center">
                                    <i class="fa fa-search" style="font-size:45px;"></i>
                                    <h4>Cari Alat</h4>
                                    <p>Pilih alat fotografi sesuai kebutuhan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="product">
                                <div class="product-body text-center">
                                    <i class="fa fa-calendar" style="font-size:45px;"></i>
                                    <h4>Booking</h4>
                                    <p>Ajukan jadwal penyewaan alat.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="product">
                                <div class="product-body text-center">
                                    <i class="fa fa-money" style="font-size:45px;"></i>
                                    <h4>Pembayaran</h4>
                                    <p>Upload bukti pembayaran manual.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="product">
                                <div class="product-body text-center">
                                    <i class="fa fa-clock-o" style="font-size:45px;"></i>
                                    <h4>Pengembalian</h4>
                                    <p>Sistem menghitung countdown dan denda keterlambatan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							<p>Bergabung untuk <strong>Kabar Terbaru</strong></p>
							<form>
								<input class="input" type="email" placeholder="Enter Your Email">
								<button class="newsletter-btn"><i class="fa fa-envelope"></i> Bergabung</button>
							</form>
							<ul class="newsletter-follow">
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-instagram"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /NEWSLETTER -->

		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Tentang Kami</h3>
								<p>Sewa alat fotografi jadi lebih mudah, aman, dan transparan di Lens.</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>Gandaria, Jakarta Selatan</a></li>
									<li><a href="#"><i class="fa fa-phone"></i>+62 851 5521 2362</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>lens@gmail.com</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Kategori</h3>
								<ul class="footer-links">
                                    <a href="{{ route('catalog', ['category' => 1]) }}">Kamera</a>
                                    <a href="{{ route('catalog', ['category' => 2]) }}">Lensa</a>
                                    <a href="{{ route('catalog', ['category' => 3]) }}">Drone</a>
                                    <a href="{{ route('catalog', ['category' => 4]) }}">Lighting</a>
                                    <a href="{{ route('catalog', ['category' => 5]) }}">Tripod</a>
                                    <a href="{{ route('catalog', ['category' => 6]) }}">Aksesoris</a>
                                </ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Informasi</h3>
								<ul class="footer-links">
                                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                                    <li><a href="{{ route('about') }}">Kontak Kami</a></li>
                                    <li><a href="{{ route('about') }}">Kebijakan Privasi</a></li>
                                    <li><a href="{{ route('about') }}">Sewa & Pengembalian</a></li>
                                    <li><a href="{{ route('about') }}">Syarat & Ketentuan</a></li>
                                </ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Layanan</h3>
								<ul class="footer-links">
                                    @auth
                                        <li><a href="{{ route('my.profile') }}">Profil Saya</a></li>
                                        <li><a href="{{ route('booking.my') }}">Pesanan Saya</a></li>
                                        <li><a href="{{ route('booking.history') }}">Riwayat Penyewaan</a></li>
                                    @else
                                        <li><a href="{{ route('login') }}">Masuk</a></li>
                                        <li><a href="{{ route('register') }}">Daftar</a></li>
                                    @endauth

                                    <li><a href="{{ route('catalog') }}">Katalog Alat</a></li>
                                </ul>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/slick.min.js') }}"></script>
        <script src="{{ asset('js/nouislider.min.js') }}"></script>
        <script src="{{ asset('js/jquery.zoom.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>

	</body>
</html>
