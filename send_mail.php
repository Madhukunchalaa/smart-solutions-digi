<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and validate form data
    $name = isset($_POST['form_name']) ? htmlspecialchars($_POST['form_name']) : '';
    $email = isset($_POST['form_email']) ? filter_var($_POST['form_email'], FILTER_VALIDATE_EMAIL) : '';
    $service = isset($_POST['service']) ? htmlspecialchars($_POST['service']) : '';
    $phone = isset($_POST['form_phone']) ? htmlspecialchars($_POST['form_phone']) : '';
    $messageContent = isset($_POST['form_message']) ? htmlspecialchars($_POST['form_message']) : '';

    // Basic validation
   

    if (!$email) {
        echo "Invalid email address.";
        exit();
    }

    // Recipient email
    $to = "contact@smartsolutionsdigi.com,madhkunchala@gmail.com";

    // Email subject
    $emailSubject = "New Inquiry – " . $service;

    // Email content
    $message = "
<html>
<head>
    <title>Contact Inquiry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .details {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .details strong {
            color: #4CAF50;
        }
        .footer {
            font-size: 12px;
            color: #777777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2>New Contact Inquiry</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Service Selected:</strong> $service</p>
        <div class='details'>
            <p><strong>Message:</strong><br>$messageContent</p>
        </div>
    </div>
</body>
</html>
";

   $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $name <contact@smartsolutionsdigi.com>" . "\r\n"; // Use domain email as sender to prevent spam flagging
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($to, $emailSubject, $message, $headers)) {
        header("Location: thank-you.html");
        exit();
    } else {
        echo "Failed to send email. Please try again later.";
    }

} else {
    echo "Invalid request method.";
}
?>
