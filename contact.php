<?php
// Start output buffering
ob_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check for output
if (ob_get_length() > 0) {
    echo "Output detected: " . ob_get_contents();
    ob_end_clean(); // Clear the buffer
    exit;
}

include('header.php');
?>

<title>Contact Us</title>
<meta name="description" content="Contact Shadow & Storm for inquiries or feedback. We value your thoughts and creativity." />
<!-- reCAPTCHA script is kept, but currently unused -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<?php include('nav.php');

// Define email recipient
define('MAIL_TO', 'amahboob@cinnova.com');

$errors = array(); // Initialize $errors as an array
$name = '';
$email = '';
$subject = '';
$message = '';

/**
 * Validate form data
 * @return boolean Return true if no error found, otherwise return false
 */
function validate_form()
{
    global $errors, $name, $email, $subject, $message;

    // Ensure $errors is an array
    if (!is_array($errors)) {
        $errors = array();
    }

    // Validate name
    if ($_POST['name'] != '') {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        if ($name == '') {
            $errors[] = 'Name is not valid';
        }
    } else {
        $errors[] = 'Name is required';
    }

    // Validate email
    if ($_POST['email'] != '') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is not valid';
        }
    } else {
        $errors[] = 'Email is required';
    }

    // Validate subject (optional)
    if (isset($_POST['subject']) && $_POST['subject'] != '') {
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    }

    // Validate message
    if ($_POST['message'] != '') {
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
        if ($message == '') {
            $errors[] = 'Message is not valid';
        }
    } else {
        $errors[] = 'Message is required';
    }

    // Check if there are any errors
    if (count($errors) > 0) {
        return false;
    } else {
        return true;
    }
}

/**
 * Display field value
 * @param string $fieldName
 */
function display_value($fieldName)
{
    echo isset($_POST[$fieldName]) ? htmlspecialchars($_POST[$fieldName]) : '';
}

/**
 * Display message to users
 * @param array $errors Array of errors
 */
function display_message($errors)
{
    if (!isset($_POST['submit'])) {
        return;
    }
    if (count($errors) === 0) {
        // No need to display a success message here since we're redirecting
    } else {
        ?>
        <div class="alert alert-block alert-danger fade in">
            <p>The following error(s) occurred:</p>
            <ul>
                <?php
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                ?>
            </ul>
        </div>
        <?php
    }
}

/**
 * Start form processing
 */
function start_form()
{
    global $errors, $name, $email, $subject, $message;

    $mail_msg = '';
    if (isset($_POST['submit'])) {
        if (validate_form()) {
            $mail_msg .= 'From: ' . $name . "\n";
            $mail_msg .= 'Email: ' . $email . "\n";
            $mail_msg .= 'Subject: ' . ($subject ? $subject : "No Subject") . "\n";
            $mail_msg .= 'Message: ' . $message . "\n";

            // Set email headers
            $headers = "From: no-reply@shadowandstorm.com\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            $email_subject = "Contact Form Submission: " . ($subject ? $subject : "No Subject");

            // Send the email
            if (mail(MAIL_TO, $email_subject, $mail_msg, $headers)) {
                // Email sent successfully, now redirect
                ob_end_clean(); // Clear the output buffer
                header('Location: thank-you.php'); // Change this to your thank you page
                exit();
            } else {
                // Email failed to send
                $errors[] = 'Error sending email';
                error_log("Failed to send email to " . MAIL_TO);
            }
        }
    }
}

start_form();
?>

<div class="single-page-bg track-page">
    <div class="container">
        <section class="signal-page">
            <h1>Contact Us</h1>

            <?php display_message($errors); ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required value="<?php display_value('name'); ?>">

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required value="<?php display_value('email'); ?>">

                <label for="subject">Subject (Optional)</label>
                <select id="subject" name="subject">
                    <option value="">Select a Subject</option>
                    <option value="Feedback" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'Feedback') ? 'selected' : ''; ?>>Feedback</option>
                    <option value="Lyric Inquiry" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'Lyric Inquiry') ? 'selected' : ''; ?>>Lyric Inquiry</option>
                    <option value="Sync Request" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'Sync Request') ? 'selected' : ''; ?>>Sync Request</option>
                    <option value="Other" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" required><?php display_value('message'); ?></textarea>

                <!-- <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY_HERE"></div> -->
                <button type="submit" name="submit">Send Message</button>
            </form>
        </section>
    </div>
</div>

<?php include('footer.php'); ?>