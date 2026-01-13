<?php
session_start();
include 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT admin_id, name, password, college_id, role FROM admin WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $admin = $res->fetch_assoc();

        
        if ($password === $admin['password']) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['college_id'] = $admin['college_id'];
            $_SESSION['role'] = $admin['role'];

            
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "❌ Incorrect password!";
        }
    } else {
        $error = "❌ Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Waste Management</title>
<style>
body{font-family:Arial;margin:0;background:linear-gradient(120deg,#84fab0,#8fd3f4);display:flex;align-items:center;justify-content:center;height:100vh}
.box{background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.15);width:380px;text-align:center}
h2{color:#333;margin-bottom:15px;}
input{width:90%;padding:10px;margin:10px 0;border-radius:8px;border:1px solid #ccc}
button{width:95%;padding:10px;border:0;background:#28b485;color:#fff;border-radius:8px;font-size:16px;cursor:pointer}
button:hover{background:#239c75;}
.error{color:red;font-size:14px;margin-top:6px;}
</style>
</head>
<body>
<div class="box">
    <h2>Campus Waste Management Login</h2>
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