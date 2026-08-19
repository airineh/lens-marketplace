<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Lens - Marketplace Penyewaan Alat Fotografi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link
            href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700"
            rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/slick.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>

    </head>

    <body>
        <header>
            <div id="top-header">
                <div class="container">
                    <ul class="header-links pull-left">
                        <li>
                            <a href="#">
                                <i class="fa fa-phone"></i>
                                +62 851 5521 2362</a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-envelope-o"></i>
                                lens@gmail.com</a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-map-marker"></i>
                                Gandaria, Jakarta Selatan</a>
                        </li>
                    </ul>

                    <ul class="header-links pull-right">
                        @auth
                        <li>
                            <a href="{{ route('my.profile') }}">
                                <i class="fa fa-user-o"></i>
                                Profil Saya
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:none; border:none; color:#fff;">
                                    Logout
                                </button>
                            </form>
                        </li>
                        @else
                        <li>
                            <a href="{{ route('login') }}">
                                <i class="fa fa-user-o"></i>
                                Masuk</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>

           <div id="header">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="header-logo">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('img/lens02.png') }}" alt="Lens">
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="header-search">
                    <form action="{{ route('catalog') }}" method="GET">
                        <input class="input"
                               type="text"
                               name="search"
                               placeholder="Cari alat fotografi"
                               value="{{ request('search') }}">

                        <button class="search-btn" type="submit">Cari</button>
                    </form>
                </div>
            </div>

            <div class="col-md-3 clearfix">
                <div class="header-ctn">
                    @auth
                        <div>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-user-o"></i>
                                <span>Dashboard</span>
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('register') }}">
                                <i class="fa fa-user-plus"></i>
                                <span>Daftar</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>
</header>

<nav id="navigation">
    <div class="container">
        <div id="responsive-nav">
            <ul class="main-nav nav navbar-nav">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('catalog') }}">Katalog</a>
                </li>
                <li>
                    <a href="{{ route('about') }}">Tentang</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

        @yield('content')

        <footer id="footer">
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="footer">
                                <h3 class="footer-title">Tentang Lens</h3>
                                <p>Marketplace penyewaan alat fotografi berbasis web.</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="footer">
                                <h3 class="footer-title">Menu</h3>
                                <ul class="footer-links">
                                    <li>
                                        <a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('catalog') }}">Katalog</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('about') }}">Tentang</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="footer">
                                <h3 class="footer-title">Kontak</h3>
                                <ul class="footer-links">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-phone"></i>
                                            +62 851 5521 2362</a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-envelope-o"></i>
                                            lens@gmail.com</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/slick.min.js') }}"></script>
        <script src="{{ asset('js/nouislider.min.js') }}"></script>
        <script src="{{ asset('js/jquery.zoom.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>