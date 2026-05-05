<?php
$conn = new mysqli("localhost","root","","waste_canteen_system");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>