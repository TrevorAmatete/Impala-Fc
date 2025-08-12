<?php
include('conn.php');
$result = mysqli_query($conn, "SELECT * FROM academy_registrations");
while ($row = mysqli_fetch_assoc($result)) {
  echo "<p>{$row['child_name']} ({$row['age_group']}) - {$row['guardian_name']}</p>";
}
?>
