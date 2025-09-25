<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}
include 'db.php';
ini_set('display_errors',1); error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $food = $_POST['food_waste'];
    $plastic = $_POST['plastic_waste'];
    $canteen = $_POST['canteen_id'];

    $stmt = $conn->prepare("INSERT INTO WasteEntry (date, food_waste_kg, plastic_waste_kg, canteen_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sddi", $date, $food, $plastic, $canteen);

    if ($stmt->execute()) {
        header("Location: view_entries.php?added=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>