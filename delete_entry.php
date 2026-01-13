<?php
session_start();
include 'db.php';


if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}


if(isset($_GET['id'])){
    $id = (int)$_GET['id']; 
    $stmt = $conn->prepare("DELETE FROM WasteEntry WHERE entry_id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        
        header("Location: view_entries.php?deleted=1");
        exit;
    } else {
        echo "Error deleting entry: " . $stmt->error;
    }
} else {
    echo "Invalid request: no entry ID.";
}
?>