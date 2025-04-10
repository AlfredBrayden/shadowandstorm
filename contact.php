<?php include('header.php'); ?>

<title>Contact Us</title>
<meta name="description"
    content="Contact Shadow & Storm for inquiries or feedback. We value your thoughts and creativity." />
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

           <!--      <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY_HERE"></div> -->
                <button type="submit">Send Message</button>
            </form>
        </section>
    </div>
</div>

<?php include('footer.php'); ?>




