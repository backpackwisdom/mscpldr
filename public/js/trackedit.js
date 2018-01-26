var removeButton = '<button type="button" name="remove-cover">X</button>';
var avatarChanged = false;

if(coverName != 'nocover.jpg') {
    $('#cover').append(removeButton);
}

$(document).ready(function() {
    // input - avatar - remove button handling
    $('input[name="c_borito"]').change(function() {
        var imageHidden = $('img').is('[hidden]');
        var inputValue = $(this).val();
        var isInputLarge = checkInputFilesize(this, 8);

        if(inputValue != '') {
            var isSubmitDisabled = $('button[type="submit"]').is('[disabled]');

            if(!isInputLarge) {
                if(isSubmitDisabled) {
                    $('button[type="submit"]').removeAttr('disabled');
                }

                if(imageHidden) {
                    $('img').removeAttr('hidden');
                    $('#cover').append(removeButton);
                } else {
                    $('img').attr('src', '#');
                }

                setTempURL(this, 'img[src="#"]');
                avatarChanged = true;
            } else {
                $('button[type="submit"]').prop('disabled', true);
                console.log('Your cover must be smaller than 8 MBs.');
            }
        }
    });

    // removing chosen cover
    $('#cover').on('click', "button[name='remove-cover']", function() {
        $('img').attr('hidden', true);
        $('img').attr('src', '#');
        $("input[name='c_borito']").val("");
        $(this).remove();
        avatarChanged = true;
    });

    // submitting form
    $('#form-edit-track').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('avatar-changed', avatarChanged);

        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                if(resp == "success") {
                    window.location = redirect_to;
                }
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_cim')) {
                    console.log(errors.c_cim[0]);
                }

                if(errors.hasOwnProperty('c_eloado')) {
                    console.log(errors.c_eloado[0]);
                }

                if(errors.hasOwnProperty('c_album')) {
                    console.log(errors.c_album[0]);
                }

                if(errors.hasOwnProperty('n_kiadev')) {
                    console.log(errors.n_kiadev[0]);
                }
            }
        });
    });
});