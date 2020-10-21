<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function onConstruct(){
        $headerCollection = $this->assets->collection('header');
        $headerCollection->addCss('css/animate.css');
        $headerCollection->addCss('css/icomoon.css');
        $headerCollection->addCss('css/themify-icons.css');
        $headerCollection->addCss('css/bootstrap.css');
        $headerCollection->addCss('css/magnific-popup.css');
        $headerCollection->addCss('css/bootstrap-datetimepicker.min.css');
        $headerCollection->addCss('css/owl.carousel.min.css');
        $headerCollection->addCss('css/owl.theme.default.min.css');
        $headerCollection->addCss('css/style.css');
        $headerCollection->addCss('css/index.css');
        $headerCollection->addCss('css/phantrang.css');
        $headerCollection->addCss('css/codinhmenu.css');

        $footerCollection = $this->assets->collection('footer');
        $footerCollection->addJs('js/modernizr-2.6.2.min.js');
        $footerCollection->addJs('js/respond.min.js');
        $footerCollection->addJs('js/jquery.min.js');
        $footerCollection->addJs('js/jquery.easing.1.3.js');
        $footerCollection->addJs('js/codinh.js');
        $footerCollection->addJs('js/bootstrap.min.js');
        $footerCollection->addJs('js/jquery.waypoints.min.js');
        $footerCollection->addJs('js/owl.carousel.min.js');
        $footerCollection->addJs('js/jquery.countTo.js');
        $footerCollection->addJs('js/jquery.stellar.min.js');
        $footerCollection->addJs('js/jquery.magnific-popup.min.js');
        $footerCollection->addJs('js/magnific-popup-options.js');
        $footerCollection->addJs('js/moment.min.js');
        $footerCollection->addJs('js/bootstrap-datetimepicker.min.js');
        $footerCollection->addJs('js/main.js');
        $footerCollection->addJs('js/index.js');
        $footerCollection->addJs('js/giohang.js');
        $footerCollection->addJs('js/menu.js');
        $footerCollection->addJs('js/wow.min.js');
        $footerCollection->addJs('js/custom.js');

    }
}
