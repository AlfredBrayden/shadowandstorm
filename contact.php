<?php include('header.php'); ?>

<title>Contact Us</title>
<meta name="description"
    content="Contact Shadow & Storm for inquiries or feedback. We value your thoughts and creativity." />

</head>

<body>

    <?php include('nav.php'); ?>

    <div class="single-page-bg track-page">


        <div class="container">


            <section class="signal-page">
                <h1>Contact Us</h1>
                <form action="send_message.php" method="post">
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

                    <button type="submit">Send Message</button>
                </form>





            </section>





        </div>

    </div>



    <?php include('footer.php'); ?>



    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Your email address (replace with your email)
    $to = "your-email@example.com";

    // Subject for the email
    $email_subject = "Contact Form Submission: " . ($subject ? $subject : "No Subject");

    // Email body content
    $email_body = "You have received a new message from the contact form:\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";

    // Headers for the email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "<p>Thank you for reaching out! We will get back to you soon.</p>";
    } else {
        echo "<p>Oops! Something went wrong, please try again later.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}
?>