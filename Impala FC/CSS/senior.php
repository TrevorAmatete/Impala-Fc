<?php
$players = [
  ['name' => 'June Federova', 'position' => 'Goalkeeper', 'image' => 'images/June.jpg'],
  // Add 19 more players here...
  ['name' => 'Weet Bol', 'position' => 'Defender', 'image' => 'images/Weet.jpeg'],
  ['name' => 'Pascal Kuol', 'position' => 'Defender', 'image' => 'images/Pascal.jpeg'],
  ['name' => 'Baraka Gilbert', 'position' => 'Defender', 'image' => 'images/Baraka.jpeg'],
  ['name' => 'Daniel Shihera', 'position' => 'Defender', 'image' => 'images/Dogo.jpeg'],
  ['name' => 'Charles Odeya', 'position' => 'Defender', 'image' => 'images/Charles.jpg'],
  ['name' => 'Sammy Mongare', 'position' => 'Defender', 'image' => 'images/Sammy.jpg'],
  ['name' => 'Dut Gabriel', 'position' => 'Defender', 'image' => 'images/Dut.jpeg'],
  ['name' => 'Rollence Owuor', 'position' => 'Defender', 'image' => 'images/Capi.jpeg'],
  ['name' => 'Henstone Shihuna', 'position' => 'Midfielder', 'image' => 'images/Ammoh.jpg'],
  ['name' => 'Mostine Bravine', 'position' => 'Midfielder', 'image' => 'images/Mostine.jpeg'],
  ['name' => 'Arial Arol', 'position' => 'Midfielder', 'image' => 'images/Arial.jpeg'],
  ['name' => 'Imran Ahmed', 'position' => 'Midfielder', 'image' => 'images/Imran.jpeg'],
  ['name' => 'Brian Ngamia', 'position' => 'Midfielder', 'image' => 'images/Brian.jpg'],
  ['name' => 'Peter Wekesa', 'position' => 'Forward', 'image' => 'images/Peter.jpeg'],
  ['name' => 'Patrick Kechkech', 'position' => 'Forward', 'image' => 'images/Pato Kech.jpeg'],
  ['name' => 'Ivan Ooga', 'position' => 'Forward', 'image' => 'images/Ivan.jpeg'],
  ['name' => 'Mark Nzusyo', 'position' => 'Forward', 'image' => 'images/Mark.jpeg'],
  ['name' => 'Trevor Amatete', 'position' => 'Forward', 'image' => 'images/Amatete.jpeg'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Senior Team - Impala FC</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Senior Team</h1>
   <form action="senior.html" method="POST"></form>
  <div class="players">
    <?php
include 'db.php';

function displayGroup($conn, $positionLabel, $positionsArray) {
    echo "<section class='player-group'>";
    echo "<h2>$positionLabel</h2>";
    echo "<div class='player-grid'>";
    
    $placeholders = rtrim(str_repeat('?,', count($positionsArray)), ',');
    $stmt = $conn->prepare("SELECT * FROM senior_players WHERE position IN ($placeholders)");
    $stmt->bind_param(str_repeat('s', count($positionsArray)), ...$positionsArray);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($player = $result->fetch_assoc()) {
        echo "<div class='player-card'>
                <img src='uploads/{$player['image']}' alt='{$player['name']}'>
                <h3>{$player['name']}</h3>
                <p><strong>Position:</strong> {$player['position']}</p>
                <p>{$player['bio']}</p>
              </div>";
    }
    echo "</div></section>";
}

// Page layout
echo "<h1>Impala FC Senior Team</h1>";

displayGroup($conn, "🧤 Goalkeepers", ["Goalkeeper"]);
displayGroup($conn, "🛡️ Defenders", ["Defender"]);
displayGroup($conn, "⚙️ Midfielders", ["Midfielder"]);
displayGroup($conn, "🎯 Attackers", ["Attacker"]);

// Optional: Display Technical Bench
echo "<section class='player-group'>";
echo "<h2>👨‍💼 Technical Bench</h2>";
echo "<div class='player-grid'>";
$tech = $conn->query("SELECT * FROM senior_players WHERE position = 'Coach'");
while ($coach = $tech->fetch_assoc()) {
    echo "<div class='player-card'>
            <img src='uploads/{$coach['image']}' alt='{$coach['name']}'>
            <h3>{$coach['name']}</h3>
            <p><strong>Role:</strong> Coach</p>
            <p>{$coach['bio']}</p>
          </div>";
}
echo "</div></section>";
?>

  </div>
</body>
</html>
