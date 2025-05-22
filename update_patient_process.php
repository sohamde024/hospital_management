<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    
    $stmt = $conn->prepare("UPDATE patients SET first_name = ?, last_name = ?, age = ?, gender = ?, address = ? WHERE patient_id = ?");
    $stmt->bind_param("ssissi", $first_name, $last_name, $age, $gender, $address, $patient_id);

    
    if ($stmt->execute()) {
        
        header("Location: view_patients1.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}

$conn->close();
?>
