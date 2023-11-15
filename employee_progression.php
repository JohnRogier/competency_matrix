<!DOCTYPE html>
<html>
<head>
    <title>Employee Progression</title>
    <!-- Include Moment.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Include Chart.js library (version 2.9.4) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
</head>
<body>
    <header>
    <?php include 'common.php'; ?>
</header>
    <?php
    // Include your database connection code
    include('dbconnect.php');

    // Get the employee name from the URL parameter
    if (isset($_GET['employee_name'])) {
        $employeeName = $_GET['employee_name'];

        // Retrieve the employee's competency data over time from the database
        $sql = "SELECT date, Total_Competencies FROM technology WHERE Name = '$employeeName'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $dates = [];
            $competencies = [];

            // Fetch the data and store it in arrays
            while ($row = mysqli_fetch_assoc($result)) {
                $dates[] = $row['date'];
                $competencies[] = $row['Total_Competencies'];
            }

            // Calculate the percentage increase
            $firstCompetency = $competencies[0];
            $lastCompetency = end($competencies);
            $maxValue = 60; // Maximum value for 100%
            $percentageIncrease = ((($lastCompetency / $maxValue) * 100) - (($firstCompetency / $maxValue) * 100));


            // Close the database connection
            mysqli_close($conn);
        } else {
            // Handle database query error
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        // Handle missing employee name
        echo 'Employee name not provided.';
    }
    ?>

    <!-- HTML Canvas Element for Chart -->
    <div style="width: 80%; margin: 0 auto;">
        <canvas id="employeeProgressionChart"></canvas>
    </div>

    <!-- Percentage Increase Box -->
    <div style="text-align: center; margin-top: 20px;">
        <div style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">
            <strong>Percentage Increase:</strong>
            <?php echo number_format($percentageIncrease, 2) ?>%
        </div>
    </div>

    <!-- JavaScript for Chart.js -->
    <script>
    // Create the chart with Chart.js version 2.9.4
    var ctx = document.getElementById("employeeProgressionChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: <?php echo json_encode($dates) ?>,
            datasets: [{
                label: "Competency Progression for <?php echo $employeeName ?>",
                data: <?php echo json_encode($competencies) ?>,
                borderColor: "rgb(75, 192, 192)",
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: 'YYYY-MM-DD HH:mm:ss', // Specify the date format (including time)
                        tooltipFormat: 'lll', // Format for tooltips (adjust as needed)
                        unit: 'day', // Display by day
                        displayFormats: {
                            day: 'YYYY-MM-DD' // Format for day labels
                        }
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10, // Limit the number of displayed ticks
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Competency Values'
                    }
                }]
            }
        }
    });
    </script>
</body>
</html>
