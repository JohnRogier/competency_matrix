<?php
// Include database connection code
include('dbconnect.php');

// Check if the ID parameter exists in the POST request
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = $_POST['id'];

    // Prepare the DELETE statement
    $deleteQuery = "DELETE FROM call_audit_data WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($deleteQuery);

    if (!$stmt) {
        die("Database query error: " . $conn->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Close the prepared statement
    $stmt->close();

    // Redirect to the display_call_audit.php page after successful deletion
    header('Location: display_call_audit.php');
    exit();
} else {
    echo 'Error executing the delete query: ';
}

// Close the database connection
$conn->close();
?>
