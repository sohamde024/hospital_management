<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    
    $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();

    
    if (!$patient) {
        echo "Patient not found!";
        exit();
    }
} else {
    echo "No patient ID provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: brown;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.9;
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

<h2>Edit Patient Details</h2>

<form action="update_patient_process.php" method="POST">
    <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient['patient_id']); ?>">
    
    <label for="first-name">First Name</label>
    <input type="text" id="first-name" name="first_name" value="<?php echo htmlspecialchars($patient['first_name']); ?>" required>

    <label for="last-name">Last Name</label>
    <input type="text" id="last-name" name="last_name" value="<?php echo htmlspecialchars($patient['last_name']); ?>" required>

    <label for="age">Age</label>
    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($patient['age']); ?>" required>

    <label for="gender">Gender</label>
    <select id="gender" name="gender" required>
        <option value="male" <?php echo ($patient['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
        <option value="female" <?php echo ($patient['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
        <option value="other" <?php echo ($patient['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
    </select>

    <label for="address">Address</label>
    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($patient['address']); ?>" required>

    <button type="submit">Update Patient</button>
</form>

<div class = "home">
<a href="view_patients1.php">Back to Patients List</a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
