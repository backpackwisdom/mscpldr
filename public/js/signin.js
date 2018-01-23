$(document).ready(function() {
    $('#form-signin').submit(function(e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: url,
            data: $(this).serialize(),
            success: function(resp) {
                window.location.href = 'dashboard';
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_username')) {
                    console.log(errors.c_username[0]);
                }

                if(errors.hasOwnProperty('c_password')) {
                    console.log(errors.c_password[0]);
                }
            }
        });
    });
});