<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once 'db_config.php';

    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $business = htmlspecialchars(trim($_POST['business'] ?? ''));
    $location = htmlspecialchars(trim($_POST['location'] ?? '')); // Added location
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));

    // Database Insertion
    $source = "Digital Marketing Strategy";
    $service_interest = "Budget: " . $budget;

    $stmt = $conn->prepare("INSERT INTO leads (source, name, email, phone, company_name, location, service_interest, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    // Note: 'business' field mapped to 'company_name', message is empty here but table has message column. 
    // Wait, form.php doesn't seem to have a message input in the collection part?
    // Checking form.php content again... it collects name, phone, business, location, budget. No message variable collected.
    // I will pass empty string for message.
    $empty_msg = "";
    $stmt->bind_param("ssssssss", $source, $name, $email, $phone, $business, $location, $service_interest, $empty_msg);
    $stmt->execute();
    $stmt->close();

    $emailRaw = $_POST['email'] ?? '';
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL);

    if (!$email) {
        die("Invalid email address.");
    }

    $to = "contact@smartsolutionsdigi.com, madhkunchala@gmail.com";
    $subject = "Digital Marketing Strategy Inquiry";

    $message = "<html><body>
        <h2>New Strategy Session Request</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Business:</strong> {$business}</p>
        <p><strong>Location:</strong> {$location}</p>
        <p><strong>Budget:</strong> {$budget}</p>
    </body></html>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Smart Solutions <contact@smartsolutionsdigi.com>\r\n";
    $headers .= "Reply-To: {$email}\r\n";

    if (mail($to, $subject, $message, $headers)) {
        header("Location: thank-you.html?type=digital-marketing");
        exit;
    } else {
        echo "Mail sending failed.";
    }
} else {
    echo "Invalid request.";
}
