var submitbutton = '';

$(document).ready(function() {
    $("button[type='submit']").click(function() {
        submitbutton = $(this).val();
    });

    $("#form-account").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('button', submitbutton);

        if(submitbutton == 'submit') {
            // form submitting
            $.ajax({
                method: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(resp) {
                    location.reload();
                },
                error: function(resp) {
                    var errors = resp.responseJSON.errors;

                    if(errors.hasOwnProperty('c_email')) {
                        showFormError('#input_email', errors.c_email[0]);
                    } else {
                        hideFormError('#input_email');
                    }

                    /*
                    if(errors.hasOwnProperty('c_avatarlink')) {
                        console.log(errors.c_avatarlink[0]);
                    }*/
                }
            });
        } else {
            // removing avatar
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(resp) {
                    if(resp == "success") {
                        location.reload();
                    }
                }
            });
        }
    });
});