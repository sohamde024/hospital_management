<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$first_name = $_POST['first-name'];
$last_name = $_POST['last-name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$department = $_POST['department'];
$address = $_POST['address'];

$sql = "INSERT INTO doctors (first_name, last_name, age, gender, department, address) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisss", $first_name, $last_name, $age, $gender, $department, $address);

if ($stmt->execute()) {
    echo "Doctor's details have been added successfully!";
} else {
    echo "Error: " . $conn->error;
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>details</title>
    <style>
        .home {
            margin-top: 20px;
        }
        .home a {
            display: inline-block;
            padding: 10px 20px;
            background-color: brown;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    
    <div class="home">
        <a href="doc_detail_update.html">Return</a>
    </div>
</body>
</html>