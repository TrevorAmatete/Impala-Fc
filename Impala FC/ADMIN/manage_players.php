<!-- admin/manage_players.php -->
<?php include('conn.php'); ?>
<form method="post" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Player Name" required>
  <input type="text" name="position" placeholder="Position" required>
  <input type="file" name="image" required>
  <input type="submit" name="upload" value="Upload Player">
</form>
