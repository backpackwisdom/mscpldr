$(document).ready(function() {
    // sliding latest tracks
    $('.new-tracks').slick({
        infinite: true,
        slidesToShow: (count_tracks < 5) ? count_tracks : 5,
        slidesToScroll: 1
    });

    // sliding latest albums
    $('.new-albums').slick({
        infinite: true,
        slidesToShow: (count_albums < 5) ? count_albums : 5,
        slidesToScroll: 1
    });

    // sliding latest users
    $('.new-users').slick({
        infinite: true,
        slidesToShow: (count_users < 5) ? count_users : 5,
        slidesToScroll: 1
    });
});