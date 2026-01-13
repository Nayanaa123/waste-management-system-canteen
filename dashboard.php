<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$admin_name = $_SESSION['admin_name'];
$admin_role = $_SESSION['role'];
$college_id = $_SESSION['college_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <style>
    body{font-family:Arial;margin:0;background:#f0faff;}
    header{background:#28b485;color:#fff;padding:18px;text-align:center;}
    nav{background:#222;padding:10px;text-align:center;}
    nav a{
      color:#fff;
      margin:0 12px;
      text-decoration:none;
      padding:8px 12px;
      border-radius:6px;
      font-weight:bold;
    }
    nav a:hover{background:#444;}
    .container{padding:30px;text-align:center;}
    .role-box{
      background:#fff;
      border-radius:10px;
      display:inline-block;
      padding:20px 30px;
      box-shadow:0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <header><h1>Campus Waste Management Dashboard</h1></header>

  <nav>
    <a href="leaderboard.php">🏆 Leaderboard</a>
    <a href="waste_entry.php">➕ Add Waste Entry</a>
    <a href="view_entries.php">📋 View Entries</a>
    <a href="charts.php">📊 Waste Charts</a>
    <a href="logout.php">🚪 Logout</a>
  </nav>

  <div class="container">
    <div class="role-box">
      <h2>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
      <p><strong>Role:</strong> <?php echo ucfirst($admin_role); ?></p>
      <?php if($admin_role === 'superadmin'): ?>
        <p>You have access to <b>all colleges</b> and can view every canteen’s waste data.</p>
      <?php else: ?>
        <p>You have access only to your assigned college’s data (College ID: <?php echo $college_id; ?>).</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>