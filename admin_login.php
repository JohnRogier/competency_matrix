<?php
session_start(); // Start a session
include('dbconnect.php'); // Include  database configuration file

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // Retrieve the entered username from the form
    $password = $_POST['password']; // Retrieve the entered password from the form

    // Prepare a SQL query to check for matching username and password in the database
    $sql = "SELECT * FROM admin_login WHERE Name = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $sql); // Execute the query

    // Check if exactly one row matches the credentials
    if (mysqli_num_rows($result) == 1) {
        // Authentication successful
        $_SESSION['admin_username'] = $username; // Store the username in the session
        header("Location: admin.php"); // Redirect to the admin page
        exit(); // Stop further script execution
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password."; // Set an error message
    }

    mysqli_close($conn); // Close the database connection
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Process</title>
</head>
<body>
    <?php if (isset($error_message)): ?> <!-- Check if an error message exists -->
        <p><?php echo $error_message; ?></p> <!-- Display the error message if present -->
    <?php endif; ?>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="./css/login.css"> <!-- Include your CSS file here -->
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required> <!-- Input for username -->

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required> <!-- Input for password -->

            <input type="submit" value="Login" class="btn"> <!-- Submit button to initiate login -->

            <!-- Link to user login page -->
            <p><a href="login.php">Back to User Login</a></p>
        </form>
    </div>
</body>
</html>
