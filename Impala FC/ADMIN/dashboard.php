<!-- admin/dashboard.php -->
<?php
session_start();
if ($_POST['username'] !== 'ImpalaFc' || $_POST['password'] !== 'impalafcconnect123') {
    die("Unauthorized access!");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Welcome to Impala FC Admin Dashboard</h1>
  <nav>
    <a href="manage_players.php">Manage Players</a> |
    <a href="manage_merchandise.php">Manage Merchandise</a> |
    <a href="view_registrations.php">View Academy Registrations</a> |
    <a href="view_inquiries.php">View Inquiries</a> |
    <a href="logout.php">Logout</a>
  </nav>
</body>
</html>
