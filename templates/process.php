<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate form data
    if (empty($name) || empty($email) || empty($message)) {
        echo 'Please fill in all fields.';
        exit;
    }

    // Send email
    $to = 'your-email@example.com';
    $subject = 'New Contact Form Submission';
    $body = "Name: $name\nEmail: $email\nMessage: $message";

    if (mail($to, $subject, $body)) {
        echo 'Thank you for your message. We will get back to you soon.';
    } else {
        echo 'Oops! Something went wrong. Please try again later.';
    }
} else {
    echo 'Invalid request.';
    exit;
}
