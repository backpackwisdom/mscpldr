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
                    showFormError('#input_oldpass', errors.c_password_old[0]);
                } else {
                    hideFormError('#input_oldpass');
                }

                if(errors.hasOwnProperty('c_password_new')) {
                    showFormError('#input_newpass', errors.c_password_new[0]);
                } else {
                    hideFormError('#input_newpass');
                }

                if(errors.hasOwnProperty('c_passconf_new')) {
                    showFormError('#input_newpassconf', errors.c_passconf_new[0]);
                } else {
                    hideFormError('#input_newpassconf');
                }
            }
        });
    });
});