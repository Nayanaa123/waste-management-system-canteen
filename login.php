<?php
session_start();
include 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT admin_id, name, password, role FROM admin WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $admin = $res->fetch_assoc();

        if ($password === $admin['password']) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['role'] = $admin['role'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body {
    background:#0F0F0F;
    color:white;
    font-family:Arial;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}

.box {
    background:#1A1A1A;
    padding:30px;
    border-radius:10px;
    text-align:center;
    width:300px;
}

.logo {
    margin-bottom:15px;
}

.logo img {
    width:120px;
    height:auto;
}

input {
    width:90%;
    padding:10px;
    margin:10px;
    border-radius:5px;
    border:none;
}

button {
    width:95%;
    padding:10px;
    background:#0082c9;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover {
    background:#006fa6;
}

.error {
    color:red;
    margin-top:10px;
}
</style>

</head>
<body>

<div class="box">

    <!-- ✅ FIXED IMAGE PATH -->
    <div class="logo">
        <img src="image/image.jpeg" alt="BinBuddy Logo">
    </div>

    <h2>Login</h2>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <?php if ($error != ''): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

</div>

</body>
</html>