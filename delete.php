<?php
include('dbconnect.php'); // Include the database configuration file

if (isset($_GET['employee_id']) && !empty($_GET['employee_id'])) {
    $id = $_GET['employee_id'];

    // Prepare the SQL statement to retrieve the 'id' from the technology table
    $sql = "SELECT employee_id, Name FROM technology WHERE employee_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->bind_result($technologyId, $staffName);
        $stmt->fetch();
        $stmt->close();

        // Now, delete the record from the technology table using the retrieved 'id'
        $deleteSql = "DELETE FROM technology WHERE employee_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $technologyId);

        if ($deleteStmt->execute()) {
            // Now, delete the record from the staff table using the retrieved 'staffName'
            $deleteStaffSql = "DELETE FROM staff WHERE Name = ?";
            $deleteStaffStmt = $conn->prepare($deleteStaffSql);
            $deleteStaffStmt->bind_param("s", $staffName);
            header("Location: competency.php");
            exit;
            } else {
                echo 'Error executing the staff delete query: ' . $deleteStaffStmt->error;
            }


            // if ($deleteStaffStmt->execute()) {
            //     // Both records deleted successfully, redirect to competency.php
            //     header("Location: competency.php");
            //     exit;
            // } else {
            //     echo 'Error executing the staff delete query: ' . $deleteStaffStmt->error;
            // }

            $deleteStaffStmt->close();
        } else {
            echo 'Error executing the technology delete query: ' . $deleteStmt->error;
        }

        $deleteStmt->close();
    } else {
        echo 'Error executing the select query: ' . $stmt->error;
    }
// } else {
//     echo 'Invalid request.';
// }

// Close the database connection
$conn->close();
?>
