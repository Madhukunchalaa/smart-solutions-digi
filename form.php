<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $business = htmlspecialchars(trim($_POST['business'] ?? ''));
    $location = htmlspecialchars(trim($_POST['location'] ?? '')); // Added location
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));

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
