<?php

session_start();
include 'db.php';


if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}


$res = $conn->query("SELECT college_id, college_name, total_food_waste, total_plastic_waste, total_waste
                     FROM CollegeRanking
                     ORDER BY total_waste ASC");


$labels = [];
$foodData = [];
$plasticData = [];

if($res && $res->num_rows > 0){
    while($r = $res->fetch_assoc()){
        $labels[] = $r['college_name'];
        $foodData[] = (float)$r['total_food_waste'];
        $plasticData[] = (float)$r['total_plastic_waste'];
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Leaderboard - Waste Management</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body{font-family:Arial;margin:20px;background:#f9fafb}
    .wrap{max-width:1000px;margin:0 auto}
    h2{text-align:center}
    table{width:100%;border-collapse:collapse;margin-top:18px;background:#fff}
    th,td{border:1px solid #e6e6e6;padding:10px;text-align:center}
    th{background:#f4f6f8}
    .btn{display:inline-block;padding:8px 12px;background:#28a745;color:#fff;border-radius:6px;text-decoration:none;margin:8px}
    .chart-box{background:#fff;padding:16px;border:1px solid #eee;border-radius:8px;margin-top:20px}
    .notice{color:#666;text-align:center;margin-top:20px}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>🏆 College Waste Leaderboard</h2>
    <div style="text-align:center">
      <a class="btn" href="dashboard.php">← Dashboard</a>
      <a class="btn" href="view_entries.php">View Entries</a>
      <a class="btn" href="charts.php">Charts</a>
    </div>

    <?php if($res && $res->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Rank</th>
            <th>College</th>
            <th>Food Waste (kg)</th>
            <th>Plastic Waste (kg)</th>
            <th>Total Waste (kg)</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $rank = 1;
            // re-run query to fetch rows for table because we already iterated above for chart arrays
            $rows = $conn->query("SELECT college_id, college_name, total_food_waste, total_plastic_waste, total_waste
                                 FROM CollegeRanking ORDER BY total_waste ASC");
            while($row = $rows->fetch_assoc()):
          ?>
            <tr>
              <td><?php echo $rank++; ?></td>
              <td><?php echo htmlspecialchars($row['college_name']); ?></td>
              <td><?php echo htmlspecialchars($row['total_food_waste']); ?></td>
              <td><?php echo htmlspecialchars($row['total_plastic_waste']); ?></td>
              <td><?php echo htmlspecialchars($row['total_waste']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

      <div class="chart-box">
        <canvas id="leaderChart" height="90"></canvas>
      </div>

      <script>
        const ctx = document.getElementById('leaderChart').getContext('2d');
        const labels = <?php echo json_encode($labels); ?>;
        const foodData = <?php echo json_encode($foodData); ?>;
        const plasticData = <?php echo json_encode($plasticData); ?>;

        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [
              {
                label: 'Food Waste (kg)',
                data: foodData,
                backgroundColor: 'rgba(255,159,64,0.8)'
              },
              {
                label: 'Plastic Waste (kg)',
                data: plasticData,
                backgroundColor: 'rgba(54,162,235,0.8)'
              }
            ]
          },
          options: {
            responsive: true,
            scales: {
              y: { beginAtZero: true }
            }
          }
        });
      </script>

    <?php else: ?>
      <p class="notice">No ranking data found. Make sure WasteEntry rows exist and Canteen → College links are set. You can add sample entries in phpMyAdmin.</p>
    <?php endif; ?>
  </div>
</body>
</html>