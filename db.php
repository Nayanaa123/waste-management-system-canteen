<?php
// db.php - connect to MySQL database

$servername = "localhost"; // XAMPP always uses localhost
$username = "root";         // XAMPP default username
$password = "";             // XAMPP default password is empty
$dbname = "WasteManagement"; // name of the database we created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";  // uncomment to test
?>