<!-- admin/login.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <h2>Admin Login</h2>
  <form method="post" action="dashboard.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" name="login" value="Login">
  </form>
</body>
</html>
