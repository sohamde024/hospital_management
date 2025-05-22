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
    $department = $_POST['department'];

    
    $sql = "SELECT a.id, a.patient_name, a.allotted_time, a.department, a.date, a.doctor_name
            FROM appointments a
            INNER JOIN doctors d ON a.department = d.department
            WHERE a.department = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $department);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matching Appointments</title>
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
        .no-result {
            color: red;
            font-style: italic;
        }
        .home {
            margin-top: 20px;
        }
        .home a {
            padding: 10px 20px;
            background-color: brown;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <h2>Matching Appointments</h2>

    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Allotted Time</th>
                <th>Department</th>
                <th>Date</th>
                <th>Doctor Name</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['allotted_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p class="no-result">No matching appointments found for the department "<?php echo htmlspecialchars($department); ?>"</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
    
    <div class="home">
    <a href="search_by_department.html">Return</a>
    </div>



</body>
</html>
