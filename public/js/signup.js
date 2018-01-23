$(document).ready(function() {
    $('#form-signup').submit(function(e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: url,
            data: $(this).serialize(),
            success: function(resp) {
                if(resp == "success") {
                    window.location.href = base_url;
                }
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_email')) {
                    console.log(errors.c_email[0]);
                }

                if(errors.hasOwnProperty('c_username')) {
                    console.log(errors.c_username[0]);
                }

                if(errors.hasOwnProperty('c_password')) {
                    console.log(errors.c_password[0]);
                }

                if(errors.hasOwnProperty('c_passconf')) {
                    console.log(errors.c_passconf[0]);
                }
            }
        });
    });
});