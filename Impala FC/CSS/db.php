<?php
$host = "localhost";
$user = "root";
$pass = "12345"; // your MySQL password
$dbname = "impalafc_db";

$conn =impalafc_connect($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$servername = "sql207.impalafc.com";
$username = "root";
$password = "12345";
$dbname = "impalafc_db";
?>