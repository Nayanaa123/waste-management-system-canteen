<?php
session_start();
include 'db.php';
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Fetch total food & plastic waste per date
$result = $conn->query("SELECT date, SUM(food_waste_kg) AS food_total, SUM(plastic_waste_kg) AS plastic_total
                        FROM WasteEntry
                        GROUP BY date
                        ORDER BY date ASC");

$dates = [];
$food = [];
$plastic = [];

while($row = $result->fetch_assoc()){
    $dates[] = $row['date'];
    $food[] = (float)$row['food_total'];
    $plastic[] = (float)$row['plastic_total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Waste Trends</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body{font-family:Arial;margin:0;padding:20px;background:#f9f9f9;}
.container{max-width:800px;margin:0 auto;}
h2{text-align:center;}
canvas{background:#fff;border-radius:8px;padding:16px;box-shadow:0 6px 12px rgba(0,0,0,0.1);}
a{display:block;text-align:center;margin-top:16px;color:#28a745;text-decoration:none;}
</style>
</head>
<body>
<div class="container">
<h2>Food & Plastic Waste Trends</h2>
<canvas id="wasteChart"></canvas>
<a href="dashboard.php">← Back to Dashboard</a>
</div>

<script>
const ctx = document.getElementById('wasteChart').getContext('2d');
const wasteChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [
            {
                label: 'Food Waste (kg)',
                data: <?php echo json_encode($food); ?>,
                borderColor: 'rgba(255,99,132,1)',
                backgroundColor: 'rgba(255,99,132,0.2)',
                fill:true,
                tension:0.2
            },
            {
                label: 'Plastic Waste (kg)',
                data: <?php echo json_encode($plastic); ?>,
                borderColor: 'rgba(54,162,235,1)',
                backgroundColor: 'rgba(54,162,235,0.2)',
                fill:true,
                tension:0.2
            }
        ]
    },
    options: {
        responsive:true,
        scales: {
            y: { beginAtZero:true }
        }
    }
});
</script>
</body>
</html>