<!DOCTYPE html>
<html>
<head>
    <title>Team Performance Charts</title>
    <!-- Include Chart.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <style>
        .chart-row {
            display: flex;
            flex-wrap: wrap;
        }

        .chart-container {
            width: 300px; /* Fixed width for the chart containers */
            height: 400px; /* Fixed height for the chart containers */
            padding: 5px;
        }
        
        .container {
            max-width: 1200px;
            margin: auto;
        }
    </style>
    <?php
    include('dbconnect.php');

    // Check if the user is logged in
    session_start();
    if (!isset($_SESSION['username'])) {
        header('location: login.php');
        exit;
    }

    // Get the user's team leader from the session
    $userTeamLeader = $_SESSION['username'];

    // Define an associative array to store competency names
    $competencyNames = [
        'Fortinet', 'Checkpoint', 'Zscaler', 'PaloAlto', 'Juniper', 'CiscoASA', 'BigIP', 'Tuffin', 'IVANTI', 'SIRA', 'AWS', 'GCP'
    ];

    // Initialize an array to store competency data for each technology entry
    $technologyData = [];

    // SQL query to retrieve technology entries for employees where Team_Leader matches the logged-in user
    $sql = "SELECT t.Name, t.Fortinet, t.Checkpoint, t.Zscaler, t.PaloAlto, t.Juniper, t.CiscoASA, t.BigIP, t.Tuffin, t.IVANTI, t.SIRA, t.AWS, t.GCP, t.date
            FROM technology t
            JOIN staff s ON t.PIMS = s.PIMS
            WHERE s.Team_Leader = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userTeamLeader);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Create an array to store competency values for this entry
            $competencyValues = array_intersect_key($row, array_flip($competencyNames));

            // Store the competency values and date for this entry
            $technologyData[] = [
                'name' => $row['Name'],
                'competencies' => $competencyValues,
                'date' => $row['date'],
            ];
        }
    }
    ?>
</head>
<body>
    <header>
        <div>
            <?php include 'common.php'; ?>
        </div>
    </header>
    <div class="chart-row">
        <?php foreach ($technologyData as $techData): ?>
            <div class="chart-container">
                <canvas class="radar-chart" data-employee-name="<?php echo $techData['name']; ?>"></canvas>
                <!-- Display the date for each technology entry -->
                <p>Date: <?php echo $techData['date']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Get references to the radar chart canvases
        const radarChartElements = document.querySelectorAll('.radar-chart');

        // Create a radar chart for each technology entry
        radarChartElements.forEach(chartElement => {
            const techName = chartElement.getAttribute('data-employee-name');
            const techData = <?php echo json_encode($technologyData); ?>;

            const entryData = techData.find(data => data.name === techName);
            const competencyValues = Object.values(entryData.competencies);

            // Create the radar chart
            new Chart(chartElement, {
                type: 'radar',
                data: {
                    labels: <?php echo json_encode($competencyNames); ?>,
                    datasets: [{
                        label: `${techName} - Staff Performance (Competency)`,
                        data: competencyValues,
                        backgroundColor: 'rgba(251, 206, 177, 0.6)', // Area fill color
                        borderColor: 'rgba(242, 140, 40, 1)', // Border color
                        borderWidth: 1, // Border width
                    }]
                },
                options: {
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 5, // Customize the maximum value on the radar chart
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        });
    </script>
</body>
</html>
