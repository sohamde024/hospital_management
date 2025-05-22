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
    $patient_name = $_POST['patient-name'];
    $allotted_time = $_POST['allotted-time'];
    $department = $_POST['department'];
    $date = $_POST['date'];
    $doctor_name = $_POST['doctor-name'];

    $sql = "INSERT INTO appointments (patient_name, allotted_time, department, date, doctor_name)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $patient_name, $allotted_time, $department, $date, $doctor_name);
    
    if ($stmt->execute()) {
        echo "New appointment added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <a href="appoinment.html">Return</a>
    </div>
</body>
</html>
