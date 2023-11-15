<?php
// Include database connection code
include('dbconnect.php');

// Get form data
$dateOfHandling = $_POST['Handling_date'];
$customer = $_POST['Customer'];
$sdEngineer = $_POST['SD_Engineer'];
$team = isset($_POST['Team']) ? $_POST['Team'] : ''; // Check if "Team" is set
$auditedBy = $_POST['Audited_By'];
$ticketHandling = $_POST['Ticket_Handling'];
$numTicket = $_POST['Num_Ticket'];
$intTicket = $_POST['Int_Ticket'];
$process = $_POST['Process'];
$communication = $_POST['Communication'];
$escalation = $_POST['Escalation'];
$technical = $_POST['Technical'];
$investigation = $_POST['Investigation'];
$customerCentered = $_POST['Customer_Centered'];
$comments = $_POST['Comments'];
$totalScore = $_POST['Total_Score'];

// SQL query with placeholders
$insertQuery = "INSERT INTO audit_data (Handling_date, Customer, SD_Engineer, Team, Audited_By, Num_Ticket, Int_Ticket, Ticket_Handling, Process, Communication, Escalation, Technical, Investigation, Customer_Centered, Comments, Total_Score)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($insertQuery);

// Bind parameters
$stmt->bind_param("sssssssiiiiiiiss", $dateOfHandling, $customer, $sdEngineer, $team, $auditedBy, $numTicket, $intTicket, $ticketHandling, $process, $communication, $escalation, $technical, $investigation, $customerCentered, $comments, $totalScore);

// Execute the query
if ($stmt->execute()) {
    // Display a success message
    echo "Audit data has been successfully stored.";
} else {
    // Handle the error
    echo "Error: " . $stmt->error;
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Audit</title>
    <link rel="stylesheet" type="text/css" href="./css/competency.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <br>
    <div class="container">
        <form method="POST" id="auditForm">
            <!-- Your form content here -->

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Success Modal (Initially Hidden) -->
        <div id="successModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Success</h4>
                        <button type="button" class="close" data-dismiss="modal" onclick="redirectToAudit()">Close</button>
                    </div>
                    <div class="modal-body">
                        Audit data has been successfully stored.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="redirectToAudit()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript to submit the form via AJAX -->
    <script>
        $(document).ready(function () {
            $("#auditForm").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "process_audit.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        // Display the success modal
                        $("#successModal").modal("show");
                    },
                    error: function (xhr, status, error) {
                        // Handle errors if needed
                        console.error(xhr.responseText);
                    },
                });
            });
        });

        // Function to redirect to audit.php
        function redirectToAudit() {
            window.location.href = "display_audit.php";
        }
    </script>
</body>
</html>
