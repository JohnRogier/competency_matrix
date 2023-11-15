<?php
//creating session for the logged in user-->
	include('dbconnect.php');  // Include the database configuration file


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $role = $_POST['role'];
    $PIMS = $_POST['PIMS'];
    $Password= $_POST['Password'];

// Hash the user's password before storing it in the database
$hashed_password = password_hash($Password, PASSWORD_DEFAULT);

    /// Check if the PIMS ID or FTID already exists in the database to avoid duplicate rows
$sql = "SELECT COUNT(*) AS count FROM login WHERE PIMS = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pims_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// If the count is greater than 0, then PIMS ID or FTID already exists
if ($row["count"] > 0) {
    echo "Error: PIMS ID already exists.";
} else {
    // Insert the new staff record into the database
    $sql = "INSERT INTO login (Username, role, PIMS, Password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $Username, $role, $PIMS, $hashed_password); // Use $hashed_password

    if ($stmt->execute()) {
            $registrationSuccessful = true; //saves values into database

                //successful registration pop-up
            if ($registrationSuccessful) {
                echo '<div class="popup">
                    <div class="popup-content">
                        <h2>Registration Successful</h2>
                        <p>Your registration has been completed successfully.</p>
                        <a href="admin.php" class="btn">OK</a>
                    </div>
                  </div>';

        }
       else {
        $error = "Error registering staff";
    }
}
}

    $stmt->close(); //close connection
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>New User</title>
    <!--linking css sheet-->
	<link rel="stylesheet" type="text/css" href="./css/newStaff.css">
    <?php include 'navigation.php'; ?>
    <style>
        /* Style the container for the instructions */
        .instructions-container {
            background-color: #f0f0f0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- form to create new staff-->
    <div class="registration-container">
        <div class="form">
            <h3>New Staff</h3>
                        <!-- Container for the instructions -->
                        <div class="instructions-container">
                <p><strong>Instructions:</strong></p>
                <ul>
                    <li>For a Team Leader, please use the name of the team as the username.(the team leader will get access to only his team)</li>
                    <li>For a Senior Manager, any username will do.(the senior_manager will get access to all employees)</li>
                    <li>For a Department Manager, it will create an admin account with access to the admin panel.(the department manager will be able to create users etc via the admin panel)</li>
                </ul>
            </div>
            <form method="post" action="create_user.php"> 
                <div class="input-box">
                    <label>Name</label>
                    <input type="text" class="input" name="Username" required>
                </div>
                <div class="input-box">
                    <label>Role</label>
                    <select class="input" name="role" required>
                        <option value="team_leader">Team Leader</option>
                        <option value="department_manager">Department Manager</option>
                        <option value="senior_manager">Senior Manager</option>
                        <option value="auditer">Auditer</option>
                    </select>
                </div>
                <div class="input-box">
                    <label>PIMS Id</label>
                    <input type="text" class="input" name="PIMS" required>
                </div>
                <div class="input-box">
                    <label>Password</label>
                    <input type="password" class="input" name="Password" required>
                </div>
                <div class="input-box">
                    <input type="submit" value="Register" class="btn">
                </div>
            </form>
        </div>
    </div>

</body>
</html>
