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
                    showFormError('#input_email', errors.c_email[0]);
                } else {
                    hideFormError('#input_email');
                }

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

                if(errors.hasOwnProperty('c_passconf')) {
                    showFormError('#input_passconf', errors.c_passconf[0]);
                } else {
                    hideFormError('#input_passconf');
                }
            }
        });
    });
});