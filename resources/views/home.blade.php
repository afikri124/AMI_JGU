<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>AMI-JGU</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/img/favicon.ico" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets-landing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets-landing/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets-landing/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets-landing/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets-landing/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets-landing/css/main.css" rel="stylesheet">
</head>

<body class="index-page mobile-nav-active" data-aos-easing="ease-in-out" data-aos-duration="600" data-aos-delay="0">
    <header id="header" class="header fixed-top"></header>
    <div class="branding d-flex align-items-center">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="assets-landing/img/logo-white.png" height="55"
                        width="115" />
                </a>
                <nav id="navmenu" class="navmenu">
                    @if (Route::has('login'))
                    <div class="pt-0 text-right">
                        @auth
                        <a href="{{ url('/dashboard') }}"
                            class="p-0">
                            <button type="button" class="btn btn-danger" class="active">Dashboard</button></a>
                        @else
                        <a href="{{ route('login') }}"
                            class="p-0">
                            <button type="button" class="btn btn-danger" class="active">Login </button></a>
                        @endauth
                    </div>
                    @endif
                    <i class="mobile-nav-toggle d-none"></i>
                </nav>
            </div>
        </nav>

    </div>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <img src="assets-landing/img/hero-bg.jpg" alt="" data-aos="fade-in">

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-start">
                    <div class="col-lg-8">
                        <div class="background">
                            <div class="animated-text-box">
                                <h1><b>WELCOME TO</b></h1>
                                <h2>
                                    <div class="nprinsley-text-redan"><b>AUDIT MUTU INTERNAL</b></div>
                                </h2>
                            </div>
                        </div>
                        </h1>
                        <br>

                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets-landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets-landing/vendor/php-email-form/validate.js"></script>
    <script src="assets-landing/vendor/aos/aos.js"></script>
    <script src="assets-landing/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets-landing/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets-landing/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets-landing/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets-landing/js/main.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.prinsh.com/NathanPrinsley-textstyle/nprinsh-stext.css" />

</body>

</html>
