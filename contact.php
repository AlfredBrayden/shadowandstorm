<?php include('header.php'); ?>

<title>Contact Us</title>
<meta name="description"
    content="Contact Shadow & Storm for inquiries or feedback. We value your thoughts and creativity." />
<!-- reCAPTCHA script is kept, but currently unused -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<?php include('nav.php'); ?>

<div class="single-page-bg track-page">
    <div class="container">
        <section class="signal-page">
            <h1>Contact Us</h1>

            <form action="" method="post">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject (Optional)</label>
                <select id="subject" name="subject">
                    <option value="">Select a Subject</option>
                    <option value="Feedback">Feedback</option>
                    <option value="Lyric Inquiry">Lyric Inquiry</option>
                    <option value="Sync Request">Sync Request</option>
                    <option value="Other">Other</option>
                </select>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" required></textarea>

                <!-- <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY_HERE"></div> -->
                <button type="submit">Send Message</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // TEMP: reCAPTCHA disabled
                /*
                $recaptcha_secret = "YOUR_SECRET_KEY_HERE";
                $recaptcha_response = $_POST['g-recaptcha-response'];

                $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
                $response_data = json_decode($verify);

                if (!$response_data->success) {
                    echo '<div class="form-feedback error">reCAPTCHA verification failed. Please try again.</div>';
                    exit;
                }
                */

                $name = htmlspecialchars(trim($_POST['name']));
                $email = htmlspecialchars(trim($_POST['email']));
                $subject = htmlspecialchars(trim($_POST['subject']));
                $message = htmlspecialchars(trim($_POST['message']));

                $to = "amahboob@cinnova.com";
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
                    echo '<div class="form-feedback success">Thank you for reaching out! We will get back to you soon.</div>';
                } else {
                    echo '<div class="form-feedback error">Oops! Something went wrong, please try again later.</div>';
                }
            }
            ?>
        </section>
    </div>
</div>

<?php include('footer.php'); ?>
