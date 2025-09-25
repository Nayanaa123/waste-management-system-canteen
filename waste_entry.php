<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}
include 'db.php'; // connects to database

// Fetch canteens from database to populate dropdown
$canteens = $conn->query("SELECT canteen_id, name FROM Canteen ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Waste Entry</title>
  <style>
    body{font-family:Arial;background:#f6fff2;}
    .box{max-width:600px;margin:40px auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 6px 12px rgba(0,0,0,0.08);}
    input, select{width:100%;padding:10px;margin:8px 0;border-radius:6px;border:1px solid #ccc;}
    button{padding:10px 16px;background:#28a745;color:#fff;border:0;border-radius:6px;cursor:pointer;}
  </style>
</head>
<body>
  <div class="box">
    <h2>Add Waste Entry</h2>
    <form action="insert.php" method="post">
      <label>Date</label>
      <input type="date" name="date" required>

      <label>Food waste (kg)</label>
      <input type="number" step="0.01" name="food_waste" placeholder="e.g. 12.50" required>

      <label>Plastic waste (kg)</label>
      <input type="number" step="0.01" name="plastic_waste" placeholder="e.g. 3.00" required>

      <label>Canteen / Hostel</label>
      <select name="canteen_id" required>
        <option value="">-- Select Canteen --</option>
        <?php while($row = $canteens->fetch_assoc()): ?>
          <option value="<?php echo $row['canteen_id']; ?>">
            <?php echo htmlspecialchars($row['name']); ?>
          </option>
        <?php endwhile; ?>
      </select>

      <button type="submit">Save Entry</button>
    </form>
    <p style="margin-top:12px"><a href="dashboard.html">← Back to Dashboard</a></p>
  </div>
</body>
</html>