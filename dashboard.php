<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>


<div class="container">
    <div class="card">
        
        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <a href="logout.php" class="logout-btn"> Logout</a>
        </div>
        
        <div class="dashboard-links">
            <a href="waste_entry.php">➕ Add Waste Entry</a>
            <a href="view_entries.php">📋 View Entries</a>
            <a href="charts.php">📊 View Charts</a>
            <a href="recommendation.php">🤖 Recommendations</a>
            <a href="leaderboard.php">🏆 Leaderboard</a>
        </div>

    </div>
</div>

</body>
</html>