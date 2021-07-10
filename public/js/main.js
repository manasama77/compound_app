// global variable
const site_url = $('#site_url').val();

$(window).on("load", function () {
    $('.preloader').fadeOut("slow");
});

$(document).ready(function () {
    // navbar shrink
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 90) {
            $('.navbar').addClass("navbar-shrink");
        } else {
            $('.navbar').removeClass("navbar-shrink");
        }
    });


    // video popup
    const videoSrc = $('#player-1').attr('src');

    $('.video-play-btn, .video-popup-close').on('click', function (e) {
        if ($('.video-popup').hasClass("open")) {
            $('.video-popup').removeClass("open");
            $('#player-1').attr('src', "");
        } else {
            $('.video-popup').addClass("open");

            if ($('#player-1').attr('src') == "") {
                $('#player-1').attr('src', videoSrc);
            }
        }
    });

    // owl carousel
    $('.team-carousel').owlCarousel({
        loop: false,
        margin: 300,
        padding: 300,
        autoplay: false,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 2,
            }
        }
    });

    $('.timeline-carousel').owlCarousel({
        loop: false,
        margin: 0,
        autoplay: false,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            }
        }
    });

    $('.timeline-carousel').owlCarousel({
        loop: false,
        margin: 0,
        autoplay: false,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            }
        }
    });

    $('.as-seen-carousel').owlCarousel({
        loop: true,
        margin: 20,
        autoplay: true,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            }
        }
    });

    // page scrollit
    $.scrollIt({
        topOffset: -50
    });

    // navbar colapse
    $('.nav-link').on('click', function () {
        $('.navbar-collapse').collapse("hide");
    });


    // toggle theme
    toggleTheme();
    $('.toggle-theme').on('click', function () {
        $("body").toggleClass("dark");

        if ($('body').hasClass("dark")) {
            localStorage.setItem("bioner-theme", "dark");
        } else {
            localStorage.setItem("bioner-theme", "light");
        }

        updateIcon();

    });

    $('#form_guestbook').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: site_url + 'guestbook/add',
            method: 'post',
            dataType: 'json',
            data: $('#form_guestbook').serialize(),
            beforeSend: function () {
                $.blockUI();
            }
        }).always(function () {
            $.unblockUI();
        }).fail(function (e) {
            console.log(e);
        }).done(function (e) {
            if (e.code == 500) {
                //error
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: `Proses submit Guestbook gagal, silahkan coba lagi`,
                    showConfirmButton: false,
                    timer: 3000,
                });
            } else if (e.code == 200) {
                // success
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: `Proses submit Guestbook berhasil, team kita akan membaca pesan dari kamu.`,
                    showConfirmButton: false,
                    timer: 3000,
                }).then(function () {
                    window.location.reload();
                });
            } else {
                //error unknown
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: `Unknown request`,
                    showConfirmButton: false,
                    timer: 3000,
                }).then(function () {
                    window.location.reload();
                });
            }
        });
    });

});

function showModalTokenDetail() {
    $('#bioner_token_detail').modal('show');
}

function toggleTheme() {
    if (localStorage.getItem("bioner-theme") != null) {
        if (localStorage.getItem("bioner-theme") === "dark") {
            $("body").addClass("dark");
        } else {
            $("body").removeClass("dark");
        }

    }
    updateIcon();
}

function updateIcon() {
    if ($('body').hasClass("dark")) {
        $(".toggle-theme i").removeClass("fa-moon");
        $(".toggle-theme i").addClass("fa-sun");
    } else {
        $(".toggle-theme i").removeClass("fa-sun");
        $(".toggle-theme i").addClass("fa-moon");
    }
}

function comingSoon() {
    Swal.fire({
        position: 'top-end',
        icon: 'info',
        title: `Coming Soon`,
        showConfirmButton: false,
        timer: 3000,
    });
}