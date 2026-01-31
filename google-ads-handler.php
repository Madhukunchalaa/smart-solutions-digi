<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';

    // Collect and validate form data
    $name = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; // matched input name="username"
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $company_name = isset($_POST['company_name']) ? htmlspecialchars($_POST['company_name']) : '';
    $location = isset($_POST['location']) ? htmlspecialchars($_POST['location']) : '';
    $service = isset($_POST['service']) ? htmlspecialchars($_POST['service']) : '';
    $messageContent = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
    $budget = isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '';

    // Database Insertion
    $source = "Google Ads";
    $service_interest = $service . ($budget ? " | Budget: " . $budget : "");

    $stmt = $conn->prepare("INSERT INTO leads (source, name, email, phone, company_name, location, service_interest, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $source, $name, $email, $phone, $company_name, $location, $service_interest, $messageContent);
    $stmt->execute();
    $stmt->close();

    // Basic validation
    if (!$email) {
        echo "Invalid email address.";
        exit();
    }

    // Recipient email
    $to = "contact@smartsolutionsdigi.com,madhkunchala@gmail.com";

    // Email subject
    $emailSubject = "Google Ads Inquiry – " . ($service ? $service : "General");

    // Email content
    $message = "
<html>
<head>
    <title>Google Ads Service Inquiry</title>
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
            color: #FF5722; /* Google Ads Theme Color */
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
        <h2>New Google Ads Service Inquiry</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Company Name:</strong> $company_name</p>
        <p><strong>Location:</strong> $location</p>
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
    $headers .= "From: $name <contact@smartsolutionsdigi.com>" . "\r\n";
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