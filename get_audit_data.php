<?php
// Include your database connection code (e.g., dbconnect.php)

// Check if the user is logged in and the 'employee' parameter is provided in the URL
if (isset($_GET['employee']) && isset($_SESSION['username'])) {
    // Sanitize and store the employee name and current user's username
    $employeeName = htmlspecialchars($_GET['employee']);
    $currentUser = $_SESSION['username'];

    include("dbconnect.php");
    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the SQL query to fetch audit data for the specified employee
    // and ensure that the employee is in the same team as the current user
    $sql = "SELECT Ticket_Handling, Process, Communication, Escalation, Technical, Investigation, Customer_Centered
            FROM audit_data
            WHERE SD_Engineer = ? AND Team = (
                SELECT Team FROM audit_data WHERE SD_Engineer = ? LIMIT 1
            )";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $employeeName, $currentUser);

    // Execute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch the row as an associative array
            $row = $result->fetch_assoc();

            // Close the database connection
            $conn->close();

            // Return the data as JSON
            header('Content-Type: application/json');
            echo json_encode($row);
        } else {
            // No data found for the specified employee
            $conn->close();
            http_response_code(404); // Not Found
            echo json_encode(array("message" => "No audit data found for this employee."));
        }
    } else {
        // Query execution failed
        $conn->close();
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Unable to fetch audit data."));
    }
} else {
    // 'employee' parameter not provided in the URL or user not logged in
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Missing 'employee' parameter or user not logged in."));
}
?>
