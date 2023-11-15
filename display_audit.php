<?php
// Start the session at the very beginning of your script
session_start();

// Include database connection code
include('dbconnect.php');

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

// Function to retrieve the user's role from the database
function getUserRoleFromDatabase($username, $conn) {
    // Prepare and execute a query to get the user's role based on their username
    $sql = "SELECT role FROM login WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userRole);

    if ($stmt->fetch()) {
        // Return the user's role
        return $userRole;
    }

    // Close the statement
    $stmt->close();

    // Return a default role or handle the case where the role is not found
    return 'default_role';
}

// After successful authentication, set the user's role in the session
$_SESSION['userRole'] = getUserRoleFromDatabase($_SESSION['username'], $conn);

// Number of records per page
$recordsPerPage = 5;

// Get the current page number from the URL, default to page 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the SQL LIMIT clause to fetch records for the current page
$offset = ($currentPage - 1) * $recordsPerPage;

// Get the search field and value from the GET request
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : '';
$searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : '';

// Initialize the SQL query
$selectQuery = "SELECT * FROM audit_data";

// Modify the SQL query to filter by user role
$userRole = $_SESSION['userRole'];
if ($userRole == 'team_leader') {
    $selectQuery .= " WHERE Team = ?";
} elseif ($userRole == 'senior_manager') {
    // Modify the query for senior managers
    $selectQuery = "SELECT * FROM audit_data WHERE Team IN (SELECT username FROM login WHERE superior = ?)";
} elseif ($userRole == 'department_manager') {
    // Modify the query for department managers
    $selectQuery = "SELECT * FROM audit_data WHERE Team IN (SELECT username FROM login WHERE department = ?)";
}

// Modify the query to include search conditions
if (!empty($searchField) && !empty($searchValue)) {
    $selectQuery .= " AND $searchField LIKE ?";
}

// Prepare the statement for the main query
$stmt = $conn->prepare($selectQuery);

if (!$stmt) {
    die("Database query error: " . $conn->error);
}

// Bind the appropriate parameter based on user role and search conditions
if (!empty($searchField) && !empty($searchValue)) {
    // Bind only the searchValue and username
    $searchValue = "%" . $searchValue . "%"; // Add wildcards for a partial search
    $stmt->bind_param("ss", $searchValue, $_SESSION['username']);
} else {
    // Bind only the username when no search is performed
    $stmt->bind_param("s", $_SESSION['username']);
}


// Bind search parameters if provided
if (!empty($searchField) && !empty($searchValue)) {
    $searchValue = "%" . $searchValue . "%"; // Add wildcards for a partial search
    $stmt->bind_param("ss", $searchField, $searchValue);
}


// Execute the main SQL query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$totalRecords = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Audit Display</title>
    <link rel="stylesheet" type="text/css" href="./css/display_audit.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <h1>Audit Data</h1>
    <div class="search-form">
        <form method="GET" action="display_audit.php">
            <label for="searchField">Search by:</label>
            <select id="searchField" name="searchField">
                <option value="SD_Engineer">SD Engineer</option>
                <option value="Customer">Customer</option>
                <option value="Num_Ticket">Num Ticket</option>
                <option value="Int_Ticket">Int Ticket</option>
            </select>
            <input type="text" name="searchValue" placeholder="Enter search value">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Handling_Date</th>
                <th>Customer</th>
                <th>SD Engineer</th>
                <th>Team</th>
                <th>Audited_By</th>
                <th>Num_Ticket</th>
                <th>Int_Ticket</th>
                <th>Ticket_Handling</th>
                <th>Process</th>
                <th>Communication</th>
                <th>Escalation</th>
                <th>Technical</th>
                <th>Investigation</th>
                <th>Customer_Centered</th>
                <th>Comments</th>
                <th>Total Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($totalRecords > 0) {
                // Loop through records starting from the calculated offset
                $result->data_seek($offset);
                for ($i = 0; $i < $recordsPerPage && $row = $result->fetch_assoc(); $i++) {
                    echo "<tr>";
                    echo "<td>" . $row['Handling_date'] . "</td>";
                    echo "<td>" . $row['Customer'] . "</td>";
                    echo "<td>" . $row['SD_Engineer'] . "</td>";
                    echo "<td>" . $row['Team'] . "</td>";
                    echo "<td>" . $row['Audited_By'] . "</td>";
                    echo "<td>" . $row['Num_Ticket'] . "</td>";
                    echo "<td>" . $row['Int_Ticket'] . "</td>";
                    echo "<td>" . $row['Ticket_Handling'] . "</td>";
                    echo "<td>" . $row['Process'] . "</td>";
                    echo "<td>" . $row['Communication'] . "</td>";
                    echo "<td>" . $row['Escalation'] . "</td>";
                    echo "<td>" . $row['Technical'] . "</td>";
                    echo "<td>" . $row['Investigation'] . "</td>";
                    echo "<td>" . $row['Customer_Centered'] . "</td>";
                    echo "<td>" . $row['Comments'] . "</td>";
                    echo "<td>" . $row['Total_Score'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No audit data found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination links -->
    <ul class="pagination">
        <?php
        $totalPages = ceil($totalRecords / $recordsPerPage);

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="display_audit.php?page=' . $i;
            
            // Add the search parameters to the pagination links if they exist
            if (!empty($searchField) && !empty($searchValue)) {
                echo '&searchField=' . $searchField . '&searchValue=' . $searchValue;
            }

            echo '">' . $i . '</a></li>';
        }
        ?>
    </ul>
</body>
</html>

<?php
// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
