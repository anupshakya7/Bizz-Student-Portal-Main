$(document).ready(function () {
    $(".equal_height").matchHeight();
    $(".equal_height_inner").matchHeight();
});

$(document).ready(function () {
    var $sidenav = $('.sidenav');
    var $hamburger = $('.hamburger');

    // Toggle sidebar on hamburger click
    $hamburger.click(function (e) {
        $sidenav.toggleClass('hovered');
        e.stopPropagation();
    });

    // Close sidebar when clicking outside
    $(document).click(function (e) {
        if (!$(e.target).closest('.sidenav_inner, .hamburger').length) {
            $sidenav.removeClass('hovered');
        }
    });

    // Hover effect for the sidebar
    $sidenav.hover(
        function () {
            $(this).addClass('hovered');
        },
        function () {
            $(this).removeClass('hovered');
        }
    );

     // Toggle dropdown menu
     $('.dropdown-toggle').click(function (e) {
        e.preventDefault();
        $(this).next('.dropdown-menu').toggleClass('show');
    });

    // Close dropdown menu when clicking outside
    $(document).click(function (e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });
});

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 0) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    });

    $('.navbar-toggler').click(function() {
        $(this).toggleClass('collapsed');
        var isOpen = $(this).attr('aria-expanded') === 'true';
        $(this).attr('aria-expanded', !isOpen);
        $('.navbar-collapse').collapse('toggle'); // Toggle the collapse state
    });

    // Close the menu when clicking outside of it
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.navbar').length && $('.navbar-collapse').hasClass('show')) {
            $('.navbar-toggler').addClass('collapsed');
            $('.navbar-toggler').attr('aria-expanded', 'false');
            $('.navbar-collapse').collapse('hide');
        }
    });
});