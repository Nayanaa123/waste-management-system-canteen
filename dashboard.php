
<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <style>
    body{font-family:Arial;margin:0;}
    header{background:#28a745;color:#fff;padding:18px;text-align:center;}
    nav{background:#222;padding:10px;text-align:center;}
    nav a{
      color:#fff;
      margin:0 12px;
      text-decoration:none;
      padding:8px 12px;
      border-radius:6px;
    }
    nav a:hover{background:#444;}
    .container{padding:30px;text-align:center;}
  </style>
</head>
<body>
  <header><h1>Waste Management Dashboard</h1></header>
  <nav>
    <a href="waste_entry.php">Add Waste Entry</a>
    <a href="view_entries.php">View Entries</a>
    <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a>
    <a href="login.php">Logout</a>
    <a href="charts.php">View Waste Charts</a>
  </nav>
  <div class="container">
    <h2>Welcome!</h2>
    <p>Use the menu above to add waste entries or view recorded data.</p>
  </div>
</body>
</html>