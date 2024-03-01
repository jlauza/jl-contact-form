$(document).ready(function () { 
    $('#contact-form').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var post_url = form.attr('action');
        var post_data = form.serialize();

        $.ajax({
            // method: 'POST',
            type: 'POST',
            url: post_url,
            data: post_data,
            headers: {'X-WP-Nonce': "<?php echo wp_create_nonce('wp_rest'); ?>"},
            success: function (msg) {
                $(form).fadeOut(500, function () {
                    form.html(msg).fadeIn();
                });
            }
        });
    });
});