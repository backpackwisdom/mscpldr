$(document).ready(function() {
    // audio input handling
    $('input[name="c_szam"]').change(function() {
        var fileSize = (((this.files[0].size) / 1024).toFixed(2) / 1024).toFixed(2);

        // file size validation
        if(fileSize > 20) {
            $('button[type="submit"]').attr('disabled', true);
            showFormError('#track', 'The track must not be larger than 20 MBs.');
        } else {
            $('button[type="submit"]').removeAttr('disabled');
            hideFormError('#track');
        }

        // adding remove button
        $('#track .row div').removeClass('col-lg-12');
        $('#track .row div').addClass('col-lg-11 col-11-corr');
        $('#track .row').append('' +
            '<div class="col-lg-1 col-md-1 col-1-corr">' +
                '<button class="btn btn-outline-danger" type="button" name="remove-track">X</button>' +
            '</div>');
    });

    // image input handling
    var _URL = window.URL || window.webkitURL;

    $('input[name="c_borito"]').change(function() {
        var file, img;
        // check if input is empty
        if((file = this.files[0])) {
            img = new Image();
            img.onload = function() {
                // checking width and height
                if(this.width < 500 || this.height < 500) {
                    $('button[type="submit"]').attr('disabled', true);
                    showFormError('#cover', 'The cover must be at least 500x500 pixels.');
                } else {
                    var fileSize = ((($('input[name="c_borito"]')[0].files[0].size) / 1024).toFixed(2) / 1024).toFixed(2);

                    // check file size
                    if(fileSize > 5) {
                        $('button[type="submit"]').attr('disabled', true);
                        hideFormError('#cover'); // hide error if there's any before
                        showFormError('#cover', 'The cover must not be larger than 5 MBs.');
                    } else {
                        $('button[type="submit"]').removeAttr('disabled');
                        hideFormError('#cover');

                        // display thumbnail
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('img[src="#"]').attr('src', e.target.result);
                            $('img').removeAttr('hidden');
                        };

                        reader.readAsDataURL($('input[name="c_borito"]')[0].files[0]);
                    }
                }
            };
            img.src = _URL.createObjectURL(file);
        }

        // adding remove button
        $('#cover').append('<button class="btn btn-outline-danger" type="button" name="remove-cover">X</button>');
    });

    // track removing button
    $('#track').on('click', "button[name='remove-track']", function() {
        hideFormError('#track'); // hide form error if there's any
        $('button[type="submit"]').attr('disabled', true);
        $("input[name='c_szam']").val("");
        $(this).parent().remove();
        $(this).remove();
        $('#track .row div').removeClass('col-lg-11 col-11-corr');
        $('#track .row div').addClass('col-lg-12');
    });

    // cover removing button
    $('#cover').on('click', "button[name='remove-cover']", function() {
        $('img').hide();
        $('img').attr('src', '#');
        $("input[name='c_borito']").val("");
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
                    window.location = redirect_to;
                }
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_cim')) {
                    showFormError('#input_cim', errors.c_cim[0]);
                } else {
                    hideFormError('#input_cim');
                }

                if(errors.hasOwnProperty('c_eloado')) {
                    showFormError('#input_eloado', errors.c_eloado[0]);
                } else {
                    hideFormError('#input_eloado');
                }

                if(errors.hasOwnProperty('c_album')) {
                    showFormError('#input_album', errors.c_album[0]);
                } else {
                    hideFormError('#input_album');
                }

                if(errors.hasOwnProperty('n_kiadev')) {
                    showFormError('#input_kiadev', errors.n_kiadev[0]);
                } else {
                    hideFormError('#input_kiadev');
                }
            }
        });
    });
});