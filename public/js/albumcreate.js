$(document).ready(function() {
    // for filtering tracks
    var filterInput = document.getElementById('input-filter-list');

    filterInput.addEventListener('keyup', function() {
        var filterValue = document.getElementById('input-filter-list').value.toUpperCase();
        var ul = document.getElementById('tracks');
        var li = ul.querySelectorAll('li.list-group-item');

        for(var i = 0; i < li.length; i++) {
            if(li[i].innerHTML.toUpperCase().indexOf(filterValue) > -1) {
                li[i].style.display = '';
            } else {
                li[i].style.display = 'none';
            }
        }
    });

    // highlighting + checkbox handling
    $('li.list-group-item').click(function() {
        if(!($(this).hasClass('active'))) {
            $(this).addClass('active');
            $(this).find('input').attr('checked', true);
            $(this).append($('<i class="fas fa-check"></i>').hide().fadeIn(300));
        } else {
            $(this).removeClass('active');
            $(this).find('input').removeAttr('checked');
            $(this).find('i').fadeOut(300).remove();
        }
    });

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

            $('img').fadeIn(1000);
            setTempURL(this, "img[src='#']");
        }

        $('#cover').append('<button class="btn btn-outline-danger" type="button" name="remove-cover">X</button>');
    });

    // removing chosen cover
    $('#cover').on('click', "button[name='remove-cover']", function() {
        $('button[type="submit"]').removeAttr('disabled');
        $('img').fadeOut(1000);
        $('img').attr('src', '#');
        $("input[name='c_borito']").val("");
        $(this).remove();
    });

    // form submitting
    $('#form-create-album').submit(function(e) {
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

                if(errors.hasOwnProperty('c_albumszamok')) {
                    showFormErrorNotInput('#select_albumszamok', errors.c_albumszamok[0]);
                } else {
                    hideFormErrorNotInput('#select_albumszamok');
                }

                if(errors.hasOwnProperty('c_albumnev')) {
                    showFormError('#input_albumnev', errors.c_albumnev[0]);
                } else {
                    hideFormError('#input_albumnev');
                }

                if(errors.hasOwnProperty('c_eloado')) {
                    showFormError('#input_eloado', errors.c_eloado[0]);
                } else {
                    hideFormError('#input_eloado');
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
