<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "";
    } else {
        echo "<p>Error deleting appointment</p>";
    }
}

$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: darkred;
        }
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

    <h2>Appointments List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Patient Name</th>
            <th>Allotted Time</th>
            <th>Department</th>
            <th>Date</th>
            <th>Doctor Name</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . htmlspecialchars($row['patient_name']) . "</td>
                        <td>" . htmlspecialchars($row['allotted_time']) . "</td>
                        <td>" . htmlspecialchars($row['department']) . "</td>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                        <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                        <td>
                            <a href='view_appointments.php?delete_id=" . $row['id'] . "'>
                                <button type='button'>Delete</button>
                            </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No appointments found</td></tr>";
        }
        ?>

    </table>

    <?php $conn->close(); ?>

    
    <div class="home">
        <a href="appoinment.html">Return</a>
    </div>

</body>
</html>
