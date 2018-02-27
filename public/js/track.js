$(document).ready(function() {
    // enlarge cover
    $('#track-cover').click(function() {
        $('#track-cover-modal').show();
        $('#modal-image').attr('src', $(this).attr('src'));
    });

    // close cover
    $('span[class="close"]').click(function() {
        $('#track-cover-modal').hide();
    });

    // enable post creating
    $('button[name="post-create"]').click(function() {
        $(this).attr('disabled', true);
        $('#form-create-post').removeAttr('hidden');
    });

    // disable post creating
    $('button[name="post-cancel"]').click(function() {
        $('button[name="post-create"]').removeAttr('disabled');
        $('#form-create-post').attr('hidden', true);
    });

    // creating post
    $('#form-create-post').submit(function(e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: url_createpost,
            data: $(this).serialize(),
            success: function(resp) {
                if(resp == "success") {
                    location.reload();
                }
            },
            error: function(resp) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_szoveg')) {
                    showFormErrorNotInput('#textarea_body', errors.c_szoveg[0]);
                } else {
                    hideFormErrorNotInput('#textarea_body');
                }
            }
        });
    });
});