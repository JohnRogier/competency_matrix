<?php
include('dbconnect.php'); // Include database configuration file

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if an ID is provided and is not empty
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id']; // Retrieve the ID from the form
        
        // Retrieve data from form fields
        $Username = $_POST['username'];
        $role = $_POST['role'];
        $PIMS = $_POST['PIMS'];
        $Password = $_POST['Password'];
        
        // Prepare an SQL statement to update the record
        $stmt = $conn->prepare("UPDATE login SET Username = ?, role = ?, PIMS = ?, Password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $Username, $role, $PIMS, $Password, $id); // Bind parameters
        
        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo '<div class="popup">
                    <div class="popup-content">
                        <p>Record Updated Successfully!</p>
                        <a href="view_users.php" class="btn">OK</a>
                    </div>
                  </div>';
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    } else {
        echo "Invalid ID provided.";
    }
} else {
    // Check if an ID is provided and is not empty
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id']; // Retrieve the ID from the URL
        
        // Prepare an SQL statement to fetch the record
        $sql = "SELECT * FROM login WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); // Bind the parameter
        $stmt->execute();
        $result = $stmt->get_result(); // Get the result

        // Check if $row is not already set and set it to an empty array
        if (!isset($row)) {
            $row = [];
        }

        // Check if a matching record was found
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); // Fetch the result row as an associative array
            } else {
                echo "No record found.";
                exit;
            }
        } else {
            echo "Error executing the query: " . $conn->error;
            exit;
        }
    }
}

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <link rel="stylesheet" type="text/css" href="./css/edit.css">
    <?php include 'navigation.php'; ?>
</head>
<body>
<h2>Edit Record</h2>
<div class="form-container">
    <div class="form">
        <form method="post" action="">
            <!-- Hidden input field to store the record ID -->
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            Username: <input type="text" name="username" value="<?php echo $row['username']; ?>" required><br>
            role: <input type="text" name="role" value="<?php echo $row['Role']; ?>" required><br>
            PIMS: <input type="text" name="PIMS" value="<?php echo $row['PIMS']; ?>" required><br>
            Password: <input type="text" name="Password" value="<?php echo $row['password']; ?>" required><br>
            <div class="input-box">
                <input type="submit" value="Update" class="btn">
            </div>
            <a href="view_users.php">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>
