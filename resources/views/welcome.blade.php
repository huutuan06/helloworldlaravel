<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($obj))
        @if($obj)
            <title>{{$obj->title}}</title>
            <meta name="title" content="{{ $obj->title }}"/>
            <meta name="referrer" content="always">
            <meta name="description" itemprop='description' content='{{$obj->description}}' />
            <meta name="keywords" content="{{ $obj->keywords }}" />
            <meta name="author" content="{{ $obj->author }}" />
            <meta name="theme-color" content="{{ $obj->theme_color }}">

            <meta property="og:title" content="{{ $obj->og_title }}"/>
            <meta property="og:image" content="{{ $obj->og_image }}"/>
            <meta property="og:url" content="{{ $obj->og_url }}"/>
            <meta property="og:site_name" content="{{ $obj->og_site_name }}"/>
            <meta property="og:description" content="{{ $obj->og_description }}"/>
            <meta property="fb:app_id" content="{{ $obj->fb_app_id }}"/>

            <meta name="twitter:card" content="{{ $obj->twitter_card }}" />
            <meta name="twitter:title" content="{{ $obj->twitter_title }}" />
            <meta name="twitter:description" content="{{ $obj->twitter_description }}" />
            <meta name="twitter:image" content="{{ $obj->twitter_image }}" />
            <meta name="twitter:url" content="{{ $obj->twitter_url }}" />
            <meta name="parsely-link" content="{{ $obj->parsely_link }}">
        @endif
    @endif
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!--
    CSS
    ============================================= -->
    <link href="{{ URL::asset('front/css/linearicons.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('front/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('front/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('front/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('front/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('front/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('front/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('front/css/main.css') }}" rel="stylesheet">
</head>
<body>

<header id="header" id="home">
    <div class="container">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="index.html"><img src="img/logo.png" alt="" title=""/></a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#fact">Fact</a></li>
                    <li><a href="#price">Price</a></li>
                    <li><a href="#course">Course</a></li>
                    <li class="menu-has-children"><a href="">Pages</a>
                        <ul>
                            <li><a href="generic.html">Generic</a></li>
                            <li><a href="elements.html">Elements</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </div>
</header><!-- #header -->


<!-- start banner Area -->
<section class="banner-area" id="home">
    <div class="container">
        <div class="row fullscreen d-flex align-items-center justify-content-start">
            <div class="banner-content col-lg-7">
                <h5 class="text-white text-uppercase">Author: Travor James</h5>
                <h1 class="text-uppercase">
                    New Adventure
                </h1>
                <p class="text-white pt-20 pb-20">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp <br> or incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim.
                </p>
                <a href="#" class="primary-btn text-uppercase">Buy Now for $9.99</a>
            </div>
            <div class="col-lg-5 banner-right">
                <img class="img-fluid" src="img/header-img.png" alt="">
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->

<!-- Start about Area -->
<section class="section-gap info-area" id="about">
    <div class="container">
        <div class="single-info row mt-40 align-items-center">
            <div class="col-lg-6 col-md-12 text-center no-padding info-left">
                <div class="info-thumb">
                    <img src="<?php if(isset($book)) echo $book->image; ?>" class="img-fluid info-img" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-12 no-padding info-rigth">
                <div class="info-content">
                    <h2 class="pb-30"><?php if(isset($book)) echo $book->author; ?></h2>
                    <?php if(isset($obj)) echo $obj->description; ?>
                    <br>
                    <img src="img/signature.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End about Area -->

<!-- Start Generic Area -->
<section class="about-generic-area section-gap">
    <div class="container border-top-generic">
        <h3 class="about-title mb-30">Elaboration about Generic Page</h3>
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if (isset($book->description)) {
                        $doc = new DOMDocument();
                        $doc->loadHTML($book->description);
                        echo preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML()));
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- End Generic Start -->

<!-- start footer Area -->
<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h6>About Us</h6>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore dolore magna aliqua.
                    </p>
                    <p class="footer-text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved | This template is made with <i class="fa fa-heart-o"
                                                                            aria-hidden="true"></i> by <a
                                href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
            <div class="col-lg-5  col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h6>Newsletter</h6>
                    <p>Stay update with our latest</p>
                    <div class="" id="mc_embed_signup">
                        <form target="_blank" novalidate="true"
                              action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                              method="get" class="form-inline">
                            <input class="form-control" name="EMAIL" placeholder="Enter Email"
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '"
                                   required="" type="email">
                            <button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right"
                                                                         aria-hidden="true"></i></button>
                            <div style="position: absolute; left: -5000px;">
                                <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                            </div>

                            <div class="info"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 social-widget">
                <div class="single-footer-widget">
                    <h6>Follow Us</h6>
                    <p>Let us be social</p>
                    <div class="footer-social d-flex align-items-center">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-dribbble"></i></a>
                        <a href="#"><i class="fa fa-behance"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End footer Area -->

<script src="{{ URL::asset('front/js/vendor/jquery-2.2.4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="{{ URL::asset('front/js/vendor/bootstrap.min.js') }}"></script>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
<script src="{{ URL::asset('front/js/easing.min.js') }}"></script>
<script src="{{ URL::asset('front/js/hoverIntent.js') }}"></script>
<script src="{{ URL::asset('front/js/superfish.min.js') }}"></script>
<script src="{{ URL::asset('front/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ URL::asset('front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ URL::asset('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('front/js/jquery.sticky.js') }}"></script>
<script src="{{ URL::asset('front/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ URL::asset('front/js/parallax.min.js') }}"></script>
<script src="{{ URL::asset('front/js/waypoints.min.js') }}"></script>
<script src="{{ URL::asset('front/js/jquery.counterup.min.js') }}"></script>
<script src="{{ URL::asset('front/js/mail-script.js') }}"></script>
<script src="{{ URL::asset('front/js/main.js') }}"></script>
</body>
</html>



