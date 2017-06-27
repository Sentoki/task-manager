$(function() {
    $('#preview').click(function () {
        $('#preview_username').html($('#user_name').val());
        $('#preview_email').html($('#InputEmail').val());
        $('#preview_description').html($('#description').val());

        var preview = document.querySelector('img');
        var file    = document.querySelector('input[type=file]').files[0];
        var reader  = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        }
    });
});