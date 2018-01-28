$(document).ready(function() {
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
            error: function(err) {
                var errors = resp.responseJSON.errors;

                if(errors.hasOwnProperty('c_szoveg')) {
                    console.log(errors.c_szoveg[0]);
                }
            }
        });
    });
});