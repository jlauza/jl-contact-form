$(document).ready(function () { 
    $('#contact-form').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        // var post_url = form.attr('action');
        var post_url = '<?php echo get_rest_url(null, "contact-form/v1/submit"); ?>';
        var post_data = form.serialize();

        console.log(post_url, post_data);
        $.ajax({
            // method: 'POST',
            type: 'POST',
            url: post_url,
            data: post_data,
            headers: {'X-WP-Nonce': "<?php echo wp_create_nonce('wp_rest'); ?>"},
            success: function (msg) {
                console.log(msg);
                $(form).fadeOut(500, function () {
                    form.html(msg).fadeIn();
                });
            }
        });
    });
});