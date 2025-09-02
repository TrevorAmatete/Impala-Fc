<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $child = $_POST['child_name'];
  $age = $_POST['age'];
  $parent = $_POST['parent_name'];
  $email = $_POST['email'];

  // Store or email logic here
  echo "Thank you, $parent. $child has been registered successfully!";
}

?>
