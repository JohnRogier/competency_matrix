<?php
include('dbconnect.php');  // Include the database configuration file

session_start();

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter the username(TEAM_NAME).";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter the password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        // Using prepared statement to prevent SQL injection
        $sql = "SELECT ID, Username, role, Password FROM login WHERE Username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $username, $role, $hashed_password);
            mysqli_stmt_fetch($stmt);
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["ID"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;

                if ($role === 'team_leader' || $role === 'senior_manager') {
                    // Redirect team leaders and senior managers to the welcome page
                    header("location: welcome.php");
                } elseif ($role === 'department_manager') {
                    // Redirect department managers to the admin page
                    header("location: admin.php");
                } elseif ($role === 'auditer') {
                    // Redirect auditers to call audit page
                    header("location: call_audit.php");
                }else {
                    // Handle the case of an invalid role or login failure
                    echo '<div class="popup">
                            <div class="popup-content">
                                <h2>Invalid username or password</h2>
                                <a href="login.php" class="btn">OK</a>
                            </div>
                          </div>';
                }
            } else {
                // Incorrect password
                $password_err = "Invalid password";
            }
        } else {
            // No user found with the given username
            $username_err = "Invalid username";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="./css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="login.php">
            <label for="username">Team Username:</label>
            <input type="text" id="username" name="username" required>
            <?php if (!empty($username_err)) : ?>
                <span class="error"><?php echo $username_err; ?></span>
            <?php endif; ?>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <?php if (!empty($password_err)) : ?>
                <span class="error"><?php echo $password_err; ?></span>
            <?php endif; ?>

            <input type="submit" value="Login" class="btn">
        </form>
        <p><a href="reset_password.php">Forgot Password?</a></p>
    </div>
</body>
</html>
