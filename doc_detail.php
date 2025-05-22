<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctors = [];
$selected_department = "";
$doctor_details = [];


if (isset($_POST['department'])) {
    $selected_department = $_POST['department'];

    $stmt = $conn->prepare("SELECT id, first_name, last_name FROM doctors WHERE department = ?");
    $stmt->bind_param("s", $selected_department);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $doctors[] = [
            'id' => $row['id'],
            'name' => $row['first_name'] . " " . $row['last_name']
        ];
    }
    $stmt->close();
}


if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];

    $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $doctor_details = $result->fetch_assoc();
    } else {
        $doctor_details = null;
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
    <title>Find Doctors by Department</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        select, button {
            padding: 10px;
            font-size: 14px;
            margin: 10px 0;
        }
        button {
            background-color: brown;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: rosybrown;
        }
        .doctor-info {
            margin-top: 20px;
        }
        a {
            text-decoration: none;
            color: brown;
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

<h2>Select Department to View Doctors</h2>


<form method="POST" action="">
    <label for="department">Department:</label>
    <select id="department" name="department" required>
        <option value="">Select</option>
        <option value="General Physician" <?php if ($selected_department == "General Physician") echo 'selected'; ?>>General Physician</option>
        <option value="Cardiologist" <?php if ($selected_department == "Cardiologist") echo 'selected'; ?>>Cardiologist</option>
        <option value="Neurologist" <?php if ($selected_department == "Neurologist") echo 'selected'; ?>>Neurologist</option>
        <option value="Dermatologist" <?php if ($selected_department == "Dermatologist") echo 'selected'; ?>>Dermatologist</option>
        <option value="Gynecologist" <?php if ($selected_department == "Gynecologist") echo 'selected'; ?>>Gynecologist</option>
        <option value="ENT Specialist" <?php if ($selected_department == "ENT Specialist") echo 'selected'; ?>>ENT Specialist</option>
        <option value="Psychiatrist" <?php if ($selected_department == "Psychiatrist") echo 'selected'; ?>>Psychiatrist</option>
    </select>
    <button type="submit">Show Doctors</button>
</form>


<?php if (!empty($doctors)) { ?>
    <h3>Doctors in <?php echo htmlspecialchars($selected_department); ?> Department:</h3>
    <ul>
        <?php foreach ($doctors as $doctor) { ?>
            <li><a href="?doctor_id=<?php echo $doctor['id']; ?>"><?php echo htmlspecialchars($doctor['name']); ?></a></li>
        <?php } ?>
    </ul>
<?php } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
    <p>No doctors found in the selected department.</p>
<?php } ?>


<?php if (!empty($doctor_details)) { ?>
    <div class="doctor-info">
        <h3>Doctor Information</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($doctor_details['first_name']) . " " . htmlspecialchars($doctor_details['last_name']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($doctor_details['age']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($doctor_details['gender']); ?></p>
        <p><strong>Department:</strong> <?php echo htmlspecialchars($doctor_details['department']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($doctor_details['address']); ?></p>
    </div>
<?php } ?>

    <div class="home">
        <a href="doctor_space.html">Return</a>
    </div>

</body>
</html>
