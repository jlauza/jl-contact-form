<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
            <form id="contact-form" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function () { 
    $('#contact-form').submit(function (e) {
        e.preventDefault();
        alert('Form submitted!')
        // var form = $(this);
        // var post_url = form.attr('action');
        // var post_data = form.serialize();

        // $.ajax({
        //     // method: 'POST',
        //     type: 'POST',
        //     url: post_url,
        //     data: post_data,
        //     headers: {'X-WP-Nonce': "<?php echo wp_create_nonce('wp_rest'); ?>"},
        //     success: function (msg) {
        //         $(form).fadeOut(500, function () {
        //             form.html(msg).fadeIn();
        //         });
        //     }
        // });
    });
});
</script>

