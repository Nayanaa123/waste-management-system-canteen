<?php
session_start();
include 'db.php';

// Check login
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// FETCH TOTAL WASTE PER CANTEEN
$query = "SELECT c.canteen_name, 
          SUM(w.food_waste_kg) as food, 
          SUM(w.plastic_waste_kg) as plastic 
          FROM wasteentry w 
          JOIN canteen c ON w.canteen_id = c.canteen_id 
          GROUP BY c.canteen_name";

$result = $conn->query($query);

$labels = [];
$foodData = [];
$plasticData = [];

while($row = $result->fetch_assoc()) {
    $labels[] = $row['canteen_name'];
    $foodData[] = $row['food'];
    $plasticData[] = $row['plastic'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <div class="card">
        <h1>📊 Waste Analytics</h1>
        
        <div class="chart-wrapper">
            <canvas id="wasteChart"></canvas>
        </div>

        <br><br>
        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</div>

<script>
const ctx = document.getElementById('wasteChart').getContext('2d');
const wasteChart = new Chart(ctx, {
    type: 'bar', // 'bar' for vertical, 'line' for a graph line
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [
            {
                label: 'Food Waste (kg)',
                data: <?php echo json_encode($foodData); ?>,
                backgroundColor: 'rgba(40, 180, 133, 0.8)', // Green
                borderColor: '#28b485',
                borderWidth: 1
            },
            {
                label: 'Plastic Waste (kg)',
                data: <?php echo json_encode($plasticData); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.8)', // Blue
                borderColor: '#36a2eb',
                borderWidth: 1
            }
        ]
    },
    // Update only the "options" part of your Chart.js code:
options: {
    responsive: true,
    maintainAspectRatio: false, // THIS IS THE KEY TO STOP OVERSIZING
    plugins: {
        legend: { labels: { color: 'white', font: { size: 16 } } }
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: { color: 'white', font: { size: 14 } },
            grid: { color: '#444' }
        },
        x: {
            ticks: { color: 'white', font: { size: 14 } },
            grid: { color: '#444' }
        }
    }
}
    
});
</script>

</body>
</html>