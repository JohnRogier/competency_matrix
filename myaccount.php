<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('location: login.php'); // Redirect to login page if not logged in
    exit();
}

include('dbconnect.php'); // Include the database connection

// Get the logged-in user's username
$username = $_SESSION['username'];
// Get the logged-in user's username
$username = $_SESSION['username'];

// SQL query to retrieve user details from the database
$sql = "SELECT * FROM login WHERE username = '$username'";

// Execute the query
$result = $conn->query($sql);

// Check if a user was found
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    #print_r($user);
} else {
    // Handle the case when the user is not found (optional)
    die("User not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
    <link rel="stylesheet" type="text/css" href="./css/myaccount.css">
    <header>
        <?php include 'common.php'; ?>
    </header>
</head>

    
<body>
    <div class="container"> <!--form containing user details-->
        <p><strong>Name:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Role:</strong> <?php echo $user['Role']; ?></p>
        <p><strong>PIMS ID:</strong> <?php echo $user['PIMS']; ?></p>
        

        <a href="resetPassword.php">Reset Password</a>
    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
