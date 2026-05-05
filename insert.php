<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $canteen_id = $_POST['canteen_id'];
    $food = $_POST['food'];
    $plastic = $_POST['plastic'];

    $conn->query("INSERT INTO wasteentry (canteen_id,food_waste_kg,plastic_waste_kg)
                  VALUES ($canteen_id,$food,$plastic)");

    echo "✅ Data Inserted!";
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

<h2>Manual Insert</h2>

<form method="POST">
<input type="number" name="canteen_id" placeholder="Canteen ID" required>
<input type="number" name="food" placeholder="Food Waste" required>
<input type="number" name="plastic" placeholder="Plastic Waste" required>
<button>Insert</button>
</form>

</div>
</div>

</body>
</html>