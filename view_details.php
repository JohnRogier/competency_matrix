<!DOCTYPE html>
<html>
<head>
    <title>View Details</title>
    <!--linking css sheet-->
	<link rel="stylesheet" type="text/css" href="./css/user_details.css">
</head>
<body>
    <header>
    <nav>
    <div class="sidebar">
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="view_users.php">Registered Users</a></li>
            <li><a href="create_user.php">Create a user</a></li>
            <li><a href="user_details.php">User Details</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
            
        </ul>
    </div>
</nav>
        
    </header>

    <?php
    include('dbconnect.php');  // Include the database configuration file

    // Check if the 'ID' parameter is set in the URL
    if (isset($_GET['id'])) {
        $selectedId = $_GET['id'];

        // Fetch data from the 'login' table based on the selected row
        $sql_login = "SELECT * FROM login WHERE login.ID = $selectedId";
        $result_login = mysqli_query($conn, $sql_login);

        // Check if any rows were returned from the query
        if (mysqli_num_rows($result_login) > 0) {
            $loginRow = mysqli_fetch_assoc($result_login); // Fetch the data from the result as an associative array

            echo '<table class="data-table">
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>PIMS</th>
                </tr>';

            echo '<tr>
                <td>' . $loginRow["username"] . '</td>
                <td>' . $loginRow["Role"] . '</td>
                <td>' . $loginRow["PIMS"] . '</td>
            </tr>';

            echo '</table>';
        
            // Fetch data from the 'staff' table based on the selected role from the login table
            $role = $loginRow['username'];
            $sql_staff = "SELECT * FROM staff WHERE Team_Leader = '$role'";
            $result_staff = mysqli_query($conn, $sql_staff);

            // Check if any rows were returned from the query
            if (mysqli_num_rows($result_staff) > 0) {
                // Display the data from the 'staff' table in a table format
                echo '<table class="data-table">
                    <tr>
                        <th>Name</th>
                        <th>Niveau</th>
                        <th>PIMS</th>
                        <th>FTID</th>
                    </tr>';

                while ($staffRow = mysqli_fetch_assoc($result_staff)) {
                    echo '<tr>';
                    echo '<td>' . $staffRow["Name"] . '</td>';
                    echo '<td>' . $staffRow["Niveau"] . '</td>';
                    echo '<td>' . $staffRow["PIMS"] . '</td>';
                    echo '<td>' . $staffRow["FTID"] . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            }
        }
        
        // Closing connection
        mysqli_close($conn);
    } else {
        echo "Invalid request.";
    }
?>

</body>
</html>
