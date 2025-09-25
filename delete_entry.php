<?php
session_start();
include 'db.php';

// Only logged-in admins can delete
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Check if ID is passed
if(isset($_GET['id'])){
    $id = (int)$_GET['id']; // Convert to integer for safety

    // Prepare DELETE query
    $stmt = $conn->prepare("DELETE FROM WasteEntry WHERE entry_id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        // Redirect back to view_entries.php with success message
        header("Location: view_entries.php?deleted=1");
        exit;
    } else {
        echo "Error deleting entry: " . $stmt->error;
    }
} else {
    echo "Invalid request: no entry ID.";
}
?>