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

// Number of records per page
$recordsPerPage = 5;

// Get the current page number from the URL, default to page 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the SQL LIMIT clause to fetch records for the current page
$offset = ($currentPage - 1) * $recordsPerPage;

// Initialize the SQL query
$selectQuery = "SELECT * FROM call_audit_data";

// Prepare the statement for the main query
$stmt = $conn->prepare($selectQuery);

if (!$stmt) {
    die("Database query error: " . $conn->error);
}

// Execute the main SQL query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$totalRecords = $result->num_rows;

//search part:
// Check if the form has been submitted
if (isset($_GET['employee_name'])) {
    // Sanitize the input to prevent SQL injection
    $employeeName = $_GET['employee_name'];
    
    // Modify the SQL query to include the search condition
    $selectQuery = "SELECT * FROM call_audit_data WHERE employee_name LIKE ?";
    
    // Prepare the statement for the main query
    $stmt = $conn->prepare($selectQuery);

    if (!$stmt) {
        die("Database query error: " . $conn->error);
    }

    // Bind the parameter and execute the query
    $param = "%$employeeName%";
    $stmt->bind_param("s", $param);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $totalRecords = $result->num_rows;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Call Audit Display</title>
    <link rel="stylesheet" type="text/css" href="./css/display_audit.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/orange-helvetica.min.css" rel="stylesheet" integrity="sha384-A0Qk1uKfS1i83/YuU13i2nx5pk79PkIfNFOVzTcjCMPGKIDj9Lqx9lJmV7cdBVQZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/boosted.min.css" rel="stylesheet" integrity="sha384-Q3wzptfwnbw1u019drn+ouP2GvlrCu/YVFXSu5YNe4jBpuFwU738RcnKa8PVyj8u" crossorigin="anonymous">
</head>
<body>
    <header>
<nav class="navbar navbar-dark bg-dark navbar-expand-lg header-minimized" aria-label="Global navigation - Minimized without title example">
            <div class="container-xxl">
                <div class="navbar-brand me-auto me-lg-4">
                    <a class="stretched-link" href="welcome.php">
                        <img src="https://boosted.orange.com/docs/5.3/assets/brand/orange-logo.svg" width="50" height="50" alt="Orange Business" loading="lazy">
                    </a>
                </div>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".global-header-0" aria-controls="global-header-0.1 global-header-0.2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="global-header-0.1" class="navbar-collapse collapse me-lg-auto global-header-0">
                    <ul class="navbar-nav">
                        <?php
                        // Get the current file name (without directory path or parameters)
                        $currentPage = basename($_SERVER['PHP_SELF']);

                        // associative array of page names and their corresponding labels
                        $pages = array(
                            'call_audit.php' => 'New Call Audit',
                            'display_call_audit.php' => 'Call Audits',
                            'call_audit_charts.php' => 'Display Call Audit Charts'
                        );

                        // Loop through the pages and create navigation links
                        foreach ($pages as $page => $label) {
                            $isActive = ($currentPage === $page) ? 'active' : '';
                            echo '<li class="nav-item ' . $isActive . '"><a href="' . $page . '" class="nav-link">' . $label . '</a></li>';
                        }

                        ?>
                        <li class="nav-item"><a href="#" id="logoutLinkNavbar" class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
    </header>

    <!-- Add a search form for employee_name -->
<form action="display_call_audit.php" method="get">
    <input type="text" name="employee_name" placeholder="Search by Employee Name">
    <input type="submit" value="Search">
</form>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Employee Name</th>
                <th>Accueil</th>
                <th>Ecoute Active</th>
                <th>Savoir Faire</th>
                <th>Qualite du discours</th>
                <th>Mise en Attente</th>
                <th>Prise de Conge</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($totalRecords > 0) {
                // Loop through records starting from the calculated offset
                $result->data_seek($offset);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['time'] . "</td>";
                    echo "<td>" . $row['employee_name'] . "</td>";
                    echo "<td>" . $row['accueil'] . "</td>";
                    echo "<td>" . $row['ecoute_active'] . "</td>";
                    echo "<td>" . $row['savoir_faire'] . "</td>";
                    echo "<td>" . $row['qualite_discours'] . "</td>";
                    echo "<td>" . $row['mise_en_attente'] . "</td>";
                    echo "<td>" . $row['prise_de_conge'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";
                    echo "<td><form action='delete_call_audit.php' method='post'><input type='hidden' name='id' value='" . $row['id'] . "'><input type='submit' value='Delete'></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='23'>No audit data found.</td></tr>";
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
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="display_call_audit.php?page=' . $i . '">' . $i . '</a></li>';
        }
        ?>
    </ul>
</body>

    <!-- Pagination links -->
    <ul class="pagination">
        <?php
        // Pagination links here
        ?>
    </ul>
</body>
</html>

<?php
// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
