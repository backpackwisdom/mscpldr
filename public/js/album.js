// stop current track if another one is started
document.addEventListener('play', function(e){
    var audios = document.getElementsByTagName('audio');
    for(var i = 0, len = audios.length; i < len;i++){
        if(audios[i] != e.target){
            audios[i].pause();
        }
    }
}, true);

$(document).ready(function() {
    // enlarge cover
    $('#album-cover').click(function() {
        $('#album-cover-modal').show();
        $('#modal-image').attr('src', $(this).attr('src'));
    });

// close cover
    $('span[class="close"]').click(function() {
        $('#album-cover-modal').hide();
    });
});