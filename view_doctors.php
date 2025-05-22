<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$searchTerm = "";


if (isset($_POST['search'])) {
    $searchTerm = $_POST['search_term'];
}


$sql = "SELECT * FROM doctors WHERE first_name LIKE ? OR last_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTermWithWildcard = "%" . $searchTerm . "%";
$stmt->bind_param("ss", $searchTermWithWildcard, $searchTermWithWildcard);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: brown;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: rosybrown;
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
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-result {
            color: #999;
            font-style: italic;
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
    
  

    <h2>Doctors List</h2>

    
    <form method="POST" action="view_doctors.php">
        <input type="text" name="search_term" placeholder="Search by name..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Department</th>
                    <th>Address</th>
                </tr>";

        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . htmlspecialchars($row['first_name']) . "</td>
                    <td>" . htmlspecialchars($row['last_name']) . "</td>
                    <td>" . $row['age'] . "</td>
                    <td>" . htmlspecialchars($row['gender']) . "</td>
                    <td>" . htmlspecialchars($row['department']) . "</td>
                    <td>" . htmlspecialchars($row['address']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-result'>No doctors found.</p>";
    }

   
    $conn->close();
    ?>



    <div class="home">
        <a href="doctor_manager.html">Return</a>
    </div>

</body>
</html>
