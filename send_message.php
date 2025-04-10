<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // OPTIONAL: reCAPTCHA validation
    /*
    $recaptcha_secret = "YOUR_SECRET_KEY_HERE";
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
    $response_data = json_decode($verify);
    if (!$response_data->success) {
        echo "<p>reCAPTCHA verification failed. Please try again.</p>";
        exit;
    }
    */

    // Sanitize and collect form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    $to = "chrisg@reticleweb.com";
    $email_subject = "Contact Form Submission: " . ($subject ? $subject : "No Subject");

    $email_body = "You have received a new message from the contact form:\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "<p>Thank you for reaching out! We will get back to you soon.</p>";
    } else {
        echo "<p>Oops! Something went wrong, please try again later.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}
?>
