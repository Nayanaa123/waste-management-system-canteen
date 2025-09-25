<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

// Session check: only logged-in admins
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Threshold limits
$food_threshold = 20;  // kg
$plastic_threshold = 5; // kg

// Fetch alerts for high waste
$alerts = [];
$alert_result = $conn->query("SELECT date, food_waste_kg, plastic_waste_kg, c.name AS canteen_name
                              FROM WasteEntry w
                              LEFT JOIN Canteen c ON w.canteen_id = c.canteen_id
                              WHERE food_waste_kg > $food_threshold OR plastic_waste_kg > $plastic_threshold
                              ORDER BY date DESC");

if($alert_result){
    while($row = $alert_result->fetch_assoc()){
        $alerts[] = "High waste on {$row['date']} in {$row['canteen_name']}: Food={$row['food_waste_kg']}kg, Plastic={$row['plastic_waste_kg']}kg";
    }
}

// Fetch all waste entries for table
$result = $conn->query("SELECT w.entry_id, w.date, w.food_waste_kg, w.plastic_waste_kg, c.name AS canteen_name
                        FROM WasteEntry w
                        LEFT JOIN Canteen c ON w.canteen_id = c.canteen_id
                        ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Entries - Waste Management</title>
<style>
body{font-family:Arial;background:#fff6f0;margin:0;padding:20px;}
table{border-collapse:collapse;width:100%;max-width:900px;margin:12px auto;background:#fff;}
th,td{border:1px solid #ddd;padding:8px;text-align:left;}
th{background:#f4f4f4;}
.top{max-width:900px;margin:8px auto;display:flex;justify-content:space-between;align-items:center;}
a.button{background:#28a745;color:#fff;padding:8px 12px;border-radius:6px;text-decoration:none;}
a.delete{background:#ff4d4d;color:#fff;padding:4px 8px;border-radius:4px;text-decoration:none;}
.alert-box{max-width:900px;margin:10px auto;padding:12px;background:#ffdddd;color:#a00;border-radius:6px;}
p.empty{text-align:center;color:#555;font-style:italic;}
</style>
</head>
<body>

<div class="top">
  <h2 style="margin-left:8px">Waste Entries</h2>
  <div style="margin-right:8px">
    <a class="button" href="waste_entry.php">Add Entry</a>
    <a class="button" href="dashboard.php">Dashboard</a>
    <a class="button" href="charts.php">View Charts</a>
    <a class="delete" href="delete_entry.php?id=<?php echo $row['entry_id']; ?>" onclick="return confirm('Are you sure you want to delete this entry?');">Delete</a>
  </div>
</div>

<!-- Threshold Alerts -->
<?php if(!empty($alerts)): ?>
  <div class="alert-box">
    <strong>⚠ High Waste Alerts:</strong>
    <ul>
      <?php foreach($alerts as $alert): ?>
        <li><?php echo $alert; ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<!-- Entries Table -->
<?php if($result && $result->num_rows > 0): ?>
<table>
<tr>
    <th>Date</th>
    <th>Canteen</th>
    <th>Food (kg)</th>
    <th>Plastic (kg)</th>
    <th>Actions</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['date']); ?></td>
    <td><?php echo htmlspecialchars($row['canteen_name'] ?? 'Unknown'); ?></td>
    <td><?php echo htmlspecialchars($row['food_waste_kg']); ?></td>
    <td><?php echo htmlspecialchars($row['plastic_waste_kg']); ?></td>
    <td>
      <a class="delete" href="delete_entry.php?id=<?php echo $row['entry_id']; ?>" onclick="return confirm('Are you sure you want to delete this entry?');">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p class="empty">No waste entries found. Please <a href="waste_entry.php">add a new entry</a>.</p>
<?php endif; ?>

</body>
</html>
