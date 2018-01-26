$(document).ready(function() {
    // the image is hidden by default
    var hiddenImage = $('img').is('[hidden]');

    // creating thumbnail + delete button for the chosen cover + not letting to upload large files
    $("input[name='c_borito']").change(function() {
        var fileSize = (((this.files[0].size) / 1024).toFixed(2) / 1024).toFixed(2);

        if(fileSize >= 8) {
            $('button[type="submit"]').prop('disabled', true);
            console.log('Your cover must be smaller than 8 MBs.');
        } else {
            if(hiddenImage == true) {
                $('img').removeAttr('hidden');
            }

            $('img').show();
            setTempURL(this, "img[src='#']");
        }

        $('#cover').append('<button type="button" name="remove-cover">X</button>');
    });

    // creating delete button for the chosen track + not letting to upload large files
    $("input[name='c_szam']").change(function() {
        var fileSize = (((this.files[0].size) / 1024).toFixed(2) / 1024).toFixed(2);

        if(fileSize >= 40) {
            $('button[type="submit"]').prop('disabled', true);
            console.log('Your song must be smaller than 40 MBs.');
        }

        $('#track').append('<button type="button" name="remove-track">X</button>')
    });

    // removing chosen cover
    $('#cover').on('click', "button[name='remove-cover']", function() {
        $('button[type="submit"]').removeAttr('disabled');
        $('img').hide();
        $('img').attr('src', '#');
        $("input[name='c_borito']").val("");
        $(this).remove();
    });

    // removing chosen track
    $('#track').on('click', "button[name='remove-track']", function() {
        $('button[type="submit"]').removeAttr('disabled');
        $("input[name='c_szam']").val("");
        $(this).remove();
    });

    // form validation
    $('#form-upload').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                if(resp == "success") {
                    console.log(resp);
                }
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_szam')) {
                    console.log(errors.c_szam[0]);
                }

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