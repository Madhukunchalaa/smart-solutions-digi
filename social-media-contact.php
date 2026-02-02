<?php
/*
|--------------------------------------------------------------------------
| Social Media Marketing Form Handler (Smart Solutions)
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Database Configuration
    require_once 'db_config.php';

    // 2. Sanitize Input
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $service = isset($_POST['service']) ? htmlspecialchars(trim($_POST['service'])) : '';
    $messageContent = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    // 3. Validate Required Fields
    if (empty($name) || empty($email)) {
        header("Location: social-media-marketing.html?status=empty");
        exit;
    }

    // 4. Database Insertion
    $source = "Social Media Marketing";
    $phone = ""; // Not in form
    $company_name = ""; // Not in form
    $location = ""; // Not in form
    $budget = ""; // Not in form

    // Check if table has 'source' column. Based on google-ads-handler.php: 
    // INSERT INTO leads (source, name, email, phone, company_name, location, service_interest, budget, message)

    $stmt = $conn->prepare("INSERT INTO leads (source, name, email, phone, company_name, location, service_interest, budget, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $source, $name, $email, $phone, $company_name, $location, $service, $budget, $messageContent);

    if ($stmt->execute()) {
        // Log success if needed, or just proceed
    } else {
        error_log("DB Insert Error: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();

    // 5. Send Email Notification
    $to = "contact@smartsolutionsdigi.com,madhkunchala@gmail.com";
    $subject = "New Social Media Inquiry from $name";

    // Email Template
    $logo_url = "https://pub-d8add5c3ed1e4923aa87c457caea356d.r2.dev/Studio%20X%20AI_Logo.png";

    $email_content = "
    <!DOCTYPE html>
    <html>
    <head>
    <style>
        body { background-color: #fff; color: #333; font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: auto; background: #f9f9f9; padding: 40px; border-radius: 8px; border: 1px solid #ddd; }
        .header { text-align: center; border-bottom: 2px solid #ff4d29; padding-bottom: 20px; }
        .logo { max-width: 150px; }
        .title { color: #ff4d29; font-size: 24px; margin: 20px 0; }
        .label { color: #888; font-size: 12px; text-transform: uppercase; margin-top: 15px; }
        .value { font-size: 16px; margin-bottom: 15px; font-weight: bold; }
        .highlight { color: #ff4d29; }
    </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <img src='$logo_url' alt='Smart Solutions' class='logo'>
                <h1 class='title'>Social Media Inquiry</h1>
            </div>
            
            <div class='label'>Name</div>
            <div class='value'>$name</div>
            
            <div class='label'>Email</div>
            <div class='value'>$email</div>
            
            <div class='label'>Service Interested</div>
            <div class='value highlight'>$service</div>

            <div class='label'>Message</div>
            <div class='value'>$messageContent</div>
            
            <div style='text-align: center; margin-top: 30px; font-size: 12px; color: #666;'>
                Sent from Social Media Page
            </div>
        </div>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $name <contact@smartsolutionsdigi.com>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";

    if (mail($to, $subject, $email_content, $headers)) {
        header("Location: thank-you.html?source=social");
        exit;
    } else {
        echo "<h3>Unable to process your request. Please try again later.</h3>";
    }

} else {
    // Redirect if accessed directly
    header("Location: social-media-marketing.html");
    exit;
}
?>