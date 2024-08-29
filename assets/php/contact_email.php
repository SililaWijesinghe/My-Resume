<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust the path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
    $budget = htmlspecialchars($_POST['budget'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    // Validate form inputs
    if (empty($name) || empty($message) || empty($subject) || empty($budget) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Please fill all the fields and try again.';
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.example.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'your-email@example.com';               // SMTP username
        $mail->Password   = 'your-email-password';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` can also be used
        $mail->Port       = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $name);                              // From email and name
        $mail->addAddress('sililawijesinghe@gmail.com');            // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'New Message from Eterniventures Contact Form';
        $mail->Body    = "Name: $name<br>Email: $email<br>Subject: $subject<br>Budget: $budget<br>Message:<br>$message";
        $mail->AltBody = "Name: $name\nEmail: $email\nSubject: $subject\nBudget: $budget\nMessage:\n$message"; // Plain text for non-HTML mail clients

        // Send email
        $mail->send();
        echo 'Thank You! We will be in touch with you very soon.';
    } catch (Exception $e) {
        echo "Oops! An error occurred and your message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
