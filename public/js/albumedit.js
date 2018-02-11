var removeButton = '<button type="button" name="remove-cover">X</button>';
var avatarChanged = false;

// append remove button if there's an album cover
if(coverName != 'nocover.jpg') {
    $('#cover').append(removeButton);
}

// highlight previous album tracks
$('li.list-group-item').each(function(i, elem) {
    var checked = (typeof $(elem).find('input').attr('checked') == 'undefined') ? false : true;

    if(checked == true) {
        $(this).addClass('active');
        $(this).append($('<i class="fas fa-check"></i>').hide().fadeIn(300));
    }
});

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
    $('#form-edit-album').submit(function(e) {
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

                if(errors.hasOwnProperty('c_albumszamok')) {
                    console.log(errors.c_albumszamok[0]);
                }

                if(errors.hasOwnProperty('c_albumnev')) {
                    console.log(errors.c_albumnev[0]);
                }

                if(errors.hasOwnProperty('c_eloado')) {
                    console.log(errors.c_eloado[0]);
                }

                if(errors.hasOwnProperty('n_kiadev')) {
                    console.log(errors.n_kiadev[0]);
                }
            }
        });
    });
});