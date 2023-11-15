<!DOCTYPE html>
<html>
<head>
    <title>Team Details</title>
    <!-- Include Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <!-- Include any additional CSS or JavaScript libraries here -->
    <link rel="stylesheet" type="text/css" href="css/team_details.css">
    <style>
        /* Adjust CSS styles for layout */
        .container {
            display: flex; /* Use flexbox layout */
        }

        .sidebar {
            /* Define styles for the sidebar */
            width: 20%; /* Adjust width as needed */
            background-color: #f2f2f2;
            /* Other sidebar styles */
        }

        .content {
            /* Define styles for the content area */
            flex-grow: 1; /* Allow content to grow to fill available space */
            padding: 20px; /* Add padding as needed */
            /* Other content styles */
        }

        .team-leader-container {
            margin-bottom: 20px; /* Add margin to separate team leader sections */
        }

        .chart-group {
            /* Define styles for the chart group container */
            display: flex; /* Use flexbox layout for charts */
            flex-wrap: wrap; /* Allow charts to wrap to the next line if needed */
        }

        .chart-container {
            /* Define styles for the chart containers */
            width: 50%; /* Adjust chart width as needed */
            margin-right: 10px; /* Add margin to separate charts */
            position: relative; /* Use relative positioning */
        }

        /* Ensure that charts appear on top of the sidebar */
        canvas {
            position: relative;
            z-index: 1; /* Set a higher z-index value */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="container">
        <div class="sidebar">
            <!-- sidebar -->
            <?php include 'navigation.php'; ?>
        </div>

        <!-- Content Area -->
        <div class="content">
        <header>
            <h1>Team Info Charts</h1>
        </header>
            <!-- Container for the instructions -->
            <div class="instructions-container">
                <p><strong>Instructions:</strong></p>
                <ul>
                    <li>One chart for each team and with their total competency value on the x-axis as well as the employee name and the value on the y-axis</li>
                </ul>

            <?php
            // Include your database connection code
            include('dbconnect.php');

            // Retrieve data from the database
            $sql = "SELECT s.Team_Leader, s.Name AS Employee_Name, t.* 
                    FROM staff s
                    JOIN technology t ON s.Name = t.Name";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $teamData = [];

                // Organize data into an associative array
                while ($row = mysqli_fetch_assoc($result)) {
                    $teamLeader = $row['Team_Leader'];
                    $employeeName = $row['Employee_Name'];

                    // Exclude the 'Team_Leader' and 'Name' columns
                    unset($row['Team_Leader']);
                    unset($row['Employee_Name']);

                    // Store competency values for each technology
                    $teamData[$teamLeader][$employeeName] = $row;
                }

                // Close the database connection
                mysqli_close($conn);

                // Loop through $teamData and generate charts
                foreach ($teamData as $teamLeader => $employeeData) {
                    echo '<div class="team-leader-container">';
                    echo '<h3>Team : ' . $teamLeader . '</h3>'; // Add a heading for each team leader
                    // Create a container for charts
                    echo '<div class="chart-group">';

                    // Extract employee names and competency values
                    $employeeNames = array_keys($employeeData);
                    $competencyValues = [];

                    foreach ($employeeData as $employee) {
                        $competencyValues[] = $employee['Total_Competencies'];
                    }
                    ?>

                    <div class="chart-container">
                        <canvas id="<?php echo str_replace(' ', '_', $teamLeader) ?>_chart"></canvas>
                    </div>

                    <script>
                        var ctx = document.getElementById("<?php echo str_replace(' ', '_', $teamLeader) ?>_chart").getContext("2d");
                        new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: <?php echo json_encode($employeeNames) ?>,
                                datasets: [{
                                    label: "Competency Values",
                                    data: <?php echo json_encode($competencyValues) ?>,
                                    backgroundColor: "rgb(75, 192, 192)",
                                    borderColor: "rgb(75, 192, 192)",
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: <?php echo (max($competencyValues) + 10) ?> // Customize the maximum value on the y-axis
                                    }
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    </script>

                    <?php
                    echo '</div>'; // Close the chart-group container
                    echo '</div>'; // Close the team-leader-container
                }
            } else {
                // Handle database query error
                echo 'Error: ' . mysqli_error($conn);
            }
            ?>

            <!-- Add a container for the stacked bar chart -->
<div class="chart-container">
    <canvas id="stackedBarChart"></canvas>
</div>

<script>
    // Function to generate random colors for the technologies
    function getRandomColor() {
        var letters = "0123456789ABCDEF";
        var color = "#";
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Define the list of technologies
    var technologies = ['Fortinet', 'Checkpoint', 'Zscaler', 'PaloAlto', 'Juniper', 'CiscoASA', 'BigIP', 'Tuffin', 'IVANTI', 'SIRA', 'AWS', 'GCP'];

        // Create arrays to hold technology data
        // Create arrays to hold technology data
    var techData = {};
    <?php
    foreach ($technologies as $tech) {
    ?>
        techData["<?php echo $tech; ?>"] = Array(<?php echo count($teamData); ?>).fill(0);
    <?php
    }
    ?>


    // Prepare data for the stacked bar chart
    <?php
    foreach ($teamData as $teamLeader => $employeeData) {
    ?>
        var <?php echo str_replace(' ', '_', $teamLeader); ?>Data = [];
        <?php
        foreach ($technologies as $tech) {
            $techTotal = 0;
            foreach ($employeeData as $employee) {
                $techTotal += $employee[$tech];
            }
        ?>
            <?php echo str_replace(' ', '_', $teamLeader); ?>Data.push(<?php echo $techTotal; ?>);
        <?php
        }
        ?>
        techData["<?php echo $teamLeader; ?>"] = <?php echo json_encode($teamData[$teamLeader]); ?>;
    <?php
    }
    ?>

    // Get the stacked bar chart canvas element
    var stackedBarChartCanvas = document.getElementById("stackedBarChart");

    // Create the stacked bar chart
    new Chart(stackedBarChartCanvas, {
        type: "bar",
        data: {
            labels: <?php echo json_encode(array_keys($teamData)); ?>,
            datasets: [
                <?php
                foreach ($technologies as $tech) {
                ?>
                    {
                        label: "<?php echo $tech; ?>",
                        data: [
                            <?php
                            foreach ($teamData as $teamLeader => $employeeData) {
                                $techTotal = 0;
                                foreach ($employeeData as $employee) {
                                    $techTotal += $employee[$tech];
                                }
                            ?>
                                <?php echo $techTotal; ?>,
                            <?php
                            }
                            ?>
                        ],
                        backgroundColor: getRandomColor(),
                    },
                <?php
                }
                ?>
            ],
        },
        options: {
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    beginAtZero: true,
                },
            },
            plugins: {
                legend: {
                    position: "top",
                },
            },
        },
    });
</script>
        </div>
    </div>
</body>
</html>
