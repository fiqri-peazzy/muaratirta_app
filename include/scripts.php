<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="assets/slick/slick.js"></script>
<script src="assets/js/webticker.js"></script>
<script src="admin/src/plugins/sweetalert2/sweetalert2.all.js"></script>
<script src="assets/vendor/ijabocroptool/ijaboCropTool.min.js"></script>
<script src="admin/src/plugins/cropperjs/dist/cropper.min.js"></script>
<script src="admin/src/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>



<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script src="assets/js/chat.js"></script>
<script>
$(document).ready(function() {
    var header = $("#header");
    var sticky = header.offset().top;
    var logo = $('#logo');

    $(window).scroll(function() {
        if (window.pageYOffset > sticky) {
            header.addClass("sticky");
            logo.addClass("color-logo");
        } else {
            header.removeClass("sticky");
            logo.removeClass("color-logo");

        }
    });

    // Toggle mobile menu
    $(".mobile-nav-toggle").click(function() {
        $("#navbar").toggleClass("show");
    });

    $('.btn-header-login').click(function() {
        $('#loginModal').modal('show');

    });

    $('.close').click(function() {
        $('#loginModal').modal('hide');
    });
});
</script>