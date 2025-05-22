<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    
    $sql = "INSERT INTO patients (first_name, last_name, age, gender, address)
            VALUES ('$first_name', '$last_name', '$age', '$gender', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "New patient added successfully. Patient ID: " . $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add patients</title>
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
        <a href="patient_manager.html">Return</a>
    </div>
</body>
</html>