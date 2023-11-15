<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
    <head>
    <title>Employee Progression</title>
    <!-- Include Moment.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Include Chart.js library (version 2.9.4) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
</head>
<style>
    .content {
        margin-left: 200px;
        padding: 20px;
    }

    #employeeProgressionChart {
        position: relative;
        z-index: 0;
    }

    #dropdown {
        margin-bottom: 20px;
    }
</style>
</head>
<body>
<?php include 'navigation.php'; ?>
<div class="content">
    <h2>Select an Employee:</h2>

    <form action="" method="post" id="dropdownForm">
        <label for="employees">Choose an employee:</label>
        <select id="employees" name="employees">
            <?php
            include('dbconnect.php');

            // Fetching employees from the 'technology' table
            $sql = "SELECT DISTINCT Name FROM technology";
            $result = $conn->query($sql);

            // Displaying employee names in the dropdown list
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
                }
            } else {
                echo "No employees found in the database.";
            }

            // Do not close the connection here
            ?>
        </select>

        <!-- Use JavaScript to automatically submit the form on dropdown change -->
        <script>
            document.getElementById("employees").onchange = function() {
                document.getElementById("dropdownForm").submit();
            };
        </script>
    </form>

    <?php
    if (isset($_POST['employees'])) {
        // Open the database connection again
        include('dbconnect.php');

        $employeeName = $_POST['employees'];

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

            <script>
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
        <?php
        } else {
            // Handle database query error
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        // Default employee name for the initial graph
        $defaultEmployeeName = "Initial Employee"; // Replace this with your default employee name

        // Retrieve the default employee's competency data over time from the database
        $sql = "SELECT date, Total_Competencies FROM technology WHERE Name = '$defaultEmployeeName'";
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
            if (!empty($competencies)) {
                $firstCompetency = $competencies[0];
                $lastCompetency = end($competencies);
                $maxValue = 60; // Maximum value for 100%
                $percentageIncrease = ((($lastCompetency / $maxValue) * 100) - (($firstCompetency / $maxValue) * 100));
            } else {
                $firstCompetency = 0;
                $lastCompetency = 0;
                $percentageIncrease = 0;
            }
        
            // Close the database connection
            mysqli_close($conn);?>
        

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

            <script>
                var ctx = document.getElementById("employeeProgressionChart").getContext("2d");
                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: <?php echo json_encode($dates) ?>,
                        datasets: [{
                            label: "Competency Progression for <?php echo $defaultEmployeeName ?>",
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
        <?php
        } else {
            // Handle database query error
            echo 'Error: ' . mysqli_error($conn);
        }
    }
    ?>
</div>
</body>
</html>
