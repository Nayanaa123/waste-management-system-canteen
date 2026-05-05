<?php
session_start();
include 'db.php';

// 1. Get the specific Entry ID from the URL
$entry_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($entry_id) {
    // Fetch the specific high-waste entry
    $query = "SELECT w.*, c.canteen_name FROM wasteentry w 
              JOIN canteen c ON w.canteen_id = c.canteen_id 
              WHERE w.entry_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $entry_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
} else {
    // If no ID is clicked, just show the most recent one
    $query = "SELECT w.*, c.canteen_name FROM wasteentry w 
              JOIN canteen c ON w.canteen_id = c.canteen_id 
              WHERE c.admin_id = ? ORDER BY w.entry_id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['admin_id']);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
}

$food = $data['food_waste_kg'] ?? 0;
$plastic = $data['plastic_waste_kg'] ?? 0;
$canteen = $data['canteen_name'] ?? "Canteen";
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <div class="card">
        <h1>🚨 Emergency Recommendation</h1>
        <p>Analyzing Entry ID: #<?php echo $entry_id; ?> for <strong><?php echo $canteen; ?></strong></p>

        <ul class="recommendation-list">
            <?php if($food > 50): ?>
                <li style="border-left: 10px solid #ff4d4d; background: #2a1010;">
                    <h3>🍔 Food Waste Alert (<?php echo $food; ?>kg)</h3>
                    <p>Your food waste is critically high. **Action:** Check if the "Main Course" was overcooked or if students disliked today's menu. Reduce tomorrow's preparation by 15%.</p>
                </li>
            <?php endif; ?>

            <?php if($plastic > 20): ?>
                <li style="border-left: 10px solid #ff4d4d; background: #2a1010;">
                    <h3>🥤 Plastic Waste Alert (<?php echo $plastic; ?>kg)</h3>
                    <p>High plastic detected! **Action:** Inspect the bin. If many plastic water bottles are found, install a water dispenser to discourage bottled water use.</p>
                </li>
            <?php endif; ?>

            <?php if($food <= 50 && $plastic <= 20): ?>
                <li style="border-left: 10px solid #28b485;">
                    <h3>✅ Data is Stable</h3>
                    <p>Everything looks good. No emergency actions needed for this entry.</p>
                </li>
            <?php endif; ?>
        </ul>

        <a href="view_entries.php" style="background: #333; padding: 15px; border-radius: 8px;">⬅ Back to Entries</a>
    </div>
</div>
</body>
</html>