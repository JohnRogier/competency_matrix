<!--due to late changes team_leader labels have been changed to team but storing in the database and in the code its still team_leader, plz take into account when doing chnages in the future -->
<?php
//creating session for the logged in user-->
include('dbconnect.php');  // Include the database configuration file
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}

// Set the Team_Leader from the session
$Team_Leader = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $niveau = $_POST['niveau'];
    $Team_LeaderPOST = $_POST['Team_Leader'];
    $pims_id = $_POST['pims_id'];
    $ftid = $_POST['ftid'];

    /// Check if the PIMS ID or FTID already exists in the database to avoid duplicate rows
    $sql = "SELECT COUNT(*) AS count FROM staff WHERE PIMS = ? OR FTID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $pims_id, $ftid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // If the count is greater than 0, then PIMSID or FTID already exists
    if ($row["count"] > 0) {
        echo "Error: PIMS ID or FTID already exists.";
    } else {
        // Insert the new staff record into the database
        $sql = "INSERT INTO staff (Name, Team_Leader, Niveau, PIMS, FTID) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $Team_LeaderPOST, $niveau, $pims_id, $ftid);

        if ($stmt->execute()) {
            $registrationSuccessful = true; // Saves values into the database
        
            // To retrieve data from staff table and auto-populate into technology table
            $sql = "INSERT IGNORE INTO technology (Name, PIMS, Fortinet, Checkpoint, Zscaler, PaloAlto, Juniper, CiscoASA, BigIP, Tuffin, IVANTI, SIRA, AWS, GCP) 
                    SELECT Name, PIMS, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1
                    FROM staff";
            $sql .= " WHERE NOT EXISTS (SELECT 1 FROM technology WHERE Name = staff.Name AND PIMS = staff.PIMS)"; // Checks if data already exist to avoid duplicate rows
        
            if ($conn->query($sql) === TRUE) {
                echo "Auto-population successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        
            // Successful registration pop-up
            if ($registrationSuccessful) {
                echo '<div class="popup">
                    <div class="popup-content">
                        <h2>Registration Successful</h2>
                        <p>Your registration has been completed successfully.</p>
                        <a href="newStaff.php" class="btn">OK</a>
                    </div>
                  </div>';
            }
        } else {
            $error = "Error registering staff";
        }

    // Close the prepared statement
    $stmt->close();
}
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
	<header>
		<!--include the common.php file-->
        <?php include 'common.php'; ?>
    </header>

    <!-- form to create new staff-->
    <div class="registration-container">
        <div class="form">
            <h3>New Staff</h3>
            <form method="post" action="newStaff.php"> 
                <div class="input-box">
                    <label>Name</label>
                    <input type="text" class="input" name="name" required>
                </div>
                <div class="input-box">
                <label>L1/L2</label>
                <select class="input" name="niveau" required>
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                </select>
                </div>

                <div class="input-box">
                    <label>PIMS Id</label>
                    <input type="text" class="input" name="pims_id" required>
                </div>
                <div class="input-box">
                    <label>Team</label>
                    <input type="text" class="input" name="Team_Leader" required readonly value="<?php echo htmlspecialchars($Team_Leader); ?>">
                </div>
                <div class="input-box">
                    <label>FTID(4 capital then 4 numbers(Format:FTID1234))</label>
                    <input type="text" class="input" name="ftid" required pattern="[A-Z]{4}\d{4}">
                </div>
                <div class="button-input-box">
                    <input type="submit" value="Register" class="btn">
                </div>
            </form>
        </div>
    </div>

</body>
</html>
