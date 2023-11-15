<!DOCTYPE html>
<html>
<?php
    include('dbconnect.php');  // Include the database configuration file

    // Query to fetch employee data
    $employeeQuery = "SELECT Name, Total_Competencies FROM technology";
    $employeeResult = mysqli_query($conn, $employeeQuery);

    // Query to fetch competency data
    $competencyQuery = "SELECT 
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
        FROM technology";
    $competencyResult = mysqli_query($conn, $competencyQuery);

    // Extract and format data for the charts
    $employeeLabels = [];
    $employeeData = [];
    $competenciesData = [];

    while ($row = mysqli_fetch_assoc($employeeResult)) {
        $employeeLabels[] = $row['Name'];
        $employeeData[] = $row['Total_Competencies'];
    }

    $competencyRow = mysqli_fetch_assoc($competencyResult);
    foreach ($competencyRow as $competencyName => $competencyValue) {
        $competenciesData[$competencyName] = $competencyValue;
    }
?>
<head>
    <title>Admin Panel Dashboard</title>
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Add CSS styles for chart containers */
        .chart-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>
    <div class="content">
        <header>
            <h1>Admin Panel Dashboard</h1>
        </header>
        <main>
        <div class="container">
            <div class="user-container">
                <h2>Registered Users</h2> 
                <?php
                    //Output Form Entries from the Database
                    $sql = "SELECT COUNT(Username) FROM login;";
                    //fire query
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_row($result);
                        $count = $row[0]; // Get the count value from the result
                        
                        echo $count;
                    } else {
                        echo "No results";
                    }
                ?>
            </div>
            <div class="staff-container">
                <h2>Number of Staffs</h2> 
                <?php
                    //Output Form Entries from the Database
                    $sql2 = "SELECT COUNT(Name) FROM staff;";
                    //fire query
                    $result2 = mysqli_query($conn, $sql2);
                    if(mysqli_num_rows($result2) > 0) {
                        $row = mysqli_fetch_row($result2);
                        $count2 = $row[0]; // Get the count value from the result
                        
                        echo $count2;
                    } else {
                        echo "No results";
                    }
                ?>
            </div>
            <div>
            <div class="chart-container">
                <h2>Competencies by Employee</h2>
                <canvas id="employeeCompetenciesChart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Competencies by Technology</h2>
                <canvas id="competenciesByNameChart"></canvas>
            </div>
        </main>
    </div>
    <script>
        // Chart.js code to create the Employee Competencies bar chart
        var ctx1 = document.getElementById('employeeCompetenciesChart').getContext('2d');
        var employeeCompetenciesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($employeeLabels); ?>,
                datasets: [{
                    label: 'Total Competencies',
                    data: <?php echo json_encode($employeeData); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart.js code to create the Competencies by Name bar chart
        var ctx2 = document.getElementById('competenciesByNameChart').getContext('2d');
        var competenciesByNameChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($competenciesData)); ?>,
                datasets: [{
                    label: 'Total Competencies',
                    data: <?php echo json_encode(array_values($competenciesData)); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
