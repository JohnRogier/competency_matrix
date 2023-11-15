<?php

	include('dbconnect.php');  // Include the database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $role = $_POST['role'];
    $PIMS = $_POST['PIMS'];
    $Password = $_POST['Password'];

    /// Check if the PIMS ID already exists in the database to avoid duplicate rows
$sql = "SELECT COUNT(*) AS count FROM login WHERE PIMS = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pims_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// If the count is greater than 0, then PIMSID or FTID already exists
if ($row["count"] > 0) {
    echo "Error: PIMS ID already exists.";
} else {
    // Insert the new record into the database
    $sql = "INSERT INTO login (Username, role, PIMS, Password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $Username, $role, $PIMS, $Password);

    if ($stmt->execute()) {
            $registrationSuccessful = true; //saves values into database
                //successful registration pop-up
            if ($registrationSuccessful) {
                echo '<div class="popup">
                    <div class="popup-content">
                        <h2>Registration Successful</h2>
                        <p>Your registration has been completed successfully.</p>
                        <a href="login.php" class="btn">OK</a>
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
	<title>New Staff</title>
    <!--linking css sheet-->
	<link rel="stylesheet" type="text/css" href="./css/newStaff.css">
</head>
<body>
    <!-- form to create new staff-->
    <div class="registration-container">
        <div class="form">
            <h3>Registration</h3>
            <form method="post" action="register.php"> 
                <div class="input-box">
                    <label>Name</label>
                    <input type="text" class="input" name="Username" required>
                </div>
                <div class="input-box">
                    <label>Role</label>
                    <input type="text" class="input" name="role" required>
                </div>
                <div class="input-box">
                    <label>PIMS</label>
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
