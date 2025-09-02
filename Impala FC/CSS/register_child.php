<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parent = $_POST['parent_name'];
    $child = $_POST['child_name'];
    $age = $_POST['age'];
    $email = $_POST['contact_email'];
    $phone = $_POST['phone'];

    // Send email
    $to = "impalafootballclub2024@gmail.com"        ; // ← your academy admin email
    $subject = "New Academy Registration – $child";
    $message = "
      A new child has been registered to the academy:\n\n
      Parent Name: $parent\n
      Child Name: $child\n
      Age: $age\n
      Email: $email\n
      Phone: $phone\n
    ";
    $headers = "From: website@impalafc.co.ke";

    // Optional: store in DB
    include 'db.php';
    $stmt = $conn->prepare("INSERT INTO academy_registrations (parent_name, child_name, age, contact_email, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $parent, $child, $age, $email, $phone);
    $stmt->execute();
    $stmt->close();

    // Send and redirect
    if (mail($to, $subject, $message, $headers)) {
        header("Location:impalafootballclub2024@gmail.com ?status=registered");
    } else {
        echo "Mail failed. Please contact admin directly.";
    }
}
?>
