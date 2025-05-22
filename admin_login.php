<?php

$admin_username = "admin";
$admin_password = "12345";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    if ($username === $admin_username && $password === $admin_password) {
       
        header("Location: admin1.html");
        exit();
    } else {
        
        header("Location: admin_login.html?error=Invalid username or password");
        exit();
    }
}
?>
