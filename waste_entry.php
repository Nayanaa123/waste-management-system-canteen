
<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$role = $_SESSION['role'];

$canteen_id = null;

/* MAIN ADMIN CAN SELECT CANTEEN */
if($role == 'mainadmin'){
    $canteens = $conn->query("SELECT * FROM canteen");
}
else{
    /* CANTEEN USER AUTO GET CANTEEN */
    $get = $conn->prepare("SELECT canteen_id FROM canteen WHERE admin_id=?");
    $get->bind_param("i", $admin_id);
    $get->execute();
    $res = $get->get_result();

    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $canteen_id = $row['canteen_id'];
    } 
    else{
        die("❌ No canteen assigned to this user!");
    }
}


/* INSERT WASTE DATA */
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $food = $_POST['food'];
    $plastic = $_POST['plastic'];
    $entry_date = $_POST['entry_date'];

    if($role == 'mainadmin'){
        $canteen_id = $_POST['canteen_id'];
    }

    $stmt = $conn->prepare(
        "INSERT INTO wasteentry 
        (canteen_id, food_waste_kg, plastic_waste_kg, entry_date) 
        VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("idds", $canteen_id, $food, $plastic, $entry_date);

    if($stmt->execute()){
        $success = "✅ Waste Entry Added Successfully!";
    }
    else{
        $error = "❌ Error inserting data!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Waste Entry</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
<div class="card">

<h2>➕ Add Waste Entry</h2>

<?php if(isset($success)) echo "<p style='color:lightgreen;'>$success</p>"; ?>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">

<?php if($role == 'mainadmin'): ?>

<select name="canteen_id" required>
<option value="">Select Canteen</option>

<?php while($c = $canteens->fetch_assoc()): ?>

<option value="<?php echo $c['canteen_id']; ?>">
<?php echo $c['canteen_name']; ?>
</option>

<?php endwhile; ?>

</select>

<?php endif; ?>


<label style="color:white;">Select Entry Date</label>

<input 
type="date" 
name="entry_date" 
value="<?php echo date('Y-m-d'); ?>" 
required
>


<input 
type="number" 
name="food" 
placeholder="Food Waste (kg)" 
required
>


<input 
type="number" 
name="plastic" 
placeholder="Plastic Waste (kg)" 
required
>


<button type="submit">
Add Entry
</button>

</form>

<br>

<a href="dashboard.php">⬅ Back</a>

</div>
</div>

</body>
</html>

