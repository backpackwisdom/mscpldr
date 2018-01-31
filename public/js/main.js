// popping up confirm message
function confirmMessage($message) {
    return confirm($message);
}

// setting temporary URL
function setTempURL(input, appendTo) {
    if(input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $(appendTo).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// checking if file to upload is too large
function checkInputFilesize(input, limit) {
    var fileSize = (((input.files[0].size) / 1024).toFixed(2) / 1024).toFixed(2);

    if(fileSize >= limit) {
        return true;
    }

    return false;
}

// show form error messages
function showFormError(id, msg) {
    if(!($(id).find('p').length)) {
        var msg_username = '<p class="error-msg">' + msg +'</p>';
        $(id).append(msg_username);
        $(id).find('.form-control').addClass('is-invalid');
    }
}

// hide form error messages
function hideFormError(id) {
    $(id).find('p').remove();
    $(id).find('.form-control').removeClass('is-invalid');
}