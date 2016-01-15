/**
 * Created by Nashwa on 6/27/2015.
 */
$( document ).ready(function(){
    /*google.maps.event.addDomListener(window, 'load', initialize);*/

    //main menu
    $(".menu-link").click(function(){
        $("#menu").toggleClass("active");
        $(".container").toggleClass("active");
        $(".menu-link").toggleClass("close");
    });

    //navigation tabs for services

    $('#tab_links a').click(function(){
        $('#tab_links .highlight').removeClass('highlight'); // remove the class from the currently selected
        $(this).addClass('highlight'); // add the class to the newly clicked link
    });

    $('#datepicker').datepicker();

    $(function(){
        $(".element").typed({
            strings: ["Our experts hate making cakes and pastries.", "Beautiful women constitute a beautiful world."],
            typeSpeed: 0,
            loop: true
        });
    });

    $("#slideshow > div:gt(0)").hide();

    setInterval(function() {
        $('#slideshow > div:first')
            .fadeOut(1000)
            .next()
            .fadeIn(1000)
            .end()
            .appendTo('#slideshow');
    },  5000);

    /*slick slider*/
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
});