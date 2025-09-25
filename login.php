<?php
session_start();
include 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch admin with this email
    $stmt = $conn->prepare("SELECT admin_id, name, password FROM Admin WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        // Check password (plain for now, later use hashing)
        if ($password === $admin['password']) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Waste Management</title>
<style>
body{font-family:Arial;margin:0;background:#eafaf1;display:flex;align-items:center;justify-content:center;height:100vh}
.box{background:#fff;padding:24px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.12);width:360px;text-align:center}
input{width:90%;padding:10px;margin:8px 0;border-radius:6px;border:1px solid #ccc}
button{width:95%;padding:10px;border:0;background:#28a745;color:#fff;border-radius:6px;font-size:16px;cursor:pointer}
.error{color:red;font-size:14px;margin-top:6px;}
</style>
</head>
<body>
<div class="box">
    <h2>Waste Management Login</h2>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
</div>
</body>
</html>