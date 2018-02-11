$(document).ready(function() {
    // sliding latest tracks
    $('.all-tracks').slick({
        infinite: true,
        slidesToShow: (count_tracks < 5) ? count_tracks : 5,
        slidesToScroll: 1
    });

    // form validation
    $('#form-signin').submit(function(e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: url,
            data: $(this).serialize(),
            success: function(resp) {
                if(resp == "success") {
                    window.location = redirect_to;
                }
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_username')) {
                    showFormError('#input_username', errors.c_username[0]);
                } else {
                    hideFormError('#input_username');
                }

                if(errors.hasOwnProperty('c_password')) {
                    showFormError('#input_password', errors.c_password[0]);
                } else {
                    hideFormError('#input_password');
                }
            }
        });
    });
});