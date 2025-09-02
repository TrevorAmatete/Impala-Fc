<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $messageText = $_POST['message'];

    // Send email
   $to = "impalafootballclub2024@gmail.com"        ; // ← your academy admin email
    $subject = "New Inquiry from $name";
    $message = "
      New inquiry received:\n\n
      Name: $name\n
      Email: $email\n
      Message:\n$messageText
    ";
    $headers = "From: website@impalafc.co.ke";

    // Optional: store in DB
    include 'db.php';
    $stmt = $conn->prepare("INSERT INTO academy_inquiries (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $messageText);
    $stmt->execute();
    $stmt->close();

    if (mail($to, $subject, $message, $headers)) {
        header("Location: impalafootballclub2024@gmail.com?status=inquiry_sent");
    } else {
        echo "Unable to send message. Please contact us via phone.";
    }
}
?>
