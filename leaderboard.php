<?php
include 'db.php';

$result = $conn->query("
SELECT c.canteen_name,
SUM(w.food_waste_kg) AS food,
SUM(w.plastic_waste_kg) AS plastic,
(SUM(w.food_waste_kg)+SUM(w.plastic_waste_kg)) AS total
FROM wasteentry w
JOIN canteen c ON w.canteen_id=c.canteen_id
GROUP BY c.canteen_id
ORDER BY total ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<div class="card">

<h2>🏆 Leaderboard</h2>

<table>
<tr>
<th>Rank</th>
<th>Canteen</th>
<th>Total Waste</th>
</tr>

<?php $rank=1; while($row=$result->fetch_assoc()): ?>
<tr>
<td>#<?php echo $rank++; ?></td>
<td><?php echo $row['canteen_name']; ?></td>
<td><?php echo $row['total']; ?> kg</td>
</tr>
<?php endwhile; ?>

</table>

<a href="dashboard.php">⬅ Back</a>

</div>
</div>

</body>
</html>