/*
credits: jazio.net
v. 1.0
*/
(function($){
    var APP = window.APP || {};
    /**
     * Menu smooth scrolling
     * @return {[type]} [description]
     */
     APP.smoothScroll = function (menu) {
        $(menu).click(function(e) {
            e.preventDefault();
            $('html,body').scrollTo(this.hash, this.hash);
        });

    }
    /**
     * [backTop description]
     * @return {[type]} [description]
     */
    APP.backTop = function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('#back-top a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

    }
    /**
     * Modalbox for image thumbnails
     * @return {[type]} [description]
     */
     APP.modalBox = function (width, height, speed, theme) {
        $("a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: speed,
            theme: theme,
            slideshow:3000, 
            //autoplay_slideshow: true,
            default_width: width,
            default_height: height,
            keyboard_shortcuts: true, //Set to false if you open forms inside prettyPhoto
            social_tools: '' /* html or false to disable */
        });
    }
    /**
     * Google Maps
     * [googleMapsInitialize description]
     * @return {[type]} [description]
     */
     APP.googleMapsInitialize = function (canvas, latitude, longitude, zoom_factor, info) {
        var map_canvas = document.getElementById(canvas);
        var map_options = {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: zoom_factor,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(map_canvas, map_options)

        var marker = new google.maps.Marker({    
            position: new google.maps.LatLng(latitude, longitude), 
            map: map
        });
        var infowindow = new google.maps.InfoWindow({
            content: info
        });

        infowindow.open(map,marker);
    }

    //runtime
    APP.smoothScroll(menu = ".nav a");
    $("#back-top").hide();
    APP.backTop();
    APP.modalBox(width = 800, height = 744, speed = 'normal', theme = 'facebook');
    APP.googleMapsInitialize(canvas = 'mapCanvas', latitude = 48.66088, longitude = -72.43883, zoom_factor = 10, info = "MyCompany<br/> 1265 Charlerois G3K 1P2");
    google.maps.event.addDomListener(window, 'load', initialize);

})(jQuery);