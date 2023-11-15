<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit; // Make sure to exit to prevent further code execution
} else {
    $username = $_SESSION['username'];
}

// Include database connection code
include('dbconnect.php');

// Define an associative array to store total competency values for each staff member
$staffCompetencies = [];

// SQL query to calculate the total competency value for each staff member
$sql = "SELECT s.Name, SUM(t.Total_Competencies) AS total_competency 
         FROM technology AS t
         JOIN staff AS s ON t.Name = s.Name
         WHERE s.Team_Leader = '$username'  -- Filter by Team Leader
         GROUP BY s.Name";

// Execute the query
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $staffName = $row['Name'];
        $totalCompetency = $row['total_competency'];

        // Store the total competency value for each staff member
        $staffCompetencies[] = [
            'name' => $staffName,
            'competency' => $totalCompetency
        ];
    }
}

// Define an associative array to store the sum of competency values for each technology name
$technologySumCompetencies = [];

// SQL query to calculate the sum of competency values for each technology name
$sql = "SELECT
            SUM(Fortinet) AS Fortinet,
            SUM(Checkpoint) AS Checkpoint,
            SUM(Zscaler) AS Zscaler,
            SUM(PaloAlto) AS PaloAlto,
            SUM(Juniper) AS Juniper,
            SUM(CiscoASA) AS CiscoASA,
            SUM(BigIP) AS BigIP,
            SUM(Tuffin) AS Tuffin,
            SUM(IVANTI) AS IVANTI,
            SUM(SIRA) AS SIRA,
            SUM(AWS) AS AWS,
            SUM(GCP) AS GCP
         FROM technology AS t
         JOIN staff AS s ON t.Name = s.Name
         WHERE s.Team_Leader = '$username'  -- Filter by Team Leader";


// Execute the query
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    // Store the sum of competency values for each technology name
    $technologySumCompetencies = $row;
}
?>
<html>
<head>
    <title>Welcome and Team Performance Charts</title>
    <!-- Include Chart.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="./css/welcome.css">
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="input-group" style="">
                <form method="GET" action="">
                    <input type="text" placeholder="Search by Name" name="search">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>

        <div class="container">
            <?php
            // Number of records per page
            $recordsPerPage = 10;

            // Get the current page number from the URL
            if (isset($_GET['page'])) {
                $currentPage = $_GET['page'];
            } else {
                $currentPage = 1;
            }

            // Calculate the OFFSET for the SQL query
            $offset = ($currentPage - 1) * $recordsPerPage;

            // Fetch data from the database with pagination
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM staff WHERE Team_leader='$username'";

            // Check if the search form is submitted
            if (isset($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['search']); // Prevent SQL injection
                $search = trim($search); // Remove leading and trailing spaces

                // Modify the SQL query to include the search condition
                $sql .= " AND staff.Name LIKE '%$search%'";
            }

            // Modify the SQL query to include LIMIT and OFFSET
            $sql .= " LIMIT $recordsPerPage OFFSET $offset";

            // Execute the SQL query
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<table class="data-table">
                    <tr>
                        <th> </th>
                        <th>Name</th>
                        <th>Niveau</th>
                        <th>PIMS</th>
                        <th>FTID</th>
                    </tr>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                            <td><a href="view.php?id=' . $row["id"] . '">View</a></td>
                            <td>' . $row["Name"] . '</td>
                            <td>' . $row["Niveau"] . '</td>
                            <td>' . $row["PIMS"] . '</td>
                            <td>' . $row["FTID"] . '</td>    
                        </tr>';
                }

                echo '</table>';
            } else {
                echo "0 results";
            }

            // Calculate total pages for pagination
            $sqlCount = "SELECT COUNT(*) FROM staff WHERE Team_leader='$username'";
            $resultCount = mysqli_query($conn, $sqlCount);
            $rowCount = mysqli_fetch_row($resultCount);
            $totalRecords = $rowCount[0];
            $totalPages = ceil($totalRecords / $recordsPerPage);

            // Output pagination links
            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="welcome.php?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>

