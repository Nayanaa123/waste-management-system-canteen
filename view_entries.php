<?php
session_start();
include 'db.php';

$role = $_SESSION['role'];
$admin_id = $_SESSION['admin_id'];

if($role=='mainadmin'){
    $result = $conn->query("
    SELECT w.*,c.canteen_name
    FROM wasteentry w
    JOIN canteen c ON w.canteen_id=c.canteen_id
    ");
} else {
    $stmt=$conn->prepare("
    SELECT w.*,c.canteen_name
    FROM wasteentry w
    JOIN canteen c ON w.canteen_id=c.canteen_id
    WHERE c.admin_id=?
    ");
    $stmt->bind_param("i",$admin_id);
    $stmt->execute();
    $result=$stmt->get_result();
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

<h2>Waste Entries</h2>
<style>
    .alert-high { background: #ff4d4d; color: white; padding: 5px 10px; border-radius: 4px; font-weight: bold; }
    .status-ok { color: #28b485; }
</style>

<table>
<tr>
<th>ID</th>
<th>Date</th>
<th>Canteen</th>
<th>Food</th>
<th>Plastic</th>
<th>Action</th>
</tr>

<?php while($row=$result->fetch_assoc()): ?>
    <?php 
    // Logic: Is this specific entry high?
    $is_high = ($row['food_waste_kg'] > 50 || $row['plastic_waste_kg'] > 20);
?>
<tr style="<?php echo $is_high ? 'background: #3a1a1a;' : ''; ?>">
<tr>
<td><?php echo $row['entry_id']; ?></td>
<td><?php echo $row['entry_date']; ?></td>
<td><?php echo $row['canteen_name']; ?></td>
<td><?php echo $row['food_waste_kg']; ?></td>
<td><?php echo $row['plastic_waste_kg']; ?></td>
<td>
    <?php 
    $is_high = ($row['food_waste_kg'] > 50 || $row['plastic_waste_kg'] > 20);
    if($is_high): 
    ?>
        <a href="recommendation.php?id=<?php echo $row['entry_id']; ?>" 
           style="background: #ff4d4d; color: white; padding: 8px; border-radius: 5px; text-decoration: none; font-weight: bold;">
           ⚠️ HIGH: Get Advice
        </a>
    <?php else: ?>
        <span style="color: #28b485;">✅ Normal</span>
    <?php endif; ?>
</td>
    <td>
<a class="delete" href="delete_entry.php?id=<?php echo $row['entry_id']; ?>">Delete</a>
</td>
</tr>
<?php endwhile; ?>

</table>

<a href="dashboard.php">⬅ Back</a>

</div>
</div>

</body>
</html>