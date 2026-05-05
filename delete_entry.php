<?php
include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM wasteentry WHERE entry_id=$id");

header("Location: view_entries.php");
?>