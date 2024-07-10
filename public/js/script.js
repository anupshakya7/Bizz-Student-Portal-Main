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
