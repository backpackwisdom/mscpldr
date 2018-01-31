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