<!-- Add the JavaScript and HTML code for the charts and toggle buttons below -->
<div id="chartContainer" style="display: none;">
    <div class="chart-container" style="width: 50%;">
        <canvas id="teamPerformanceChart1" width="400" height="200"></canvas>
    </div>
    <div class="chart-container" style="width: 50%;">
        <canvas id="technologySumChart" width="400" height="200"></canvas>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <button class="btn btn-primary" id="toggleTableBtn">Table</button>
            <button class="btn btn-primary" id="toggleChartsBtn">Charts</button>
        </div>
    </div>
</div>

<script>
    // Button elements
    const toggleTableBtn = document.getElementById('toggleTableBtn');
    const toggleChartsBtn = document.getElementById('toggleChartsBtn');

    // Table and Chart containers
    const tableContainer = document.querySelector('.data-table');
    const chartContainer = document.getElementById('chartContainer');

    // Search bar and pagination elements
    const searchBar = document.querySelector('.input-group');
    const pagination = document.querySelector('.pagination');

    // Function to initialize the charts
    function initializeCharts() {
        // Get references to the chart canvases
        const ctx1 = document.getElementById('teamPerformanceChart1').getContext('2d');
        const ctx2 = document.getElementById('technologySumChart').getContext('2d');

        // Extract staff names and competency values from PHP data
        const staffNames = <?php echo json_encode(array_column($staffCompetencies, 'name')); ?>;
        const competencyValues = <?php echo json_encode(array_column($staffCompetencies, 'competency')); ?>;

        // Extract technology names and their sum of competency values from PHP data
        const technologyNames = <?php echo json_encode(array_keys($technologySumCompetencies)); ?>;
        const technologySumValues = <?php echo json_encode(array_values($technologySumCompetencies)); ?>;

        // Create the first bar chart (Total Competency)
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: staffNames,
                datasets: [{
                    label: 'Staff Performance (Total competency)',
                    data: competencyValues,
                    backgroundColor: 'rgb(251, 206, 177)', // Bar color
                    borderColor: 'rgb(255, 127, 80)', // Border color
                    borderWidth: 1, // Border width
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 60, // Customize the maximum value on the y-axis
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Create the second bar chart (Sum of Competencies by Technology)
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: technologyNames,
                datasets: [{
                    label: 'Sum of Competencies by Technology',
                    data: technologySumValues,
                    backgroundColor: 'rgb(151, 206, 177)', // Bar color
                    borderColor: 'rgb(75, 192, 192)', // Border color
                    borderWidth: 1, // Border width
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        // Customize the maximum value on the y-axis for the technology chart
                        max: Math.max(...technologySumValues) + 10,
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    }

        // Check if the charts already exist and destroy them if they do
    if (window.myCharts && window.myCharts.length) {
        window.myCharts.forEach(chart => {
            chart.destroy();
        });
    }
    // Initialize the charts initially
    initializeCharts();

    // Toggle between Table and Charts
    toggleTableBtn.addEventListener('click', () => {
        tableContainer.style.display = 'table';
        chartContainer.style.display = 'none';
        toggleTableBtn.style.display = 'none';
        toggleChartsBtn.style.display = 'block';
        searchBar.style.display = 'block';
        pagination.style.display = 'block';
    });

    toggleChartsBtn.addEventListener('click', () => {
        tableContainer.style.display = 'none';
        chartContainer.style.display = 'flex'; // Display charts side by side
        toggleTableBtn.style.display = 'block';
        toggleChartsBtn.style.display = 'none';
        searchBar.style.display = 'none'; // Hide search bar
        pagination.style.display = 'none'; // Hide pagination

        // Reinitialize the charts when displaying the chart container
        initializeCharts();
    });
</script>

