<?php
//     include('dbconnect.php');  // Include the database configuration file

// // Function to check user's permission
// function hasPermission($conn, $userId, $permission) {
//     $sql = "SELECT COUNT(*) AS count
//             FROM user
//             INNER JOIN role_permission ON user.roleId = role_permission.roleId
//             INNER JOIN permissions ON role_permission.PermId = permissions.PermId
//             WHERE user.userId = $userId AND permissions.permission = '$permission'";

//     $result = $conn->query($sql);
//     $row = $result->fetch_assoc();
    
//     return $row['count'] > 0;
// }

// // Usage example
// $userId = 1; 

// if (hasPermission($conn, $userId, 'view_dashboard')) {
//     echo "User has permission to view dashboard.";
// } else {
//     echo "User does not have permission to view dashboard.";
// }

// $conn->close();

?> 
