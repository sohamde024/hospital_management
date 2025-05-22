<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_db";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor_id = "";
$first_name = "";
$last_name = "";
$age = "";
$gender = "";
$department = "";
$address = "";
$error = "";


if (isset($_POST['search'])) {
    $first_name = $_POST['first_name'];

    $stmt = $conn->prepare("SELECT * FROM doctors WHERE first_name = ?");
    $stmt->bind_param("s", $first_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $doctor_id = $row['id'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $age = $row['age'];
        $gender = $row['gender'];
        $department = $row['department'];
        $address = $row['address'];
    } else {
        $error = "No doctor found with this name.";
    }
    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $doctor_id = $_POST['doctor_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $address = $_POST['address'];

    $update_stmt = $conn->prepare("UPDATE doctors SET first_name = ?, last_name = ?, age = ?, gender = ?, department = ?, address = ? WHERE id = ?");
    $update_stmt->bind_param("ssisssi", $first_name, $last_name, $age, $gender, $department, $address, $doctor_id);
    $update_stmt->execute();
    $update_stmt->close();

    header("Location: doctor_space.html"); 
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit My Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], select {
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
        .error {
            color: red;
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

<h2>Edit My Information</h2>


<form method="POST" action="">
    <label for="first_name">Enter First Name: </label>
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
    <button type="submit" name="search">Search</button>


    <div class="home">
        <a href="doctor_space.html">Return</a>
    </div>
</form>

<?php if (!empty($error)) { ?>
    <p class="error"><?php echo $error; ?></p>
<?php } ?>


<?php if (!empty($doctor_id)) { ?>
    <form method="POST" action="">
        <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required><br><br>

        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>" required><br><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php if ($gender == "Male") echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($gender == "Female") echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($gender == "Other") echo 'selected'; ?>>Other</option>
        </select><br><br>

       
        <label for="department">Department:</label>
        <select id="department" name="department" required>
            <option value="">Select</option>
            <option value="General Physician" <?php if ($department == "General Physician") echo 'selected'; ?>>General Physician</option>
            <option value="Cardiologist" <?php if ($department == "Cardiologist") echo 'selected'; ?>>Cardiologist</option>
            <option value="Neurologist" <?php if ($department == "Neurologist") echo 'selected'; ?>>Neurologist</option>
            <option value="Dermatologist" <?php if ($department == "Dermatologist") echo 'selected'; ?>>Dermatologist</option>
            <option value="Gynecologist" <?php if ($department == "Gynecologist") echo 'selected'; ?>>Gynecologist</option>
            <option value="ENT Specialist" <?php if ($department == "ENT Specialist") echo 'selected'; ?>>ENT Specialist</option>
            <option value="Psychiatrist" <?php if ($department == "Psychiatrist") echo 'selected'; ?>>Psychiatrist</option>
        </select><br><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br><br>

        <button type="submit" name="update">Update</button>
    </form>
<?php } ?>

</body>
</html>
