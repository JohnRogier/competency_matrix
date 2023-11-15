<?php
include('dbconnect.php');
session_start();

// Check if the user is logged in (similar to login.php)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $competency_name = $_POST["competency_name"];
    $competency_rating = $_POST["competency_rating"];

    // Validate and sanitize user input here (to prevent SQL injection)

    $employee_id = $_SESSION['employee_id']; // You need to determine how to get the employee ID

    // Insert the competency into the database
    $sql = "INSERT INTO competencies (Employee_ID, Competency_Name, Competency_Rating) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $employee_id, $competency_name, $competency_rating);
    
    if (mysqli_stmt_execute($stmt)) {
        // Competency added successfully
        header("location: competency.php"); // Redirect back to the competency page
    } else {
        // Handle error
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Close the database connection

?>
