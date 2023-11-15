<!DOCTYPE html>
<html>
<head>
    <?php
        include('dbconnect.php');  // Include the database configuration file
    ?>
    <!-- Linking CSS stylesheet -->
    <title>View Users</title>
    <link rel="stylesheet" type="text/css" href="./css/view_users.css">
    <?php include 'navigation.php'; ?>
</head>
<body>
    
    <?php
        // Output Form Entries from the Database
        $sql = "SELECT * FROM login";
        // Fire query
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            // Display table if there are results
            echo '<table class="data-table">
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>PIMS</th>
                    </tr>';
            
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td>' . $row["username"] . '</td>
                                <td>' . $row["Role"] . '</td>
                                <td>' . $row["PIMS"] . '</td>
                                <td><a href="edit_user.php?id=' . $row["id"] . '">Edit</a></td>
                                <td><a href="delete_user.php?id=' . $row["id"] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">Delete</a></td>
                              </tr>';
                    }
            echo '</table>';
        }
        else {
            // Display if no results
            echo "0 results";
        }
        
        // Close the database connection
        mysqli_close($conn);
    ?>
</body>
</html>
