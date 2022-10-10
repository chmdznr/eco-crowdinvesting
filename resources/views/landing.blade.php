<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title>Eco - Crowd Investing</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Eco Crowd Investing" />
        <meta name="keywords" content="Eco, Crowd, Investing" />
        <meta content="Themesdesign" name="author" />

        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('landing/images/eco.png') }}" />

        <!-- Bootstrap css-->
        <link href="{{ asset('landing/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Materialdesign icon-->
        <link rel="stylesheet" href="{{ asset('landing/css/materialdesignicons.min.css') }}" type="text/css" />

        <!-- Swiper Slider css -->
        <link rel="stylesheet" href="{{ asset('landing/css/swiper-bundle.min.css') }}" type="text/css" />

        <!-- Custom Css -->
        <link href="{{ asset('landing/css/style.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- colors -->
        <link href="{{ asset('landing/css/colors/default.css') }}" rel="stylesheet" type="text/css" id="color-opt" />

    </head>

    <body data-bs-spy="scroll" data-bs-target="#navbar-navlist" data-bs-offset="60">

        <!--start page Loader -->
        <div id="preloader">
            <div id="status">
                <div class="load">
                    <hr />
                    <hr />
                    <hr />
                    <hr />
                </div>
            </div>
        </div>
        <!--end page Loader -->

        <!-- START NAVBAR -->
        <nav id="navbar" class="navbar navbar-expand-lg fixed-top sticky">
            <div class="container">
                <a class="navbar-brand" href="javascript:void();"><img src="{{ asset('landing/images/eco-logo.png') }}" alt="" height="23"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="mdi mdi-menu text-muted"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbar-navlist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    </ul>
                </div>
                <!--end collapse-->
            </div>
            <!--end container-->
        </nav>
        <!-- END NAVBAR -->

        <!-- START HOME -->
        <section class="bg-home4 overflow-hidden" id="home">
            <div class="container">
                <div class="position-relative" style="z-index: 1;">
                    <div class="row align-items-center">
                        <div class="col-xl-5 col-lg-6">
                            <div>
                                <h6 class="home-subtitle text-primary mb-4">Matchhing Fund</h6>
                                <h1>Eco - Crowd Investing</h1>
                                <p class="text-black-50 fs-17 pt-4">Teknologi UMKM (Digital Economy) memanfaatkan energi hijau ramah lingkungan (Green Economy)
                                  dengan menggunakan platform crowdsourcing, arsitektur microservices dan machine learning.
                                </p>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6 offset-xl-1">
                            <div class="mt-lg-0 mt-5">
                                <img src="{{ asset('landing/images/work-2.png') }}" alt="home04" class="home-img">
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end container-->
        </section>
        <div class="position-relative">
            <div class="shape overflow-hidden text-white position-absolute">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 100%;" height="250" preserveAspectRatio="none"
                    viewBox="0 0 1440 250">
                    <g mask="url(&quot;#SvgjsMask1006&quot;)" fill="none">
                        <path d="M 0,246 C 288,210 1152,102 1440,66L1440 250L0 250z" fill="rgba(255, 255, 255, 1)"></path>
                    </g>
                    <defs>
                        <mask id="SvgjsMask1006">
                            <rect width="1440" height="250" fill="#ffffff"></rect>
                        </mask>
                    </defs>
                </svg>
            </div>
        </div>
        <!-- END HOME -->

        <!-- START FEATURES -->
        <section class="section" id="features">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mb-5">
                            <h3>Product Features</h3>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="feature-box card border-0 mt-3">
                            <div class="card-body">
                                <div class="feature-icon mx-auto">
                                    <i class="mdi mdi-leaf"></i>
                                </div>
                                <div class="mt-4">
                                    <h6 class="mb-3 fs-17">Sistem Penggalangan Investasi Hijau & Verifikasi Digital</h6>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end feature-box-->
                    </div>
                    <!--end col-->

                    <div class="col-lg-6 col-md-6">
                        <div class="feature-box card border-0 mt-3">
                            <div class="card-body">
                                <div class="feature-icon mx-auto">
                                    <i class="mdi mdi-receipt"></i>
                                </div>
                                <div class="mt-4">
                                    <h6 class="mb-3 fs-17">Sistem Kelayakan Pembiayaan</h6>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end feature-box-->
                    </div>
                    <!--end col-->

                    <div class="col-lg-6 col-md-6">
                        <div class="feature-box card border-0 mt-3">
                            <div class="card-body">
                                <div class="feature-icon mx-auto">
                                    <i class="mdi mdi-security"></i>
                                </div>
                                <div class="mt-4">
                                    <h6 class="mb-3 fs-17">Sistem Pengawasan Pembayaran Pembiayaan & Keamanan Pembayaran</h6>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end feature-box-->
                    </div>
                    <!--end col-->

                    <div class="col-lg-6 col-md-6">
                        <div class="feature-box card border-0 mt-3">
                            <div class="card-body">
                                <div class="feature-icon mx-auto">
                                    <i class="mdi mdi-cloud-print-outline"></i>
                                </div>
                                <div class="mt-4">
                                    <h6 class="mb-3 fs-17">Sistem Pelaporan Digital</h6>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end feature-box-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>
        <!-- END FEATURES -->

        <!-- Style switcher -->
        <div id="style-switcher" onclick="toggleSwitcher()" style="left: -189px;">
            <div>
                <h6>Select your color</h6>
                <ul class="pattern list-unstyled mb-0">
                    <li>
                        <a class="color1" href="javascript: void(0);" onclick="setColor('default')"></a>
                    </li>
                    <li>
                        <a class="color2" href="javascript: void(0);" onclick="setColor('success')"></a>
                    </li>
                    <li>
                        <a class="color3" href="javascript: void(0);" onclick="setColor('warning')"></a>
                    </li>
                    <li>
                        <a class="color4" href="javascript: void(0);" onclick="setColor('orange')"></a>
                    </li>
                    <li>
                        <a class="color5" href="javascript: void(0);" onclick="setColor('info')"></a>
                    </li>
                    <li>
                        <a class="color6" href="javascript: void(0);" onclick="setColor('purple')"></a>
                    </li>
                </ul>
            </div>
            <div class="bottom">
                <a href="javascript: void(0);" class="settings rounded-end"><i class="mdi mdi-cog mdi-spin"></i></a>
            </div>
        </div>
        <!-- end switcher-->

        <!--start back-to-top-->
        <button onclick="topFunction()" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->


        <!-- Bootstrap Bundale js -->
        <script src="{{ asset('landing/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Swiper Slider js -->
        <script src="{{ asset('landing/js/swiper-bundle.min.js') }}"></script>

        <!-- Contact Js -->
        <script src="{{ asset('landing/js/contact.js') }}"></script>

        <!-- Index-init Js -->
        <script src="{{ asset('landing/js/index.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('landing/js/app.js') }}"></script>
    </body>

</html>