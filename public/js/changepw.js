$(document).ready(function() {
    $('#form-pw-change').submit(function(e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: url,
            data: $(this).serialize(),
            success: function(resp) {
                if(resp == "success") {
                    location.reload();
                }
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_password_old')) {
                    console.log(errors.c_password_old[0]);
                }

                if(errors.hasOwnProperty('c_password_new')) {
                    console.log(errors.c_password_new[0]);
                }

                if(errors.hasOwnProperty('c_passconf_new')) {
                    console.log(errors.c_passconf_new[0]);
                }
            }
        });
    });
});